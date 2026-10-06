<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Blog;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Category;
use App\Models\AboutPage;
use App\Models\AboutStat;
use App\Models\RepairPage;
use App\Models\DynamicPage;
use Illuminate\Support\Arr;
use App\Models\RepairOption;
use Illuminate\Http\Request;
use App\Traits\LogsApiCalls;
use App\Models\RepairBooking;
use App\Models\ContactBranch;
use App\Models\RepairCategory;
use App\Models\AboutTestGroup;
use App\Models\ContactEnquiry;
use App\Models\AttributeValue;
use App\Models\AboutCommitment;
use Illuminate\Validation\Rule;
use App\Models\CategoryAttribute;
use Illuminate\Support\Collection;
use App\Models\ProductAttributeValue;
use App\Models\ExchangeBrandRule;
use App\Models\ExchangeOption;
use App\Models\ExchangePage;
use App\Models\ExchangeRequest;
use App\Models\ExchangeStep;
use App\Models\HomeHeroSlide;
use App\Models\HomeFeature;
use App\Models\HomeBudgetCard;
use App\Models\HomeGuidedOption;
use App\Models\HomeProcessStep;
use App\Models\HomeCtaBlock;
use App\Models\HomeStoreLocation;
use App\Models\HomeSectionHeading;
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


    public function home()
    {
        // ── Shop By Category tiles: featured top-level categories ──
        $homeCategories = Category::active()
            ->parents()
            ->where('is_featured', 1)
            ->orderBy('sort_order')
            ->limit(6)   // 4 categories + the static Repair / Exchange tiles = 6-column grid
            ->get();

        // ── Product sections (Featured Laptops / Mobiles / Accessories ...):
        //    one section per "popular" top-level category ──
        $homeSections = Category::active()
            ->parents()
            ->where('is_popular', 1)
            ->orderBy('sort_order')
            ->limit(3)
            ->get()
            ->map(function (Category $category) {
                return [
                    'category' => $category,
                    'products' => $this->productsFor($category, 4),
                    // Attributes flagged "show on listing" for this category (used by the product card)
                    'listingAttributes' => $category->categoryAttributes()
                        ->where('show_on_listing', 1)
                        ->with('attribute')
                        ->orderBy('id')          // swap for your sort column if CategoryAttribute has one
                        ->get(),
                ];
            })
            ->filter(fn($section) => $section['products']->isNotEmpty())
            ->values();

        // ── Shop By Brand ──
        $homeBrands = Brand::where('status', 1)
            ->withCount(['products' => fn($q) => $q->visible()])
            ->having('products_count', '>', 0)
            ->orderBy('name')
            ->limit(12)
            ->get();

        // ── FAQ (only those marked "show on home") ──
        $homeFaqs = Faq::where('status', 1)
            ->where('show_home', 1)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->limit(6)
            ->get();

        // ── Admin-managed homepage content (the view filters active rows and sorts them) ──
        $slides = HomeHeroSlide::orderBy('sort_order')->get();
        $trustItems = HomeFeature::where('section', 'trust_strip')->orderBy('sort_order')->get();
        $whyItems = HomeFeature::where('section', 'why_us')->orderBy('sort_order')->get();
        $budgetCards = HomeBudgetCard::orderBy('sort_order')->get();
        $guided = HomeGuidedOption::orderBy('sort_order')->get();
        $steps = HomeProcessStep::orderBy('sort_order')->get();
        $stores = HomeStoreLocation::orderBy('sort_order')->get();
        $headings = HomeSectionHeading::get()->keyBy('key');   // $headings->get('categories') etc.
        $ctaBlocks = HomeCtaBlock::get()->keyBy('key');         // $ctaBlocks->get('final_cta') etc.

        return view('front-pages.home', compact(
            'homeCategories',
            'homeSections',
            'homeBrands',
            'homeFaqs',
            'slides',
            'trustItems',
            'whyItems',
            'budgetCards',
            'guided',
            'steps',
            'stores',
            'headings',
            'ctaBlocks'
        ));
    }


    /** Live-search autocomplete (JSON) for the header search box. */
    /** Live-search autocomplete (JSON) for the header search box. */
    public function searchSuggest(Request $request)
    {
        $q = trim((string) $request->query('q', ''));

        if (mb_strlen($q) < 2) {
            return response()->json(['products' => [], 'total' => 0]);
        }

        $like = '%' . addcslashes($q, '%_\\') . '%';
        $prefix = addcslashes($q, '%_\\') . '%';
        $cur = config('shop.currency', '₹');

        $base = Product::visible()->where(function ($w) use ($like) {
            $w->where('name', 'like', $like)
                ->orWhere('sku', 'like', $like)
                ->orWhereHas('brand', fn($b) => $b->where('name', 'like', $like))
                ->orWhereHas('category', fn($c) => $c->where('name', 'like', $like));
        });

        $total = (clone $base)->count();

        $products = $base
            ->with([
                'brand:id,name',
                'images',
                // same source as the product card badge: first active collection by sort_order
                'collections' => fn($c) => $c->where('status', 1)->orderBy('sort_order'),
            ])
            ->orderByRaw('CASE WHEN name LIKE ? THEN 0 ELSE 1 END', [$prefix]) // names starting with the query first
            ->latest('id')
            ->limit(6)
            ->get()
            ->map(function ($p) use ($cur) {
                $img = $p->images->firstWhere('is_default', 1) ?? $p->images->first();
                $tag = $p->collections->first();
                $color = $tag->badge_color ?? null;

                return [
                    'name' => $p->name,
                    'brand' => optional($p->brand)->name,
                    'url' => route('product.show', $p->slug),
                    'image' => $img ? asset('storage/' . ($img->thumb ?? $img->image)) : null,
                    'price' => $cur . number_format($p->price),
                    'mrp' => $p->mrp > $p->price ? $cur . number_format($p->mrp) : null,
                    'badge' => $tag ? \Illuminate\Support\Str::upper($tag->name) : null,
                    // only accept a real hex colour, otherwise the CSS fallback class is used
                    'badgeColor' => ($color && preg_match('/^#[0-9a-fA-F]{3,8}$/', $color)) ? $color : null,
                ];
            });

        return response()->json(['products' => $products, 'total' => $total]);
    }

    /**
     * Latest visible products of a category, including products filed under its sub categories.
     * Eager loads everything the product card reads.
     */
    private function productsFor(Category $category, int $limit)
    {
        $ids = $category->children()->pluck('id')->push($category->id);

        return Product::visible()
            ->where(function ($q) use ($ids) {
                $q->whereIn('category_id', $ids)
                    ->orWhereIn('subcategory_id', $ids);
            })
            ->with(['brand', 'collections', 'attributeValues.attribute', 'attributeValues.value'])
            ->withAvg('approvedReviews as approved_reviews_avg_rating', 'rating')
            ->latest('id')
            ->limit($limit)
            ->get();
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
        $search = trim((string) $request->query('search', ''));
        $catSlugs = array_values(array_filter(Arr::wrap($request->query('category'))));
        $conds = array_values(array_intersect(Arr::wrap($request->query('condition')), Product::CONDITIONS));
        $brandIds = array_values(array_filter(array_map('intval', Arr::wrap($request->query('brand')))));
        $minPrice = is_numeric($request->query('minPrice')) ? (float) $request->query('minPrice') : null;
        $maxPrice = is_numeric($request->query('maxPrice')) ? (float) $request->query('maxPrice') : null;
        $sort = $request->query('sort', 'featured');

        $attrFilters = collect((array) $request->query('attr', []))
            ->mapWithKeys(fn($vals, $id) => [(int) $id => array_values(array_filter(array_map('intval', Arr::wrap($vals))))])
            ->filter();

        // Selected categories (a parent includes its subcategories)
        $selectedCategories = $catSlugs
            ? Category::active()->whereIn('slug', $catSlugs)->with(['children' => fn($q) => $q->active()])->get()
            : collect();

        $scopeIds = $selectedCategories
            ->flatMap(fn($c) => $c->children->pluck('id')->push($c->id))
            ->unique()->values();

        // ── Products ──
        $query = Product::visible()
            ->with([
                'brand',
                'attributeValues.attribute',
                'attributeValues.value',
                'collections' => fn($q) => $q->where('status', 1)->orderBy('sort_order'),
            ])
            ->withAvg('approvedReviews', 'rating')
            ->withCount('approvedReviews');

        if ($search !== '') {
            $like = '%' . $search . '%';
            $query->where(function ($q) use ($like) {
                $q->where('name', 'like', $like)
                    ->orWhere('sku', 'like', $like)
                    ->orWhereHas('brand', fn($b) => $b->where('name', 'like', $like))
                    ->orWhereHas('category', fn($c) => $c->where('name', 'like', $like));
            });
        }

        if ($scopeIds->isNotEmpty()) {
            $query->where(fn($q) => $q->whereIn('category_id', $scopeIds)->orWhereIn('subcategory_id', $scopeIds));
        } elseif ($catSlugs) {
            $query->whereRaw('0 = 1'); // unknown category slug → nothing
        }

        if ($conds)
            $query->whereIn('condition', $conds);
        if ($brandIds)
            $query->whereIn('brand_id', $brandIds);
        if ($minPrice !== null)
            $query->where('price', '>=', $minPrice);
        if ($maxPrice !== null)
            $query->where('price', '<=', $maxPrice);

        foreach ($attrFilters as $attributeId => $valueIds) {
            $query->whereHas('attributeValues', fn($q) => $q
                ->where('attribute_id', $attributeId)
                ->whereIn('attribute_value_id', $valueIds));
        }

        match ($sort) {
            'price-asc' => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            'rating' => $query->orderByDesc('approved_reviews_avg_rating'),
            'discount' => $query->orderByRaw('CASE WHEN mrp > price THEN (mrp - price) / mrp ELSE 0 END DESC'),
            default => $query->latest(),
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
            ->when($scopeIds->isNotEmpty(), fn($q) => $q->whereIn('category_id', $scopeIds))
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
            ->map(fn($ca) => ['attribute' => $ca->attribute, 'values' => $valuesByAttr->get($ca->attribute_id, collect())])
            ->filter(fn($row) => $row['attribute'] && $row['values']->isNotEmpty())
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
            return route('shop', array_filter($q, fn($v) => $v !== [] && $v !== null && $v !== ''));
        };

        $activeFilters = [];
        if ($search !== '')
            $activeFilters[] = ['label' => 'Search: ' . $search, 'url' => $without('search')];
        foreach ($selectedCategories as $c)
            $activeFilters[] = ['label' => $c->name, 'url' => $without('category', $c->slug)];
        foreach ($conds as $c)
            $activeFilters[] = ['label' => $c, 'url' => $without('condition', $c)];
        foreach ($brands->whereIn('id', $brandIds) as $b)
            $activeFilters[] = ['label' => $b->name, 'url' => $without('brand', $b->id)];
        if ($maxPrice !== null && $maxPrice < $priceMax)
            $activeFilters[] = ['label' => 'Up to ' . config('shop.currency', '₹') . number_format($maxPrice), 'url' => $without('maxPrice')];
        if ($minPrice !== null && $minPrice > 0)
            $activeFilters[] = ['label' => 'From ' . config('shop.currency', '₹') . number_format($minPrice), 'url' => $without('minPrice')];
        foreach ($filterAttributes as $row) {
            foreach ($row['values'] as $v) {
                if (in_array($v->id, $attrFilters->get($row['attribute']->id, []), true)) {
                    $activeFilters[] = ['label' => $row['attribute']->name . ': ' . $v->value, 'url' => $without('attr.' . $row['attribute']->id, $v->id)];
                }
            }
        }

        $sortOptions = [
            'featured' => 'Featured First',
            'price-asc' => 'Price: Low to High',
            'price-desc' => 'Price: High to Low',
            'rating' => 'Top Customer Rated',
            'discount' => 'Biggest Discount %',
        ];

        return view('front-pages.shop', compact(
            'products',
            'search',
            'sort',
            'sortOptions',
            'categories',
            'conditions',
            'brands',
            'priceMin',
            'priceMax',
            'filterAttributes',
            'catSlugs',
            'conds',
            'brandIds',
            'maxPrice',
            'attrFilters',
            'listingByCategory',
            'activeFilters'
        ));
    }

    public function categories()
    {
        $categories = Category::active()
            ->parents()
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')])
            ->withCount(['products' => fn($q) => $q->visible()])
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
                'count' => (clone $base)->count(),
                'min' => (clone $base)->min('price'),
                'brands' => $brands,
            ];
        }

        return view('front-pages.categories', compact('categories', 'totalProducts', 'categoryStats'));
    }

    public function categoryShow(Request $request, $slug)
    {
        $category = Category::active()
            ->where('slug', $slug)
            ->with(['children' => fn($q) => $q->active()->orderBy('sort_order')])
            ->firstOrFail();

        $ids = $category->children->pluck('id')->push($category->id);

        $query = Product::visible()
            ->with([
                'brand',
                'attributeValues.attribute',
                'attributeValues.value',
                'collections' => fn($q) => $q->where('status', 1)->orderBy('sort_order'),
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
            'price-asc' => $query->orderBy('price', 'asc'),
            'price-desc' => $query->orderBy('price', 'desc'),
            'rating' => $query->orderByDesc('approved_reviews_avg_rating'),
            default => $query->latest(),
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
                'collections' => fn($q) => $q->where('status', 1)->orderBy('sort_order'),
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
                'collections' => fn($q) => $q->where('status', 1)->orderBy('sort_order'),
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

    public function blogs(Request $request)
    {
        $blogs = Blog::where('status', 1)
            ->when($request->filled('tag'), fn($q) => $q->whereJsonContains('tags', $request->query('tag')))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return view('front-pages.blog', compact('blogs'));
    }

    public function blogDetail($slug)
    {
        $blog = Blog::where('slug', $slug)->where('status', 1)->firstOrFail();

        $trending = Blog::where('status', 1)
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(3)
            ->get();

        // Posts sharing the most tags come first, then the newest ones
        $currentTags = $blog->tags ?? [];

        $related = Blog::where('status', 1)
            ->where('id', '!=', $blog->id)
            ->latest()
            ->take(20)
            ->get()
            ->sortByDesc(fn($p) => count(array_intersect($p->tags ?? [], $currentTags)))
            ->take(3)
            ->values();

        // Popular Topics: unique tags from all published blogs
        $topics = Blog::where('status', 1)
            ->pluck('tags')
            ->flatten()
            ->filter()
            ->unique()
            ->values()
            ->take(8);

        return view('front-pages.blog-detail', compact('blog', 'trending', 'related', 'topics'));
    }

    public function faqs()
    {
        $faqs = Faq::where('status', 1)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // Only show topics that actually have FAQs
        $categories = collect(Faq::CATEGORIES)->only($faqs->pluck('category')->filter()->unique()->all());

        return view('front-pages.faq', compact('faqs', 'categories'));
    }

    public function policies(Request $request)
    {
        $pages = DynamicPage::where('status', 'active')
            ->where('show_in_policies', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        abort_if($pages->isEmpty(), 404);

        // ?tab=<page_name>, falling back to the first page
        $activePage = $pages->firstWhere('page_name', $request->query('tab')) ?? $pages->first();
        $active = $activePage->page_name;

        $lastUpdated = $pages->max('updated_at');

        return view('front-pages.policies', compact('pages', 'active', 'activePage', 'lastUpdated'));
    }

    public function contact()
    {
        $setting = Setting::first();
        $branches = ContactBranch::active()->get();
        $inquiryTypes = ContactEnquiry::TYPES;

        return view('front-pages.contact', compact('setting', 'branches', 'inquiryTypes'));
    }

    public function contactSubmit(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'mobile' => ['required', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'email' => 'nullable|email|max:150',
            'inquiry_type' => ['required', Rule::in(array_keys(ContactEnquiry::TYPES))],
            'message' => 'required|string|max:2000',
        ], [
            'mobile.regex' => 'Please enter a valid phone number.',
        ]);

        ContactEnquiry::create($data);

        return response()->json([
            'success' => true,
            'message' => "Thank you, {$data['name']}! Your inquiry has been received. Our team will contact you.",
        ]);
    }

    public function about()
    {
        $about = AboutPage::first() ?? new AboutPage;
        $stats = AboutStat::active()->get();
        $groups = AboutTestGroup::active()->with('items')->get();
        $commitments = AboutCommitment::active()->get();
        $setting = Setting::first();

        return view('front-pages.about', compact('about', 'stats', 'groups', 'commitments', 'setting'));
    }


    public function repair()
    {
        $page = RepairPage::first() ?? new RepairPage;

        $categories = RepairCategory::active()
            ->with('activeServices')
            ->get()
            ->filter(fn($c) => $c->activeServices->isNotEmpty());

        $options = RepairOption::where('status', true)
            ->orderBy('sort_order')->orderBy('id')
            ->get()
            ->groupBy('type');

        $setting = Setting::first();

        return view('front-pages.repair', compact('page', 'categories', 'options', 'setting'));
    }

    public function repairBook(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'mobile' => ['required', 'regex:/^[0-9+\-\s]{10,15}$/'],
            'device_type' => $this->repairOptionRule('device_type', true),
            'brand' => 'required|string|max:100',
            'model' => 'nullable|string|max:150',
            'issue' => $this->repairOptionRule('issue', true),
            'service_mode' => $this->repairOptionRule('service_mode', false),
            'description' => 'nullable|string|max:2000',
        ], [
            'mobile.regex' => 'Please enter a valid phone number.',
        ]);

        $booking = RepairBooking::create($data);
        $booking->update(['ticket_no' => 'REP-' . (1000 + $booking->id)]);

        return response()->json([
            'success' => true,
            'message' => "Repair Ticket #{$booking->ticket_no} booked for {$data['name']}! Our technician will call you shortly.",
        ]);
    }

    // Must match one of the admin-defined options; if none are defined, any text is accepted
    private function repairOptionRule(string $type, bool $required): array
    {
        $values = RepairOption::where('type', $type)->where('status', true)->pluck('value')->all();

        if (!$values) {
            return ['nullable', 'string', 'max:100'];
        }

        return [$required ? 'required' : 'nullable', Rule::in($values)];
    }



    public function exchange()
    {
        $page = ExchangePage::content();
        $steps = ExchangeStep::active()->get();
        $options = ExchangeOption::active()->get()->groupBy('type');

        return view('front-pages.exchange', compact('page', 'steps', 'options'));
    }

    public function calculateExchange(Request $request)
    {
        $data = $request->validate([
            'category' => 'required|string|max:50',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:150',
            'condition' => 'required|string|max:50',
            'age' => 'nullable|string|max:50',
            'specs' => 'nullable|string|max:150',
            'charger' => 'nullable|string|max:10',
        ]);

        $category = ExchangeOption::active()->ofType('category')->where('value', $data['category'])->first();
        $condition = ExchangeOption::active()->ofType('condition')->where('value', $data['condition'])->first();

        if (!$category || !$condition) {
            return response()->json(['success' => false, 'message' => 'Invalid device category or condition.'], 422);
        }

        $min = (int) $category->base_min;
        $max = (int) $category->base_max;

        // First matching brand rule (ordered by sort_order) adds its bonus
        $brand = strtolower($data['brand']);
        $rule = ExchangeBrandRule::active()->get()
            ->first(fn($r) => $r->keyword !== '' && str_contains($brand, strtolower($r->keyword)));

        if ($rule) {
            $min += $rule->add_min;
            $max += $rule->add_max;
        }

        $min = (int) round($min * $condition->min_multiplier);
        $max = (int) round($max * $condition->max_multiplier);

        ExchangeRequest::create([
            'category' => $data['category'],
            'brand' => $data['brand'],
            'model' => $data['model'],
            'condition' => $data['condition'],
            'age' => $data['age'] ?? null,
            'specs' => $data['specs'] ?? null,
            'charger' => $data['charger'] ?? null,
            'estimated_min' => $min,
            'estimated_max' => $max,
            'ip_address' => $request->ip(),
        ]);

        $page = ExchangePage::content();
        $text = str_replace(['{brand}', '{model}'], [$data['brand'], $data['model']], (string) $page->result_text);

        return response()->json([
            'success' => true,
            'min' => $min,
            'max' => $max,
            'text' => $text,
        ]);
    }


}