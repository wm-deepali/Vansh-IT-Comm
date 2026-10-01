@extends('layouts.app')

@section('title', 'Shopping Cart | ' . config('app.name'))
@section('meta_description', 'Review items in your cart, apply promo coupons, and proceed to secure checkout.')

@section('content')

  @php
    $currency = config('shop.currency', '₹');
    $freeShipAt = (int) config('shop.free_shipping_threshold', 999);
    $fallback = asset('assets/img/product-1588872657578-7efd1f1555ed.jpg'); // placeholder only
    $money = fn($n) => $currency . number_format((float) $n);
    $hasItems = $cart && $cart->items->isNotEmpty();
    $s = $summary ?? [];
  @endphp

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('shop') }}" class="hover:text-blue-600">Shop</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Shopping Cart</span>
      </nav>

      <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200">
        <div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Shopping Cart</h1>
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5" id="cart-item-count-text">
            @if($hasItems)
              You have {{ $s['count'] }} {{ \Illuminate\Support\Str::plural('item', $s['count']) }} in your cart.
            @else
              Your cart is empty.
            @endif
          </p>
        </div>
        @if($hasItems)
          <button type="button" onclick="handleClearCart()" id="clear-cart-btn"
            class="btn-base btn-secondary btn-sm text-xs font-semibold">
            <i class="fa-regular fa-trash-can mr-1"></i> Clear Cart
          </button>
        @endif
      </div>

      @if(!$hasItems)

        <!-- Empty state -->
        <div
          class="text-center py-16 px-4 bg-white rounded-3xl border border-slate-200 shadow-sm max-w-lg mx-auto my-8 mb-16">
          <div
            class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fa-solid fa-cart-shopping"></i>
          </div>
          <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Your cart is waiting for something great</h3>
          <p class="text-xs text-slate-500 mb-6 max-w-sm mx-auto">Explore our tested refurbished laptops, smartphones, and
            accessories.</p>
          <a href="{{ route('shop') }}" class="btn-base btn-primary px-6 py-2.5 text-xs font-semibold">Start Exploring
            Products</a>
        </div>

      @else

        <div id="cart-main-content" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">

          <!-- Left: Cart Items -->
          <section class="lg:col-span-8 space-y-4">

            @if($freeShipAt > 0)
              <div id="shipping-progress-banner"
                class="bg-blue-50 border border-blue-200 p-4 rounded-2xl flex items-center gap-3">
                <div
                  class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg flex-shrink-0">
                  <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div class="flex-1 text-xs">
                  <div class="font-bold text-slate-900">Free Delivery Threshold</div>
                  <p class="text-slate-600" id="shipping-progress-desc">Free Pan-India delivery on orders above
                    {{ $money($freeShipAt) }}.
                  </p>
                </div>
              </div>
            @endif

            <div id="cart-items-container" class="space-y-3">
              @foreach($cart->items as $item)
                @php
                  $product = $item->product;
                  if (!$product)
                    continue;

                  $img = $product->images->sortByDesc('is_default')->first();
                  $imgUrl = $img ? asset('storage/' . $img->image) : $fallback;

                  // Route name assumed — adjust to your product detail route
                  $url = route('product.show', $product->slug);

                  $attrs = $item->selected_attributes;
                  $attrs = is_array($attrs) ? $attrs : (json_decode($attrs ?? '[]', true) ?: []);

                  $addonSum = $item->addons->sum('price');
                  $lineMrp = ($item->priceVariant?->mrp ?: $product->mrp ?: $item->price) + $addonSum;
                  $lineMrp = $lineMrp * $item->quantity;
                @endphp

                <div
                  class="cart-row bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-4"
                  data-item-id="{{ $item->id }}">

                  <!-- Image -->
                  <a href="{{ $url }}"
                    class="w-20 h-20 bg-slate-50 rounded-xl p-2 border border-slate-100 flex-shrink-0 flex items-center justify-center">
                    <img src="{{ $imgUrl }}" alt="{{ $product->name }}" class="max-h-full max-w-full object-contain"
                      onerror="this.onerror=null; this.src='{{ $fallback }}';" />
                  </a>

                  <!-- Info -->
                  <div class="flex-1 min-w-0 text-center sm:text-left">
                    @if($product->condition || $product->warranty)
                      <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                        @if($product->condition)
                          <span class="badge badge-tested text-[9px]">{{ $product->condition }}</span>
                        @endif
                        @if($product->warranty)
                          <span class="text-[11px] text-slate-400">{{ $product->warranty }}</span>
                        @endif
                      </div>
                    @endif

                    <h3 class="text-xs sm:text-sm font-bold text-slate-900 truncate">
                      <a href="{{ $url }}" class="hover:text-blue-600">{{ $product->name }}</a>
                    </h3>

                    @if(count($attrs))
                      <p class="text-[11px] text-slate-500 mt-0.5">
                        {{ collect($attrs)->map(fn($a) => ($a['attribute'] ?? '') . ': ' . ($a['value'] ?? ''))->implode(' • ') }}
                      </p>
                    @endif

                    @foreach($item->addons as $addon)
                      <p class="text-[11px] text-slate-500 mt-0.5">
                        + {{ $addon->detail }} ({{ $money($addon->price) }})
                      </p>
                    @endforeach

                    <div class="text-xs font-extrabold text-slate-900 mt-1">
                      {{ $money($item->price) }}
                      <span
                        class="js-item-mrp text-[10px] text-slate-400 line-through font-normal ml-1 {{ $lineMrp > $item->total ? '' : 'hidden' }}">{{ $money($lineMrp) }}</span>
                    </div>
                  </div>

                  <!-- Quantity -->
                  <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl p-1">
                    <button type="button" onclick="changeQty({{ $item->id }}, 'minus')"
                      class="js-qty-btn w-7 h-7 rounded-lg bg-white text-slate-700 hover:bg-slate-200 flex items-center justify-center text-xs font-bold shadow-sm">-</button>
                    <span class="js-qty w-8 text-center text-xs font-bold text-slate-800">{{ $item->quantity }}</span>
                    <button type="button" onclick="changeQty({{ $item->id }}, 'plus')"
                      class="js-qty-btn w-7 h-7 rounded-lg bg-white text-slate-700 hover:bg-slate-200 flex items-center justify-center text-xs font-bold shadow-sm">+</button>
                  </div>

                  <!-- Total & Remove -->
                  <div class="text-right flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto gap-2">
                    <div class="js-item-total text-sm font-extrabold text-slate-900">{{ $money($item->total) }}</div>
                    <button type="button" onclick="removeItem({{ $item->id }})"
                      class="text-slate-400 hover:text-red-500 text-xs font-semibold flex items-center gap-1 transition-colors">
                      <i class="fa-regular fa-trash-can"></i> Remove
                    </button>
                  </div>
                </div>
              @endforeach
            </div>
          </section>

          <!-- Right: Order Summary -->
          <aside class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-6 sticky top-28">
            <h3 class="text-base font-bold text-slate-900 font-heading border-b border-slate-100 pb-3">Order Summary</h3>

            <!-- Coupon -->
            <div>
              <label for="coupon-input" class="block text-xs font-bold text-slate-700 mb-1.5">Have a Coupon Code?</label>
              <div class="flex items-center gap-2">
                <input type="text" id="coupon-input" placeholder="Enter coupon code"
                  class="flex-1 uppercase bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 focus:outline-none focus:border-blue-600" />
                <button type="button" onclick="handleApplyCoupon()"
                  class="btn-base btn-dark btn-sm text-xs font-semibold py-2 px-3">Apply</button>
              </div>
              <div id="applied-coupon-tag" class="mt-2 text-xs hidden"></div>
            </div>

            <!-- Breakdown -->
            <div class="space-y-2.5 text-xs pt-2 border-t border-slate-100 text-slate-600">
              <div class="flex items-center justify-between">
                <span>Total MRP</span>
                <span class="text-slate-400 line-through" id="summary-mrp">{{ $money($s['mrp_total']) }}</span>
              </div>
              <div class="flex items-center justify-between text-emerald-600 font-semibold">
                <span>Product Savings</span>
                <span id="summary-savings">- {{ $money($s['savings']) }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span>Subtotal</span>
                <span class="font-bold text-slate-900" id="summary-subtotal">{{ $money($s['subtotal']) }}</span>
              </div>
              <div
                class="flex items-center justify-between text-emerald-600 font-semibold {{ $s['discount'] > 0 ? '' : 'hidden' }}"
                id="summary-coupon-row">
                <span>Coupon Discount</span>
                <span id="summary-coupon-discount">- {{ $money($s['discount']) }}</span>
              </div>
              <div class="flex items-center justify-between {{ $s['tax'] > 0 ? '' : 'hidden' }}" id="summary-tax-row">
                <span>GST</span>
                <span class="font-semibold text-slate-800" id="summary-tax">{{ $money($s['tax']) }}</span>
              </div>
              <div class="flex items-center justify-between">
                <span>Estimated Shipping</span>
                <span class="font-semibold text-slate-800" id="summary-shipping">—</span>
              </div>

              <div class="pt-3 border-t border-slate-200 flex items-baseline justify-between text-sm">
                <span class="font-bold text-slate-900">Total Payable</span>
                <span class="text-2xl font-extrabold text-slate-900 font-body"
                  id="summary-total">{{ $money($s['grand_total']) }}</span>
              </div>
            </div>

            <!-- CTA -->
            <div class="space-y-2 pt-2">
              <a href="{{ route('checkout') }}" @guest('customer') data-requires-login @endguest
                class="btn-base btn-primary w-full py-3.5 text-xs sm:text-sm font-semibold justify-center shadow-lg shadow-blue-600/30">
                Proceed to Checkout <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
              </a>
              <a href="{{ route('shop') }}"
                class="btn-base btn-secondary w-full py-2.5 text-xs font-semibold justify-center">Continue Shopping</a>
            </div>

            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-[11px] text-slate-500 space-y-1">
              <div class="flex items-center gap-1.5 font-semibold text-slate-700">
                <i class="fa-solid fa-shield-halved text-blue-600"></i> Secure Checkout
              </div>
              <p>Insured courier delivery, 7-day replacement, and full GST invoice.</p>
            </div>
          </aside>
        </div>

      @endif
    </div>
  </main>

@endsection

@push('scripts')
  @if($hasItems)
    <script>
      // Route names below must match routes/web.php (remove takes the item id).
      const CART = {
        currency: @json($currency),
        freeShipAt: @json($freeShipAt),
        csrf: @json(csrf_token()),
        initial: @json($s),
        routes: {
          update: { url: @json(route('cart.update')), method: 'POST' },
          remove: { url: @json(route('cart.remove', ':id')), method: 'DELETE' },
          clear: { url: @json(route('cart.clear')), method: 'POST' },
          applyCoupon: { url: @json(route('cart.coupon.apply')), method: 'POST' },
          removeCoupon: { url: @json(route('cart.coupon.remove')), method: 'POST' },
        },
      };

      const money = n => CART.currency + Number(n || 0).toLocaleString('en-IN', { maximumFractionDigits: 0 });
      const $ = id => document.getElementById(id);

      function toast(msg, type = 'info') {
        if (typeof showToast === 'function') showToast(msg, type);
        else console.warn('showToast not loaded:', msg);
      }

      async function api(route, payload = {}, id = null) {
        const hasBody = !['GET', 'DELETE'].includes(route.method);
        const res = await fetch(id ? route.url.replace(':id', id) : route.url, {
          method: route.method,
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': CART.csrf,
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: hasBody ? JSON.stringify(payload) : undefined,
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok || data.status === false) {
          throw new Error(data.message || 'Something went wrong. Please try again.');
        }
        return data;
      }

      // Keep header cart badge / mini-cart in sync (adjust selectors to match your add-to-cart JS)
      function syncHeader(data) {
        document.querySelectorAll('[data-cart-count]').forEach(el => {
          el.textContent = data.cart_count > 99 ? '99+' : data.cart_count;
          el.classList.toggle('hidden', !(data.cart_count > 0));
        });
      }

      function renderSummary(s) {
        $('cart-item-count-text').textContent = `You have ${s.count} item${s.count > 1 ? 's' : ''} in your cart.`;
        $('summary-mrp').textContent = money(s.mrp_total);
        $('summary-savings').textContent = '- ' + money(s.savings);
        $('summary-subtotal').textContent = money(s.subtotal);
        $('summary-total').textContent = money(s.grand_total);

        // Coupon row + tag
        const tag = $('applied-coupon-tag');
        const row = $('summary-coupon-row');
        if (s.coupon_code && s.discount > 0) {
          row.classList.remove('hidden');
          $('summary-coupon-discount').textContent = '- ' + money(s.discount);
          tag.className = 'mt-2 text-xs flex items-center justify-between p-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 font-bold';
          tag.innerHTML = `<span><i class="fa-solid fa-tag mr-1"></i> ${s.coupon_code} Applied</span>
                      <button type="button" onclick="handleRemoveCoupon()" class="text-red-500 hover:underline font-normal text-[11px]">&times; Remove</button>`;
        } else {
          row.classList.add('hidden');
          tag.className = 'hidden';
          tag.innerHTML = '';
        }

        // GST row
        $('summary-tax-row').classList.toggle('hidden', !(s.tax > 0));
        $('summary-tax').textContent = money(s.tax);

        // Shipping + free-delivery progress
        const qualifies = CART.freeShipAt > 0 && s.subtotal >= CART.freeShipAt;
        $('summary-shipping').textContent = qualifies ? 'FREE' : 'Calculated at checkout';

        const desc = $('shipping-progress-desc');
        if (desc) {
          desc.innerHTML = qualifies
            ? `<span class="text-emerald-600 font-bold"><i class="fa-solid fa-circle-check"></i> Congratulations!</span> You have qualified for <strong>FREE Pan-India Delivery</strong>.`
            : `Add ${money(CART.freeShipAt - s.subtotal)} more to unlock FREE delivery.`;
        }
      }

      function setBusy(busy) {
        document.querySelectorAll('.js-qty-btn').forEach(b => b.disabled = busy);
      }

      async function changeQty(itemId, action) {
        setBusy(true);
        try {
          const data = await api(CART.routes.update, { item_id: itemId, action });
          const row = document.querySelector(`.cart-row[data-item-id="${itemId}"]`);
          if (row) {
            row.querySelector('.js-qty').textContent = data.quantity;
            row.querySelector('.js-item-total').textContent = money(data.item_total);
            const mrpEl = row.querySelector('.js-item-mrp');
            if (mrpEl) {
              mrpEl.textContent = money(data.total_mrp);
              mrpEl.classList.toggle('hidden', !(data.total_mrp > data.item_total));
            }
          }
          renderSummary(data.summary);
          syncHeader(data);
          if (data.coupon_removed && data.coupon_message) toast(data.coupon_message, 'info');
        } catch (e) {
          toast(e.message, 'error');
        } finally {
          setBusy(false);
        }
      }

      async function removeItem(itemId) {
        try {
          const data = await api(CART.routes.remove, {}, itemId);
          syncHeader(data);
          if (data.coupon_removed && data.coupon_message) toast(data.coupon_message, 'info');

          if (data.summary.count === 0) { location.reload(); return; }

          const row = document.querySelector(`.cart-row[data-item-id="${itemId}"]`);
          if (row) row.remove();
          renderSummary(data.summary);
          toast('Item removed.', 'info');
        } catch (e) {
          toast(e.message, 'error');
        }
      }

      async function handleApplyCoupon() {
        const code = $('coupon-input').value.trim();
        if (!code) { toast('Please enter a coupon code.', 'error'); return; }
        try {
          const data = await api(CART.routes.applyCoupon, { coupon_code: code });
          $('coupon-input').value = '';
          renderSummary(data.summary);
          toast(data.message, 'success');
        } catch (e) {
          toast(e.message, 'error');
        }
      }

      async function handleRemoveCoupon() {
        try {
          const data = await api(CART.routes.removeCoupon);
          renderSummary(data.summary);
          toast('Coupon removed.', 'info');
        } catch (e) {
          toast(e.message, 'error');
        }
      }

      async function handleClearCart() {
        if (!confirm('Are you sure you want to clear your cart?')) return;
        try {
          await api(CART.routes.clear);
          location.reload();
        } catch (e) {
          toast(e.message, 'error');
        }
      }

      // Initial pass: sets coupon tag + free-delivery text from server data
      document.addEventListener('DOMContentLoaded', () => renderSummary(CART.initial));
    </script>
  @endif
@endpush