@extends('layouts.app')

@section('title', 'Order Confirmed — Thank You | VANSH IT & COMM')
@section('meta_description', 'Your order has been placed successfully. Track your parcel dispatch and view your GST invoice summary.')

@section('content')

  <main class="flex-grow py-8 sm:py-12">
    <div class="container-custom max-w-4xl">

      <!-- Order Success Banner -->
      <div class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm text-center mb-8 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-emerald-50 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-blue-50 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10">
          <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-emerald-500 text-white flex items-center justify-center text-3xl sm:text-4xl mx-auto mb-4 shadow-lg shadow-emerald-500/30 animate-bounce">
            <i class="fa-solid fa-check"></i>
          </div>

          <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-3 py-1 font-bold uppercase tracking-wider mb-2 inline-block">
            <i class="fa-solid fa-circle-check text-emerald-500 mr-1.5"></i> Order Placed Successfully
          </span>

          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 font-heading mb-2">
            Thank You For Your Order!
          </h1>
          <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto mb-6">
            We have received your order. Our engineering team is conducting the final 20-Point QC inspection before handing your parcel to our express courier partner.
          </p>

          <!-- Order Meta Quick Pill -->
          <div class="inline-flex flex-wrap items-center justify-center gap-3 sm:gap-6 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 font-medium">
            <div>
              <span class="text-slate-400 block text-[10px] uppercase font-bold">Order ID</span>
              <strong class="text-blue-600 text-sm font-extrabold" id="ty-order-id">VIC2026-XXXX</strong>
            </div>
            <div class="hidden sm:block text-slate-300">|</div>
            <div>
              <span class="text-slate-400 block text-[10px] uppercase font-bold">Estimated Delivery</span>
              <strong class="text-slate-900 text-xs font-bold" id="ty-delivery-date">3–5 Business Days</strong>
            </div>
            <div class="hidden sm:block text-slate-300">|</div>
            <div>
              <span class="text-slate-400 block text-[10px] uppercase font-bold">Payment Status</span>
              <span class="badge bg-emerald-100 text-emerald-800 text-[10px] font-extrabold" id="ty-payment-mode">Paid (Demo)</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Main Order Details Grid (2 Columns) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-12">

        <!-- Left: Ordered Items List (7 Columns) -->
        <section class="lg:col-span-7 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-4">
          <div class="flex items-center justify-between pb-4 border-b border-slate-100">
            <h2 class="text-base font-bold text-slate-900 font-heading flex items-center gap-2">
              <i class="fa-solid fa-box-open text-blue-600"></i> Items in This Order
            </h2>
            <span class="text-xs text-slate-500" id="ty-item-count">0 items</span>
          </div>

          <div id="ty-items-container" class="space-y-3 divide-y divide-slate-100">
            <!-- Dynamically populated from order history -->
          </div>
        </section>

        <!-- Right: Delivery Address & Summary Actions (5 Columns) -->
        <aside class="lg:col-span-5 space-y-6">

          <!-- Shipping Address Card -->
          <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading flex items-center gap-1.5 pb-2 border-b border-slate-100">
              <i class="fa-solid fa-location-dot text-blue-600"></i> Shipping Details
            </h3>
            <div class="space-y-1 text-slate-600">
              <div class="font-bold text-slate-900 text-sm" id="ty-customer-name">Demo Customer</div>
              <div id="ty-customer-phone">+91 98765 43210</div>
              <div id="ty-customer-email" class="text-slate-500">customer@example.com</div>
              <div class="pt-2 text-slate-700 font-medium" id="ty-customer-address">
                House 104, Tech Park Boulevard, Cyber City, New Delhi - 110001
              </div>
            </div>
          </div>

          <!-- Total Summary Card -->
          <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
            <h3 class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading pb-2 border-b border-slate-100">
              Payment Breakdown
            </h3>
            <div class="space-y-2 text-slate-600">
              <div class="flex items-center justify-between">
                <span>Total Amount Paid</span>
                <strong class="text-base font-extrabold text-slate-900" id="ty-total-paid">₹0</strong>
              </div>
              <p class="text-[11px] text-slate-400">Includes 18% GST invoice and transit packaging insurance.</p>
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2 pt-3 border-t border-slate-100">
              <a href="{{ route('track-order') }}" id="ty-track-btn" class="btn-base btn-primary w-full py-3 text-xs font-semibold justify-center shadow-md">
                <i class="fa-solid fa-location-crosshairs mr-1.5"></i> Track Package Live
              </a>
              <button type="button" onclick="App.showToast('GST Invoice PDF simulation generated & downloaded!', 'success')" class="btn-base btn-secondary w-full py-2.5 text-xs font-semibold justify-center">
                <i class="fa-solid fa-file-invoice mr-1.5"></i> Download GST Tax Invoice
              </button>
              <a href="{{ route('shop') }}" class="btn-base btn-secondary w-full py-2.5 text-xs font-semibold justify-center bg-slate-50">
                Continue Shopping
              </a>
            </div>
          </div>

        </aside>
      </div>

      <!-- Trust Reassurance Badges -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-center">
        <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
          <i class="fa-solid fa-shield-halved text-blue-600 text-xl mb-1.5 block"></i>
          <h4 class="text-xs font-bold text-slate-900">Warranty Backed</h4>
          <p class="text-[11px] text-slate-500">Up to 12 Month Protection</p>
        </div>
        <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
          <i class="fa-solid fa-truck-fast text-emerald-600 text-xl mb-1.5 block"></i>
          <h4 class="text-xs font-bold text-slate-900">Insured Parcel</h4>
          <p class="text-[11px] text-slate-500">BlueDart & Delhivery Express</p>
        </div>
        <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
          <i class="fa-solid fa-rotate-left text-amber-600 text-xl mb-1.5 block"></i>
          <h4 class="text-xs font-bold text-slate-900">7-Day Replacement</h4>
          <p class="text-[11px] text-slate-500">Hassle-Free Transition</p>
        </div>
        <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
          <i class="fa-solid fa-headset text-purple-600 text-xl mb-1.5 block"></i>
          <h4 class="text-xs font-bold text-slate-900">Expert Support</h4>
          <p class="text-[11px] text-slate-500">Assistance On Demand</p>
        </div>
      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    const TRACK_ORDER_URL = "{{ route('track-order') }}";

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader();
      Components.renderFooter();
      renderThankYouOrder();
    });

    function renderThankYouOrder() {
      const params = App.getUrlParams();
      const orders = JSON.parse(localStorage.getItem('vansh_orders') || '[]');
      let currentOrder = null;

      if (params.orderId) {
        currentOrder = orders.find(o => o.orderId === params.orderId);
      }
      if (!currentOrder && orders.length > 0) {
        currentOrder = orders[0]; // latest order
      }

      if (!currentOrder) {
        // Fallback demo order
        currentOrder = {
          orderId: params.orderId || 'VIC2026-7841',
          date: new Date().toLocaleDateString('en-IN', { day: 'numeric', month: 'short', year: 'numeric' }),
          paymentMethod: 'UPI Instant',
          items: [
            {
              id: 'lap-01',
              name: 'Dell Latitude 5420 Business Laptop',
              price: 32499,
              image: "{{ asset('assets/img/product-1593642632823-8f785ba67e45.jpg') }}",
              quantity: 1,
              condition: 'Refurbished'
            }
          ],
          total: 32499,
          customer: {
            name: 'Rahul Sharma',
            phone: '+91 98765 43210',
            email: 'rahul.sharma@example.com',
            address: '104 Tech Park, Cyber City, New Delhi - 110001'
          }
        };
      }

      // Populate UI
      document.getElementById('ty-order-id').textContent = currentOrder.orderId;
      document.getElementById('ty-track-btn').href = `${TRACK_ORDER_URL}?orderId=${encodeURIComponent(currentOrder.orderId)}`;
      document.getElementById('ty-payment-mode').textContent = currentOrder.paymentMethod || 'Paid (Demo)';
      document.getElementById('ty-total-paid').textContent = ProductsEngine.formatPrice(currentOrder.total || 0);
      document.getElementById('ty-item-count').textContent = `${(currentOrder.items || []).length} item${(currentOrder.items || []).length > 1 ? 's' : ''}`;

      if (currentOrder.customer) {
        document.getElementById('ty-customer-name').textContent = currentOrder.customer.name || 'Valued Customer';
        document.getElementById('ty-customer-phone').textContent = currentOrder.customer.phone || 'Phone verified';
        document.getElementById('ty-customer-email').textContent = currentOrder.customer.email || 'Invoice sent via email';
        document.getElementById('ty-customer-address').textContent = currentOrder.customer.address || 'Standard Delivery Address';
      }

      const container = document.getElementById('ty-items-container');
      container.innerHTML = (currentOrder.items || []).map(item => `
        <div class="flex items-center gap-3 pt-3 text-xs">
          <img src="${item.image}" alt="${item.name}" class="w-14 h-14 object-contain rounded-xl bg-slate-100 p-1 border border-slate-200 flex-shrink-0" />
          <div class="flex-1 min-w-0">
            <h4 class="font-bold text-slate-900 truncate">${item.name}</h4>
            <div class="text-[11px] text-slate-500 mt-0.5">
              <span class="badge ${ProductsEngine.getBadgeClass(item.condition)} text-[9px] py-0 px-1.5">${item.condition || 'Tested'}</span>
              <span class="ml-2">Qty: <strong>${item.quantity}</strong></span>
            </div>
          </div>
          <div class="text-right font-extrabold text-slate-900">
            ${ProductsEngine.formatPrice(item.price * item.quantity)}
          </div>
        </div>
      `).join('');
    }
  </script>
@endpush