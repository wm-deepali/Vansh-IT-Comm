@extends('layouts.app')

@section('active_page', 'account')

@section('content')

  @php
    $currency = config('shop.currency', '₹');

    $statusClass = function ($status) {
      $s = strtolower((string) $status);
      return match (true) {
        in_array($s, ['delivered', 'completed']) => 'bg-emerald-100 text-emerald-800',
        in_array($s, ['cancelled', 'canceled', 'failed', 'rejected', 'rto']) => 'bg-red-100 text-red-700',
        in_array($s, ['shipped', 'out_for_delivery', 'dispatched']) => 'bg-blue-100 text-blue-800',
        default => 'bg-amber-100 text-amber-800',
      };
    };
    $label = fn ($v) => ucwords(str_replace('_', ' ', (string) $v));
  @endphp

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">My Account</span>
      </nav>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start mb-16">

        <!-- Sidebar -->
        <aside class="lg:col-span-4 bg-white p-6 rounded-3xl border border-slate-200 shadow-sm space-y-6">
          <div class="flex items-center gap-4 pb-6 border-b border-slate-100">
            <div class="w-14 h-14 rounded-2xl bg-blue-600 text-white font-extrabold text-xl flex items-center justify-center shadow-md flex-shrink-0">
              @if(filled($customer->name))
                {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($customer->name, 0, 1)) }}
              @else
                <i class="fa-solid fa-user"></i>
              @endif
            </div>
            <div class="min-w-0">
              @if(filled($customer->name))
                <h2 class="text-base font-bold text-slate-900 font-heading truncate">{{ $customer->name }}</h2>
              @endif
              @if(filled($customer->email))
                <p class="text-xs text-slate-500 truncate">{{ $customer->email }}</p>
              @endif
              @if(filled($customer->phone ?? null))
                <p class="text-xs text-slate-500">{{ $customer->phone }}</p>
              @endif
            </div>
          </div>

          <nav class="space-y-1.5 text-xs font-semibold" aria-label="Account Navigation">
            <button type="button" onclick="switchAccountTab('orders')" id="acc-tab-orders"
              class="w-full flex items-center justify-between p-3 rounded-xl bg-blue-50 text-blue-600 font-bold transition-colors">
              <span class="flex items-center gap-2.5"><i class="fa-solid fa-box-archive"></i> My Orders
                @if($orders->total())<span class="text-[10px] bg-blue-600 text-white rounded-full px-1.5 py-0.5">{{ $orders->total() }}</span>@endif
              </span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
            <button type="button" onclick="switchAccountTab('repairs')" id="acc-tab-repairs"
              class="w-full flex items-center justify-between p-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors">
              <span class="flex items-center gap-2.5"><i class="fa-solid fa-screwdriver-wrench"></i> Repair Tickets</span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
            <button type="button" onclick="switchAccountTab('addresses')" id="acc-tab-addresses"
              class="w-full flex items-center justify-between p-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors">
              <span class="flex items-center gap-2.5"><i class="fa-solid fa-location-dot"></i> Saved Addresses
                @if($addresses->count())<span class="text-[10px] bg-slate-200 text-slate-700 rounded-full px-1.5 py-0.5">{{ $addresses->count() }}</span>@endif
              </span>
              <i class="fa-solid fa-chevron-right text-[10px]"></i>
            </button>
            <a href="{{ route('wishlist') }}"
              class="w-full flex items-center justify-between p-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors">
              <span class="flex items-center gap-2.5"><i class="fa-regular fa-heart"></i> Saved Wishlist
                @if($wishlistCount)<span class="text-[10px] bg-red-500 text-white rounded-full px-1.5 py-0.5">{{ $wishlistCount }}</span>@endif
              </span>
              <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
            </a>
          </nav>

          <form method="POST" action="{{ route('user.logout') }}" class="pt-4 border-t border-slate-100">
            @csrf
            <button type="submit"
              class="w-full flex items-center gap-2.5 p-3 rounded-xl text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors">
              <i class="fa-solid fa-right-from-bracket"></i> Logout
            </button>
          </form>
        </aside>

        <!-- Content -->
        <section class="lg:col-span-8 bg-white p-6 sm:p-8 rounded-3xl border border-slate-200 shadow-sm min-h-[400px]">

          <!-- Orders -->
          <div id="acc-content-orders" class="space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
              <h3 class="text-base font-bold text-slate-900 font-heading">Order History</h3>
              <a href="{{ route('user.track-order') }}" class="text-xs font-bold text-blue-600 hover:underline">Track Any Order →</a>
            </div>

            @forelse($orders as $order)
              <div class="p-4 bg-slate-50 border border-slate-200 rounded-2xl text-xs space-y-3">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 pb-2 border-b border-slate-200">
                  <div>
                    <span class="text-slate-400">Order ID:</span>
                    <strong class="text-blue-600 font-bold ml-1">{{ $order->order_number }}</strong>
                    <span class="text-slate-400 ml-2">({{ $order->created_at->format('d M Y') }})</span>
                  </div>
                  <div class="flex items-center gap-2">
                    @if(filled($order->status))
                      <span class="badge {{ $statusClass($order->status) }} text-[10px] font-bold">{{ $label($order->status) }}</span>
                    @endif
                    <a href="{{ route('user.track-order') }}?orderId={{ urlencode($order->order_number) }}"
                      class="btn-base btn-secondary btn-sm text-[11px] py-1 px-2.5">
                      <i class="fa-solid fa-location-crosshairs mr-1"></i> Track
                    </a>
                  </div>
                </div>

                <div class="space-y-1.5">
                  @foreach($order->items as $item)
                    <div class="flex items-center justify-between gap-3">
                      <span class="truncate font-medium text-slate-800">
                        @if($item->product?->slug)
                          <a href="{{ route('product.show', $item->product->slug) }}" class="hover:text-blue-600">{{ $item->product_name }}</a>
                        @else
                          {{ $item->product_name }}
                        @endif
                        <span class="text-slate-400">×{{ $item->quantity }}</span>
                      </span>
                      <span class="font-bold text-slate-900 flex-shrink-0">{{ $currency }}{{ number_format($item->total ?? ($item->price * $item->quantity)) }}</span>
                    </div>
                  @endforeach
                </div>

                <div class="pt-2 border-t border-slate-200 flex items-center justify-between text-xs gap-2 flex-wrap">
                  <span class="text-slate-500">
                    @if(filled($order->payment_method))
                      {{ $order->payment_status === 'paid' ? 'Paid' : 'Total' }} via {{ $label($order->payment_method) }}
                      @if(filled($order->payment_status) && $order->payment_status !== 'paid')
                        <span class="text-slate-400">({{ $label($order->payment_status) }})</span>
                      @endif
                    @else
                      Order Total
                    @endif
                  </span>
                  <strong class="text-sm text-slate-900">{{ $currency }}{{ number_format($order->grand_total) }}</strong>
                </div>

                <div class="pt-2 border-t border-slate-200 flex items-center gap-2 flex-wrap">
                  <a href="{{ route('user.account.orders.show', $order->id) }}"
                    class="btn-base btn-primary btn-sm text-[11px] py-1.5 px-3">
                    <i class="fa-solid fa-receipt mr-1"></i> View Details
                  </a>
                  @if($order->invoice)
                    <a href="{{ route('user.account.orders.invoice', $order->id) }}" target="_blank"
                      class="btn-base btn-secondary btn-sm text-[11px] py-1.5 px-3">
                      <i class="fa-solid fa-file-invoice mr-1"></i> Invoice
                    </a>
                  @endif
                </div>
              </div>
            @empty
              <div class="text-center py-12 px-4">
                <i class="fa-solid fa-box-open text-slate-300 text-4xl mb-3"></i>
                <h4 class="text-sm font-bold text-slate-800 mb-1">No Orders Placed Yet</h4>
                <p class="text-xs text-slate-500 mb-4">When you place orders, they will be archived here for live tracking and warranty claims.</p>
                <a href="{{ route('shop') }}" class="btn-base btn-primary btn-sm text-xs">Start Shopping</a>
              </div>
            @endforelse

            @if($orders->hasPages())
              <div class="pt-2">{{ $orders->links() }}</div>
            @endif
          </div>

          <!-- Repair tickets (no repair module yet) -->
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

          <!-- Addresses -->
          <div id="acc-content-addresses" class="hidden space-y-4">
            <div class="flex items-center justify-between pb-4 border-b border-slate-100">
              <h3 class="text-base font-bold text-slate-900 font-heading">Saved Addresses</h3>
              <button type="button" onclick="openAddressModal()" class="text-xs font-bold text-blue-600 hover:underline">+ Add New</button>
            </div>

            @forelse($addresses as $address)
              <div class="p-4 bg-slate-50 rounded-2xl border border-slate-200 text-xs text-slate-700 space-y-1">
                <div class="font-bold text-slate-900 flex items-center justify-between">
                  <span>{{ filled($address->address_type) ? $label($address->address_type) . ' Address' : 'Address' }}</span>
                  @if($address->is_default)
                    <span class="badge bg-blue-100 text-blue-800 text-[10px]">Default</span>
                  @endif
                </div>
                @if(filled($address->name) || filled($address->phone))
                  <p>{{ collect([$address->name, $address->phone])->filter()->implode(' • ') }}</p>
                @endif
                <p class="text-slate-500">{{ $address->fullAddress() }}</p>

                <div class="flex items-center gap-3 pt-2 text-[11px] font-semibold">
                  <button type="button" class="text-blue-600 hover:underline"
                    data-address="{{ json_encode([
                      'id' => $address->id, 'name' => $address->name, 'email' => $address->email,
                      'phone' => $address->phone, 'address_line_1' => $address->address_line_1,
                      'address_line_2' => $address->address_line_2, 'state_id' => $address->state_id,
                      'city_id' => $address->city_id, 'pincode' => $address->pincode,
                      'address_type' => $address->address_type, 'is_default' => (bool) $address->is_default,
                    ]) }}"
                    onclick="openAddressModal(JSON.parse(this.dataset.address))">Edit</button>
                  @unless($address->is_default)
                    <button type="button" class="text-slate-600 hover:underline" onclick="setDefaultAddress({{ $address->id }})">Set as default</button>
                  @endunless
                  <button type="button" class="text-red-600 hover:underline" onclick="deleteAddress({{ $address->id }})">Delete</button>
                </div>
              </div>
            @empty
              <div class="p-6 text-center border border-dashed border-slate-200 rounded-2xl">
                <i class="fa-solid fa-location-dot text-slate-300 text-3xl mb-2"></i>
                <p class="text-xs text-slate-500 mb-3">No saved addresses yet.</p>
                <button type="button" onclick="openAddressModal()" class="btn-base btn-secondary btn-sm text-xs">Add Address</button>
              </div>
            @endforelse
          </div>

        </section>
      </div>
    </div>
  </main>

  <!-- Address Modal -->
  <div id="address-modal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="closeAddressModal()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto p-6">
      <div class="flex items-center justify-between mb-4">
        <h3 id="address-modal-title" class="text-base font-bold text-slate-900 font-heading">Add Address</h3>
        <button type="button" onclick="closeAddressModal()" class="text-slate-400 hover:text-slate-700">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </div>

      <form id="address-form" onsubmit="saveAddress(event)" class="space-y-3 text-xs">
        <input type="hidden" id="addr-id">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block font-bold text-slate-800 mb-1">Full Name *</label>
            <input id="addr-name" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
          </div>
          <div>
            <label class="block font-bold text-slate-800 mb-1">Mobile *</label>
            <input id="addr-phone" required maxlength="10" inputmode="numeric" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
          </div>
        </div>

        <div>
          <label class="block font-bold text-slate-800 mb-1">Email *</label>
          <input id="addr-email" type="email" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
        </div>

        <div>
          <label class="block font-bold text-slate-800 mb-1">Address Line 1 *</label>
          <input id="addr-line1" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
        </div>

        <div>
          <label class="block font-bold text-slate-800 mb-1">Address Line 2</label>
          <input id="addr-line2" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block font-bold text-slate-800 mb-1">State *</label>
            <select id="addr-state" required onchange="loadCities(this.value)" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
              <option value="">Select state</option>
              @foreach($states as $st)
                <option value="{{ $st->id }}">{{ $st->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block font-bold text-slate-800 mb-1">City *</label>
            <select id="addr-city" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
              <option value="">Select city</option>
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
          <div>
            <label class="block font-bold text-slate-800 mb-1">PIN Code *</label>
            <input id="addr-pincode" required maxlength="6" inputmode="numeric" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
          </div>
          <div>
            <label class="block font-bold text-slate-800 mb-1">Address Type *</label>
            <select id="addr-type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 focus:outline-none focus:border-blue-600">
              <option value="home">Home</option>
              <option value="work">Work</option>
              <option value="other">Other</option>
            </select>
          </div>
        </div>

        <label class="flex items-center gap-2 cursor-pointer text-slate-700">
          <input type="checkbox" id="addr-default" class="rounded text-blue-600"> Make this my default address
        </label>

        <button type="submit" id="addr-submit" class="btn-base btn-primary w-full py-3 text-xs font-bold justify-center">
          Save Address
        </button>
      </form>
    </div>
  </div>

@endsection

@push('scripts')
  @include('partials.cart-helpers')
  <script>
    const ACC = {
      csrf: @json(csrf_token()),
      storeUrl: @json(route('user.account.addresses.store')),
      baseUrl: @json(url('user/account/addresses')),
      citiesUrl: @json(url('user/account/cities')),
    };

    function switchAccountTab(tabId) {
      const on = 'w-full flex items-center justify-between p-3 rounded-xl bg-blue-50 text-blue-600 font-bold transition-colors';
      const off = 'w-full flex items-center justify-between p-3 rounded-xl text-slate-600 hover:bg-slate-50 transition-colors';

      ['orders', 'repairs', 'addresses'].forEach(t => {
        document.getElementById('acc-content-' + t).classList.toggle('hidden', t !== tabId);
        document.getElementById('acc-tab-' + t).className = t === tabId ? on : off;
      });
    }

    // stay on the addresses tab after a reload
    document.addEventListener('DOMContentLoaded', () => {
      if (location.hash === '#addresses') switchAccountTab('addresses');
    });

    async function api(url, method, body) {
      const res = await fetch(url, {
        method,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': ACC.csrf,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: body ? JSON.stringify(body) : undefined,
      });
      const data = await res.json().catch(() => ({}));
      if (!res.ok || data.status === false) {
        const firstError = data.errors ? Object.values(data.errors)[0][0] : null;
        throw new Error(firstError || data.message || 'Something went wrong.');
      }
      return data;
    }

    function reloadOnAddresses() {
      location.hash = 'addresses';
      location.reload();
    }

    async function loadCities(stateId, selectedCityId = null) {
      const sel = document.getElementById('addr-city');
      sel.innerHTML = '<option value="">Select city</option>';
      if (!stateId) return;

      try {
        const res = await fetch(ACC.citiesUrl + '/' + stateId, { headers: { 'Accept': 'application/json' } });
        const cities = await res.json();
        sel.innerHTML = '<option value="">Select city</option>' +
          cities.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
        if (selectedCityId) sel.value = selectedCityId;
      } catch (e) {
        toast('Could not load cities.', 'error');
      }
    }

    function openAddressModal(addr = null) {
      document.getElementById('address-form').reset();
      document.getElementById('addr-city').innerHTML = '<option value="">Select city</option>';
      document.getElementById('addr-id').value = addr ? addr.id : '';
      document.getElementById('address-modal-title').textContent = addr ? 'Edit Address' : 'Add Address';

      if (addr) {
        document.getElementById('addr-name').value = addr.name || '';
        document.getElementById('addr-phone').value = addr.phone || '';
        document.getElementById('addr-email').value = addr.email || '';
        document.getElementById('addr-line1').value = addr.address_line_1 || '';
        document.getElementById('addr-line2').value = addr.address_line_2 || '';
        document.getElementById('addr-state').value = addr.state_id || '';
        document.getElementById('addr-pincode').value = addr.pincode || '';
        document.getElementById('addr-type').value = addr.address_type || 'home';
        document.getElementById('addr-default').checked = !!addr.is_default;
        loadCities(addr.state_id, addr.city_id);
      }

      const modal = document.getElementById('address-modal');
      modal.classList.remove('hidden');
      modal.classList.add('flex');
      document.body.style.overflow = 'hidden';
    }

    function closeAddressModal() {
      const modal = document.getElementById('address-modal');
      modal.classList.add('hidden');
      modal.classList.remove('flex');
      document.body.style.overflow = '';
    }

    async function saveAddress(e) {
      e.preventDefault();
      const id = document.getElementById('addr-id').value;
      const btn = document.getElementById('addr-submit');

      const payload = {
        name: document.getElementById('addr-name').value.trim(),
        phone: document.getElementById('addr-phone').value.trim(),
        email: document.getElementById('addr-email').value.trim(),
        address_line_1: document.getElementById('addr-line1').value.trim(),
        address_line_2: document.getElementById('addr-line2').value.trim() || null,
        state_id: document.getElementById('addr-state').value,
        city_id: document.getElementById('addr-city').value,
        pincode: document.getElementById('addr-pincode').value.trim(),
        address_type: document.getElementById('addr-type').value,
        is_default: document.getElementById('addr-default').checked,
      };

      setBtnLoading(btn, true, 'Saving...');
      try {
        await api(id ? ACC.baseUrl + '/' + id : ACC.storeUrl, id ? 'PUT' : 'POST', payload);
        reloadOnAddresses();
      } catch (err) {
        toast(err.message, 'error');
        setBtnLoading(btn, false);
      }
    }

    async function setDefaultAddress(id) {
      try {
        await api(ACC.baseUrl + '/' + id + '/default', 'POST');
        reloadOnAddresses();
      } catch (err) {
        toast(err.message, 'error');
      }
    }

    async function deleteAddress(id) {
      if (!confirm('Delete this address?')) return;
      try {
        await api(ACC.baseUrl + '/' + id, 'DELETE');
        reloadOnAddresses();
      } catch (err) {
        toast(err.message, 'error');
      }
    }
  </script>
@endpush