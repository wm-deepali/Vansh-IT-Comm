@extends('layouts.app')

@section('active_page', 'track-order')

@section('content')

  @php
    $label = fn($v) => ucwords(str_replace('_', ' ', (string) $v));
    $partnerClass = 'p-2 bg-slate-50 rounded-xl border border-slate-100 flex items-center gap-2 min-w-0';
  @endphp

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Track Your Parcel</span>
      </nav>

      <!-- Hero Header -->
      <div
        class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-10 border border-slate-800 shadow-xl">
        <div class="max-w-4xl space-y-3">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1 font-bold">REAL-TIME
            LOGISTICS</span>
          <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Live Order & Parcel Tracking
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            Track your verified pre-owned laptop, phone, or replacement shipment across all courier hubs in India.
          </p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16 items-start">

        <!-- Left: search -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
          <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
              <i class="fa-solid fa-location-crosshairs"></i>
            </div>
            <div>
              <h3 class="text-base font-bold text-slate-900 font-heading">Track Parcel</h3>
              <p class="text-xs text-slate-500 mt-0.5">Enter your Order ID or AWB Tracking number.</p>
            </div>

            <form method="GET" action="{{ route('user.track-order') }}" class="space-y-3">
              <div>
                <label for="track-order-id" class="block text-xs font-semibold text-slate-700 mb-1">Order / AWB
                  Number</label>
                <input type="text" id="track-order-id" name="orderId" required value="{{ $query }}"
                  placeholder="Enter your Order ID or AWB"
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-2.5 text-xs font-bold text-slate-800 focus:outline-none focus:border-blue-600 uppercase" />
              </div>
              <button type="submit"
                class="btn-base btn-primary w-full py-2.5 text-xs font-semibold shadow-lg shadow-blue-600/30">
                <i class="fa-solid fa-magnifying-glass mr-1.5"></i> Track Status
              </button>
            </form>
          </div>

          <!-- Courier partners (from couriers table) -->
          @if($couriers->isNotEmpty())
            <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-3">
              <h4 class="text-xs font-bold text-slate-900 font-heading">Our Express Partners:</h4>
              <div class="grid grid-cols-2 gap-2 text-[11px] text-slate-600 font-semibold">
                @foreach($couriers as $courier)
                  @php $courierIcon = filled($courier->icon) ? $courier->icon : 'fa-solid fa-truck-fast'; @endphp

                  @if(filled($courier->website_url))
                    <a href="{{ $courier->website_url }}" target="_blank" rel="noopener"
                      class="{{ $partnerClass }} hover:border-blue-300 hover:text-blue-600 transition-colors"
                      title="Open {{ $courier->name }} tracking site">
                      <i class="{{ $courierIcon }} text-blue-600 flex-shrink-0"></i>
                      <span class="truncate">{{ $courier->name }}</span>
                    </a>
                  @else
                    <div class="{{ $partnerClass }}">
                      <i class="{{ $courierIcon }} text-blue-600 flex-shrink-0"></i>
                      <span class="truncate">{{ $courier->name }}</span>
                    </div>
                  @endif
                @endforeach
              </div>
            </div>
          @endif
        </div>

        <!-- Right: result -->
        <div class="lg:col-span-8">

          @if(!$searched)
            <div class="bg-white p-10 rounded-3xl border border-slate-200 shadow-sm text-center">
              <i class="fa-solid fa-truck-fast text-slate-300 text-4xl mb-3"></i>
              <h3 class="text-sm font-bold text-slate-800 mb-1">Enter your Order ID to begin</h3>
              <p class="text-xs text-slate-500">You'll find it in your confirmation email and under My Account → My Orders.
              </p>
            </div>

          @elseif(!$order)
            <div class="bg-white p-10 rounded-3xl border border-slate-200 shadow-sm text-center">
              <i class="fa-solid fa-circle-question text-slate-300 text-4xl mb-3"></i>
              <h3 class="text-sm font-bold text-slate-800 mb-1">No order found for "{{ $query }}"</h3>
              <p class="text-xs text-slate-500">Check the number and try again, or
                <a href="{{ route('contact') }}" class="text-blue-600 font-semibold hover:underline">contact our
                  helpdesk</a>.
              </p>
            </div>

          @else
            <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-8">

              <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-6 border-b border-slate-100">
                <div>
                  <span class="text-xs text-slate-400">Tracking Information for:</span>
                  <h2 class="text-2xl font-extrabold text-blue-600 font-heading">{{ $order->order_number }}</h2>
                  <span class="text-[11px] text-slate-400">Placed on {{ $order->created_at->format('d M Y') }}</span>
                </div>
                <div class="text-xs text-slate-600 sm:text-right space-y-0.5">
                  @if($order->courier?->name)
                    <div><strong>Logistics:</strong> {{ $order->courier->name }}</div>
                  @endif
                  @if(filled($order->tracking_number))
                    <div><strong>AWB:</strong> {{ $order->tracking_number }}</div>
                  @endif
                  @if($order->courier?->website_url)
                    <div><a href="{{ $order->courier->website_url }}" target="_blank" rel="noopener"
                        class="text-blue-600 font-semibold hover:underline">Open courier tracking site →</a></div>
                  @endif
                  <div class="font-bold text-slate-900">Status: {{ $label($order->status) }}</div>
                </div>
              </div>

              @if($isOffTrack)
                <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-700 flex items-center gap-2">
                  <i class="fa-solid fa-circle-exclamation"></i>
                  {{ $offTrackMessage }} Contact our helpdesk if you need help.
                </div>
              @else
                <!-- Timeline -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-6 relative">
                  @foreach ($stages as $stage)
                    @php
                      $circle = match ($stage['state']) {
                        'done' => 'bg-emerald-600 text-white shadow-md',
                        'current' => 'bg-blue-600 text-white shadow-md animate-pulse',
                        default => 'bg-slate-100 text-slate-400 border border-slate-200',
                      };
                      $titleClass = $stage['state'] === 'current' ? 'text-blue-600'
                        : ($stage['state'] === 'pending' ? 'text-slate-700' : 'text-slate-900');
                    @endphp
                    <div
                      class="flex md:flex-col items-center gap-3.5 md:text-center {{ $stage['state'] === 'pending' ? 'opacity-50' : '' }}">
                      <div
                        class="w-11 h-11 rounded-full {{ $circle }} flex items-center justify-center text-base font-bold flex-shrink-0">
                        <i class="fa-solid {{ $stage['icon'] }}"></i>
                      </div>
                      <div>
                        <h4 class="text-xs font-bold {{ $titleClass }}">{{ $stage['title'] }}</h4>
                        <p class="text-[11px] {{ $stage['state'] === 'pending' ? 'text-slate-400' : 'text-slate-500' }}">
                          {{ $stage['date'] ? $stage['date']->format('d M, h:i A') : $stage['sub'] }}
                        </p>
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

              <!-- Update history -->
              @if($order->statusHistory->isNotEmpty())
                <div class="pt-6 border-t border-slate-100 space-y-3">
                  <h4 class="text-xs font-bold text-slate-900 font-heading">Order Updates</h4>
                  @foreach($order->statusHistory as $h)
                    <div class="flex items-start gap-3 text-xs">
                      <span class="w-2 h-2 rounded-full bg-blue-600 mt-1.5 flex-shrink-0"></span>
                      <div>
                        <div class="font-semibold text-slate-800">{{ $label($h->status) }}
                          <span class="text-slate-400 font-normal ml-1">{{ $h->created_at->format('d M Y, h:i A') }}</span>
                        </div>
                        @if(filled($h->remarks))
                          <p class="text-slate-500">{{ $h->remarks }}</p>
                        @endif
                      </div>
                    </div>
                  @endforeach
                </div>
              @endif

              <!-- Items -->
              @if($order->items->isNotEmpty())
                <div class="pt-6 border-t border-slate-100 space-y-1.5 text-xs">
                  <h4 class="font-bold text-slate-900 font-heading mb-2">Items in this order</h4>
                  @foreach($order->items as $item)
                    <div class="text-slate-700">{{ $item->product_name }} <span
                        class="text-slate-400">×{{ $item->quantity }}</span></div>
                  @endforeach
                </div>
              @endif

              <!-- Footer: help + links -->
              <div
                class="pt-6 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4 text-xs text-slate-500">
                <span>Need help with delivery instructions? <a href="{{ route('contact') }}"
                    class="text-blue-600 font-semibold hover:underline">Contact Dispatch Helpdesk</a></span>
                <div class="flex items-center gap-2 flex-wrap">
                  <a href="{{ route('user.account.orders.show', $order->id) }}"
                    class="btn-base btn-primary btn-sm py-1.5 px-3 text-xs">
                    <i class="fa-solid fa-receipt mr-1"></i> Order Details
                  </a>
                  @if($order->invoice)
                    <a href="{{ route('user.account.orders.invoice', $order->id) }}" target="_blank"
                      class="btn-base btn-secondary btn-sm py-1.5 px-3 text-xs">
                      <i class="fa-solid fa-file-invoice mr-1"></i> Invoice
                    </a>
                  @endif
                  <a href="#" class="btn-base btn-secondary btn-sm py-1.5 px-3 text-xs">Shipping Policy</a>
                </div>
              </div>

            </div>
          @endif

        </div>
      </div>
    </div>
  </main>

@endsection