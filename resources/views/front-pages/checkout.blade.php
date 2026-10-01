@extends('layouts.app')

@section('title', 'Checkout & Order Confirmation | VANSH IT & COMM')
@section('meta_description', 'Complete your purchase with secure address entry and demo payment options.')

@section('content')

  @php
    $currency = config('shop.currency', '₹');
    $freeShipAt = (int) config('shop.free_shipping_threshold', 999);
    $fallback = asset('assets/img/product-1588872657578-7efd1f1555ed.jpg'); // placeholder only
    $money = fn($n) => $currency . number_format((float) $n);
    $items = $cart?->items ?? collect();

    // Address selection: default address, else the first saved one
    $hasAddresses = $addresses->isNotEmpty();
    $selectedAddress = $defaultAddress ?? $addresses->first();
    $needsDefault = $selectedAddress && !$selectedAddress->is_default;
    $lockContact = (bool) $selectedAddress;

    // Contact prefill: selected address > logged-in customer
    $contactName  = old('name',  $selectedAddress->name  ?? $customer->name  ?? '');
    $contactPhone = old('phone', $selectedAddress->phone ?? $customer->phone ?? '');
    $contactEmail = old('email', $selectedAddress->email ?? $customer->email ?? '');

    $inputCls = 'w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white';
    $lockCls = $lockContact ? ' opacity-70 cursor-not-allowed' : '';
  @endphp

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('cart') }}" class="hover:text-blue-600">Cart</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Checkout</span>
      </nav>

      <!-- Demo Notice Bar -->
      <div class="bg-amber-50 border border-amber-200 p-3 sm:p-3.5 rounded-xl sm:rounded-2xl mb-5 sm:mb-8 flex items-center gap-2.5 sm:gap-3 text-xs text-amber-900">
        <i class="fa-solid fa-triangle-exclamation text-amber-600 text-sm sm:text-base flex-shrink-0"></i>
        <div class="leading-relaxed">
          <strong>Demo Checkout Mode:</strong> No real payment will be deducted. Payment gateway integration (Razorpay / Cashfree / Stripe) is required for production.
        </div>
      </div>

      <!-- Checkout Container -->
      <div id="checkout-view" class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 items-start mb-12 sm:mb-16">

        <!-- Left: Form Steps (8 Columns) -->
        <section class="lg:col-span-8 space-y-4 sm:space-y-6">

          <!-- Step Indicator -->
          <div class="bg-white p-2.5 sm:p-4 rounded-2xl border border-slate-200 shadow-sm overflow-x-auto no-scrollbar">
            <div class="flex items-center justify-between gap-1 sm:gap-2 text-[10px] sm:text-xs font-bold text-slate-400">
              <span class="text-blue-600 flex items-center gap-1 sm:gap-1.5 whitespace-nowrap">
                <i class="fa-solid fa-circle-check text-blue-600 text-xs sm:text-sm"></i>
                <span>1. Contact</span>
              </span>
              <i class="fa-solid fa-chevron-right text-[8px] sm:text-[10px] text-slate-300 flex-shrink-0"></i>

              <span class="text-blue-600 flex items-center gap-1 sm:gap-1.5 whitespace-nowrap">
                <i class="fa-solid fa-circle-check text-blue-600 text-xs sm:text-sm"></i>
                <span>2. Address</span>
              </span>
              <i class="fa-solid fa-chevron-right text-[8px] sm:text-[10px] text-slate-300 flex-shrink-0"></i>

              <span class="text-blue-600 flex items-center gap-1 sm:gap-1.5 whitespace-nowrap">
                <i class="fa-solid fa-circle-check text-blue-600 text-xs sm:text-sm"></i>
                <span>3. Delivery</span>
              </span>
              <i class="fa-solid fa-chevron-right text-[8px] sm:text-[10px] text-slate-300 flex-shrink-0"></i>

              <span class="text-blue-600 flex items-center gap-1 sm:gap-1.5 whitespace-nowrap">
                <i class="fa-solid fa-circle-check text-blue-600 text-xs sm:text-sm"></i>
                <span>4. Payment</span>
              </span>
            </div>
          </div>

          <!-- Checkout Form -->
          <form id="checkout-form" class="space-y-4 sm:space-y-6" onsubmit="handlePlaceOrder(event)">

            <!-- Contact Section — DYNAMIC -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-3 sm:space-y-4">
              <div class="flex flex-wrap items-center justify-between gap-2">
                <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-heading flex items-center gap-2">
                  <i class="fa-regular fa-user text-blue-600"></i> 1. Contact Information
                </h3>
                @if($customer->email)
                  <span class="text-[11px] text-slate-500 flex items-center gap-1">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    Signed in as <strong class="text-slate-700">{{ $customer->email }}</strong>
                  </span>
                @endif
              </div>

              <p id="contact-lock-note" class="text-[11px] text-slate-500 {{ $lockContact ? '' : 'hidden' }}">
                Using the contact details of the selected address. Choose "Add new address" to enter different details.
              </p>

              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <div>
                  <label for="chk-name" class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                  <input type="text" id="chk-name" name="name" required value="{{ $contactName }}"
                    placeholder="e.g. Rahul Sharma" @if($lockContact) readonly @endif
                    class="{{ $inputCls }}{{ $lockCls }}" />
                </div>
                <div>
                  <label for="chk-phone" class="block text-xs font-bold text-slate-700 mb-1">Mobile Number (For Courier Updates) *</label>
                  <input type="tel" id="chk-phone" name="phone" required value="{{ $contactPhone }}"
                    placeholder="10-digit mobile" @if($lockContact) readonly @endif
                    class="{{ $inputCls }}{{ $lockCls }}" />
                </div>
                <div class="sm:col-span-2">
                  <label for="chk-email" class="block text-xs font-bold text-slate-700 mb-1">Email Address (For GST Invoice) *</label>
                  <input type="email" id="chk-email" name="email" required value="{{ $contactEmail }}"
                    placeholder="name@example.com" @if($lockContact) readonly @endif
                    class="{{ $inputCls }}{{ $lockCls }}" />
                </div>
              </div>
            </div>

            <!-- Delivery Address Section — DYNAMIC (saved addresses + add new) -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-3 sm:space-y-4">
              <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-heading flex items-center gap-2">
                <i class="fa-solid fa-location-dot text-blue-600"></i> 2. Delivery Address
              </h3>

              @if($hasAddresses)
                <div id="saved-addresses" class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                  @foreach($addresses as $addr)
                    @php $isSel = $selectedAddress && $selectedAddress->id === $addr->id; @endphp
                    <label
                      class="js-address-card p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 {{ $isSel ? 'border-blue-600 bg-blue-50/40' : 'border-slate-200 hover:border-slate-300' }} flex items-start gap-2.5 sm:gap-3 cursor-pointer"
                      data-name="{{ $addr->name }}" data-phone="{{ $addr->phone }}" data-email="{{ $addr->email }}">
                      <input type="radio" name="address_id" value="{{ $addr->id }}" {{ $isSel ? 'checked' : '' }}
                        onchange="onAddressChange(this)" class="mt-1 text-blue-600" />
                      <div class="min-w-0 text-xs">
                        <div class="flex items-center gap-1.5 flex-wrap">
                          <span class="font-bold text-slate-900">{{ $addr->name }}</span>
                          @if($addr->address_type)
                            <span class="text-[10px] uppercase font-bold tracking-wide px-1.5 py-0.5 rounded bg-slate-100 text-slate-600">{{ $addr->address_type }}</span>
                          @endif
                          @if($addr->is_default)
                            <span class="text-[10px] font-bold px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-700">Default</span>
                          @endif
                        </div>
                        <div class="text-slate-600 mt-1 leading-relaxed">
                          {{ $addr->address_line_1 }}@if($addr->address_line_2), {{ $addr->address_line_2 }}@endif<br>
                          {{ collect([$addr->city?->name, $addr->state?->name])->filter()->implode(', ') }} - {{ $addr->pincode }}
                        </div>
                        @if($addr->phone)
                          <div class="text-[11px] text-slate-500 mt-1"><i class="fa-solid fa-phone mr-1"></i>{{ $addr->phone }}</div>
                        @endif
                      </div>
                    </label>
                  @endforeach

                  <!-- Add new address card -->
                  <label
                    class="js-address-card p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-dashed border-slate-300 hover:border-blue-400 flex items-center gap-2.5 sm:gap-3 cursor-pointer">
                    <input type="radio" name="address_id" value="new" onchange="onAddressChange(this)" class="text-blue-600" />
                    <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                      <i class="fa-solid fa-plus text-blue-600"></i> Add new address
                    </div>
                  </label>
                </div>
              @endif

              <!-- New address form (always visible when the customer has no saved address) -->
              <div id="new-address-form" class="space-y-3 sm:space-y-4 {{ $hasAddresses ? 'hidden' : '' }}">
                <div>
                  <label for="new-address-line-1" class="block text-xs font-bold text-slate-700 mb-1">Flat / House No. / Building / Street *</label>
                  <input type="text" id="new-address-line-1" placeholder="House / Flat / Street address" class="{{ $inputCls }}" />
                </div>
                <div>
                  <label for="new-address-line-2" class="block text-xs font-bold text-slate-700 mb-1">Landmark / Area (optional)</label>
                  <input type="text" id="new-address-line-2" placeholder="Near, area, locality" class="{{ $inputCls }}" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                  <div>
                    <label for="new-state" class="block text-xs font-bold text-slate-700 mb-1">State *</label>
                    <select id="new-state" onchange="loadCities(this.value)" class="{{ $inputCls }}">
                      <option value="">Select state</option>
                      @foreach($states as $st)
                        <option value="{{ $st->id }}">{{ $st->name }}</option>
                      @endforeach
                    </select>
                  </div>
                  <div>
                    <label for="new-city" class="block text-xs font-bold text-slate-700 mb-1">City *</label>
                    <select id="new-city" disabled class="{{ $inputCls }}">
                      <option value="">Select state first</option>
                    </select>
                  </div>
                  <div>
                    <label for="new-pincode" class="block text-xs font-bold text-slate-700 mb-1">PIN Code *</label>
                    <input type="text" id="new-pincode" maxlength="6" inputmode="numeric" placeholder="6-digit PIN" class="{{ $inputCls }}" />
                  </div>
                  <div>
                    <label for="new-address-type" class="block text-xs font-bold text-slate-700 mb-1">Address Type</label>
                    <select id="new-address-type" class="{{ $inputCls }}">
                      <option value="home">Home</option>
                      <option value="work">Work</option>
                      <option value="other">Other</option>
                    </select>
                  </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 pt-1">
                  <button type="button" id="save-address-btn" onclick="saveNewAddress()"
                    class="btn-base btn-primary btn-sm text-xs font-semibold px-4 py-2">
                    <i class="fa-solid fa-floppy-disk mr-1.5"></i> Save &amp; use this address
                  </button>
                  @if($hasAddresses)
                    <button type="button" onclick="cancelNewAddress()"
                      class="btn-base btn-secondary btn-sm text-xs font-semibold px-4 py-2">Cancel</button>
                  @endif
                </div>
              </div>
            </div>

            <!-- Payment Method Section -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-3 sm:space-y-4">
              <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-heading flex items-center gap-2">
                <i class="fa-regular fa-credit-card text-blue-600"></i> 3. Payment Method (Demo)
              </h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 sm:gap-3">
                <label class="p-3 sm:p-4 rounded-xl sm:rounded-2xl border-2 border-blue-600 bg-blue-50/40 flex items-start gap-2.5 sm:gap-3 cursor-pointer">
                  <input type="radio" name="paymentMethod" value="UPI" checked class="mt-1 text-blue-600" />
                  <div>
                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-qrcode text-blue-600"></i> UPI Instant (GPay / PhonePe)</div>
                    <div class="text-[11px] text-slate-500">Fast and seamless UPI checkout.</div>
                  </div>
                </label>

                <label class="p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-200 hover:border-slate-300 flex items-start gap-2.5 sm:gap-3 cursor-pointer">
                  <input type="radio" name="paymentMethod" value="Card" class="mt-1 text-blue-600" />
                  <div>
                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-credit-card text-slate-600"></i> Credit / Debit Cards</div>
                    <div class="text-[11px] text-slate-500">Visa, MasterCard, RuPay supported.</div>
                  </div>
                </label>

                <label class="p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-200 hover:border-slate-300 flex items-start gap-2.5 sm:gap-3 cursor-pointer">
                  <input type="radio" name="paymentMethod" value="NetBanking" class="mt-1 text-blue-600" />
                  <div>
                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-building-columns text-slate-600"></i> Net Banking</div>
                    <div class="text-[11px] text-slate-500">All major Indian banks supported.</div>
                  </div>
                </label>

                <label class="p-3 sm:p-4 rounded-xl sm:rounded-2xl border border-slate-200 hover:border-slate-300 flex items-start gap-2.5 sm:gap-3 cursor-pointer">
                  <input type="radio" name="paymentMethod" value="COD" class="mt-1 text-blue-600" />
                  <div>
                    <div class="text-xs font-bold text-slate-900 flex items-center gap-1.5"><i class="fa-solid fa-money-bill-wave text-emerald-600"></i> Cash on Delivery (COD)</div>
                    <div class="text-[11px] text-slate-500">Pay when order arrives.</div>
                  </div>
                </label>
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-base btn-primary w-full py-3.5 sm:py-4 text-xs sm:text-sm font-bold justify-center shadow-lg shadow-blue-600/30">
              <i class="fa-solid fa-lock mr-2"></i> Place Order (Demo Mode)
            </button>
          </form>

        </section>

        <!-- Right: Order Review (4 Columns) — DYNAMIC -->
        <aside class="lg:col-span-4 bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-4 sticky top-28">
          <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-heading pb-3 border-b border-slate-100 flex items-center justify-between">
            <span>Order Review</span>
            <span class="text-[11px] font-normal text-slate-500 lowercase">insured dispatch</span>
          </h3>

          <!-- Items Mini List -->
          <div id="checkout-items-summary" class="space-y-3 max-h-60 overflow-y-auto pr-1">
            @forelse($items as $item)
              @php
                $product = $item->product;
                if (!$product) {
                  continue;
                }

                // Thumbnail: image variant > product default image > placeholder
                if ($item->imageVariant && $item->imageVariant->image) {
                  $imgUrl = asset('storage/' . $item->imageVariant->image);
                } else {
                  $img = $product->images->sortByDesc('is_default')->first();
                  $imgUrl = $img ? asset('storage/' . $img->image) : $fallback;
                }

                $attrs = $item->selected_attributes;
                $attrs = is_array($attrs) ? $attrs : (json_decode($attrs ?? '[]', true) ?: []);
              @endphp

              <div class="flex items-center gap-3 text-xs">
                <img src="{{ $imgUrl }}" alt="{{ $product->name }}"
                  class="w-12 h-12 object-contain bg-slate-50 p-1 rounded-lg border border-slate-200 flex-shrink-0"
                  onerror="this.onerror=null; this.src='{{ $fallback }}';" />
                <div class="flex-1 min-w-0">
                  <div class="font-bold text-slate-800 truncate">{{ $product->name }}</div>

                  @if(count($attrs))
                    <div class="text-[11px] text-slate-500 truncate">
                      {{ collect($attrs)->map(fn($a) => ($a['attribute'] ?? '') . ': ' . ($a['value'] ?? ''))->implode(' • ') }}
                    </div>
                  @endif

                  @foreach($item->addons as $addon)
                    <div class="text-[11px] text-slate-500 truncate">+ {{ $addon->detail }} ({{ $money($addon->price) }})</div>
                  @endforeach

                  <div class="text-[11px] text-slate-500">Qty: {{ $item->quantity }} × {{ $money($item->price) }}</div>
                </div>
                <span class="font-extrabold text-slate-900">{{ $money($item->total) }}</span>
              </div>
            @empty
              <p class="text-xs text-slate-500 text-center py-4">
                Your cart is empty. <a href="{{ route('shop') }}" class="text-blue-600 font-semibold">Continue shopping</a>
              </p>
            @endforelse
          </div>

          <!-- Price Totals -->
          @if($items->isNotEmpty())
            <div class="space-y-2 text-xs pt-3 border-t border-slate-100 text-slate-600">
              <div class="flex items-center justify-between">
                <span>Subtotal</span>
                <span class="font-bold text-slate-900" id="chk-subtotal">{{ $money($cart->subtotal) }}</span>
              </div>

              @if($cart->discount > 0)
                <div class="flex items-center justify-between text-emerald-600 font-semibold" id="chk-coupon-row">
                  <span>Discount{{ $cart->coupon_code ? ' (' . $cart->coupon_code . ')' : '' }}</span>
                  <span id="chk-coupon-discount">- {{ $money($cart->discount) }}</span>
                </div>
              @endif

              @if($cart->tax_amount > 0)
                @if($cart->gst_type === 'igst' && $cart->igst_amount > 0)
                  <div class="flex items-center justify-between">
                    <span>IGST ({{ rtrim(rtrim(number_format($cart->igst_rate, 2), '0'), '.') }}%)</span>
                    <span class="font-semibold text-slate-800">{{ $money($cart->igst_amount) }}</span>
                  </div>
                @else
                  @if($cart->cgst_amount > 0)
                    <div class="flex items-center justify-between">
                      <span>CGST ({{ rtrim(rtrim(number_format($cart->cgst_rate, 2), '0'), '.') }}%)</span>
                      <span class="font-semibold text-slate-800">{{ $money($cart->cgst_amount) }}</span>
                    </div>
                  @endif
                  @if($cart->sgst_amount > 0)
                    <div class="flex items-center justify-between">
                      <span>SGST ({{ rtrim(rtrim(number_format($cart->sgst_rate, 2), '0'), '.') }}%)</span>
                      <span class="font-semibold text-slate-800">{{ $money($cart->sgst_amount) }}</span>
                    </div>
                  @endif
                @endif
              @endif

              @if($freeShipAt > 0 && $cart->subtotal >= $freeShipAt)
                <div class="flex items-center justify-between">
                  <span>Insured Shipping</span>
                  <span class="font-semibold text-emerald-600" id="chk-shipping">FREE</span>
                </div>
              @endif

              <div class="pt-3 border-t border-slate-200 flex items-baseline justify-between text-sm">
                <span class="font-bold text-slate-900">Grand Total</span>
                <span class="text-xl sm:text-2xl font-extrabold text-slate-900 font-body" id="chk-total">{{ $money($cart->grand_total) }}</span>
              </div>
            </div>
          @endif
        </aside>

      </div>

      <!-- Confirmation Screen (Hidden Initially) -->
      <div id="order-success-view" class="hidden max-w-2xl mx-auto text-center py-12 px-6 bg-white rounded-3xl border border-slate-200 shadow-sm my-8 space-y-6">
        <div class="w-20 h-20 rounded-full bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto text-3xl shadow-sm">
          <i class="fa-solid fa-check"></i>
        </div>

        <div>
          <span class="badge bg-emerald-100 text-emerald-800 text-xs px-3 py-1 mb-2 font-bold">ORDER CONFIRMED</span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
            Order Placed Successfully!
          </h2>
          <p class="text-xs sm:text-sm text-slate-500 mt-1">
            Thank you for buying with VANSH IT & COMM. We have sent confirmation details to your email.
          </p>
        </div>

        <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200 text-left space-y-2 text-xs">
          <div class="flex items-center justify-between pb-2 border-b border-slate-200">
            <span class="text-slate-500">Order ID:</span>
            <strong class="text-blue-600 text-sm" id="conf-order-id">VIC2026-XXXX</strong>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-500">Customer Name:</span>
            <strong class="text-slate-800" id="conf-name">-</strong>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-500">Estimated Delivery:</span>
            <strong class="text-emerald-700">3–5 Business Days</strong>
          </div>
          <div class="flex items-center justify-between">
            <span class="text-slate-500">Payment Mode:</span>
            <strong class="text-slate-800" id="conf-payment">UPI (Demo)</strong>
          </div>
        </div>

        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
          <a href="{{ route('track-order') }}" id="conf-track-btn" class="btn-base btn-primary px-6 py-2.5 text-xs font-semibold">
            <i class="fa-solid fa-location-crosshairs mr-1.5"></i> Track Your Order
          </a>
          <a href="{{ route('shop') }}" class="btn-base btn-secondary px-6 py-2.5 text-xs font-semibold">
            Continue Shopping
          </a>
        </div>
      </div>

    </div>
  </main>

