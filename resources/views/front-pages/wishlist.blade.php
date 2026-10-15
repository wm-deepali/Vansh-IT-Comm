@extends('layouts.app')

@section('active_page', 'wishlist')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">My Wishlist</span>
      </nav>

      <div class="flex items-center justify-between mb-8 pb-4 border-b border-slate-200">
        <div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">My Wishlist</h1>
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5" id="wishlist-summary-text">
            @if($products->count())
              You have {{ $products->count() }} {{ \Illuminate\Support\Str::plural('item', $products->count()) }} saved in your wishlist.
            @else
              You have no saved items.
            @endif
          </p>
        </div>

        <button type="button" id="clear-wishlist-btn" onclick="clearWishlist()"
          class="btn-base btn-secondary btn-sm text-xs font-semibold {{ $products->isEmpty() ? 'hidden' : '' }}">
          <i class="fa-regular fa-trash-can mr-1"></i> Clear Wishlist
        </button>
      </div>

      <!-- Product grid -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6" id="wishlist-grid-container">
        @foreach($products as $p)
          @php
            $cardAttrs = collect($listingByCategory->get($p->subcategory_id, []))
              ->merge($listingByCategory->get($p->category_id, []))
              ->unique('attribute_id')->values();
          @endphp
          @include('partials.product-card', ['product' => $p, 'listingAttributes' => $cardAttrs])
        @endforeach
      </div>

      <!-- Empty state (server-rendered when empty, shown by JS when last item is removed) -->
      <div id="wishlist-empty"
        class="{{ $products->isEmpty() ? '' : 'hidden' }} text-center py-16 px-4 bg-white rounded-3xl border border-slate-200 shadow-sm max-w-lg mx-auto my-8">
        <div class="w-16 h-16 rounded-full bg-red-50 text-red-400 flex items-center justify-center mx-auto mb-4 text-2xl">
          <i class="fa-regular fa-heart"></i>
        </div>
        <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Your wishlist is waiting</h3>
        <p class="text-xs text-slate-500 mb-6 max-w-sm mx-auto">Click the heart icon on any product to save it here.</p>
        <a href="{{ route('shop') }}" class="btn-base btn-primary px-6 py-2.5 text-xs font-semibold">Explore Products</a>
      </div>

    </div>
  </main>

  @include('partials.quick-view')

@endsection

@push('scripts')
  @include('partials.cart-helpers')
  @include('partials.cart-js')
  @include('partials.wishlist-js')
  <script>
    const PAGE = {
      csrf: @json(csrf_token()),
      wishlistClearUrl: @json(route('wishlist.clear')),
    };

    function refreshWishlistUI() {
      const grid = document.getElementById('wishlist-grid-container');
      const count = grid.querySelectorAll('.product-card').length;
      const summary = document.getElementById('wishlist-summary-text');
      const clearBtn = document.getElementById('clear-wishlist-btn');
      const empty = document.getElementById('wishlist-empty');

      summary.textContent = count
        ? `You have ${count} item${count > 1 ? 's' : ''} saved in your wishlist.`
        : 'You have no saved items.';
      clearBtn.classList.toggle('hidden', count === 0);
      empty.classList.toggle('hidden', count !== 0);
    }

    // When a heart is un-toggled on this page, remove the card
    document.addEventListener('wishlist:changed', (e) => {
      if (e.detail.wishlisted) return;
      document.querySelectorAll('#wishlist-grid-container .product-card[data-product-id="' + e.detail.productId + '"]')
        .forEach(card => card.remove());
      refreshWishlistUI();
    });

    async function clearWishlist() {
      if (!confirm('Are you sure you want to clear your wishlist?')) return;

      try {
        const res = await fetch(PAGE.wishlistClearUrl, {
          method: 'DELETE',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': PAGE.csrf,
            'X-Requested-With': 'XMLHttpRequest',
          },
        });
        const data = await res.json().catch(() => ({}));
        if (!res.ok || data.status === false) throw new Error(data.message || 'Could not clear wishlist.');

        document.getElementById('wishlist-grid-container').innerHTML = '';
        document.querySelectorAll('[data-wishlist-count]').forEach(el => {
          el.textContent = 0;
          el.classList.add('hidden');
        });
        refreshWishlistUI();
        toast(data.message, 'info');
      } catch (err) {
        toast(err.message, 'error');
      }
    }
  </script>
@endpush