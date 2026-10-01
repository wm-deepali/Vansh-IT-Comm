@php
  /*
   | Expects (optional): $listingAttributes — ordered collection of CategoryAttribute
   | rows (with ->attribute loaded) where show_on_listing = true. Passed from the controller.
   | Nothing below is hardcoded: if a product has no value for a field, that field is hidden.
   */
  $fallbackImg = asset('assets/img/product-1588872657578-7efd1f1555ed.jpg'); // placeholder only

  // ── Pricing ──
  $price = $product->price;
  $mrp   = $product->mrp;
  $discountPct = ($mrp && $mrp > $price) ? round((($mrp - $price) / $mrp) * 100) : null;

  // ── Rating (hidden when the product has no approved reviews) ──
  $hasRating = $product->approved_reviews_avg_rating !== null;
  $rating    = round((float) $product->approved_reviews_avg_rating, 1);
  $full      = (int) floor($rating);
  $half      = ($rating - $full) >= 0.5;

  // ── Brand / warranty (no fake defaults) ──
  $brandName = $product->brand->name ?? null;
  $warranty  = $product->warranty ?: null;

  // ── Badge: comes from the product's collections (first active one by sort_order) ──
  $badgeCollection = $product->collections->where('status', 1)->sortBy('sort_order')->first();
  $badgeText  = $badgeCollection ? \Illuminate\Support\Str::upper($badgeCollection->name) : null;
  $badgeColor = $badgeCollection->badge_color ?? null;           // optional hex set in admin
  $badgeClass = $badgeColor ? '' : 'badge-tested';               // CSS fallback when no color

  $img = $product->display_image ?? $fallbackImg;
  $url = route('product.show', $product->slug);

  $desc = \Illuminate\Support\Str::limit(
            trim(strip_tags($product->short_description ?: $product->description ?: '')), 220
          );

  // ── Specs: only attributes flagged "show on listing", in the admin-defined order ──
  $defaultIcon = config('shop.default_spec_icon', 'fa-solid fa-circle-check');

  $specs = collect($listingAttributes ?? [])
    ->map(function ($ca) use ($product, $defaultIcon) {
        $name = $ca->attribute->name ?? null;
        return [
            'label' => $name,
            'value' => $name ? $product->attr($name) : null,
            'icon'  => $ca->attribute->icon ?: $defaultIcon,   // set per attribute in admin
        ];
    })
    ->filter(fn ($s) => $s['label'] && filled($s['value']))
    ->take(4)
    ->values();

  $qv = [
    'id'         => $product->id,
    'name'       => $product->name,
    'url'        => $url,
    'image'      => $img,
    'fallback'   => $fallbackImg,
    'price'      => '₹' . number_format($price),
    'mrp'        => $discountPct ? '₹' . number_format($mrp) : null,
    'discount'   => $discountPct,
    'rating'     => $hasRating ? $rating : null,
    'badge'      => $badgeText,
    'badgeClass' => $badgeClass,
    'badgeColor' => $badgeColor,
    'brand'      => $brandName,
    'description'=> $desc,
    'specs'      => $specs->map(fn ($s) => [$s['label'], $s['value']])->all(),
    'warranty'   => $warranty,
  ];
@endphp

