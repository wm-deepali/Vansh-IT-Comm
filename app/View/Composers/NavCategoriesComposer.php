<?php

namespace App\View\Composers;

use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Builds $navCategories for partials/header.blade.php.
 *
 * One entry per active top-level category:
 *   ['category' => Category, 'cols' => [[title, [[label, shopParams, cssClass?], ...]], ...], 'promo' => [...]]
 *
 * Columns = the attributes mapped to that category (status = 1, show_in_filter = 1),
 * each listing only the values real, visible products use. A static Budget column
 * is always appended. Every link is a shop-page filter URL, e.g.
 *   route('shop', ['category' => ['laptops'], 'attr' => [3 => [12]]])
 */
class NavCategoriesComposer
{
    /** Max attribute columns per category (the static Budget column is added on top). */
    private const MAX_ATTRIBUTE_COLS = 4;

    /** Max values shown per attribute column. */
    private const MAX_VALUES = 8;

    public function compose(View $view): void
    {
        $view->with('navCategories', $this->build());
    }

    private function build()
    {
        $categories = Category::active()
            ->parents()
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')])
            ->orderBy('sort_order')
            ->get();

        if ($categories->isEmpty()) {
            return collect();
        }

        // Every category id in play (parents + their subcategories)
        $allCategoryIds = $categories
            ->flatMap(fn($c) => $c->children->pluck('id')->push($c->id))
            ->unique()
            ->values();

        // Attributes mapped to those categories (one query)
        $mappedAttributes = CategoryAttribute::with('attribute:id,name')
            ->whereIn('category_id', $allCategoryIds)
            ->where('status', 1)
            ->where('show_in_filter', true)
            ->orderBy('sort_order')
            ->get();

        // Which (category, attribute, value) combinations real products actually use (one query)
        $pav = (new ProductAttributeValue)->getTable();
        $prod = (new Product)->getTable();

        $usedPairs = DB::table("$pav as pav")
            ->join("$prod as p", 'p.id', '=', 'pav.product_id')
            ->whereIn('p.id', Product::visible()->select('id'))
            ->select('p.category_id', 'p.subcategory_id', 'pav.attribute_id', 'pav.attribute_value_id')
            ->distinct()
            ->get();

        // Value labels (one query)
        $values = AttributeValue::whereIn('attribute_id', $mappedAttributes->pluck('attribute_id')->unique())
            ->orderBy('sort_order')
            ->get()
            ->groupBy('attribute_id');

        $budgets = [
            ['Under ₹15,000', ['maxPrice' => 15000], 'font-semibold text-emerald-600'],
            ['₹15K – ₹25K', ['minPrice' => 15000, 'maxPrice' => 25000]],
            ['₹25K – ₹35K', ['minPrice' => 25000, 'maxPrice' => 35000]],
            ['₹35K – ₹50K', ['minPrice' => 35000, 'maxPrice' => 50000]],
            ['Flagships ₹50K+', ['minPrice' => 50000]],
        ];

        return $categories->map(function ($category) use ($mappedAttributes, $usedPairs, $values, $budgets) {
            $ids = $category->children->pluck('id')->push($category->id)->all();

            // value ids really used by this category's products, grouped by attribute
            $usedByAttribute = $usedPairs
                ->filter(fn($r) => in_array($r->category_id, $ids) || in_array($r->subcategory_id, $ids))
                ->groupBy('attribute_id')
                ->map(fn($rows) => $rows->pluck('attribute_value_id')->unique()->all());

            $cols = [];

            $attributes = $mappedAttributes
                ->whereIn('category_id', $ids)
                ->unique('attribute_id')
                ->sortBy('sort_order');

            foreach ($attributes as $mapped) {
                if (count($cols) >= self::MAX_ATTRIBUTE_COLS || !$mapped->attribute) {
                    continue;
                }

                $usedIds = $usedByAttribute->get($mapped->attribute_id, []);

                $items = collect($values->get($mapped->attribute_id, []))
                    ->whereIn('id', $usedIds)
                    ->take(self::MAX_VALUES)
                    ->map(fn($v) => [
                        $v->value,
                        [
                            'category' => [$category->slug],
                            'attr' => [$mapped->attribute_id => [$v->id]],
                        ],
                    ])
                    ->values()
                    ->all();

                if ($items) {
                    $cols[] = ['By ' . $mapped->attribute->name, $items];
                }
            }

            // Static budget column, scoped to this category
            $cols[] = [
                'Budget Range',
                array_map(function ($b) use ($category) {
                    $item = [$b[0], ['category' => [$category->slug]] + $b[1]];
                    if (isset($b[2])) {
                        $item[] = $b[2];
                    }
                    return $item;
                }, $budgets),
            ];

            $minPrice = Product::visible()
                ->where(fn($q) => $q->whereIn('category_id', $ids)->orWhereIn('subcategory_id', $ids))
                ->min('price');

            return [
                'category' => $category,
                'cols' => $cols,
                'promo' => [
                    'url' => route('shop', ['category' => [$category->slug]]),
                    'gradient' => 'from-slate-900 to-blue-950',
                    'badgeClass' => 'bg-blue-500',
                    'badge' => '20-PT TESTED',
                    'title' => $category->name,
                    'text' => 'Tested & up to 12-Mo Warranty.',
                    'price' => $minPrice ? 'From ₹' . number_format($minPrice) . '*' : 'Best Prices',
                    'btn' => 'Explore',
                ],
            ];
        })->values();
    }
}