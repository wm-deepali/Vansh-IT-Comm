@extends('layouts.app')

@section('title', $product->name . ' | VANSH IT & COMM')
@section('meta_description', \Illuminate\Support\Str::limit(trim(strip_tags($product->short_description ?: $product->description)), 155))
@section('og_type', 'product')

@section('content')

@php
  /*
   | Expects from the controller:
   |   $product, $related
   |   $productAttributes — all active CategoryAttribute rows (ordered, ->attribute loaded)
   |   $listingAttributes — the subset flagged show_on_listing (passed on to related cards)
   |   $variantAttributes — selectable attributes (used_for_variant with 2+ values on this product)
   | Nothing here is hardcoded: empty data hides its block. Settings live in config/shop.php.
   */
  $fallback = asset('assets/img/product-1588872657578-7efd1f1555ed.jpg'); // placeholder only
  $currency = config('shop.currency', '₹');
  $phoneCode = config('shop.phone_code', '+91');
  $defaultIcon = config('shop.default_spec_icon', 'fa-solid fa-circle-check');
  $qcLabel = config('shop.qc_label', 'QC Verified');
  $palette = config('shop.tile_palette', ['bg-blue-50 text-blue-600']);

  // NEW: names of attributes shown as selectors — hidden from tiles and specs table
  $variantNames = collect($variantAttributes ?? [])
    ->map(fn($r) => strtolower($r['attribute']->name))
    ->all();

  $category = $product->category;
  $brandName = $product->brand->name ?? null;
  $sku = $product->sku ?: null;

  // ── Price ──
  $price = $product->price;
  $mrp = $product->mrp;
  $discountPct = ($mrp && $mrp > $price) ? round((($mrp - $price) / $mrp) * 100) : null;
  $taxNote = config('shop.tax_note');

  // ── Rating (only when there are approved reviews) ──
  $reviewsCount = (int) $product->approved_reviews_count;
  $hasRating = $reviewsCount > 0 && $product->approved_reviews_avg_rating !== null;
  $rating = round((float) $product->approved_reviews_avg_rating, 1);
  $full = (int) floor($rating);
  $half = ($rating - $full) >= 0.5;

  // ── Badge: first active collection (by sort_order) ──
  $badgeCollection = $product->collections->where('status', 1)->sortBy('sort_order')->first();
  $badgeText = $badgeCollection ? \Illuminate\Support\Str::upper($badgeCollection->name) : null;
  $badgeColor = $badgeCollection->badge_color ?? null;
  $badgeClass = $badgeColor ? '' : 'badge-tested';

  // ── Gallery (default image first) ──
  $gallery = $product->images->sortByDesc('is_default')->values()->map(fn($i) => [
    'full' => asset('storage/' . $i->image),
    'thumb' => asset('storage/' . ($i->thumb ?? $i->image)),
  ]);
  $mainImg = $gallery->first()['full'] ?? $fallback;

  // ── Key spec tiles: category attributes first, then remaining key specs (max 6) ──
  $tiles = [];
  $seen = [];

  foreach ($productAttributes ?? [] as $ca) {
    $name = $ca->attribute->name ?? null;
    if (!$name)
      continue;
    if (in_array(strtolower($name), $variantNames, true))   // CHANGED: skip selectable attributes
      continue;
    $value = $product->keySpec($name) ?: $product->attr($name);
    if (!filled($value))
      continue;
    $tiles[] = ['label' => $name, 'icon' => $ca->attribute->icon ?: $defaultIcon, 'value' => $value];
    $seen[] = strtolower($name);
  }

  foreach ($product->key_specs ?? [] as $s) {
    $label = trim($s['label'] ?? '');
    $value = trim($s['value'] ?? '');
    if ($label === '' || $value === '' || in_array(strtolower($label), $seen, true))
      continue;
    if (in_array(strtolower($label), $variantNames, true))  // CHANGED: skip selectable attributes
      continue;
    $tiles[] = ['label' => $label, 'icon' => $defaultIcon, 'value' => $value];
    $seen[] = strtolower($label);
  }

  $tiles = array_slice($tiles, 0, 6);

  // ── Full specifications table: base rows → attributes → remaining key specs ──
  $attrSummary = $product->attributeSummary();

  $specRows = collect([
    ['Product Name', $product->name],
    ['Brand', $brandName],
    ['Category', $category->name ?? null],
    ['Condition', $product->condition ? $product->condition . ($product->quality ? ' — ' . $qcLabel : '') : null],
    ['Warranty', $product->warranty],
  ])->filter(fn($r) => filled($r[1]))->values()->all();

  foreach ($attrSummary as $label => $value) {
    if (in_array(strtolower($label), $variantNames, true))  // CHANGED: skip selectable attributes
      continue;
    $specRows[] = [$label, $product->keySpec($label) ?: $value];
  }

  foreach ($product->key_specs ?? [] as $s) {
    $label = $s['label'] ?? '';
    if (in_array(strtolower($label), $variantNames, true))  // CHANGED: skip selectable attributes
      continue;
    $alreadyShown = collect($attrSummary)->keys()->contains(fn($k) => strcasecmp($k, $label) === 0);
    if ($label !== '' && !$alreadyShown) {
      $specRows[] = [$label, $s['value'] ?? ''];
    }
  }

  // ── Tabs: only the ones that have real content ──
  $hasConditionNotes = trim(strip_tags($product->condition_details ?? '')) !== '';
  $hasWarrantyText = trim(strip_tags($product->warranty_coverage ?? '')) !== '';
  $hasShippingText = trim(strip_tags($product->shipping_delivery ?? '')) !== '';

  $tabs = collect([
    ['id' => 'specs', 'label' => 'Technical Specifications', 'show' => count($specRows) > 0],
    ['id' => 'condition', 'label' => 'Condition & Quality Check', 'show' => $hasConditionNotes],
    ['id' => 'warranty', 'label' => 'Warranty & Coverage', 'show' => $hasWarrantyText || filled($product->warranty)],
    ['id' => 'shipping', 'label' => 'Shipping & Delivery', 'show' => $hasShippingText],
  ])->where('show', true)->values();

  $vc = config('shop.video_call', []);

  $isWishlisted = in_array($product->id, \App\Models\Wishlist::currentProductIds());
