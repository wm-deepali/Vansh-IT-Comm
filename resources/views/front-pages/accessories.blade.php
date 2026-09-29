@extends('layouts.app')

@section('title', 'Computer & Mobile Accessories | VANSH IT & COMM')
@section('meta_description', 'Shop GaN fast chargers, NVMe SSDs, laptop RAM, mechanical keyboards, stands, and audio accessories.')

@section('content')

  <main class="flex-grow py-6 sm:py-8">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('shop') }}" class="hover:text-blue-600">Shop</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Accessories</span>
      </nav>

      <!-- Category Hero Banner -->
      <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 border border-slate-800 shadow-md">
        <div class="max-w-2xl space-y-2">
          <span class="badge bg-indigo-500/20 text-indigo-300 border border-indigo-400/30 text-[10px] sm:text-xs px-2.5 py-0.5">PERFORMANCE GEAR</span>
          <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight font-heading">
            Computer & Mobile Accessories
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            High-speed GaN chargers, NVMe SSD storage, RAM modules, ergonomic aluminum stands, mechanical keyboards, and ANC earbuds.
          </p>
        </div>

        <!-- Quick Filter Pills -->
        <div class="flex items-center gap-2 mt-5 overflow-x-auto no-scrollbar pb-1 text-xs">
          <button type="button" onclick="filterByTag('all')" class="pill-btn px-3 py-1.5 rounded-full bg-blue-600 text-white font-semibold flex-shrink-0">All Accessories</button>
          <button type="button" onclick="filterByTag('chargers')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">GaN & Chargers</button>
          <button type="button" onclick="filterByTag('storage')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">SSD & RAM</button>
          <button type="button" onclick="filterByTag('peripherals')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Mice & Keyboards</button>
          <button type="button" onclick="filterByTag('stands')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Stands & Cooling</button>
          <button type="button" onclick="filterByTag('audio')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Audio & Earbuds</button>
          <button type="button" onclick="filterByTag('bags')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Laptop Bags</button>
        </div>
      </div>

      <!-- Sorting & Info Bar -->
      <div class="flex items-center justify-between bg-white p-3.5 rounded-xl border border-slate-200 mb-6 text-xs">
        <span class="text-slate-700 font-semibold" id="acc-count-badge">Loading accessories...</span>
        <div class="flex items-center gap-2">
          <label for="acc-sort" class="text-slate-500 font-medium hidden sm:inline">Sort by:</label>
          <select id="acc-sort" onchange="renderAccessories()" class="bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-semibold focus:outline-none focus:border-blue-600">
            <option value="featured">Featured First</option>
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="rating">Top Rated</option>
          </select>
        </div>
      </div>

      <!-- 4 Columns Desktop / 2 Mobile -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6" id="accessories-grid-container"></div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    let activeTag = 'all';

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('accessories');
      Components.renderFooter();

      const params = App.getUrlParams();
      if (params.type) activeTag = params.type;

      renderAccessories();
    });

    function filterByTag(tag) {
      activeTag = tag;
      const pills = document.querySelectorAll('.pill-btn');
      pills.forEach(p => {
        p.className = 'pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0';
      });
      event.target.className = 'pill-btn px-3 py-1.5 rounded-full bg-blue-600 text-white font-semibold flex-shrink-0';
      renderAccessories();
    }

    function renderAccessories() {
      let list = PRODUCTS_DATA.filter(p => p.category === 'accessories');

      if (activeTag !== 'all') {
        list = list.filter(p => (p.subcategory || '').toLowerCase() === activeTag.toLowerCase());
      }

      const sort = document.getElementById('acc-sort').value;
      if (sort === 'price-asc') list.sort((a, b) => a.price - b.price);
      if (sort === 'price-desc') list.sort((a, b) => b.price - a.price);
      if (sort === 'rating') list.sort((a, b) => b.rating - a.rating);

      document.getElementById('acc-count-badge').textContent = `Showing ${list.length} Accessories`;
      ProductsEngine.renderProductsGrid('accessories-grid-container', list);
    }
  </script>
@endpush