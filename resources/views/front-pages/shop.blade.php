@extends('layouts.app')

@section('title', ($search !== '' ? 'Results for "' . $search . '"' : 'Shop All Products') . ' | ' . config('app.name'))
@section('meta_description', 'Browse laptops, mobile phones and accessories at ' . config('app.name') . '.')
@section('active_page', 'shop')

@section('content')

  <main class="flex-grow py-6 sm:py-8">
    <div class="container-custom">

      <!-- Breadcrumb & Title -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">{{ $search !== '' ? 'Search: ' . $search : 'All Products' }}</span>
      </nav>

      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
            {{ $search !== '' ? 'Results for "' . $search . '"' : 'All Products' }}
          </h1>
        </div>

        <div class="flex items-center gap-3">
          <button type="button" onclick="toggleMobileFilterDrawer()"
            class="lg:hidden btn-base btn-secondary btn-sm text-xs py-2 px-3 flex items-center gap-2">
            <i class="fa-solid fa-sliders"></i> Filters
          </button>

          <div class="flex items-center gap-2 text-xs">
            <label for="sort-select" class="font-semibold text-slate-600 hidden sm:inline">Sort By:</label>
            <select id="sort-select" onchange="changeSort(this.value)"
              class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:border-blue-600">
              @foreach($sortOptions as $value => $label)
                <option value="{{ $value }}" {{ $sort === $value ? 'selected' : '' }}>{{ $label }}</option>
              @endforeach
            </select>
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Desktop Filter Sidebar -->
        <aside class="hidden lg:block lg:col-span-3 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm sticky top-28">
          @include('partials.shop-filters', ['formId' => 'filters-desktop'])
        </aside>

        <!-- Product Grid Area -->
        <section class="lg:col-span-9">
          <div class="flex items-center justify-between gap-3 bg-white p-3 rounded-xl border border-slate-200 mb-4 text-xs flex-wrap">
            <span class="text-slate-600 font-medium">
              @if($products->total())
                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }} {{ \Illuminate\Support\Str::plural('product', $products->total()) }}
              @else
                No products found
              @endif
            </span>

            @if(count($activeFilters))
              <div class="flex items-center gap-2 flex-wrap">
                @foreach($activeFilters as $f)
                  <a href="{{ $f['url'] }}" class="inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 border border-blue-100 rounded-full px-2.5 py-1 font-semibold hover:bg-blue-100">
                    {{ $f['label'] }} <i class="fa-solid fa-xmark text-[10px]"></i>
                  </a>
                @endforeach
              </div>
            @endif
          </div>

          @if($products->count())
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6">
              @foreach($products as $p)
                @php
                  // listing specs for this product's category (+ its subcategory)
                  $cardAttrs = collect($listingByCategory->get($p->subcategory_id, []))
                    ->merge($listingByCategory->get($p->category_id, []))
                    ->unique('attribute_id')->values();
                @endphp
                @include('partials.product-card', ['product' => $p, 'listingAttributes' => $cardAttrs])
              @endforeach
            </div>

            <div class="mt-8">{{ $products->links() }}</div>
          @else
            <div class="bg-white border border-slate-200 rounded-2xl p-10 text-center">
              <div class="w-14 h-14 rounded-2xl bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto mb-3">
                <i class="fa-solid fa-magnifying-glass"></i>
              </div>
              <h3 class="text-base font-bold text-slate-900 mb-1">No products match your filters</h3>
              <p class="text-xs text-slate-500 mb-4">Try removing a filter or searching for something else.</p>
              <a href="{{ route('shop') }}" class="btn-base btn-primary btn-sm text-xs px-4 py-2">Clear all filters</a>
            </div>
          @endif
        </section>
      </div>

    </div>
  </main>

  <!-- Mobile Filter Drawer -->
  <div id="mobile-filter-drawer" class="fixed inset-0 z-50 pointer-events-none opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="toggleMobileFilterDrawer()"></div>
    <div class="absolute right-0 top-0 bottom-0 w-80 max-w-full bg-white p-6 overflow-y-auto shadow-2xl transform translate-x-full transition-transform duration-300" id="mobile-filter-drawer-box">
      <button type="button" onclick="toggleMobileFilterDrawer()" class="absolute top-4 right-4 p-1 text-slate-400 hover:text-slate-700">
        <i class="fa-solid fa-xmark text-lg"></i>
      </button>
      @include('partials.shop-filters', ['formId' => 'filters-mobile'])
    </div>
  </div>

@endsection

@push('scripts')
  <script>
    // Filters are applied server-side (GET form). Sorting keeps every other query param.
    function changeSort(value) {
      const url = new URL(window.location.href);
      url.searchParams.set('sort', value);
      url.searchParams.delete('page');
      window.location.href = url.toString();
    }

    function toggleMobileFilterDrawer() {
      const drawer = document.getElementById('mobile-filter-drawer');
      const box = document.getElementById('mobile-filter-drawer-box');
      if (!drawer || !box) return;

      if (drawer.classList.contains('opacity-0')) {
        drawer.classList.remove('opacity-0', 'pointer-events-none');
        box.classList.remove('translate-x-full');
      } else {
        drawer.classList.add('opacity-0', 'pointer-events-none');
        box.classList.add('translate-x-full');
      }
    }
  </script>
@endpush