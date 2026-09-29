@extends('layouts.app')

@section('title', 'My Wishlist | VANSH IT & COMM')
@section('meta_description', 'View and manage your saved refurbished laptops, smartphones, and accessories.')

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
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5" id="wishlist-summary-text">Items saved to your personal device.</p>
        </div>
        <button
          type="button"
          onclick="clearWishlist()"
          id="clear-wishlist-btn"
          class="btn-base btn-secondary btn-sm text-xs font-semibold"
        >
          <i class="fa-regular fa-trash-can mr-1"></i> Clear Wishlist
        </button>
      </div>

      <!-- Wishlist Product Grid (4 cols on desktop, 2 on mobile) -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6" id="wishlist-grid-container">
        <!-- Dynamically rendered -->
      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    const SHOP_URL = @json(route('shop'));

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('wishlist');
      Components.renderFooter();
      renderWishlistPage();

      window.addEventListener('wishlistUpdated', renderWishlistPage);
    });

    function renderWishlistPage() {
      const ids = Wishlist.getItems();
      const container = document.getElementById('wishlist-grid-container');
      const clearBtn = document.getElementById('clear-wishlist-btn');
      const summaryText = document.getElementById('wishlist-summary-text');

      if (!ids || ids.length === 0) {
        if (clearBtn) clearBtn.style.display = 'none';
        if (summaryText) summaryText.textContent = 'You have no saved items.';
        container.innerHTML = `
          <div class="col-span-full text-center py-16 px-4 bg-white rounded-3xl border border-slate-200 shadow-sm max-w-lg mx-auto my-8">
            <div class="w-16 h-16 rounded-full bg-red-50 text-red-400 flex items-center justify-center mx-auto mb-4 text-2xl">
              <i class="fa-regular fa-heart"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-900 mb-2 font-heading">Your wishlist is waiting</h3>
            <p class="text-xs text-slate-500 mb-6 max-w-sm mx-auto">Explore our tested refurbished laptops, smartphones, and accessories and click the heart icon to save favorites.</p>
            <a href="${SHOP_URL}" class="btn-base btn-primary px-6 py-2.5 text-xs font-semibold">
              Explore Products
            </a>
          </div>
        `;
        return;
      }

      if (clearBtn) clearBtn.style.display = 'inline-flex';
      if (summaryText) summaryText.textContent = `You have ${ids.length} item${ids.length > 1 ? 's' : ''} saved in your wishlist.`;

      const items = PRODUCTS_DATA.filter(p => ids.includes(p.id));
      ProductsEngine.renderProductsGrid('wishlist-grid-container', items);
    }

    function clearWishlist() {
      if (confirm('Are you sure you want to clear your wishlist?')) {
        Wishlist.saveItems([]);
        renderWishlistPage();
        showToast('Wishlist cleared.', 'info');
      }
    }
  </script>
@endpush