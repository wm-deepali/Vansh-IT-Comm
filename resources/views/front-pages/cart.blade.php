@extends('layouts.app')

@section('title', 'Shopping Cart | VANSH IT & COMM')
@section('meta_description', 'Review items in your cart, apply promo coupons, and proceed to secure checkout.')

@section('content')

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
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5" id="cart-item-count-text">Review your selected items.</p>
        </div>
        <button
          type="button"
          onclick="handleClearCart()"
          id="clear-cart-btn"
          class="btn-base btn-secondary btn-sm text-xs font-semibold"
        >
          <i class="fa-regular fa-trash-can mr-1"></i> Clear Cart
        </button>
      </div>

      <!-- Main Cart Layout: 2 Columns on Desktop, 1 on Mobile -->
      <div id="cart-main-content" class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">

        <!-- Left: Cart Items List (8 Columns) -->
        <section class="lg:col-span-8 space-y-4">
          <!-- Free Shipping Progress Bar -->
          <div id="shipping-progress-banner" class="bg-blue-50 border border-blue-200 p-4 rounded-2xl flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center text-lg flex-shrink-0">
              <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div class="flex-1 text-xs">
              <div class="font-bold text-slate-900" id="shipping-progress-title">Free Delivery Threshold</div>
              <p class="text-slate-600" id="shipping-progress-desc">Free Pan-India delivery on orders above ₹999.</p>
            </div>
          </div>

          <!-- Items Container -->
          <div id="cart-items-container" class="space-y-3">
            <!-- Dynamically populated -->
          </div>
        </section>

        <!-- Right: Order Summary & Coupon (4 Columns) -->
        <aside class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-6 sticky top-28">
          <h3 class="text-base font-bold text-slate-900 font-heading border-b border-slate-100 pb-3">
            Order Summary
          </h3>

          <!-- Coupon Code Input -->
          <div>
            <label class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center justify-between">
              <span>Have a Coupon Code?</span>
              <span class="text-[11px] text-blue-600 font-semibold cursor-pointer" onclick="showToast('Try code: VANSH10 or WELCOME500', 'info')">View Codes</span>
            </label>
            <div class="flex items-center gap-2">
              <input
                type="text"
                id="coupon-input"
                placeholder="e.g. VANSH10"
                class="flex-1 uppercase bg-slate-50 border border-slate-200 rounded-xl px-3 py-2 text-xs font-bold text-slate-800 focus:outline-none focus:border-blue-600"
              />
              <button
                type="button"
                onclick="handleApplyCoupon()"
                class="btn-base btn-dark btn-sm text-xs font-semibold py-2 px-3"
              >
                Apply
              </button>
            </div>
            <div id="applied-coupon-tag" class="mt-2 text-xs hidden"></div>
          </div>

          <!-- Cost Breakdown -->
          <div class="space-y-2.5 text-xs pt-2 border-t border-slate-100 text-slate-600">
            <div class="flex items-center justify-between">
              <span>Total MRP</span>
              <span class="text-slate-400 line-through" id="summary-mrp">₹0</span>
            </div>
            <div class="flex items-center justify-between text-emerald-600 font-semibold">
              <span>Product Savings</span>
              <span id="summary-savings">- ₹0</span>
            </div>
            <div class="flex items-center justify-between">
              <span>Subtotal</span>
              <span class="font-bold text-slate-900" id="summary-subtotal">₹0</span>
            </div>
            <div class="flex items-center justify-between text-emerald-600 font-semibold" id="summary-coupon-row">
              <span>Coupon Discount</span>
              <span id="summary-coupon-discount">- ₹0</span>
            </div>
            <div class="flex items-center justify-between">
              <span>Estimated Shipping</span>
              <span class="font-semibold text-slate-800" id="summary-shipping">FREE</span>
            </div>

            <div class="pt-3 border-t border-slate-200 flex items-baseline justify-between text-sm">
              <span class="font-bold text-slate-900">Total Payable</span>
              <span class="text-2xl font-extrabold text-slate-900 font-body" id="summary-total">₹0</span>
            </div>
            <p class="text-[11px] text-slate-400 text-right">Includes 18% GST Invoice</p>
          </div>

          <!-- Checkout CTA -->
          <div class="space-y-2 pt-2">
            <a href="{{ route('checkout') }}" class="btn-base btn-primary w-full py-3.5 text-xs sm:text-sm font-semibold justify-center shadow-lg shadow-blue-600/30">
              Proceed to Checkout <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
            </a>
            <a href="{{ route('shop') }}" class="btn-base btn-secondary w-full py-2.5 text-xs font-semibold justify-center">
              Continue Shopping
            </a>
          </div>

          <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-[11px] text-slate-500 space-y-1">
            <div class="flex items-center gap-1.5 font-semibold text-slate-700">
              <i class="fa-solid fa-shield-halved text-blue-600"></i> Secure Checkout
            </div>
            <p>Insured courier delivery, 7-day replacement, and full GST invoice.</p>
          </div>
        </aside>
      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    const SHOP_URL = "{{ route('shop') }}";
    const PRODUCT_URL = "{{ route('product') }}";

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('cart');
      Components.renderFooter();
      renderCartPage();

      window.addEventListener('cartUpdated', renderCartPage);
    });

    function renderCartPage() {
      const items = Cart.getItems();
      const container = document.getElementById('cart-items-container');
      const countText = document.getElementById('cart-item-count-text');
      const clearBtn = document.getElementById('clear-cart-btn');
      const mainContent = document.getElementById('cart-main-content');

      if (!items || items.length === 0) {
        if (clearBtn) clearBtn.style.display = 'none';
        if (countText) countText.textContent = 'Your cart is empty.';
        mainContent.innerHTML = `
          <div class="col-span-full text-center py-16 px-4 bg-white rounded-3xl border border-slate-200 shadow-sm max-w-lg mx-auto my-8">
            <div class="w-16 h-16 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mx-auto mb-4 text-2xl">
              <i class="fa-solid fa-cart-shopping"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Your cart is waiting for something great</h3>
            <p class="text-xs text-slate-500 mb-6 max-w-sm mx-auto">Explore our tested refurbished laptops, smartphones, and accessories.</p>
            <a href="${SHOP_URL}" class="btn-base btn-primary px-6 py-2.5 text-xs font-semibold">
              Start Exploring Products
            </a>
          </div>
        `;
        return;
      }

      if (clearBtn) clearBtn.style.display = 'inline-flex';
      const count = Cart.getCount();
      countText.textContent = `You have ${count} item${count > 1 ? 's' : ''} in your cart.`;

      // Render Item Cards
      container.innerHTML = items.map(item => `
        <div class="bg-white p-4 sm:p-5 rounded-2xl border border-slate-200 shadow-sm flex flex-col sm:flex-row items-center gap-4">
          <!-- Image -->
          <div class="w-20 h-20 bg-slate-50 rounded-xl p-2 border border-slate-100 flex-shrink-0 flex items-center justify-center">
            <img src="${item.image}" alt="${item.name}" class="max-h-full max-w-full object-contain" />
          </div>

          <!-- Info -->
          <div class="flex-1 min-w-0 text-center sm:text-left">
            <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
              <span class="badge ${ProductsEngine.getBadgeClass(item.condition)} text-[9px]">${item.condition}</span>
              <span class="text-[11px] text-slate-400">${item.warranty || 'Warranty Backed'}</span>
            </div>
            <h3 class="text-xs sm:text-sm font-bold text-slate-900 truncate">
              <a href="${PRODUCT_URL}?id=${item.id}" class="hover:text-blue-600">${item.name}</a>
            </h3>
            <div class="text-xs font-extrabold text-slate-900 mt-1">
              ${ProductsEngine.formatPrice(item.price)}
              ${item.mrp ? `<span class="text-[10px] text-slate-400 line-through font-normal ml-1">${ProductsEngine.formatPrice(item.mrp)}</span>` : ''}
            </div>
          </div>

          <!-- Quantity Controls -->
          <div class="flex items-center gap-2 bg-slate-50 border border-slate-200 rounded-xl p-1">
            <button type="button" onclick="Cart.updateQuantity('${item.id}', -1)" class="w-7 h-7 rounded-lg bg-white text-slate-700 hover:bg-slate-200 flex items-center justify-center text-xs font-bold shadow-sm">
              -
            </button>
            <span class="w-8 text-center text-xs font-bold text-slate-800">${item.quantity}</span>
            <button type="button" onclick="Cart.updateQuantity('${item.id}', 1)" class="w-7 h-7 rounded-lg bg-white text-slate-700 hover:bg-slate-200 flex items-center justify-center text-xs font-bold shadow-sm">
              +
            </button>
          </div>

          <!-- Item Total & Delete -->
          <div class="text-right flex sm:flex-col items-center sm:items-end justify-between w-full sm:w-auto gap-2">
            <div class="text-sm font-extrabold text-slate-900">
              ${ProductsEngine.formatPrice(item.price * item.quantity)}
            </div>
            <button type="button" onclick="Cart.removeItem('${item.id}')" class="text-slate-400 hover:text-red-500 text-xs font-semibold flex items-center gap-1 transition-colors">
              <i class="fa-regular fa-trash-can"></i> Remove
            </button>
          </div>
        </div>
      `).join('');

      // Update Summary Breakdown
      const summary = Cart.getSummary();
      document.getElementById('summary-mrp').textContent = ProductsEngine.formatPrice(summary.mrpTotal);
      document.getElementById('summary-savings').textContent = `- ${ProductsEngine.formatPrice(summary.productSavings)}`;
      document.getElementById('summary-subtotal').textContent = ProductsEngine.formatPrice(summary.subtotal);

      const couponRow = document.getElementById('summary-coupon-row');
      if (summary.coupon && summary.couponDiscount > 0) {
        couponRow.style.display = 'flex';
        document.getElementById('summary-coupon-discount').textContent = `- ${ProductsEngine.formatPrice(summary.couponDiscount)}`;

        const couponTag = document.getElementById('applied-coupon-tag');
        couponTag.className = 'mt-2 text-xs flex items-center justify-between p-2 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 font-bold';
        couponTag.innerHTML = `
          <span><i class="fa-solid fa-tag mr-1"></i> ${summary.coupon.code} Applied</span>
          <button type="button" onclick="handleRemoveCoupon()" class="text-red-500 hover:underline font-normal text-[11px]">&times; Remove</button>
        `;
      } else {
        couponRow.style.display = 'none';
        document.getElementById('applied-coupon-tag').className = 'hidden';
      }

      document.getElementById('summary-shipping').textContent = summary.shipping === 0 ? 'FREE' : '₹99';
      document.getElementById('summary-total').textContent = ProductsEngine.formatPrice(summary.total);

      // Shipping progress text
      if (summary.subtotal >= 999) {
        document.getElementById('shipping-progress-desc').innerHTML = `<span class="text-emerald-600 font-bold"><i class="fa-solid fa-circle-check"></i> Congratulations!</span> You have qualified for <strong>FREE Pan-India Delivery</strong>.`;
      } else {
        const remaining = 999 - summary.subtotal;
        document.getElementById('shipping-progress-desc').textContent = `Add ₹${remaining.toLocaleString('en-IN')} more to unlock FREE delivery.`;
      }
    }

    function handleApplyCoupon() {
      const code = document.getElementById('coupon-input').value;
      const res = Cart.applyCoupon(code);
      if (res.success) {
        showToast(res.message, 'success');
        renderCartPage();
      } else {
        showToast(res.message, 'error');
      }
    }

    function handleRemoveCoupon() {
      Cart.removeCoupon();
      showToast('Coupon removed.', 'info');
      renderCartPage();
    }

    function handleClearCart() {
      if (confirm('Are you sure you want to clear your cart?')) {
        Cart.clearCart();
        renderCartPage();
        showToast('Cart cleared.', 'info');
      }
    }
  </script>
@endpush