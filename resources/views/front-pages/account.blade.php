@extends('layouts.app')

@section('title', 'User Account & Dashboard | VANSH IT & COMM')
@section('meta_description', 'View past orders, track deliveries, manage wishlist, and repair requests.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">My Account</span>
      </nav>

      <!-- Account Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">

        <!-- Left Sidebar: Profile Card & Tabs -->
        <aside class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-6">
          <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
            <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white font-extrabold text-xl flex items-center justify-center shadow-md">
              <i class="fa-solid fa-user"></i>
            </div>
            <div>
              <h2 class="text-base font-bold text-slate-900 font-heading">Demo Customer</h2>
              <p class="text-xs text-slate-500">demo.user@example.com</p>
              <span class="badge bg-emerald-50 text-emerald-700 text-[10px] mt-1">Active Account</span>
            </div>
          </div>

          <!-- Navigation Tabs -->
          <nav class="space-y-1.5 text-xs font-semibold" aria-label="Account Navigation">
            <button type="button" onclick="switchAccountTab('orders')" id="acc-tab-orders" class="w-full flex items-center justify-between p-3 rounded-xl bg-blue-50 text-blue-600 font-bold transition-colors">
              <span class="flex items-center gap-2.5"><i class="fa-solid fa-box-archive"></i> My Orders</span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
            <button type="button" onclick="switchAccountTab('repairs')" id="acc-tab-repairs" class="w-full flex items-center justify-between p-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors">
              <span class="flex items-center gap-2.5"><i class="fa-solid fa-screwdriver-wrench"></i> Repair Tickets</span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
            <button type="button" onclick="switchAccountTab('addresses')" id="acc-tab-addresses" class="w-full flex items-center justify-between p-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors">
              <span class="flex items-center gap-2.5"><i class="fa-solid fa-location-dot"></i> Saved Addresses</span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
            <a href="{{ route('wishlist') }}" class="w-full flex items-center justify-between p-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors text-decoration-none">
              <span class="flex items-center gap-2.5"><i class="fa-regular fa-heart"></i> Saved Wishlist</span>
              <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
          </nav>
        </aside>

        <!-- Right Content Panels (8 Columns) -->
        <section class="lg:col-span-8 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm min-h-[400px]">

          <!-- Tab 1: Orders -->
          <div id="acc-content-orders" class="space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
              <h3 class="text-base font-bold text-slate-900 font-heading">Order History</h3>
              <a href="{{ route('track-order') }}" class="text-xs font-bold text-blue-600 hover:underline">Track Any Order →</a>
            </div>
            <div id="acc-orders-container" class="space-y-4">
              <!-- Dynamically populated from vansh_orders -->
            </div>
          </div>

          <!-- Tab 2: Repair Tickets -->
          <div id="acc-content-repairs" class="hidden space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
              <h3 class="text-base font-bold text-slate-900 font-heading">Repair Requests</h3>
              <a href="{{ route('repair') }}" class="text-xs font-bold text-blue-600 hover:underline">+ Book New Repair</a>
            </div>
            <div class="p-6 text-center border border-dashed border-slate-200 rounded-2xl">
              <i class="fa-solid fa-wrench text-slate-300 text-3xl mb-2"></i>
              <p class="text-xs text-slate-500">No active repair tickets currently.</p>
              <a href="{{ route('repair') }}" class="btn-base btn-secondary btn-sm text-xs mt-3">Book Device Service</a>
            </div>
          </div>

          <!-- Tab 3: Saved Addresses -->
          <div id="acc-content-addresses" class="hidden space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
              <h3 class="text-base font-bold text-slate-900 font-heading">Saved Addresses</h3>
              <button type="button" onclick="showToast('Address management active in demo mode.', 'info')" class="text-xs font-bold text-blue-600 hover:underline">+ Add New</button>
            </div>
            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-700 space-y-1">
              <div class="font-bold text-slate-900 flex items-center justify-between">
                <span>Default Address (Home)</span>
                <span class="badge bg-blue-100 text-blue-800 text-[10px]">Default</span>
              </div>
              <p>Demo User • +91 98765 43210</p>
              <p class="text-slate-500">104 Tech Avenue, Cyber City, New Delhi - 110001</p>
            </div>
          </div>

        </section>

      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('account');
      Components.renderFooter();
      renderUserOrders();
    });

    function switchAccountTab(tabId) {
      ['orders', 'repairs', 'addresses'].forEach(t => {
        document.getElementById(`acc-content-${t}`).classList.add('hidden');
        document.getElementById(`acc-tab-${t}`).className = 'w-full flex items-center justify-between p-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors';
      });
      document.getElementById(`acc-content-${tabId}`).classList.remove('hidden');
      document.getElementById(`acc-tab-${tabId}`).className = 'w-full flex items-center justify-between p-3 rounded-xl bg-blue-50 text-blue-600 font-bold transition-colors';
    }

    function renderUserOrders() {
      const orders = JSON.parse(localStorage.getItem('vansh_orders') || '[]');
      const container = document.getElementById('acc-orders-container');

      if (orders.length === 0) {
        container.innerHTML = `
          <div class="text-center py-12 px-4">
            <i class="fa-solid fa-box-open text-slate-300 text-4xl mb-3"></i>
            <h4 class="text-sm font-bold text-slate-800 mb-1">No Orders Placed Yet</h4>
            <p class="text-xs text-slate-500 mb-4">When you place orders, they will be archived here for live tracking and warranty claims.</p>
            <a href="{{ route('shop') }}" class="btn-base btn-primary btn-sm text-xs">Start Shopping</a>
          </div>
        `;
        return;
      }

      container.innerHTML = orders.map(ord => `
        <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-3">
          <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-200">
            <div>
              <span class="text-slate-400">Order ID:</span>
              <strong class="text-blue-600 font-bold ml-1">${ord.orderId}</strong>
              <span class="text-slate-400 ml-2">(${ord.date})</span>
            </div>
            <div class="flex items-center gap-2">
              <span class="badge bg-emerald-100 text-emerald-800 text-[10px] font-bold">${ord.status}</span>
              <a href="{{ route('track-order') }}?orderId=${ord.orderId}" class="btn-base btn-secondary btn-sm text-[11px] py-1 px-2.5">
                <i class="fa-solid fa-location-crosshairs mr-1"></i> Track
              </a>
            </div>
          </div>

          <div class="space-y-1.5">
            ${(ord.items || []).map(item => `
              <div class="flex items-center justify-between">
                <span class="truncate max-w-xs sm:max-w-md font-medium text-slate-800">${item.name} <span class="text-slate-400">×${item.quantity}</span></span>
                <span class="font-bold text-slate-900">${ProductsEngine.formatPrice(item.price * item.quantity)}</span>
              </div>
            `).join('')}
          </div>

          <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-xs">
            <span class="text-slate-500">Total Paid via ${ord.paymentMethod}:</span>
            <strong class="text-sm text-slate-900">${ProductsEngine.formatPrice(ord.total)}</strong>
          </div>
        </div>
      `).join('');
    }
  </script>
@endpush