<article class="product-card group" data-product-id="{{ $product->id }}" data-quickview="{{ json_encode($qv) }}">
  <!-- Image & Actions -->
  <div class="img-wrapper">
    <img src="{{ $img }}" alt="{{ $product->name }}" loading="lazy"
      onerror="this.onerror=null; this.src='{{ $fallbackImg }}';" />

    @if($badgeText)
      <div class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5 z-10">
        <span class="badge {{ $badgeClass }} text-[9px] sm:text-[10px] px-1.5 py-0.5 sm:px-2 sm:py-0.5"
              @if($badgeColor) style="background-color: {{ $badgeColor }}; color: #fff;" @endif>{{ $badgeText }}</span>
      </div>
    @endif

    <button type="button" data-wishlist-btn="{{ $product->id }}"
      class="heart-btn absolute top-2 right-2 sm:top-2.5 sm:right-2.5 z-10 w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-white/90 backdrop-blur-sm border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-white hover:text-red-500 shadow-sm transition-all"
      aria-label="Add to wishlist">
      <i class="fa-regular fa-heart text-[11px] sm:text-sm"></i>
    </button>

    <button type="button" onclick="QuickView.open({{ $product->id }})"
      class="absolute bottom-2.5 left-2.5 right-2.5 py-2 px-3 bg-slate-950/85 hover:bg-blue-600 text-white text-xs font-bold rounded-xl backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 flex items-center justify-center gap-1.5 shadow-lg hidden sm:flex">
      <i class="fa-solid fa-eye text-xs"></i> Quick View
    </button>
  </div>

  <!-- Content -->
  <div class="p-2 sm:p-3.5 lg:p-4 flex flex-col flex-1 justify-between bg-white">
    <div>
      @if($hasRating || $brandName)
        <div class="flex items-center justify-between gap-1 mb-1 sm:mb-1.5">
            <div class="flex items-center text-amber-400 text-[9px] sm:text-xs gap-0.5" aria-label="{{ $rating }} out of 5 stars">
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
          @if($brandName)
            <span class="ml-auto text-[8px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-wider bg-slate-100 px-1 sm:px-1.5 py-0.5 rounded flex-shrink-0">{{ $brandName }}</span>
          @endif
        </div>
      @endif

      <h3 class="font-bold text-slate-900 text-xs sm:text-sm leading-snug line-clamp-2 hover:text-blue-600 transition-colors mb-1.5 sm:mb-2 min-h-[2rem] sm:min-h-[2.4rem]">
        <a href="{{ $url }}">{{ $product->name }}</a>
      </h3>

      {{-- Dynamic specs: icon + value only (attributes marked "show on listing") --}}
      @if($specs->isNotEmpty())
        <div class="text-[10px] sm:text-[11px] text-slate-600 mb-2 sm:mb-2.5 bg-slate-50 p-1.5 sm:p-2.5 rounded-lg sm:rounded-xl border border-slate-100 min-h-[48px] sm:min-h-[62px] flex flex-wrap content-center gap-x-2 sm:gap-x-3 gap-y-0.5 sm:gap-y-1 leading-tight">
          @foreach($specs as $spec)
            <span class="inline-flex items-center min-w-0 max-w-full {{ $loop->first ? 'w-full font-medium text-slate-800' : '' }}"
                  title="{{ $spec['label'] }}: {{ $spec['value'] }}">
              <i class="{{ $spec['icon'] }} text-blue-600 mr-1 sm:mr-1.5 w-3 text-center text-[9px] sm:text-[10px] flex-shrink-0"></i>
              <span class="truncate">{{ $spec['value'] }}</span>
            </span>
          @endforeach
        </div>
      @endif
    </div>

    <div>
      <div class="pt-1.5 sm:pt-2 border-t border-slate-100 mb-2 sm:mb-2.5">
        <div class="flex items-baseline gap-1 sm:gap-1.5 flex-wrap min-h-[22px] sm:min-h-[26px] items-center">
          <span class="product-price text-slate-900 font-black text-sm sm:text-base lg:text-lg leading-none">₹{{ number_format($price) }}</span>
          @if($discountPct)
            <span class="text-[9px] sm:text-xs text-slate-400 line-through">₹{{ number_format($mrp) }}</span>
            <span class="text-[8px] sm:text-[10px] font-black text-emerald-700 bg-emerald-50 border border-emerald-200 px-1 py-0.5 rounded whitespace-nowrap">{{ $discountPct }}% OFF</span>
          @endif
        </div>
        @if($warranty)
          <div class="flex items-center gap-1 text-[9px] sm:text-[11px] text-slate-500 mt-0.5 sm:mt-1">
            <i class="fa-solid fa-shield-halved text-blue-600 text-[9px] sm:text-[10px]"></i>
            <span class="truncate">{{ $warranty }}</span>
          </div>
        @endif
      </div>

      <div class="grid grid-cols-2 gap-1 sm:gap-1.5">
        <button type="button" data-add-to-cart="{{ $product->id }}"
          class="btn-base btn-secondary btn-sm text-[10px] sm:text-xs py-1.5 sm:py-2 px-1 w-full add-to-cart-btn font-bold flex items-center justify-center gap-1 rounded-lg sm:rounded-xl">
          <i class="fa-solid fa-cart-shopping text-[9px] sm:text-xs"></i> Add
        </button>
        <a href="{{ $url }}"
          class="btn-base btn-primary btn-sm text-[10px] sm:text-xs py-1.5 sm:py-2 px-1 w-full font-bold flex items-center justify-center gap-1 rounded-lg sm:rounded-xl">
          View <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px]"></i>
        </a>
      </div>
    </div>
  </div>
</article>