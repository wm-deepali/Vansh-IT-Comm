@extends('layouts.app')

@section('content')

  @php
    $currency = config('shop.currency', '₹');
    $money = fn($n) => $currency . number_format((float) $n, 2);
    $fallback = asset('assets/img/product-1588872657578-7efd1f1555ed.jpg'); // placeholder only

    $order->loadMissing([
      'items.product.images',
      'items.imageVariant',
      'items.addons',
      'state',
      'city',
      'invoice',
    ]);

    $isPaid = $order->payment_status === 'paid';
    $isCod = $order->payment_method === 'cod';

    $paymentLabel = $isPaid ? 'Paid Online' : ($isCod ? 'Cash on Delivery' : ucfirst($order->payment_status ?? 'Pending'));
    $paymentBadge = $isPaid ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800';

    $fullAddress = collect([
      $order->address_line_1,
      $order->address_line_2,
      $order->city?->name,
      $order->state?->name,
    ])->filter()->implode(', ') . ($order->pincode ? ' - ' . $order->pincode : '');

    $itemCount = $order->items->count();
  @endphp

  <main class="flex-grow py-8 sm:py-12">
    <div class="container-custom max-w-4xl">

      <!-- Order Success Banner -->
      <div
        class="bg-white rounded-3xl p-6 sm:p-10 border border-slate-200 shadow-sm text-center mb-8 relative overflow-hidden">
        <div class="absolute -top-12 -right-12 w-40 h-40 bg-emerald-50 rounded-full blur-2xl pointer-events-none"></div>
        <div class="absolute -bottom-12 -left-12 w-40 h-40 bg-blue-50 rounded-full blur-2xl pointer-events-none"></div>

        <div class="relative z-10">
          <div
            class="w-16 h-16 sm:w-20 sm:h-20 rounded-3xl bg-emerald-500 text-white flex items-center justify-center text-3xl sm:text-4xl mx-auto mb-4 shadow-lg shadow-emerald-500/30 animate-bounce">
            <i class="fa-solid fa-check"></i>
          </div>

          <span
            class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-3 py-1 font-bold uppercase tracking-wider mb-2 inline-block">
            <i class="fa-solid fa-circle-check text-emerald-500 mr-1.5"></i> Order Placed Successfully
          </span>

          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 font-heading mb-2">
            Thank You For Your Order!
          </h1>
          <p class="text-xs sm:text-sm text-slate-500 max-w-lg mx-auto mb-6">
            We have received your order. Our engineering team is conducting the final 20-Point QC inspection before
            handing your parcel to our express courier partner.
            A confirmation has been sent to <strong class="text-slate-700">{{ $order->customer_email }}</strong>.
          </p>

          <!-- Order Meta Quick Pill -->
          <div
            class="inline-flex flex-wrap items-center justify-center gap-3 sm:gap-6 p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-700 font-medium">
            <div>
              <span class="text-slate-400 block text-[10px] uppercase font-bold">Order ID</span>
              <strong class="text-blue-600 text-sm font-extrabold">{{ $order->order_number }}</strong>
            </div>
            <div class="hidden sm:block text-slate-300">|</div>
            <div>
              <span class="text-slate-400 block text-[10px] uppercase font-bold">Order Date</span>
              <strong class="text-slate-900 text-xs font-bold">{{ $order->created_at->format('d M Y') }}</strong>
            </div>
            <div class="hidden sm:block text-slate-300">|</div>
            <div>
              <span class="text-slate-400 block text-[10px] uppercase font-bold">Estimated Delivery</span>
              <strong class="text-slate-900 text-xs font-bold">3–5 Business Days</strong>
            </div>
            <div class="hidden sm:block text-slate-300">|</div>
            <div>
              <span class="text-slate-400 block text-[10px] uppercase font-bold">Payment</span>
              <span class="badge {{ $paymentBadge }} text-[10px] font-extrabold">{{ $paymentLabel }}</span>
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
            <span class="text-xs text-slate-500">{{ $itemCount }} item{{ $itemCount === 1 ? '' : 's' }}</span>
          </div>

          <div class="space-y-3 divide-y divide-slate-100">
            @foreach($order->items as $item)
              @php
                $product = $item->product;

                // Thumbnail: image variant > product default image > placeholder
                if ($item->imageVariant && $item->imageVariant->image) {
                  $imgUrl = asset('storage/' . $item->imageVariant->image);
                } else {
                  $img = $product?->images?->sortByDesc('is_default')->first();
                  $imgUrl = $img ? asset('storage/' . $img->image) : $fallback;
                }

                $attrs = $item->selected_attributes;
                $attrs = is_array($attrs) ? $attrs : (json_decode($attrs ?? '[]', true) ?: []);

                $addonsTotal = $item->addons->sum('price');
                $lineTotal = ($item->price * $item->quantity) + $addonsTotal;
              @endphp

              <div class="flex items-center gap-3 pt-3 text-xs first:pt-0">
                <img src="{{ $imgUrl }}" alt="{{ $item->product_name }}"
                  class="w-14 h-14 object-contain rounded-xl bg-slate-100 p-1 border border-slate-200 flex-shrink-0"
                  onerror="this.onerror=null; this.src='{{ $fallback }}';" />
                <div class="flex-1 min-w-0">
                  <h4 class="font-bold text-slate-900 truncate">{{ $item->product_name }}</h4>

                  @if(count($attrs))
                    <div class="text-[11px] text-slate-500 truncate">
                      {{ collect($attrs)->map(fn($a) => is_array($a) ? (($a['attribute'] ?? '') . ': ' . ($a['value'] ?? '')) : $a)->implode(' • ') }}
                    </div>
                  @endif

                  @foreach($item->addons as $addon)
                    <div class="text-[11px] text-slate-500 truncate">+ {{ $addon->detail }} ({{ $money($addon->price) }})
                    </div>
                  @endforeach

                  <div class="text-[11px] text-slate-500 mt-0.5">
                    Qty: <strong>{{ $item->quantity }}</strong> × {{ $money($item->price) }}
                  </div>
                </div>
                <div class="text-right font-extrabold text-slate-900">
                  {{ $money($lineTotal) }}
                </div>
              </div>
            @endforeach
          </div>
        </section>

        <!-- Right: Delivery Address & Summary Actions (5 Columns) -->
        <aside class="lg:col-span-5 space-y-6">

          <!-- Shipping Address Card -->
          <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
            <h3
              class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading flex items-center gap-1.5 pb-2 border-b border-slate-100">
              <i class="fa-solid fa-location-dot text-blue-600"></i> Shipping Details
            </h3>
            <div class="space-y-1 text-slate-600">
              <div class="font-bold text-slate-900 text-sm">{{ $order->customer_name }}</div>
              <div>{{ $order->customer_phone }}</div>
              <div class="text-slate-500">{{ $order->customer_email }}</div>
              <div class="pt-2 text-slate-700 font-medium">{{ $fullAddress }}</div>
            </div>
          </div>

          <!-- Total Summary Card -->
          <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
            <h3
              class="text-xs font-bold text-slate-900 uppercase tracking-wider font-heading pb-2 border-b border-slate-100">
              Payment Breakdown
            </h3>
            <div class="space-y-2 text-slate-600">
              <div class="flex items-center justify-between">
                <span>Subtotal</span>
                <span class="font-semibold text-slate-800">{{ $money($order->subtotal) }}</span>
              </div>
              @if($order->discount > 0)
              <div class="flex items-center justify-between text-emerald-600 font-semibold">
                  <span>Discount{{ $order->coupon_code ? ' (' . $order->coupon_code . ')' : '' }}</span>
                  <span>- {{ $money($order->discount) }}</span>
                </div>
              @endif

              @if($order->tax_amount > 0)
              @if($order->gst_type === 'igst' && $order->igst_amount > 0)
              <div class="flex items-center justify-between">
                <span>IGST ({{ rtrim(rtrim(number_format($order->igst_rate, 2), '0'), '.') }}%)</span>
                <span class="font-semibold text-slate-800">{{ $money($order->igst_amount) }}</span>
              </div>
              @else
              @if($order->cgst_amount > 0)
              <div class="flex items-center justify-between">
                      <span>CGST ({{ rtrim(rtrim(number_format($order->cgst_rate, 2), '0'), '.') }}%)</span>
                      <span class="font-semibold text-slate-800">{{ $money($order->cgst_amount) }}</span>
                    </div>
                    @endif
                  @if($order->sgst_amount > 0)
                  <div class="flex items-center justify-between">
                    <span>SGST ({{ rtrim(rtrim(number_format($order->sgst_rate, 2), '0'), '.') }}%)</span>
                      <span class="font-semibold text-slate-800">{{ $money($order->sgst_amount) }}</span>
                    </div>
                  @endif
                @endif
              @endif
              
              @if($order->shipping_charge > 0)
                <div class="flex items-center justify-between">
                  <span>Shipping</span>
                  <span class="font-semibold text-slate-800">{{ $money($order->shipping_charge) }}</span>
                </div>
              @endif
              
              <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                <span class="font-bold text-slate-900">{{ $isPaid ? 'Total Amount Paid' : 'Total Amount' }}</span>
                <strong class="text-base font-extrabold text-slate-900">{{ $money($order->grand_total) }}</strong>
              </div>

              @if($isCod && !$isPaid)
                <p class="text-[11px] text-amber-600 font-semibold">
                  Please keep {{ $money($order->grand_total) }} ready to pay at the time of delivery.
                </p>
              @endif

              @if($order->invoice)
                <p class="text-[11px] text-slate-400">Invoice No: {{ $order->invoice->invoice_number }}</p>
              @endif
            </div>

            <!-- Action Buttons -->
            <div class="space-y-2 pt-3 border-t border-slate-100">
              <a href="{{ route('user.track-order') }}?orderId={{ urlencode($order->order_number) }}"
                class="btn-base btn-primary w-full py-3 text-xs font-semibold justify-center shadow-md">
                <i class="fa-solid fa-location-crosshairs mr-1.5"></i> Track Package Live
              </a>

              {{-- Shown only once an invoice download route exists (e.g. route name: order.invoice) --}}
              @if($order->invoice && \Illuminate\Support\Facades\Route::has('order.invoice'))
                <a href="{{ route('order.invoice', $order->id) }}"
                  class="btn-base btn-secondary w-full py-2.5 text-xs font-semibold justify-center">
                  <i class="fa-solid fa-file-invoice mr-1.5"></i> Download GST Tax Invoice
                </a>
              @endif

              <a href="{{ route('shop') }}"
                class="btn-base btn-secondary w-full py-2.5 text-xs font-semibold justify-center bg-slate-50">
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
  @if(!empty($purchaseScript))
    <script>
      {!! $purchaseScript !!}
    </script>
  @endif
@endpush