@endsection

@push('scripts')
  @if(!empty($beginCheckoutScript))
    {!! $beginCheckoutScript !!}
  @endif

  <script>
    const CART_URL = "{{ route('cart') }}";
    const THANK_YOU_URL = "{{ route('thank-you') }}";

    // Route names below must match routes/web.php
    const CHECKOUT = {
      csrf: @json(csrf_token()),
      hasAddresses: @json($hasAddresses),
      needsDefault: @json($needsDefault),
      selectedId: @json($selectedAddress?->id),
      routes: {
        storeAddress: @json(route('checkout.address.store')),
        setDefault: @json(route('checkout.address.default')),
        cities: @json(route('checkout.cities', ':state')),
      },
    };

    const $ = id => document.getElementById(id);

    function toast(msg, type = 'info') {
      if (typeof showToast === 'function') showToast(msg, type);
      else alert(msg);
    }

    async function postJson(url, payload) {
      const res = await fetch(url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CHECKOUT.csrf,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify(payload),
      });
      const data = await res.json().catch(() => ({}));
      if (!res.ok || data.success === false) {
        const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
        throw new Error(firstError || data.message || 'Something went wrong. Please try again.');
      }
      return data;
    }

    /* ---------- Address cards ---------- */

    function refreshAddressCards() {
      document.querySelectorAll('.js-address-card').forEach(card => {
        const on = card.querySelector('input').checked;
        card.classList.toggle('border-blue-600', on);
        card.classList.toggle('bg-blue-50/40', on);
        card.classList.toggle('border-slate-200', !on && !card.classList.contains('border-dashed'));
      });
    }

    function setContactLocked(locked) {
      ['chk-name', 'chk-phone', 'chk-email'].forEach(id => {
        const el = $(id);
        el.readOnly = locked;
        el.classList.toggle('opacity-70', locked);
        el.classList.toggle('cursor-not-allowed', locked);
      });
      $('contact-lock-note').classList.toggle('hidden', !locked);
    }

    function setBusy(busy) {
      document.querySelectorAll('input[name="address_id"]').forEach(r => r.disabled = busy);
    }

    async function makeDefault(addressId) {
      setBusy(true);
      try {
        await postJson(CHECKOUT.routes.setDefault, { address_id: addressId });
        location.reload(); // GST in Order Review + contact prefill depend on the default address
      } catch (e) {
        toast(e.message, 'error');
        setBusy(false);
      }
    }

    function onAddressChange(radio) {
      refreshAddressCards();

      if (radio.value === 'new') {
        $('new-address-form').classList.remove('hidden');
        setContactLocked(false);
        $('new-address-line-1').focus();
        return;
      }

      $('new-address-form').classList.add('hidden');

      // Reflect the chosen address's contact details right away, then persist + reload
      const card = radio.closest('.js-address-card');
      $('chk-name').value = card.dataset.name || '';
      $('chk-phone').value = card.dataset.phone || '';
      $('chk-email').value = card.dataset.email || '';
      setContactLocked(true);

      makeDefault(radio.value);
    }

    function cancelNewAddress() {
      const selected = document.querySelector(`input[name="address_id"][value="${CHECKOUT.selectedId}"]`);
      if (selected) {
        selected.checked = true;
        onAddressChange(selected);
      }
    }

    /* ---------- New address form ---------- */

    async function loadCities(stateId) {
      const citySel = $('new-city');
      citySel.innerHTML = '<option value="">Select city</option>';
      citySel.disabled = true;
      if (!stateId) {
        citySel.innerHTML = '<option value="">Select state first</option>';
        return;
      }
      try {
        const res = await fetch(CHECKOUT.routes.cities.replace(':state', stateId), {
          headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
        });
        const cities = await res.json();
        citySel.innerHTML = '<option value="">Select city</option>' +
          cities.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
        citySel.disabled = false;
      } catch (e) {
        citySel.innerHTML = '<option value="">Could not load cities</option>';
        toast('Could not load cities. Please try again.', 'error');
      }
    }

    async function saveNewAddress() {
      const payload = {
        name: $('chk-name').value.trim(),
        phone: $('chk-phone').value.trim(),
        email: $('chk-email').value.trim(),
        address_line_1: $('new-address-line-1').value.trim(),
        address_line_2: $('new-address-line-2').value.trim(),
        state_id: $('new-state').value,
        city_id: $('new-city').value,
        pincode: $('new-pincode').value.trim(),
        address_type: $('new-address-type').value,
      };

      if (!payload.name || !payload.phone || !payload.email) {
        toast('Please fill in your name, mobile number and email above.', 'error'); return;
      }
      if (payload.phone.replace(/\D/g, '').length < 10) {
        toast('Please enter a valid 10-digit mobile number.', 'error'); return;
      }
      if (!payload.address_line_1) { toast('Please enter your street address.', 'error'); return; }
      if (!payload.state_id) { toast('Please select a state.', 'error'); return; }
      if (!payload.city_id) { toast('Please select a city.', 'error'); return; }
      if (!/^\d{6}$/.test(payload.pincode)) { toast('Please enter a valid 6-digit PIN code.', 'error'); return; }

      const btn = $('save-address-btn');
      btn.disabled = true;
      try {
        await postJson(CHECKOUT.routes.storeAddress, payload);
        location.reload(); // new address becomes default → GST + selection refresh
      } catch (e) {
        toast(e.message, 'error');
        btn.disabled = false;
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
      // No default address saved yet but the customer has addresses: make the shown one the default
      if (CHECKOUT.hasAddresses && CHECKOUT.needsDefault && CHECKOUT.selectedId) {
        makeDefault(CHECKOUT.selectedId);
      }
    });

    // ---- Still static (localStorage demo) — rewritten in the Payment step ----
    // NOTE: reads the old chk-address / chk-city / chk-state / chk-pin fields, which no longer exist.
    function handlePlaceOrder(event) {
      event.preventDefault();
      const name = document.getElementById('chk-name').value.trim();
      const phone = document.getElementById('chk-phone').value.trim();
      const email = document.getElementById('chk-email').value.trim();
      const address = document.getElementById('chk-address').value.trim();
      const city = document.getElementById('chk-city').value.trim();
      const state = document.getElementById('chk-state').value.trim();
      const pin = document.getElementById('chk-pin').value.trim();
      const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked').value;

      const orderId = App.generateOrderId();
      const summary = Cart.getSummary();
      const items = Cart.getItems();

      // Save order to localStorage for track-order, thank-you page, and account dashboard
      const existingOrders = JSON.parse(localStorage.getItem('vansh_orders') || '[]');
      const newOrder = {
        orderId,
        date: new Date().toLocaleDateString('en-IN', { month: 'short', day: 'numeric', year: 'numeric' }),
        customer: {
          name,
          phone,
          email,
          address: `${address}, ${city}, ${state} - ${pin}`
        },
        items,
        subtotal: summary.subtotal,
        discount: summary.couponDiscount,
        shipping: summary.shipping,
        total: summary.total,
        paymentMethod,
        status: 'Order Confirmed'
      };
      existingOrders.unshift(newOrder);
      localStorage.setItem('vansh_orders', JSON.stringify(existingOrders));

      // Clear Cart
      Cart.clearCart();

      // Redirect to Thank You Page
      showToast(`Order #${orderId} placed successfully!`, 'success');
      setTimeout(() => {
        window.location.href = `${THANK_YOU_URL}?orderId=${orderId}`;
      }, 500);
    }
  </script>
@endpush