@endphp

@php
  $conditionMap = ['New' => 'NewCondition', 'Refurbished' => 'RefurbishedCondition', 'Open Box' => 'UsedCondition'];
  $productUrl = route('product.show', $product->slug);

  $productSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->name,
    'description' => \Illuminate\Support\Str::limit(trim(strip_tags($product->short_description ?: $product->description)), 300),
    'image' => $gallery->pluck('full')->all() ?: [$fallback],
    'sku' => $sku,
    'brand' => $brandName ? ['@type' => 'Brand', 'name' => $brandName] : null,
    'category' => $category->name ?? null,
    'url' => $productUrl,
    'offers' => [
      '@type' => 'Offer',
      'url' => $productUrl,
      'priceCurrency' => 'INR',
      'price' => number_format((float) $price, 2, '.', ''),
      'itemCondition' => isset($conditionMap[$product->condition]) ? 'https://schema.org/' . $conditionMap[$product->condition] : null,
      // Stock logic variants par depend karta hai, isliye abhi InStock; apna accessor ho to yahan lagayen
      'availability' => 'https://schema.org/InStock',
    ],
    'aggregateRating' => $hasRating
      ? ['@type' => 'AggregateRating', 'ratingValue' => $rating, 'reviewCount' => $reviewsCount]
      : null,
  ];

  $productCrumbs = [
    ['name' => 'Home', 'url' => route('home')],
    ['name' => $category->name ?? 'Categories', 'url' => $category ? route('category.show', $category->slug) : route('categories')],
    ['name' => $product->name, 'url' => $productUrl],
  ];
@endphp

