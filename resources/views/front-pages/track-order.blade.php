@extends('layouts.app')

@section('title', 'Track Your Order | VANSH IT & COMM')
@section('meta_description', 'Track your dispatched electronics order and view live transit status across India.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Track Your Parcel</span>
      </nav>

      <!-- Hero Header -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-10 border border-slate-800 shadow-xl">
        <div class="max-w-4xl space-y-3">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1 font-bold">REAL-TIME LOGISTICS</span>
          <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Live Order & Parcel Tracking
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            Track your verified pre-owned laptop, phone, or replacement shipment across all courier hubs in India.
          </p>
        </div>
      </div>

      <!-- Master Full-Width 2-Column Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16 items-start">

        <!-- Left Column: Search Form Card -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
          <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
              <i class="fa-solid fa-location-crosshairs"></i>
            </div>
            <div>
              <h3 class="text-base font-bold text-slate-900 font-heading">Track Parcel</h3>
              <p class="text-xs text-slate-500 mt-0.5">Enter your Order ID (e.g. VIC2026-7841) or AWB Tracking number.</p>
            </div>

            <form id="track-form" class="space-y-3" onsubmit="handleTrackLookup(event)">
              <div>
                <label for="track-order-id" class="block text-xs font-semibold text-slate-700 mb-1">Order / AWB Number</label>
                <input
                  type="text"
                  id="track-order-id"
                  required
                  placeholder="VIC2026-7841"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:border-blue-600 uppercase"
                />
              </div>
              <button type="submit" class="btn-base btn-primary w-full py-2.5 text-xs font-semibold shadow-lg shadow-blue-600/30">
                <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Track Status
              </button>
            </form>
          </div>

          <!-- Courier Partners Card -->
          <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <h4 class="text-xs font-bold text-slate-900 font-heading">Our Express Partners:</h4>
            <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600 font-semibold">
              <div class="p-2 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-2"><i class="fa-solid fa-plane text-blue-600"></i> BlueDart Air</div>
              <div class="p-2 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-2"><i class="fa-solid fa-truck-fast text-red-600"></i> Delhivery Express</div>
              <div class="p-2 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-2"><i class="fa-solid fa-box text-orange-600"></i> DTDC Premium</div>
              <div class="p-2 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-2"><i class="fa-solid fa-envelope text-emerald-600"></i> Speed Post</div>
            </div>
          </div>
        </div>

        <!-- Right Column: Live Tracking Timeline Result -->
        <div class="lg:col-span-8">
          <div id="tracking-timeline-box" class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-8">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
              <div>
                <span class="text-xs text-slate-400">Tracking Information for:</span>
                <h2 class="text-2xl font-extrabold text-blue-600 font-heading" id="timeline-order-id">VIC2026-7841</h2>
              </div>
              <div class="text-xs text-slate-600 sm:text-right space-y-0.5">
                <div><strong>Logistics:</strong> BlueDart Air Insured Express</div>
                <div class="text-emerald-600 font-bold flex items-center gap-1.5 sm:justify-end">
                  <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                  <span>Estimated Delivery: Within 48 Hours</span>
                </div>
              </div>
            </div>

            <!-- 5-Step Timeline -->
            @php
              $stages = [
                ['icon' => 'fa-check',           'title' => 'Order Placed', 'sub' => 'Payment verified',    'state' => 'done'],
                ['icon' => 'fa-clipboard-check', 'title' => '20-Point QC',  'sub' => 'Passed diagnostics',  'state' => 'done'],
                ['icon' => 'fa-box',             'title' => 'Dispatched',   'sub' => 'Handed to courier',   'state' => 'current'],
                ['icon' => 'fa-truck',           'title' => 'In Transit',   'sub' => 'Airport express hub', 'state' => 'pending'],
                ['icon' => 'fa-house-chimney',   'title' => 'Delivered',    'sub' => 'Safe doorstep OTP',   'state' => 'pending'],
              ];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-5 gap-6 relative">
              @foreach ($stages as $stage)
                <div class="flex md:flex-col items-center gap-3.5 md:text-center {{ $stage['state'] === 'pending' ? 'opacity-50' : '' }}">
                  @if ($stage['state'] === 'done')
                    <div class="w-11 h-11 rounded-full bg-emerald-600 text-white flex items-center justify-center text-base font-bold shadow-md flex-shrink-0">
                  @elseif ($stage['state'] === 'current')
                    <div class="w-11 h-11 rounded-full bg-blue-600 text-white flex items-center justify-center text-base font-bold shadow-md flex-shrink-0 animate-pulse">
                  @else
                    <div class="w-11 h-11 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-base font-bold flex-shrink-0 border border-slate-200">
                  @endif
                    <i class="fa-solid {{ $stage['icon'] }}"></i>
                  </div>
                  <div>
                    <h4 class="text-xs font-bold {{ $stage['state'] === 'current' ? 'text-blue-600' : ($stage['state'] === 'pending' ? 'text-slate-700' : 'text-slate-900') }}">{{ $stage['title'] }}</h4>
                    <p class="text-[11px] {{ $stage['state'] === 'pending' ? 'text-slate-400' : 'text-slate-500' }}">{{ $stage['sub'] }}</p>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- Support Footer Inside Tracking -->
            <div class="pt-6 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4 text-xs text-slate-500">
              <span>Need help with delivery instructions? <a href="{{ route('contact') }}" class="text-blue-600 font-semibold hover:underline">Contact Dispatch Helpdesk</a></span>
              <a href="{{ route('shipping') }}" class="btn-base btn-secondary btn-sm py-1.5 px-3 text-xs">Shipping Policy</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader();
      Components.renderFooter();

      const params = App.getUrlParams();
      if (params.orderId) {
        document.getElementById('track-order-id').value = params.orderId;
        document.getElementById('timeline-order-id').textContent = params.orderId;
      }
    });

    function handleTrackLookup(event) {
      event.preventDefault();
      const id = document.getElementById('track-order-id').value.trim().toUpperCase();
      document.getElementById('timeline-order-id').textContent = id;
      showToast(`Fetching live tracking for #${id}...`, 'info');
    }
  </script>
@endpush