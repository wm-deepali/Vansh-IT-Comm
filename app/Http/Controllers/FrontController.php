<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Traits\LogsApiCalls;
use App\Models\Brand;
use App\Models\Category;
use App\Models\CategoryAttribute;
use App\Models\Product;
use App\Models\AttributeValue;
use App\Models\ProductAttributeValue;
use Illuminate\Support\Arr;

class FrontController extends Controller
{
    use LogsApiCalls;

    /**
     * All active attributes attached to the given category ids, in admin order.
     * Fetched ONCE per request.
     */
    protected function categoryAttributes(iterable $categoryIds): Collection
    {
        return CategoryAttribute::with('attribute:id,name,icon')
            ->whereIn('category_id', collect($categoryIds)->filter()->all())
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get()
            ->unique('attribute_id')
            ->values();
    }

    /** Only the attributes flagged "show on listing" (product cards). */
    protected function listingAttributes(iterable $categoryIds): Collection
    {
        return $this->categoryAttributes($categoryIds)
            ->where('show_on_listing', true)
            ->values();
    }

    public function home(Request $request)
    {
        return view('front-pages.home');
    }

    /**
     * All Products page — every filter option comes from the database:
     * categories, conditions (Product::CONDITIONS), brands, price range and
     * the attributes flagged "show_in_filter".
     *
     * Query string: search, category[], condition[], brand[], minPrice, maxPrice,
     *               attr[<attribute_id>][], sort, page
     */
    public function shop(Request $request)
    {
        $search   = trim((string) $request->query('search', ''));
        $catSlugs = array_values(array_filter(Arr::wrap($request->query('category'))));
        $conds    = array_values(array_intersect(Arr::wrap($request->query('condition')), Product::CONDITIONS));
        $brandIds = array_values(array_filter(array_map('intval', Arr::wrap($request->query('brand')))));
        $minPrice = is_numeric($request->query('minPrice')) ? (float) $request->query('minPrice') : null;
        $maxPrice = is_numeric($request->query('maxPrice')) ? (float) $request->query('maxPrice') : null;
        $sort     = $request->query('sort', 'featured');

        $attrFilters = collect((array) $request->query('attr', []))
            ->mapWithKeys(fn ($vals, $id) => [(int) $id => array_values(array_filter(array_map('intval', Arr::wrap($vals))))])
            ->filter();

        // Selected categories (a parent includes its subcategories)
        $selectedCategories = $catSlugs
            ? Category::active()->whereIn('slug', $catSlugs)->with(['children' => fn ($q) => $q->active()])->get()
            : collect();

        $scopeIds = $selectedCategories
            ->flatMap(fn ($c) => $c->children->pluck('id')->push($c->id))
            ->unique()->values();

        // ── Products ──
        $query = Product::visible()
            ->with([
                'brand',
                'attributeValues.attribute',
                'attributeValues.value',
                'collections' => fn ($q) => $q->where('status', 1)->orderBy('sort_order'),
            ])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews');

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)
                  ->orWhere('sku', 'like', $like)
                  ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', $like))
                  ->orWhereHas('category', fn ($c) => $c->where('name', 'like', $like));
            });
        }

        if ($scopeIds->isNotEmpty()) {
            $query->where(fn ($q) => $q->whereIn('category_id', $scopeIds)->orWhereIn('subcategory_id', $scopeIds));
        } elseif ($catSlugs) {
            $query->whereRaw('0 = 1'); // unknown category slug → nothing
        }

        if ($conds)    $query->whereIn('condition', $conds);
        if ($brandIds) $query->whereIn('brand_id', $brandIds);
        if ($minPrice !== null) $query->where('price', '>=', $minPrice);
        if ($maxPrice !== null) $query->where('price', '<=', $maxPrice);

        foreach ($attrFilters as $attributeId => $valueIds) {
            $query->whereHas('attributeValues', fn ($q) => $q
                ->where('attribute_id', $attributeId)
                ->whereIn('attribute_value_id', $valueIds));
        }

        match ($sort) {
            'price-asc'  => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            'rating'     => $query->orderByDesc('approved_reviews_avg_rating'),
            'discount'   => $query->orderByRaw('CASE WHEN mrp > price THEN (mrp - price) / mrp ELSE 0 END DESC'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        // ── Filter options (from the DB) ──
        $categories = Category::active()->parents()->orderBy('sort_order')->get();

        $presentConditions = Product::visible()->whereNotNull('condition')->distinct()->pluck('condition')->all();
        $conditions = array_values(array_intersect(Product::CONDITIONS, $presentConditions));

        $brands = Brand::where('status', 1)
            ->whereIn('id', Product::visible()->whereNotNull('brand_id')->select('brand_id'))
            ->orderBy('name')
            ->get();

        $priceMax = (int) (ceil((float) Product::visible()->max('price') / 1000) * 1000);
        $priceMin = (int) (floor((float) Product::visible()->min('price') / 1000) * 1000);

        // Attribute filters: only attributes flagged show_in_filter, limited to the
        // selected categories (or all), showing only values that products really use.
        $filterAttrs = CategoryAttribute::with('attribute:id,name')
            ->where('show_in_filter', true)
            ->where('status', 1)
            ->when($scopeIds->isNotEmpty(), fn ($q) => $q->whereIn('category_id', $scopeIds))
            ->orderBy('sort_order')
            ->get()
            ->unique('attribute_id')
            ->values();

        $usedValueIds = ProductAttributeValue::whereIn('product_id', Product::visible()->select('id'))
            ->pluck('attribute_value_id')->unique();

        $valuesByAttr = AttributeValue::whereIn('attribute_id', $filterAttrs->pluck('attribute_id'))
            ->whereIn('id', $usedValueIds)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('attribute_id');

        $filterAttributes = $filterAttrs
            ->map(fn ($ca) => ['attribute' => $ca->attribute, 'values' => $valuesByAttr->get($ca->attribute_id, collect())])
            ->filter(fn ($row) => $row['attribute'] && $row['values']->isNotEmpty())
            ->values();

        // Listing specs for each card, per product category
        $listingByCategory = CategoryAttribute::with('attribute:id,name,icon')
            ->where('show_on_listing', true)
            ->where('status', 1)
            ->orderBy('sort_order')
            ->get()
            ->groupBy('category_id');

        // ── Active filter chips (each with a "remove this filter" URL) ──
        $without = function (string $path, $value = null) use ($request) {
            $q = $request->query();
            if ($value === null) {
                Arr::forget($q, $path);
            } else {
                $list = array_values(array_diff(array_map('strval', (array) Arr::get($q, $path, [])), [(string) $value]));
                $list ? Arr::set($q, $path, $list) : Arr::forget($q, $path);
            }
            unset($q['page']);
            return route('shop', array_filter($q, fn ($v) => $v !== [] && $v !== null && $v !== ''));
        };

        $activeFilters = [];
        if ($search !== '') $activeFilters[] = ['label' => 'Search: ' . $search, 'url' => $without('search')];
        foreach ($selectedCategories as $c) $activeFilters[] = ['label' => $c->name, 'url' => $without('category', $c->slug)];
        foreach ($conds as $c) $activeFilters[] = ['label' => $c, 'url' => $without('condition', $c)];
        foreach ($brands->whereIn('id', $brandIds) as $b) $activeFilters[] = ['label' => $b->name, 'url' => $without('brand', $b->id)];
        if ($maxPrice !== null && $maxPrice < $priceMax) $activeFilters[] = ['label' => 'Up to ' . config('shop.currency', '₹') . number_format($maxPrice), 'url' => $without('maxPrice')];
        if ($minPrice !== null && $minPrice > 0) $activeFilters[] = ['label' => 'From ' . config('shop.currency', '₹') . number_format($minPrice), 'url' => $without('minPrice')];
        foreach ($filterAttributes as $row) {
            foreach ($row['values'] as $v) {
                if (in_array($v->id, $attrFilters->get($row['attribute']->id, []), true)) {
                    $activeFilters[] = ['label' => $row['attribute']->name . ': ' . $v->value, 'url' => $without('attr.' . $row['attribute']->id, $v->id)];
                }
            }
        }

        $sortOptions = [
            'featured'   => 'Featured First',
            'price-asc'  => 'Price: Low to High',
            'price-desc' => 'Price: High to Low',
            'rating'     => 'Top Customer Rated',
            'discount'   => 'Biggest Discount %',
        ];

        return view('front-pages.shop', compact(
            'products', 'search', 'sort', 'sortOptions',
            'categories', 'conditions', 'brands', 'priceMin', 'priceMax', 'filterAttributes',
            'catSlugs', 'conds', 'brandIds', 'maxPrice', 'attrFilters',
            'listingByCategory', 'activeFilters'
        ));
    }

    public function categories()
    {
        $categories = Category::active()
            ->parents()
            ->with(['children' => fn ($q) => $q->active()->orderBy('sort_order')])
            ->withCount(['products' => fn ($q) => $q->visible()])
            ->orderBy('sort_order')
            ->get();

        $totalProducts = Product::visible()->count();

        $categoryStats = [];

        foreach ($categories as $cat) {
            $ids = $cat->children->pluck('id')->push($cat->id);

            $base = Product::visible()->where(function ($q) use ($ids) {
                $q->whereIn('category_id', $ids)
                  ->orWhereIn('subcategory_id', $ids);
            });

            $brandIds = (clone $base)
                ->whereNotNull('brand_id')
                ->distinct()
                ->pluck('brand_id');

            $brands = Brand::where('status', 1)
                ->whereIn('id', $brandIds)
                ->orderBy('name')
                ->limit(4)
                ->get();

            $categoryStats[$cat->id] = [
                'count'  => (clone $base)->count(),
                'min'    => (clone $base)->min('price'),
                'brands' => $brands,
            ];
        }

        return view('front-pages.categories', compact('categories', 'totalProducts', 'categoryStats'));
    }

    public function categoryShow(Request $request, $slug)
    {
        $category = Category::active()
            ->where('slug', $slug)
            ->with(['children' => fn ($q) => $q->active()->orderBy('sort_order')])
            ->firstOrFail();

        $ids = $category->children->pluck('id')->push($category->id);

        $query = Product::visible()
            ->with([
                'brand',
                'attributeValues.attribute',
                'attributeValues.value',
                'collections' => fn ($q) => $q->where('status', 1)->orderBy('sort_order'),
            ])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews')
            ->where(function ($q) use ($ids) {
                $q->whereIn('category_id', $ids)
                  ->orWhereIn('subcategory_id', $ids);
            });

        if ($request->filled('brand')) {
            $query->where('brand_id', $request->query('brand'));
        }

        $activeTag = $request->query('tag', 'all');

        if ($activeTag === 'under15k') {
            $query->where('price', '<=', 15000);
        } elseif ($activeTag === 'under25k') {
            $query->where('price', '>', 15000)->where('price', '<=', 25000);
        } elseif ($activeTag !== 'all') {
            $sub = $category->children->firstWhere('slug', $activeTag);
            if ($sub) {
                $query->where(function ($q) use ($sub) {
                    $q->where('category_id', $sub->id)
                      ->orWhere('subcategory_id', $sub->id);
                });
            }
        }

        $sort = $request->query('sort', 'featured');
        match ($sort) {
            'price-asc'  => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            'rating'     => $query->orderByDesc('approved_reviews_avg_rating'),
            default      => $query->latest(),
        };

        $products = $query->paginate(12)->withQueryString();

        $listingAttributes = $this->listingAttributes($ids);

        return view('front-pages.category-show', compact('category', 'products', 'activeTag', 'sort', 'listingAttributes'));
    }

    public function productShow($slug)
    {
        $product = Product::visible()
            ->with([
                'category',
                'subcategory',
                'brand',
                'images',
                'collections' => fn ($q) => $q->where('status', 1)->orderBy('sort_order'),
                'attributeValues.attribute',
                'attributeValues.value',
            ])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews')
            ->where('slug', $slug)
            ->firstOrFail();

        $related = Product::visible()
            ->with([
                'brand',
                'attributeValues.attribute',
                'attributeValues.value',
                'collections' => fn ($q) => $q->where('status', 1)->orderBy('sort_order'),
            ])
            ->withAvg('approvedReviews', 'rating')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        $productAttributes = $this->categoryAttributes([$product->category_id, $product->subcategory_id]);
        $listingAttributes = $productAttributes->where('show_on_listing', true)->values();

        return view('front-pages.product-show', compact('product', 'related', 'productAttributes', 'listingAttributes'));
    }
}