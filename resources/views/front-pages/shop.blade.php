@extends('layouts.app')

@section('title', 'Shop All Electronics & Refurbished Devices | VANSH IT & COMM')
@section('meta_description', 'Explore certified refurbished & new laptops, smartphones, and computer accessories with up to 12-month warranty and 20-point testing.')

@section('content')

  <main class="flex-grow py-6 sm:py-8">
    <div class="container-custom">

      <!-- Breadcrumb & Title -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold" id="page-breadcrumb-current">All Products</span>
      </nav>

      <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-6 pb-4 border-b border-slate-200">
        <div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading" id="catalog-heading">All Products</h1>
          <p class="text-xs sm:text-sm text-slate-500 mt-0.5">Showing tested laptops, mobile phones, and accessories.</p>
        </div>

        <!-- Sorting & Mobile Filter Button -->
        <div class="flex items-center gap-3">
          <button
            type="button"
            onclick="toggleMobileFilterDrawer()"
            class="lg:hidden btn-base btn-secondary btn-sm text-xs py-2 px-3 flex items-center gap-2"
          >
            <i class="fa-solid fa-sliders"></i> Filters
          </button>

          <div class="flex items-center gap-2 text-xs">
            <label for="sort-select" class="font-semibold text-slate-600 hidden sm:inline">Sort By:</label>
            <select
              id="sort-select"
              onchange="handleFilterChange()"
              class="bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs font-semibold text-slate-800 focus:outline-none focus:border-blue-600"
            >
              <option value="featured">Featured First</option>
              <option value="price-asc">Price: Low to High</option>
              <option value="price-desc">Price: High to Low</option>
              <option value="rating">Top Customer Rated</option>
              <option value="discount">Biggest Discount %</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Main Layout: Sidebar Filters + Products Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

        <!-- Desktop Filter Sidebar -->
        <aside class="hidden lg:block lg:col-span-3 bg-white p-6 rounded-2xl border border-slate-200 shadow-sm space-y-6 sticky top-28">
          <div class="flex items-center justify-between pb-3 border-b border-slate-100">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider font-heading"><i class="fa-solid fa-filter text-blue-600 mr-1.5"></i> Filters</h3>
            <button type="button" onclick="resetAllFilters()" class="text-xs text-blue-600 hover:underline font-semibold">Clear All</button>
          </div>

          <!-- Category Filter -->
          <div>
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5">Category</h4>
            <div class="space-y-1.5 text-xs text-slate-600">
              <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="cat" value="laptops" onchange="handleFilterChange()" class="rounded text-blue-600 focus:ring-0"> Laptops
              </label>
              <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="cat" value="mobile-phones" onchange="handleFilterChange()" class="rounded text-blue-600 focus:ring-0"> Mobile Phones
              </label>
              <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="cat" value="accessories" onchange="handleFilterChange()" class="rounded text-blue-600 focus:ring-0"> Accessories
              </label>
            </div>
          </div>

          <!-- Condition Filter -->
          <div class="pt-4 border-t border-slate-100">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5">Condition</h4>
            <div class="space-y-1.5 text-xs text-slate-600">
              <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="condition" value="Refurbished" onchange="handleFilterChange()" class="rounded text-blue-600 focus:ring-0"> Refurbished (Tested)
              </label>
              <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="condition" value="Open Box" onchange="handleFilterChange()" class="rounded text-blue-600 focus:ring-0"> Open Box
              </label>
              <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
                <input type="checkbox" name="condition" value="New" onchange="handleFilterChange()" class="rounded text-blue-600 focus:ring-0"> Brand New
              </label>
            </div>
          </div>

          <!-- Brand Filter -->
          <div class="pt-4 border-t border-slate-100">
            <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5">Brand</h4>
            <div class="space-y-1.5 text-xs text-slate-600 max-h-48 overflow-y-auto pr-1">
              @foreach (['Dell', 'Lenovo', 'HP', 'Apple', 'Samsung', 'OnePlus', 'Xiaomi', 'Google Pixel'] as $brand)
                <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
                  <input type="checkbox" name="brand" value="{{ $brand }}" onchange="handleFilterChange()" class="rounded text-blue-600 focus:ring-0"> {{ $brand }}
                </label>
              @endforeach
            </div>
          </div>

          <!-- Price Max Slider -->
          <div class="pt-4 border-t border-slate-100">
            <div class="flex items-center justify-between mb-2">
              <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Max Price</h4>
              <span id="price-slider-value" class="text-xs font-extrabold text-blue-600">₹75,000</span>
            </div>
            <input
              type="range"
              id="price-range"
              min="1000"
              max="75000"
              step="1000"
              value="75000"
              oninput="document.getElementById('price-slider-value').textContent = '₹' + Number(this.value).toLocaleString('en-IN'); handleFilterChange();"
              class="w-full accent-blue-600 cursor-pointer"
            />
          </div>
        </aside>

        <!-- Product Grid Area (9 Cols Desktop) -->
        <section class="lg:col-span-9">
          <!-- Active Filter Summary -->
          <div class="flex items-center justify-between bg-white p-3 rounded-xl border border-slate-200 mb-4 text-xs">
            <span class="text-slate-600 font-medium" id="products-count-badge">Loading items...</span>
            <div id="active-filter-tags" class="flex items-center gap-2 flex-wrap"></div>
          </div>

          <!-- Products Grid (3 cols on large desktop, 2 cols on mobile) -->
          <div class="grid grid-cols-2 md:grid-cols-3 gap-3 sm:gap-6" id="catalog-products-grid"></div>
        </section>
      </div>

    </div>
  </main>

  <!-- Mobile Filter Drawer Modal -->
  <div id="mobile-filter-drawer" class="fixed inset-0 z-50 pointer-events-none opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm" onclick="toggleMobileFilterDrawer()"></div>
    <div class="absolute right-0 top-0 bottom-0 w-80 max-w-full bg-white p-6 overflow-y-auto shadow-2xl flex flex-col justify-between transform translate-x-full transition-transform duration-300" id="mobile-filter-drawer-box">
      <div>
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
          <h3 class="text-base font-bold text-slate-900 font-heading">Filters</h3>
          <button type="button" onclick="toggleMobileFilterDrawer()" class="p-1 text-slate-400 hover:text-slate-700">
            <i class="fa-solid fa-xmark text-lg"></i>
          </button>
        </div>
        <p class="text-xs text-slate-500 mb-4">Adjust filters on desktop sidebar or reload page with search keywords.</p>
        <button type="button" onclick="resetAllFilters(); toggleMobileFilterDrawer();" class="btn-base btn-secondary btn-sm w-full mb-3">
          Reset All Filters
        </button>
      </div>
      <button type="button" onclick="toggleMobileFilterDrawer()" class="btn-base btn-primary w-full py-2.5 text-xs font-semibold">
        Apply & Close
      </button>
    </div>
  </div>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('shop');
      Components.renderFooter();

      // Read initial query params (e.g., search, category, brand, maxPrice)
      const params = App.getUrlParams();
      if (params.search) {
        document.getElementById('catalog-heading').textContent = `Results for "${params.search}"`;
        document.getElementById('page-breadcrumb-current').textContent = `Search: ${params.search}`;
      } else if (params.category) {
        const catName = params.category === 'laptops' ? 'Laptops' : params.category === 'mobile-phones' ? 'Mobile Phones' : 'Accessories';
        document.getElementById('catalog-heading').textContent = catName;
        document.getElementById('page-breadcrumb-current').textContent = catName;

        // Check category checkbox
        const catBox = document.querySelector(`input[name="cat"][value="${params.category}"]`);
        if (catBox) catBox.checked = true;
      }

      if (params.brand) {
        const brandBox = document.querySelector(`input[name="brand"][value="${params.brand}"]`);
        if (brandBox) brandBox.checked = true;
      }

      handleFilterChange();
    });

    function handleFilterChange() {
      const params = App.getUrlParams();
      let filtered = [...PRODUCTS_DATA];

      // 1. Text Search Filter (from URL or input)
      if (params.search) {
        const q = params.search.toLowerCase();
        filtered = filtered.filter(p =>
          p.name.toLowerCase().includes(q) ||
          p.brand.toLowerCase().includes(q) ||
          (p.processor && p.processor.toLowerCase().includes(q)) ||
          p.category.toLowerCase().includes(q)
        );
      }

      // 2. Category Checkboxes
      const selectedCats = Array.from(document.querySelectorAll('input[name="cat"]:checked')).map(cb => cb.value);
      if (selectedCats.length > 0) {
        filtered = filtered.filter(p => selectedCats.includes(p.category));
      }

      // 3. Condition Checkboxes
      const selectedConds = Array.from(document.querySelectorAll('input[name="condition"]:checked')).map(cb => cb.value);
      if (selectedConds.length > 0) {
        filtered = filtered.filter(p => selectedConds.includes(p.condition));
      }

      // 4. Brand Checkboxes
      const selectedBrands = Array.from(document.querySelectorAll('input[name="brand"]:checked')).map(cb => cb.value);
      if (selectedBrands.length > 0) {
        filtered = filtered.filter(p => selectedBrands.some(b => p.brand.toLowerCase() === b.toLowerCase()));
      }

      // 5. Price Max Slider
      const priceSlider = document.getElementById('price-range');
      if (priceSlider) {
        const maxVal = Number(priceSlider.value);
        filtered = filtered.filter(p => p.price <= maxVal);
      }

      // 6. Sorting
      const sortVal = document.getElementById('sort-select').value;
      if (sortVal === 'price-asc') {
        filtered.sort((a, b) => a.price - b.price);
      } else if (sortVal === 'price-desc') {
        filtered.sort((a, b) => b.price - a.price);
      } else if (sortVal === 'rating') {
        filtered.sort((a, b) => b.rating - a.rating);
      } else if (sortVal === 'discount') {
        filtered.sort((a, b) => (b.discount || 0) - (a.discount || 0));
      }

      // Update count & render
      document.getElementById('products-count-badge').textContent = `Showing ${filtered.length} products`;
      ProductsEngine.renderProductsGrid('catalog-products-grid', filtered);
    }

    function resetAllFilters() {
      document.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
      const slider = document.getElementById('price-range');
      if (slider) {
        slider.value = 75000;
        document.getElementById('price-slider-value').textContent = '₹75,000';
      }
      handleFilterChange();
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