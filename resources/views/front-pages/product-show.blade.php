@extends('layouts.app')

@section('title', ($product->meta_title ?: $product->name) . ' | ' . config('app.name'))
@section('meta_description', $product->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($product->short_description ?? ''), 155))

@section('content')

  @php
    /*
     | Expects from the controller:
     |   $product, $related
     |   $productAttributes — all active CategoryAttribute rows (ordered, ->attribute loaded)
     |   $listingAttributes — the subset flagged show_on_listing (passed on to related cards)
     | Nothing here is hardcoded: empty data hides its block. Settings live in config/shop.php.
     */
    $fallback = asset('assets/img/product-1588872657578-7efd1f1555ed.jpg'); // placeholder only
    $currency = config('shop.currency', '₹');
    $phoneCode = config('shop.phone_code', '+91');
    $defaultIcon = config('shop.default_spec_icon', 'fa-solid fa-circle-check');
    $qcLabel = config('shop.qc_label', 'QC Verified');
    $palette = config('shop.tile_palette', ['bg-blue-50 text-blue-600']);

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
      $specRows[] = [$label, $product->keySpec($label) ?: $value];
    }

    foreach ($product->key_specs ?? [] as $s) {
      $label = $s['label'] ?? '';
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
  @endphp

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

            <button type="button" id="prod-detail-wishlist-btn" data-wishlist-btn="{{ $product->id }}"
              class="heart-btn absolute top-3 sm:top-4 right-3 sm:right-4 z-10 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50/90 border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-white hover:text-red-500 shadow-sm transition-all"
              aria-label="Add to Wishlist">
              <i class="fa-regular fa-heart text-sm sm:text-base"></i>
            </button>
          </div>

          <!-- Thumbnails -->
          @if($gallery->count() > 1)
            <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto no-scrollbar pb-1" id="prod-thumbnails-container">
              @foreach($gallery as $idx => $g)
                <button type="button" onclick="setMainImage('{{ $g['full'] }}', this)"
                  class="prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 {{ $idx === 0 ? 'border-blue-600' : 'border-slate-200' }} bg-white p-1 flex-shrink-0 transition-all hover:border-blue-400">
                  <img src="{{ $g['thumb'] }}" alt="{{ $product->name }}" class="w-full h-full object-contain" />
                </button>
              @endforeach
            </div>
          @endif

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
            @if($brandName || $sku)
              <div class="flex items-center justify-between text-xs text-slate-500">
                <span class="font-bold text-blue-600 uppercase tracking-wider" id="prod-brand">{{ $brandName }}</span>
                @if($sku)<span id="prod-sku">SKU: {{ $sku }}</span>@endif
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
                @if($discountPct)
                  <span class="text-sm sm:text-base text-slate-400 line-through font-medium"
                    id="prod-mrp">{{ $currency }}{{ number_format($mrp) }}</span>
                  <span class="text-[10px] sm:text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md"
                    id="prod-discount">{{ $discountPct }}% OFF</span>
                @endif
              </div>
              @if($taxNote)
                <p class="text-[11px] sm:text-xs text-slate-500 mt-1">{{ $taxNote }}</p>
              @endif

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
                <button type="button" id="prod-add-cart-btn" data-add-to-cart="{{ $product->id }}"
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
                      {{ $product->warranty }}</p>
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
  <script>
    // Header/footer are rendered by Blade partials now — no Components.render*() calls.
    const PAGE = {
      productId: @json($product->id),
      deliveryTime: @json($product->delivery_time),
      phoneCode: @json($phoneCode),
      csrf: @json(csrf_token()),
      cartAddUrl: @json(route('cart.add')),      // match your route name
      checkoutUrl: @json(route('checkout')),
    };

    function toast(msg, type = 'info') {
      if (typeof showToast === 'function') showToast(msg, type);
      else console.warn('showToast not loaded:', msg);
    }

    // ==========================================
    // ADD TO CART / BUY NOW
    // ==========================================
    // No variant UI on this page: the controller auto-picks an in-stock
    // variant (if any) and uses the product's min_qty when quantity is omitted.
    async function postAddToCart() {
      const res = await fetch(PAGE.cartAddUrl, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': PAGE.csrf,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ product_id: PAGE.productId }),
      });

      const data = await res.json().catch(() => ({}));

      if (!res.ok || data.status === false) {
        throw new Error(data.message || 'Could not add this product to the cart.');
      }
      return data;
    }

    // Header badge + mini cart (adjust selectors to match your layout)
       function syncHeader(data) {
      document.querySelectorAll('[data-cart-count]').forEach(el => {
        el.textContent = data.cart_count > 99 ? '99+' : data.cart_count;
        el.classList.toggle('hidden', !(data.cart_count > 0));
      });
    }

    function setBtnLoading(btn, loading, html) {
      if (!btn) return;
      if (loading) {
        btn.dataset.original = btn.innerHTML;
        btn.disabled = true;
        btn.classList.add('opacity-70', 'cursor-not-allowed');
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ' + html;
      } else {
        btn.disabled = false;
        btn.classList.remove('opacity-70', 'cursor-not-allowed');
        btn.innerHTML = btn.dataset.original || btn.innerHTML;
      }
    }

    async function addToCart(btn) {
      setBtnLoading(btn, true, 'Adding...');
      try {
        const data = await postAddToCart();
        syncHeaderCart(data);
        if (window.fireTrackingEvents) fireTrackingEvents(data.tracking_events); // only if you have such a helper
        toast(data.message, 'success');
        if (data.coupon_removed && data.coupon_message) toast(data.coupon_message, 'info');
        return true;
      } catch (e) {
        toast(e.message, 'error');
        return false;
      } finally {
        setBtnLoading(btn, false);
      }
    }

    async function buyNow(btn) {
      setBtnLoading(btn, true, 'Please wait...');
      try {
        const data = await postAddToCart();
        syncHeaderCart(data);
        if (window.fireTrackingEvents) fireTrackingEvents(data.tracking_events);
        window.location.href = PAGE.checkoutUrl;
      } catch (e) {
        toast(e.message, 'error');
        setBtnLoading(btn, false);
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      const addBtn = document.getElementById('prod-add-cart-btn');
      const buyBtn = document.getElementById('prod-buy-now-btn');

      // stopPropagation so a global [data-add-to-cart] handler in the layout
      // (if you have one) doesn't fire a second request.
      if (addBtn) addBtn.addEventListener('click', e => { e.stopPropagation(); addToCart(addBtn); });
      if (buyBtn) buyBtn.addEventListener('click', e => { e.stopPropagation(); buyNow(buyBtn); });
    });

    // ==========================================
    // GALLERY / TABS / PINCODE
    // ==========================================
    function setMainImage(src, btn) {
      document.getElementById('main-product-image').src = src;
      document.querySelectorAll('.prod-thumb').forEach(t => t.className = 'prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 border-slate-200 bg-white p-1 flex-shrink-0 transition-all hover:border-blue-400');
      btn.className = 'prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 border-blue-600 bg-white p-1 flex-shrink-0 transition-all';
    }

    // Tabs are generated from whatever content exists (data-tab-btn / data-tab-content)
    function switchTab(tabId) {
      const on = 'px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl flex-shrink-0 bg-blue-600 text-white';
      const off = 'px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl flex-shrink-0 text-slate-600 hover:bg-slate-100';

      document.querySelectorAll('[data-tab-content]').forEach(c =>
        c.classList.toggle('hidden', c.dataset.tabContent !== tabId));
      document.querySelectorAll('[data-tab-btn]').forEach(b =>
        b.className = b.dataset.tabBtn === tabId ? on : off);
    }

    // Static check (no courier API wired yet): validates the PIN and shows the product's delivery time
    function checkPincode() {
      const pin = (document.getElementById('pincode-input').value || '').trim();
      const status = document.getElementById('pincode-status');
      status.classList.remove('hidden');

      if (pin.length === 6 && /^\d+$/.test(pin)) {
        const eta = PAGE.deliveryTime ? `Estimated delivery in ${PAGE.deliveryTime}` : 'Delivery is available';
        status.innerHTML = `<span class="text-emerald-600 font-bold"><i class="fa-solid fa-circle-check"></i> ${eta}</span> to <strong>${pin}</strong>.`;
      } else {
        status.innerHTML = `<span class="text-red-500 font-semibold"><i class="fa-solid fa-triangle-exclamation"></i> Please enter a valid 6-digit PIN code.</span>`;
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