@section('og_image', $mainImg)

  @push('meta')
    <meta property="product:price:amount" content="{{ number_format((float) $price, 2, '.', '') }}" />
    <meta property="product:price:currency" content="INR" />
  @endpush

  @push('schema')
    @include('partials.json-ld', ['data' => $productSchema])
  @endpush

  @include('partials.breadcrumbs', ['visible' => false, 'crumbs' => $productCrumbs])

  <style>
    .rich-content p {
      margin-bottom: .6rem;
    }

    .rich-content h3,
    .rich-content h4 {
      font-weight: 700;
      color: #0f172a;
      margin: .9rem 0 .35rem;
    }

    .rich-content ul {
      list-style: disc;
      padding-left: 1.1rem;
      margin-bottom: .6rem;
    }

    .rich-content ol {
      list-style: decimal;
      padding-left: 1.1rem;
      margin-bottom: .6rem;
    }

    .rich-content a {
      color: #2563eb;
      text-decoration: underline;
    }
  </style>

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        @if($category)
          <a href="{{ route('category.show', $category->slug) }}" class="hover:text-blue-600"
            id="prod-bread-cat">{{ $category->name }}</a>
        @else
          <a href="{{ route('categories') }}" class="hover:text-blue-600" id="prod-bread-cat">Categories</a>
        @endif
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold truncate max-w-xs sm:max-w-md"
          id="prod-bread-title">{{ $product->name }}</span>
      </nav>

      <!-- Main Product View -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12 mb-12 sm:mb-16 items-start">

        <!-- Left: Image Gallery & Video Request -->
        <div class="lg:col-span-6 space-y-3 sm:space-y-4">
          <div
            class="relative bg-white border border-slate-200 rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm overflow-hidden flex items-center justify-center min-h-[260px] sm:min-h-[380px] lg:min-h-[420px]">
            <img id="main-product-image" src="{{ $mainImg }}" alt="{{ $product->name }}"
              class="max-h-[240px] sm:max-h-[340px] lg:max-h-[380px] max-w-full object-contain transition-all duration-300 hover:scale-105 cursor-zoom-in"
              onerror="this.onerror=null; this.src='{{ $fallback }}';"
              onclick="window.openImageLightbox && openImageLightbox()" />

            @if($badgeText)
              <div class="absolute top-3 sm:top-4 left-3 sm:left-4 z-10">
                <span id="prod-badge"
                  class="badge {{ $badgeClass }} text-[10px] sm:text-xs px-2.5 sm:px-3 py-0.5 sm:py-1 font-bold"
                  @if($badgeColor) style="background-color: {{ $badgeColor }}; color: #fff;" @endif>{{ $badgeText }}</span>
              </div>
            @endif

            <button type="button" data-wishlist-btn="{{ $product->id }}"
              aria-pressed="{{ $isWishlisted ? 'true' : 'false' }}"
              class="heart-btn absolute top-3 sm:top-4 right-3 sm:right-4 z-10 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50/90 border border-slate-200 {{ $isWishlisted ? 'text-red-500' : 'text-slate-600' }} flex items-center justify-center hover:bg-white hover:text-red-500 shadow-sm transition-all"
              aria-label="Add to Wishlist">
              <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart text-sm sm:text-base"></i>
            </button>
          </div>

          <!-- Thumbnails -->
          <div
            class="flex items-center gap-2 sm:gap-3 overflow-x-auto no-scrollbar pb-1 {{ $gallery->count() > 1 ? '' : 'hidden' }}"
            id="prod-thumbnails-container">
            @foreach($gallery as $idx => $g)
              <button type="button" onclick="setMainImage('{{ $g['full'] }}', this)"
                class="prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 {{ $idx === 0 ? 'border-blue-600' : 'border-slate-200' }} bg-white p-1 flex-shrink-0 transition-all hover:border-blue-400">
                <img src="{{ $g['thumb'] }}" alt="{{ $product->name }}" class="w-full h-full object-contain" />
              </button>
            @endforeach
          </div>

          <!-- Video demo request -->
          @if($product->video_call_demo)
            <div
              class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 p-3.5 sm:p-5 rounded-2xl text-white flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4 shadow-sm text-center sm:text-left">
              <div>
                <div
                  class="flex items-center justify-center sm:justify-start gap-1.5 text-[10px] sm:text-xs font-bold text-blue-400 uppercase tracking-wider mb-0.5">
                  <i class="fa-solid fa-camera-retro"></i> Actual Product Transparency
                </div>
                <h4 class="font-bold text-xs sm:text-sm text-white">Want to see live photos & video of this unit?</h4>
                <p class="text-[11px] sm:text-xs text-slate-300">Request actual unit serial number inspection before
                  dispatch.</p>
              </div>
              <button type="button" onclick="openVideoCallDrawer()"
                class="btn-base btn-primary text-xs px-3.5 sm:px-4 py-2 font-semibold flex-shrink-0 w-full sm:w-auto text-center justify-center shadow-md">
                <i class="fa-solid fa-video mr-1.5"></i> Video Call Demo
              </button>
            </div>
          @endif
        </div>

        <!-- Right: Details, Pricing, Pincode Checker, Actions -->
        <div class="lg:col-span-6 sticky top-28 space-y-3.5 sm:space-y-4">
          <div class="space-y-3.5 sm:space-y-4">

            <!-- Brand & SKU -->
            @if($brandName || $sku || collect($variantData)->contains('type', 'sku'))
              <div class="flex items-center justify-between text-xs text-slate-500">
                <span class="font-bold text-blue-600 uppercase tracking-wider" id="prod-brand">{{ $brandName }}</span>
                <span id="prod-sku" class="{{ $sku ? '' : 'hidden' }}">SKU: <span
                    id="prod-sku-value">{{ $sku }}</span></span>
              </div>
            @endif

            <!-- Title -->
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-slate-900 font-heading leading-tight"
              id="prod-name">
              {{ $product->name }}
            </h1>

            <!-- Ratings & QC -->
            @if($hasRating || $product->quality)
              <div class="flex items-center gap-2 sm:gap-3 text-xs flex-wrap">
                <div id="prod-stars" class="flex items-center">
                  <div class="flex items-center text-amber-400 text-[9px] sm:text-xs gap-0.5"
                    aria-label="{{ $rating }} out of 5 stars">
                    @for($i = 0; $i < 5; $i++)
                      @if($i < $full)
                        <i class="fa-solid fa-star"></i>
                      @elseif($i === $full && $half)
                        <i class="fa-solid fa-star-half-stroke"></i>
                      @else
                        <i class="fa-regular fa-star text-slate-300"></i>
                      @endif
                    @endfor
                    <span class="text-slate-500 font-bold ml-1 text-[9px] sm:text-xs">{{ number_format($rating, 1) }}</span>
                  </div>
                </div>
                <span class="text-slate-300">•</span>
                <span class="text-slate-600 font-medium text-[11px] sm:text-xs" id="prod-reviews-count">{{ $reviewsCount }}
                  verified {{ \Illuminate\Support\Str::plural('review', $reviewsCount) }}</span>
                @if($product->quality)
                  @if($hasRating)<span class="text-slate-300">•</span>@endif
                  <span class="badge bg-emerald-50 text-emerald-700 font-bold text-[10px] sm:text-xs px-2 py-0.5"><i
                      class="fa-solid fa-circle-check"></i> {{ $qcLabel }}</span>
                @endif
              </div>
            @endif

            <!-- Price Block -->
            <div class="p-3.5 sm:p-4 bg-slate-50 rounded-2xl border border-slate-200">
              <div class="flex items-baseline gap-2.5 sm:gap-3 flex-wrap">
                <span class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 font-body"
                  id="prod-price">{{ $currency }}{{ number_format($price) }}</span>
                <span
                  class="text-sm sm:text-base text-slate-400 line-through font-medium {{ $discountPct ? '' : 'hidden' }}"
                  id="prod-mrp">{{ $discountPct ? $currency . number_format($mrp) : '' }}</span>
                <span
                  class="text-[10px] sm:text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md {{ $discountPct ? '' : 'hidden' }}"
                  id="prod-discount">{{ $discountPct ? $discountPct . '% OFF' : '' }}</span>
              </div>
              @if($taxNote)
                <p class="text-[11px] sm:text-xs text-slate-500 mt-1">{{ $taxNote }}</p>
              @endif
              <p id="prod-stock" class="text-[11px] sm:text-xs font-semibold mt-1.5 hidden"></p>

              @if($product->delivery_time)
                <div
                  class="mt-2.5 pt-2.5 border-t border-slate-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-1 sm:gap-0 text-[11px] sm:text-xs text-slate-700">
                  @if($product->delivery_time)
                    <span class="text-emerald-600 font-semibold flex items-center gap-1"><i
                        class="fa-solid fa-truck text-emerald-600"></i> Delivery in {{ $product->delivery_time }}</span>
                  @endif
                </div>
              @endif
            </div>

            <!-- Key Specs (dynamic: category attributes, then key specs) -->
            @if(count($tiles))
              <div
                class="grid grid-cols-2 md:grid-cols-3 gap-2 sm:gap-2.5 bg-white p-3 sm:p-4 rounded-2xl border border-slate-200 shadow-sm"
                id="prod-key-specs">
                @foreach($tiles as $i => $tile)
                  <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
                    <div
                      class="w-6 h-6 rounded-lg {{ $palette[$i % count($palette)] }} flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
                      <i class="{{ $tile['icon'] }}"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                      <span
                        class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">{{ $tile['label'] }}</span>
                      <strong class="text-xs font-bold text-slate-800 leading-tight block truncate"
                        title="{{ $tile['value'] }}">{{ $tile['value'] }}</strong>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif


            <!-- Variant Options (attributes with used_for_variant; first value preselected) -->
            @if($variantAttributes->isNotEmpty())
              <div id="variant-options" class="space-y-3 bg-white p-3 sm:p-4 rounded-2xl border border-slate-200 shadow-sm">
                @foreach($variantAttributes as $row)
                  @php $attr = $row['attribute']; @endphp
                  <div data-variant-group="{{ $attr->id }}">
                    <div class="text-xs font-bold text-slate-700 mb-1.5">
                      {{ $attr->name }}:
                      <span data-variant-label class="text-slate-900">{{ $row['values']->first()->value }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                      @foreach($row['values'] as $v)
                        <label class="cursor-pointer">
                          <input type="radio" class="peer sr-only" name="variant[{{ $attr->id }}]" value="{{ $v->id }}"
                            data-label="{{ $v->value }}" @checked($loop->first) />
                          <span
                            class="block px-3 py-1.5 rounded-xl border border-slate-200 bg-slate-50 text-xs font-semibold text-slate-700 transition-all hover:border-blue-400 peer-checked:border-blue-600 peer-checked:bg-blue-50 peer-checked:text-blue-700 peer-focus-visible:ring-2 peer-focus-visible:ring-blue-300">
                            {{ $v->value }}
                          </span>
                        </label>
                      @endforeach
                    </div>
                  </div>
                @endforeach
              </div>
            @endif

            <!-- Pincode Delivery Checker -->
            <div class="p-3 sm:p-3.5 bg-slate-50 rounded-xl border border-slate-200">
              <label for="pincode-input" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <i class="fa-solid fa-location-dot text-blue-600"></i> Check Delivery Availability
              </label>
              <div class="flex items-center gap-2">
                <input type="text" id="pincode-input" maxlength="6" placeholder="Enter 6-digit PIN code"
                  class="flex-1 bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
                <button type="button" onclick="checkPincode()"
                  class="btn-base btn-secondary btn-sm text-xs font-semibold py-2 px-3">
                  Check
                </button>
              </div>
              <div id="pincode-status" class="text-xs mt-2 hidden"></div>
            </div>

            <!-- CTA Buttons -->
            <div class="space-y-2 pt-1 sm:pt-2">
              <div class="grid grid-cols-2 gap-2 sm:gap-3">
                <button type="button" id="prod-add-cart-btn" data-add-to-cart data-product-id="{{ $product->id }}"
                  class="btn-base btn-secondary py-2.5 sm:py-3.5 text-xs sm:text-sm font-semibold w-full justify-center shadow-sm">
                  <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                </button>
                <button type="button" id="prod-buy-now-btn" data-buy-now="{{ $product->id }}"
                  class="btn-base btn-primary py-2.5 sm:py-3.5 text-xs sm:text-sm font-semibold w-full justify-center shadow-lg shadow-blue-600/30">
                  <i class="fa-solid fa-bolt"></i> Buy Now
                </button>
              </div>
            </div>

            <!-- Trust Bar (driven by product flags) -->
            <div class="grid grid-cols-3 gap-1.5 sm:gap-2 text-center pt-1 text-[10px] sm:text-[11px] text-slate-600">
              @if($product->warranty_backed)
                <div class="p-1.5 sm:p-2 rounded-xl bg-white border border-slate-100 shadow-2xs">
                  <i class="fa-solid fa-shield-halved text-blue-600 text-xs sm:text-sm mb-0.5 sm:mb-1 block"></i>
                  <span>Warranty Backed</span>
                </div>
              @endif
              @if($product->seven_day_returns)
                <div class="p-1.5 sm:p-2 rounded-xl bg-white border border-slate-100 shadow-2xs">
                  <i class="fa-solid fa-arrow-rotate-left text-emerald-600 text-xs sm:text-sm mb-0.5 sm:mb-1 block"></i>
                  <span>7-Day Returns</span>
                </div>
              @endif
              @if($product->insured_transit)
                <div class="p-1.5 sm:p-2 rounded-xl bg-white border border-slate-100 shadow-2xs">
                  <i class="fa-solid fa-box text-purple-600 text-xs sm:text-sm mb-0.5 sm:mb-1 block"></i>
                  <span>Insured Transit</span>
                </div>
              @endif
            </div>

          </div>
        </div>

      </div>

      <!-- Specifications & Details Tabs (only tabs with real content) -->
      @if($tabs->isNotEmpty())
        <section
          class="bg-white border border-slate-200 rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-10 mb-12 sm:mb-16 shadow-sm">
          <div
            class="flex items-center gap-1.5 sm:gap-2 border-b border-slate-200 pb-3 overflow-x-auto no-scrollbar text-xs sm:text-sm font-bold">
            @foreach($tabs as $tab)
              <button type="button" data-tab-btn="{{ $tab['id'] }}" onclick="switchTab('{{ $tab['id'] }}')"
                class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl flex-shrink-0 {{ $loop->first ? 'bg-blue-600 text-white' : 'text-slate-600 hover:bg-slate-100' }}">{{ $tab['label'] }}</button>
            @endforeach
          </div>

          @foreach($tabs as $tab)
            <div data-tab-content="{{ $tab['id'] }}" class="py-6 {{ $loop->first ? '' : 'hidden' }}">

              @if($tab['id'] === 'specs')
                <h3 class="text-lg font-bold text-slate-900 mb-4 font-heading">Complete Technical Specifications</h3>
                <div class="overflow-x-auto">
                  <table class="w-full text-xs text-left text-slate-700 border border-slate-200 rounded-xl overflow-hidden"
                    id="prod-full-specs-table">
                    @foreach($specRows as [$label, $value])
                      <tr class="border-b border-slate-100 hover:bg-slate-50">
                        <td class="py-2.5 px-4 font-bold text-slate-600 w-1/3 bg-slate-50/50">{{ $label }}</td>
                        <td class="py-2.5 px-4 text-slate-800 font-medium">{{ $value }}</td>
                      </tr>
                    @endforeach
                  </table>
                </div>

              @elseif($tab['id'] === 'condition')
                <div class="space-y-4 text-xs text-slate-700 leading-relaxed font-body">
                  <div class="flex items-center justify-between flex-wrap gap-2">
                    <h3 class="text-lg font-bold text-slate-900 font-heading">Condition & Quality Check</h3>
                    @if($product->quality)
                      <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-3 py-1 font-bold">
                        <i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i> {{ $qcLabel }}
                      </span>
                    @endif
                  </div>
                  <div class="rich-content p-4 rounded-2xl bg-slate-50 border border-slate-200">
                    {!! $product->condition_details !!}
                  </div>
                </div>

              @elseif($tab['id'] === 'warranty')
                <div class="space-y-4 text-xs text-slate-700 leading-relaxed font-body">
                  <h3 class="text-lg font-bold text-slate-900 font-heading">Warranty Policy & Claims</h3>
                  @if($product->warranty)
                    <p class="font-semibold text-slate-900"><i class="fa-solid fa-shield-halved text-blue-600 mr-1"></i>
                      {{ $product->warranty }}
                    </p>
                  @endif
                  @if($hasWarrantyText)
                    <div class="rich-content">{!! $product->warranty_coverage !!}</div>
                  @endif
                </div>

              @elseif($tab['id'] === 'shipping')
                <div class="space-y-4 text-xs text-slate-700 leading-relaxed font-body">
                  <h3 class="text-lg font-bold text-slate-900 font-heading">Shipping & Delivery</h3>
                  <div class="rich-content">{!! $product->shipping_delivery !!}</div>
                </div>
              @endif

            </div>
          @endforeach
        </section>
      @endif

      <!-- Related Products -->
      @if($related->count())
        <section class="mb-12">
          <div class="flex items-center justify-between gap-3 mb-6">
            <h3 class="text-lg sm:text-2xl font-bold text-slate-900 font-heading truncate">You Might Also Like</h3>
            @if($category)
              <a href="{{ route('category.show', $category->slug) }}"
                class="text-xs font-bold text-blue-600 hover:underline whitespace-nowrap flex-shrink-0">View All →</a>
            @endif
          </div>
          <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6"
            id="related-products-grid">
            @foreach($related as $relatedProduct)
              @include('partials.product-card', ['product' => $relatedProduct, 'listingAttributes' => $listingAttributes])
            @endforeach
          </div>
        </section>
      @endif

    </div>
  </main>

  <!-- Slide-In Right Drawer for Live Video Inspection Call -->
  @if($product->video_call_demo)
    <div id="video-call-drawer"
      class="fixed inset-0 z-50 pointer-events-none opacity-0 transition-opacity duration-300 ease-in-out"
      aria-hidden="true">
      <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" onclick="closeVideoCallDrawer()">
      </div>

      <div
        class="absolute right-0 top-0 bottom-0 w-full max-w-md bg-white shadow-2xl flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-in-out z-10"
        id="video-call-drawer-box">
        <div
          class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-slate-900 text-white flex-shrink-0">
          <div class="flex items-center gap-2.5">
            <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-base shadow-md">
              <i class="fa-solid fa-video"></i>
            </div>
            <div>
              <h3 class="text-base font-extrabold font-heading text-white leading-tight">Live Video Call Inspection</h3>
              <p class="text-[11px] text-blue-300">Direct unit verification with technician</p>
            </div>
          </div>
          <button type="button" onclick="closeVideoCallDrawer()"
            class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition-colors">
            <i class="fa-solid fa-xmark text-sm"></i>
          </button>
        </div>

        <div class="p-5 sm:p-6 overflow-y-auto space-y-5 flex-1 text-xs">

          <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-3">
            <img id="drawer-prod-img" src="{{ $mainImg }}" alt="{{ $product->name }}"
              onerror="this.onerror=null; this.src='{{ $fallback }}';"
              class="w-14 h-14 object-contain rounded-xl bg-white p-1 border border-slate-200 flex-shrink-0" />
            <div class="flex-1 min-w-0">
              @if($product->quality)
                <span class="badge bg-emerald-100 text-emerald-800 text-[9px] font-bold"><i
                    class="fa-solid fa-circle-check"></i> {{ $qcLabel }}</span>
              @endif
              <h4 class="font-extrabold text-slate-900 text-xs truncate mt-0.5" id="drawer-prod-name">{{ $product->name }}
              </h4>
              <span class="text-xs font-black text-blue-600 font-heading"
                id="drawer-prod-price">{{ $currency }}{{ number_format($price) }}</span>
            </div>
          </div>

          <div class="p-3.5 rounded-2xl bg-blue-50/60 border border-blue-100 text-slate-700 space-y-1">
            <div class="font-bold text-blue-900 flex items-center gap-1.5">
              <i class="fa-solid fa-circle-info text-blue-600"></i> Why Book a Live Video Call?
            </div>
            <p class="text-[11px] text-slate-600 leading-relaxed">
              Inspect the unit's condition, ports and working live on video before making a payment.
            </p>
          </div>

          <!-- Inspection Form (options come from config/shop.php) -->
          <form id="video-call-form" class="space-y-4" onsubmit="handleVideoCallBooking(event)">
            <div>
              <label class="block text-xs font-bold text-slate-800 mb-1">Your Full Name *</label>
              <input type="text" id="vcall-name" required placeholder="Your full name"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition-all" />
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-800 mb-1">WhatsApp / Mobile Number *</label>
              <div class="relative flex items-center">
                <span class="absolute left-3.5 text-slate-400 font-bold text-xs">{{ $phoneCode }}</span>
                <input type="tel" id="vcall-phone" required maxlength="10" placeholder="10-digit mobile"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition-all" />
              </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
              <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">Platform</label>
                <select id="vcall-platform"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  @foreach($vc['platforms'] ?? [] as $platform)
                    <option value="{{ $platform }}">{{ $platform }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-800 mb-1">Preferred Slot</label>
                <select id="vcall-slot"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  @foreach($vc['slots'] ?? [] as $slot)
                    <option value="{{ $slot }}">{{ $slot }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            @if(!empty($vc['checks']))
              <div>
                <label class="block text-xs font-bold text-slate-800 mb-1.5">What would you like to inspect?</label>
                <div class="space-y-1.5 text-[11px] text-slate-700">
                  @foreach($vc['checks'] as $check)
                    <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked
                        class="rounded text-blue-600" /> {{ $check }}</label>
                  @endforeach
                </div>
              </div>
            @endif

            <div>
              <label class="block text-xs font-bold text-slate-800 mb-1">Specific Query / Requirement</label>
              <textarea id="vcall-notes" rows="2" placeholder="Anything specific you'd like to see?"
                class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white"></textarea>
            </div>

            <button type="submit"
              class="btn-base btn-primary w-full py-3.5 text-xs font-bold justify-center shadow-lg shadow-blue-600/30">
              <i class="fa-solid fa-video mr-1.5"></i> Schedule Video Inspection Call
            </button>
          </form>

          <div id="video-call-success" class="hidden text-center py-6 space-y-3">
            <div
              class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mx-auto shadow-sm">
              <i class="fa-solid fa-circle-check"></i>
            </div>
            <h4 class="text-base font-extrabold text-slate-900 font-heading">Video Call Scheduled!</h4>
            <p class="text-xs text-slate-600 leading-relaxed max-w-xs mx-auto">
              Our technician will connect with you on <strong id="vcall-confirm-phone" class="text-slate-900"></strong> for
              live unit inspection.
            </p>
            <div class="pt-2">
              <button type="button" onclick="closeVideoCallDrawer()" class="btn-base btn-secondary btn-sm text-xs">
                Back to Product Details
              </button>
            </div>
          </div>

        </div>

        <div
          class="p-4 bg-slate-50 border-t border-slate-100 text-[11px] text-slate-500 text-center flex items-center justify-center gap-2 flex-shrink-0">
          <i class="fa-solid fa-lock text-slate-400"></i> No Obligation to Buy • 100% Free Live Demonstration
        </div>
      </div>
    </div>
  @endif

@endsection

@push('scripts')
  @include('partials.cart-helpers')
  @include('partials.cart-js')
  @include('partials.wishlist-js')
  <script>
    const PAGE = {
      productId: @json($product->id),
      deliveryTime: @json($product->delivery_time),
      phoneCode: @json($phoneCode),
      checkoutUrl: @json(route('checkout')),
      pincodeUrl: @json(route('pincode.check')),
    };

    // ==========================================
    // VARIANT SELECTION + RESOLUTION
    // ==========================================
    const VARIANTS = @json($variantData);
    const FIXED_VALUE_IDS = @json($fixedValueIds);
    const BASE = {
      price: @json((float) $product->price),
      mrp: @json((float) $product->mrp),
      sku: @json($product->sku),
      stock: @json((int) $product->stock),
      currency: @json($currency),
      lowStock: @json((int) config('shop.low_stock', 5)),
    };
    const byId = id => document.getElementById(id);
    const fmt = n => BASE.currency + Math.round(n).toLocaleString('en-US');
    const ORIG = { ready: false, imageVariantId: undefined };

    // { attributeId: attributeValueId } for the selectors on the page
    window.getSelectedVariant = function () {
      const selected = {};
      document.querySelectorAll('#variant-options input[type=radio]:checked').forEach(r => {
        selected[r.name.match(/\[(\d+)\]/)[1]] = parseInt(r.value, 10);
      });
      return selected;
    };

    function selectedValueIds() {
      const ids = new Set(FIXED_VALUE_IDS);
      Object.values(window.getSelectedVariant()).forEach(v => ids.add(v));
      return ids;
    }

    // A variant matches if ALL its values are selected; most specific match wins
    function resolveVariant(type, ids) {
      let best = null;
      VARIANTS.forEach(v => {
        if (v.type !== type || !v.value_ids.length) return;
        if (!v.value_ids.every(id => ids.has(id))) return;
        if (!best || v.value_ids.length > best.value_ids.length) best = v;
      });
      return best;
    }

    // For the cart: matches cart_items.price_variant_id / image_variant_id / stock_variant_id / sku_variant_id
    window.getResolvedVariants = function () {
      const ids = selectedValueIds();
      const get = t => (resolveVariant(t, ids) || {}).id ?? null;
      return {
        price_variant_id: get('price'),
        image_variant_id: get('image'),
        stock_variant_id: get('stock'),
        sku_variant_id: get('sku'),
      };
    };

    // Read by partials.cart-js on every Add to Cart / Buy Now from this page
    window.getCartExtraPayload = function () {
      return {
        ...window.getResolvedVariants(),   // price_variant_id, image_variant_id, stock_variant_id, sku_variant_id
        selected_values: Object.values(window.getSelectedVariant()),   // value ids the customer picked
      };
    };

    function applyVariant() {
      if (!VARIANTS.length) return;   // product has no variants: leave the page untouched

      const ids = selectedValueIds();
      const pv = resolveVariant('price', ids);
      const iv = resolveVariant('image', ids);
      const sv = resolveVariant('stock', ids);
      const kv = resolveVariant('sku', ids);

      // ── Price ──
      const usePrice = pv && pv.price > 0;
      const price = usePrice ? pv.price : BASE.price;
      const mrp = usePrice ? pv.mrp : BASE.mrp;
      const pct = mrp > price ? Math.round(((mrp - price) / mrp) * 100) : 0;

      byId('prod-price').textContent = fmt(price);
      const mrpEl = byId('prod-mrp'), pctEl = byId('prod-discount');
      if (mrpEl && pctEl) {
        mrpEl.textContent = pct ? fmt(mrp) : '';
        pctEl.textContent = pct ? pct + '% OFF' : '';
        mrpEl.classList.toggle('hidden', !pct);
        pctEl.classList.toggle('hidden', !pct);
      }
      const drawerPrice = byId('drawer-prod-price');
      if (drawerPrice) drawerPrice.textContent = fmt(price);

      // ── SKU ──
      const skuEl = byId('prod-sku');
      if (skuEl) {
        const sku = kv && kv.sku ? kv.sku : BASE.sku;
        byId('prod-sku-value').textContent = sku || '';
        skuEl.classList.toggle('hidden', !sku);
      }

      // ── Stock ──
      const stock = sv ? sv.stock : BASE.stock;
      const stockEl = byId('prod-stock');
      if (stockEl) {
        stockEl.className = 'text-[11px] sm:text-xs font-semibold mt-1.5 ' +
          (stock <= 0 ? 'text-red-600' : stock <= BASE.lowStock ? 'text-amber-600' : 'text-emerald-600');
        stockEl.textContent = stock <= 0 ? 'Out of stock'
          : stock <= BASE.lowStock ? `Only ${stock} left in stock` : 'In stock';
      }
      ['prod-add-cart-btn', 'prod-buy-now-btn'].forEach(id => {
        const b = byId(id);
        if (!b) return;
        if (!b.dataset.label) b.dataset.label = b.innerHTML;
        const out = stock <= 0;
        b.disabled = out;
        b.classList.toggle('opacity-50', out);
        b.classList.toggle('cursor-not-allowed', out);
        b.innerHTML = out ? '<i class="fa-solid fa-ban"></i> Out of Stock' : b.dataset.label;
      });

      // ── Images (only re-render when the matched image variant changes) ──
      const mainEl = byId('main-product-image');
      const thumbs = byId('prod-thumbnails-container');
      if (!ORIG.ready) {
        ORIG.main = mainEl.getAttribute('src');
        ORIG.thumbs = thumbs ? thumbs.innerHTML : '';
        ORIG.thumbsHidden = thumbs ? thumbs.classList.contains('hidden') : true;
        ORIG.ready = true;
      }
      const imageId = iv && iv.images.length ? iv.id : null;
      if (imageId !== ORIG.imageVariantId) {
        ORIG.imageVariantId = imageId;
        const drawerImg = byId('drawer-prod-img');

        if (imageId) {
          mainEl.src = iv.images[0].full;
          if (drawerImg) drawerImg.src = iv.images[0].full;
          if (thumbs) {
            thumbs.innerHTML = '';
            iv.images.forEach((g, i) => {
              const b = document.createElement('button');
              b.type = 'button';
              b.className = 'prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 bg-white p-1 flex-shrink-0 transition-all ' +
                (i === 0 ? 'border-blue-600' : 'border-slate-200 hover:border-blue-400');
              b.onclick = () => setMainImage(g.full, b);
              const im = document.createElement('img');
              im.src = g.thumb || g.full;
              im.className = 'w-full h-full object-contain';
              b.appendChild(im);
              thumbs.appendChild(b);
            });
            thumbs.classList.toggle('hidden', iv.images.length < 2);
          }
        } else {
          mainEl.setAttribute('src', ORIG.main);
          if (drawerImg) drawerImg.setAttribute('src', ORIG.main);
          if (thumbs) {
            thumbs.innerHTML = ORIG.thumbs;
            thumbs.classList.toggle('hidden', ORIG.thumbsHidden);
          }
        }
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      document.querySelectorAll('#variant-options input[type=radio]').forEach(r => {
        r.addEventListener('change', () => {
          const label = r.closest('[data-variant-group]').querySelector('[data-variant-label]');
          if (label) label.textContent = r.dataset.label;
          document.dispatchEvent(new CustomEvent('variant:changed', { detail: window.getSelectedVariant() }));
        });
      });
      document.addEventListener('variant:changed', applyVariant);
      applyVariant();   // resolve the preselected values on load
    });

    // ==========================================
    // BUY NOW (Add to Cart is handled by partials.cart-js)
    // ==========================================
    async function buyNow(btn) {
      setBtnLoading(btn, true, 'Please wait...');
      try {
        const data = await window.postAddToCart(PAGE.productId);
        syncHeaderCart(data);
        if (window.fireTrackingEvents) fireTrackingEvents(data.tracking_events);
        window.location.href = PAGE.checkoutUrl;
      } catch (e) {
        toast(e.message, 'error');
        setBtnLoading(btn, false);
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const buyBtn = document.getElementById('prod-buy-now-btn');
      if (buyBtn) buyBtn.addEventListener('click', e => { e.stopPropagation(); buyNow(buyBtn); });

      const pinInput = document.getElementById('pincode-input');
      if (pinInput) {
        pinInput.addEventListener('input', () => { pinInput.value = pinInput.value.replace(/\D/g, ''); });
        pinInput.addEventListener('keydown', e => { if (e.key === 'Enter') { e.preventDefault(); checkPincode(); } });
      }

    });

    // ==========================================
    // GALLERY / TABS / PINCODE
    // ==========================================
    function setMainImage(src, btn) {
      document.getElementById('main-product-image').src = src;
      document.querySelectorAll('.prod-thumb').forEach(t => t.className = 'prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 border-slate-200 bg-white p-1 flex-shrink-0 transition-all hover:border-blue-400');
      btn.className = 'prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 border-blue-600 bg-white p-1 flex-shrink-0 transition-all';
    }

    function switchTab(tabId) {
      const on = 'px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl flex-shrink-0 bg-blue-600 text-white';
      const off = 'px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl flex-shrink-0 text-slate-600 hover:bg-slate-100';

      document.querySelectorAll('[data-tab-content]').forEach(c =>
        c.classList.toggle('hidden', c.dataset.tabContent !== tabId));
      document.querySelectorAll('[data-tab-btn]').forEach(b =>
        b.className = b.dataset.tabBtn === tabId ? on : off);
    }

    async function checkPincode() {
      const input = document.getElementById('pincode-input');
      const status = document.getElementById('pincode-status');
      const btn = input.closest('div').querySelector('button');
      const pin = (input.value || '').trim();

      const esc = s => String(s ?? '').replace(/[&<>"']/g, c =>
        ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
      const show = (html) => { status.classList.remove('hidden'); status.innerHTML = html; };
      const fail = (msg) => show(`<span class="text-red-500 font-semibold"><i class="fa-solid fa-triangle-exclamation"></i> ${esc(msg)}</span>`);

      if (!/^\d{6}$/.test(pin)) { fail('Please enter a valid 6-digit PIN code.'); return; }

      btn.disabled = true;
      show('<span class="text-slate-500"><i class="fa-solid fa-spinner fa-spin"></i> Checking...</span>');

      try {
        const res = await fetch(`${PAGE.pincodeUrl}?pincode=${encodeURIComponent(pin)}`, {
          headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const data = await res.json().catch(() => ({}));

        if (res.status === 429) { fail('Too many attempts. Please wait a minute and try again.'); return; }
        if (res.status === 422) { fail(data.errors?.pincode?.[0] || 'Please enter a valid 6-digit PIN code.'); return; }
        if (!res.ok) { fail('Could not check this PIN code right now. Please try again.'); return; }

        if (!data.status) { fail(data.message || 'Delivery is not available for this PIN code.'); return; }

        const place = [data.district, data.state].filter(Boolean).join(', ');
        const eta = PAGE.deliveryTime ? `Estimated delivery in ${PAGE.deliveryTime}` : 'Delivery is available';

        show(`<span class="text-emerald-600 font-bold"><i class="fa-solid fa-circle-check"></i> ${esc(eta)}</span>
              to <strong>${esc(data.pincode)}</strong>${place ? ` (${esc(place)})` : ''}.`);
      } catch (e) {
        fail('Network error. Please check your connection and try again.');
      } finally {
        btn.disabled = false;
      }
    }

    // ==========================================
    // SLIDE-IN RIGHT DRAWER (Live Video Call)
    // ==========================================
    function openVideoCallDrawer() {
      const drawer = document.getElementById('video-call-drawer');
      const drawerBox = document.getElementById('video-call-drawer-box');
      if (!drawer || !drawerBox) return;

      drawer.classList.remove('pointer-events-none', 'opacity-0');
      drawer.classList.add('opacity-100');
      drawerBox.classList.remove('translate-x-full');
      drawerBox.classList.add('translate-x-0');
      document.body.style.overflow = 'hidden';
    }

    function closeVideoCallDrawer() {
      const drawer = document.getElementById('video-call-drawer');
      const drawerBox = document.getElementById('video-call-drawer-box');
      if (!drawer || !drawerBox) return;

      drawerBox.classList.remove('translate-x-0');
      drawerBox.classList.add('translate-x-full');
      drawer.classList.remove('opacity-100');
      drawer.classList.add('opacity-0', 'pointer-events-none');
      document.body.style.overflow = '';

      setTimeout(() => {
        const form = document.getElementById('video-call-form');
        const success = document.getElementById('video-call-success');
        if (form) form.classList.remove('hidden');
        if (success) success.classList.add('hidden');
      }, 300);
    }

    // Static for now (no booking backend yet)
    function handleVideoCallBooking(e) {
      e.preventDefault();
      const phone = document.getElementById('vcall-phone').value.trim();
      const platform = document.getElementById('vcall-platform').value;
      const slot = document.getElementById('vcall-slot').value;

      document.getElementById('video-call-form').classList.add('hidden');
      document.getElementById('video-call-success').classList.remove('hidden');
      document.getElementById('vcall-confirm-phone').textContent = `${PAGE.phoneCode} ${phone}`;

      toast(`Video call request sent for ${platform} (${slot})!`, 'success');
    }
  </script>
@endpush