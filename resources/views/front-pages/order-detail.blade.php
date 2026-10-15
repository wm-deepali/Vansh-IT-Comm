@extends('layouts.app')

@section('active_page', 'account')

@section('content')

  @php
    $currency = config('shop.currency', '₹');
    $money = fn($v) => $currency . number_format((float) $v, 2);
    $label = fn($v) => ucwords(str_replace('_', ' ', (string) $v));

    $statusClass = function ($status) {
      $s = strtolower((string) $status);
      return match (true) {
        in_array($s, ['delivered', 'completed']) => 'bg-emerald-100 text-emerald-800',
        in_array($s, ['cancelled', 'canceled', 'failed', 'rejected']) => 'bg-red-100 text-red-700',
        in_array($s, ['shipped', 'out_for_delivery', 'dispatched']) => 'bg-blue-100 text-blue-800',
        default => 'bg-amber-100 text-amber-800',
      };
    };

    $payClass = match (strtolower((string) $order->payment_status)) {
      'paid' => 'bg-emerald-100 text-emerald-800',
      'failed' => 'bg-red-100 text-red-700',
      'refunded' => 'bg-purple-100 text-purple-800',
      default => 'bg-amber-100 text-amber-800',
    };
  @endphp

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('user.account') }}" class="hover:text-blue-600">My Account</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Order {{ $order->order_number }}</span>
      </nav>

      {{-- Flash messages --}}
      @if(session('success'))
        <div
          class="mb-4 p-3 rounded-xl bg-emerald-50 border border-emerald-100 text-xs text-emerald-700 flex items-center gap-2">
          <i class="fa-solid fa-circle-check"></i> {{ session('success') }}
        </div>
      @endif
      @if(session('error'))
        <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-100 text-xs text-red-700 flex items-center gap-2">
          <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
      @endif

      <!-- Header card -->
      <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm mb-8">
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-5">
          <div class="space-y-1.5">
            <span class="text-xs text-slate-400">Order ID</span>
            <h1 class="text-2xl font-extrabold text-blue-600 font-heading">{{ $order->order_number }}</h1>
            <p class="text-[11px] text-slate-400">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
            <div class="flex items-center gap-2 pt-1">
              @if(filled($order->status))
                <span
                  class="badge {{ $statusClass($order->status) }} text-[10px] font-bold">{{ $label($order->status) }}</span>
              @endif
              @if(filled($order->payment_status))
                <span class="badge {{ $payClass }} text-[10px] font-bold">Payment:
                  {{ $label($order->payment_status) }}</span>
              @endif
            </div>
          </div>

          <div class="flex items-center gap-2 flex-wrap">
            <a href="{{ route('user.account') }}" class="btn-base btn-secondary btn-sm text-xs py-2 px-3">
              <i class="fa-solid fa-arrow-left mr-1.5"></i> My Orders
            </a>
            <a href="{{ route('user.track-order') }}?orderId={{ urlencode($order->order_number) }}"
              class="btn-base btn-secondary btn-sm text-xs py-2 px-3">
              <i class="fa-solid fa-location-crosshairs mr-1.5"></i> Track
            </a>
            @if($order->invoice)
              <a href="{{ route('user.account.orders.invoice', $order->id) }}" target="_blank"
                class="btn-base btn-secondary btn-sm text-xs py-2 px-3">
                <i class="fa-solid fa-file-invoice mr-1.5"></i> Invoice
              </a>
              <a href="{{ route('user.account.orders.invoice.download', $order->id) }}"
                class="btn-base btn-primary btn-sm text-xs py-2 px-3">
                <i class="fa-solid fa-download mr-1.5"></i> Download PDF
              </a>
            @endif
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">

        <!-- ═════════ LEFT ═════════ -->
        <div class="lg:col-span-8 space-y-8">

          {{-- Tracker / cancelled notice --}}
          @if($isCancelled)
            <div class="p-4 rounded-2xl bg-red-50 border border-red-100 text-xs text-red-700 flex items-center gap-2">
              <i class="fa-solid fa-circle-exclamation"></i>
              This order was cancelled. Contact our helpdesk if you need help.
            </div>
          @elseif(count($stages))
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm">
              <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                @foreach($stages as $stage)
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
            </div>
          @endif

          {{-- Items --}}
          <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
              <h3 class="text-base font-bold text-slate-900 font-heading">Items in this order</h3>
              <span class="text-xs text-slate-400">
                {{ $order->items->count() }} {{ \Illuminate\Support\Str::plural('item', $order->items->count()) }}
              </span>
            </div>

            <div class="divide-y divide-slate-100">
              @foreach($order->items as $item)
                @php
                  // Thumbnail: image variant > product default image > null
                  $thumb = null;
                  if ($item->imageVariant && $item->imageVariant->image) {
                    $thumb = asset('storage/' . $item->imageVariant->image);
                  } elseif ($item->product) {
                    $thumb = $item->product->display_image;
                  }

                  // Variant label from the selected_attributes snapshot
                  $variantLabel = null;
                  if (!empty($item->selected_attributes)) {
                    $variantLabel = collect($item->selected_attributes)
                      ->map(function ($value, $key) {
                        if (is_array($value)) {
                          $attrName = $value['attribute'] ?? $value['name'] ?? $key;
                          $attrVal = $value['value'] ?? $value['label'] ?? reset($value);
                          return $attrName . ': ' . $attrVal;
                        }
                        return $key . ': ' . $value;
                      })
                      ->join(' · ');
                  }

                  // SKU: sku variant > snapshot sku > product sku
                  $sku = optional($item->skuVariant)->sku ?? ($item->sku ?? optional($item->product)->sku);

                  $addonsTotal = $item->addons->sum('price');
                  $lineTotal = ($item->price * $item->quantity) + $addonsTotal;
                  $itemName = $item->product_name ?? ($item->product->name ?? 'Product');
                @endphp

                <div class="p-5 sm:px-6 flex items-start gap-4 text-xs">
                  @if($thumb)
                    <img src="{{ $thumb }}" alt="{{ $itemName }}"
                      class="w-16 h-16 rounded-xl object-cover border border-slate-200 flex-shrink-0">
                  @else
                    <div
                      class="w-16 h-16 rounded-xl bg-slate-50 border border-slate-200 text-slate-300 flex items-center justify-center text-xl flex-shrink-0">
                      <i class="fa-regular fa-image"></i>
                    </div>
                  @endif

                  <div class="min-w-0 flex-1 space-y-0.5">
                    <div class="font-bold text-slate-900 text-sm">
                      @if($item->product?->slug)
                        <a href="{{ route('product.show', $item->product->slug) }}"
                          class="hover:text-blue-600">{{ $itemName }}</a>
                      @else
                        {{ $itemName }}
                      @endif
                    </div>
                    @if($variantLabel)
                      <div class="text-slate-500">{{ $variantLabel }}</div>
                    @endif
                    @if($sku)
                      <div class="text-slate-400">SKU: {{ $sku }}</div>
                    @endif
                    @foreach($item->addons as $addon)
                      <div class="text-slate-500">+ {{ $addon->detail }} ({{ $money($addon->price) }})</div>
                    @endforeach
                    <div class="text-slate-500 pt-1">
                      Qty: <span class="font-semibold text-slate-700">{{ $item->quantity }}</span>
                      <span class="text-slate-300 mx-1">×</span>
                      {{ $money($item->price) }}
                    </div>
                  </div>

                  <div class="font-bold text-slate-900 text-sm flex-shrink-0">{{ $money($lineTotal) }}</div>
                </div>
              @endforeach
            </div>

            {{-- Price breakdown --}}
            <div class="px-6 py-5 bg-slate-50 border-t border-slate-100 text-xs space-y-2">
              <div class="flex items-center justify-between">
                <span class="text-slate-500">Subtotal</span>
                <span class="font-semibold text-slate-800">{{ $money($order->subtotal) }}</span>
              </div>

              @if($order->discount > 0)
                <div class="flex items-center justify-between">
                  <span class="text-slate-500">
                    Discount
                    @if($order->coupon_code)
                      <span
                        class="ml-1 px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800 font-bold text-[10px]">{{ $order->coupon_code }}</span>
                    @endif
                  </span>
                  <span class="font-semibold text-emerald-700">− {{ $money($order->discount) }}</span>
                </div>
              @endif

              {{-- GST breakdown --}}
              @if($order->tax_amount > 0)
                @if($order->gst_type === 'igst' && $order->igst_amount > 0)
                  <div class="flex items-center justify-between">
                    <span class="text-slate-500">IGST ({{ $order->igst_rate }}%)</span>
                    <span class="font-semibold text-slate-800">{{ $money($order->igst_amount) }}</span>
                  </div>
                @else
                  @if($order->cgst_amount > 0)
                    <div class="flex items-center justify-between">
                      <span class="text-slate-500">CGST ({{ $order->cgst_rate }}%)</span>
                      <span class="font-semibold text-slate-800">{{ $money($order->cgst_amount) }}</span>
                    </div>
                  @endif
                  @if($order->sgst_amount > 0)
                    <div class="flex items-center justify-between">
                      <span class="text-slate-500">SGST ({{ $order->sgst_rate }}%)</span>
                      <span class="font-semibold text-slate-800">{{ $money($order->sgst_amount) }}</span>
                    </div>
                  @endif
                @endif
              @endif

              @if($order->shipping_charge > 0)
                <div class="flex items-center justify-between">
                  <span class="text-slate-500">Shipping</span>
                  <span class="font-semibold text-slate-800">{{ $money($order->shipping_charge) }}</span>
                </div>
              @endif

              <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                <span class="text-sm font-bold text-slate-900">Total</span>
                <span class="text-lg font-extrabold text-slate-900">{{ $money($order->grand_total) }}</span>
              </div>
            </div>
          </div>

          {{-- Order updates --}}
          @if($order->statusHistory->isNotEmpty())
            <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm space-y-3">
              <h4 class="text-base font-bold text-slate-900 font-heading">Order Updates</h4>
              @foreach($order->statusHistory->sortByDesc('created_at') as $h)
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

        </div>

        <!-- ═════════ RIGHT ═════════ -->
        <aside class="lg:col-span-4 space-y-6">

          {{-- Payment --}}
          <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
            <h4 class="text-sm font-bold text-slate-900 font-heading">Payment</h4>
            <div class="flex items-center justify-between gap-3">
              <span class="text-slate-400">Method</span>
              <span class="font-semibold text-slate-800">{{ $label($order->payment_method ?: '—') }}</span>
            </div>
            <div class="flex items-center justify-between gap-3">
              <span class="text-slate-400">Status</span>
              <span class="badge {{ $payClass }} text-[10px] font-bold">{{ $label($order->payment_status) }}</span>
            </div>
            @if(filled($order->transaction_id))
              <div class="flex items-center justify-between gap-3">
                <span class="text-slate-400">Transaction ID</span>
                <span class="font-semibold text-slate-800 break-all text-right">{{ $order->transaction_id }}</span>
              </div>
            @endif
            @if($order->invoice)
              <div class="flex items-center justify-between gap-3">
                <span class="text-slate-400">Invoice #</span>
                <span class="font-semibold text-slate-800">{{ $order->invoice->invoice_number }}</span>
              </div>
            @endif
          </div>

          {{-- Shipping address --}}
          <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-2 text-xs">
            <h4 class="text-sm font-bold text-slate-900 font-heading">Shipping Address</h4>
            <div class="text-slate-600 leading-relaxed">
              <strong class="block text-slate-900">{{ $order->customer_name }}</strong>
              @if($order->address_line_1) {{ $order->address_line_1 }}<br> @endif
              @if($order->address_line_2) {{ $order->address_line_2 }}<br> @endif
              @if($order->city) {{ $order->city->name }}, @endif
              @if($order->state) {{ $order->state->name }}<br> @endif
              @if($order->pincode) {{ $order->pincode }}<br> @endif
              India
              @if($order->customer_phone)
                <br><span class="text-slate-400"><i
                    class="fa-solid fa-phone text-[10px] mr-1"></i>{{ $order->customer_phone }}</span>
              @endif
            </div>
          </div>

          {{-- Courier / tracking --}}
          @if($order->courier || filled($order->tracking_number))
            <div class="bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-3 text-xs">
              <h4 class="text-sm font-bold text-slate-900 font-heading">Delivery</h4>
              @if($order->courier?->name)
                <div class="flex items-center justify-between gap-3">
                  <span class="text-slate-400">Courier</span>
                  <span class="font-semibold text-slate-800">{{ $order->courier->name }}</span>
                </div>
              @endif
              @if(filled($order->tracking_number))
                <div class="flex items-center justify-between gap-3">
                  <span class="text-slate-400">Tracking No.</span>
                  <span class="font-semibold text-slate-800 break-all text-right">{{ $order->tracking_number }}</span>
                </div>
              @endif
              @if($order->courier?->website_url)
                <a href="{{ $order->courier->website_url }}" target="_blank" rel="noopener"
                  class="block text-blue-600 font-semibold hover:underline">Open courier tracking site →</a>
              @endif
            </div>
          @endif

          <div class="text-[11px] text-slate-500 px-1">
            Need help with this order?
            <a href="{{ route('contact') }}" class="text-blue-600 font-semibold hover:underline">Contact our helpdesk</a>
          </div>

        </aside>
      </div>
    </div>
  </main>

@endsection