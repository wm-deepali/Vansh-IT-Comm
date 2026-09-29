@extends('layouts.app')

@section('title', 'Checkout & Order Confirmation | VANSH IT & COMM')
@section('meta_description', 'Complete your purchase with secure address entry and demo payment options.')

@section('content')

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

            <!-- Contact Section -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-3 sm:space-y-4">
              <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-heading flex items-center gap-2">
                <i class="fa-regular fa-user text-blue-600"></i> 1. Contact Information
              </h3>
              <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <div>
                  <label class="block text-xs font-bold text-slate-700 mb-1">Full Name *</label>
                  <input type="text" id="chk-name" required placeholder="e.g. Rahul Sharma" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
                </div>
                <div>
                  <label class="block text-xs font-bold text-slate-700 mb-1">Mobile Number (For Courier Updates) *</label>
                  <input type="tel" id="chk-phone" required placeholder="10-digit mobile" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
                </div>
                <div class="sm:col-span-2">
                  <label class="block text-xs font-bold text-slate-700 mb-1">Email Address (For GST Invoice) *</label>
                  <input type="email" id="chk-email" required placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
                </div>
              </div>
            </div>

            <!-- Shipping Address Section -->
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-3 sm:space-y-4">
              <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-heading flex items-center gap-2">
                <i class="fa-solid fa-location-dot text-blue-600"></i> 2. Delivery Address
              </h3>
              <div class="space-y-3 sm:space-y-4">
                <div>
                  <label class="block text-xs font-bold text-slate-700 mb-1">Flat / House No. / Building / Street *</label>
                  <input type="text" id="chk-address" required placeholder="House / Flat / Street address" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4">
                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">City *</label>
                    <input type="text" id="chk-city" required placeholder="City name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
                  </div>
                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">State *</label>
                    <input type="text" id="chk-state" required placeholder="State" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
                  </div>
                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">PIN Code *</label>
                    <input type="text" id="chk-pin" required maxlength="6" placeholder="6-digit PIN" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
                  </div>
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

        <!-- Right: Order Summary (4 Columns) -->
        <aside class="lg:col-span-4 bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-4 sticky top-28">
          <h3 class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider font-heading pb-3 border-b border-slate-100 flex items-center justify-between">
            <span>Order Review</span>
            <span class="text-[11px] font-normal text-slate-500 lowercase">insured dispatch</span>
          </h3>

          <!-- Items Mini List -->
          <div id="checkout-items-summary" class="space-y-3 max-h-60 overflow-y-auto pr-1"></div>

          <!-- Price Totals -->
          <div class="space-y-2 text-xs pt-3 border-t border-slate-100 text-slate-600">
            <div class="flex items-center justify-between">
              <span>Subtotal</span>
              <span class="font-bold text-slate-900" id="chk-subtotal">₹0</span>
            </div>
            <div class="flex items-center justify-between text-emerald-600 font-semibold" id="chk-coupon-row">
              <span>Discount</span>
              <span id="chk-coupon-discount">- ₹0</span>
            </div>
            <div class="flex items-center justify-between">
              <span>Insured Shipping</span>
              <span class="font-semibold text-slate-800" id="chk-shipping">FREE</span>
            </div>
            <div class="pt-3 border-t border-slate-200 flex items-baseline justify-between text-sm">
              <span class="font-bold text-slate-900">Grand Total</span>
              <span class="text-xl sm:text-2xl font-extrabold text-slate-900 font-body" id="chk-total">₹0</span>
            </div>
          </div>
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
  <script>
    const CART_URL = "{{ route('cart') }}";
    const THANK_YOU_URL = "{{ route('thank-you') }}";

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('cart');
      Components.renderFooter();
      renderCheckoutSummary();
    });

    function renderCheckoutSummary() {
      const items = Cart.getItems();
    //   if (!items || items.length === 0) {
    //     window.location.href = CART_URL;
    //     return;
    //   }

      const summary = Cart.getSummary();
      const container = document.getElementById('checkout-items-summary');

      container.innerHTML = items.map(item => `
        <div class="flex items-center gap-3 text-xs">
          <img src="${item.image}" alt="${item.name}" class="w-12 h-12 object-contain bg-slate-50 p-1 rounded-lg border border-slate-200 flex-shrink-0" />
          <div class="flex-1 min-w-0">
            <div class="font-bold text-slate-800 truncate">${item.name}</div>
            <div class="text-[11px] text-slate-500">Qty: ${item.quantity} × ${ProductsEngine.formatPrice(item.price)}</div>
          </div>
          <span class="font-extrabold text-slate-900">${ProductsEngine.formatPrice(item.price * item.quantity)}</span>
        </div>
      `).join('');

      document.getElementById('chk-subtotal').textContent = ProductsEngine.formatPrice(summary.subtotal);

      const coupRow = document.getElementById('chk-coupon-row');
      if (summary.coupon && summary.couponDiscount > 0) {
        coupRow.style.display = 'flex';
        document.getElementById('chk-coupon-discount').textContent = `- ${ProductsEngine.formatPrice(summary.couponDiscount)}`;
      } else {
        coupRow.style.display = 'none';
      }

      document.getElementById('chk-shipping').textContent = summary.shipping === 0 ? 'FREE' : '₹99';
      document.getElementById('chk-total').textContent = ProductsEngine.formatPrice(summary.total);
    }

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