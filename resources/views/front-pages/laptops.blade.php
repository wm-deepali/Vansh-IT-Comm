@extends('layouts.app')

@section('title', 'Refurbished & New Laptops — Dell, ThinkPad, HP, Apple | VANSH IT & COMM')
@section('meta_description', 'Buy certified business & gaming laptops with up to 12-month warranty, 20-point testing, and pan-India delivery.')

@section('content')

  <main class="flex-grow py-6 sm:py-8">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('shop') }}" class="hover:text-blue-600">Shop</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Laptops</span>
      </nav>

      <!-- Category Hero Banner -->
      <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 border border-slate-800 shadow-md">
        <div class="max-w-2xl space-y-2">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] sm:text-xs px-2.5 py-0.5">20-POINT CERTIFIED</span>
          <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight font-heading">
            Refurbished & New Laptops
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            Enterprise Dell Latitudes, developer ThinkPads, sleek HP EliteBooks, and Apple MacBooks tested with genuine chargers and up to 12-Month Warranty.
          </p>
        </div>

        <!-- Quick Filter Pills -->
        <div class="flex items-center gap-2 mt-5 overflow-x-auto no-scrollbar pb-1 text-xs">
          <button type="button" onclick="filterByTag('all')" class="pill-btn px-3 py-1.5 rounded-full bg-blue-600 text-white font-semibold flex-shrink-0">All Laptops</button>
          <button type="button" onclick="filterByTag('under15k')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-emerald-400 font-semibold border border-slate-700 flex-shrink-0">Under ₹15,000</button>
          <button type="button" onclick="filterByTag('under25k')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">₹15K – ₹25K</button>
          <button type="button" onclick="filterByTag('Dell')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Dell</button>
          <button type="button" onclick="filterByTag('Lenovo')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">ThinkPad</button>
          <button type="button" onclick="filterByTag('Apple')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Apple Mac</button>
          <button type="button" onclick="filterByTag('gaming')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Gaming</button>
        </div>
      </div>

      <!-- Products Grid & Sort Header -->
      <div class="flex items-center justify-between bg-white p-3.5 rounded-xl border border-slate-200 mb-6 text-xs">
        <span class="text-slate-700 font-semibold" id="laptop-count-badge">Loading laptops...</span>
        <div class="flex items-center gap-2">
          <label for="laptop-sort" class="text-slate-500 font-medium hidden sm:inline">Sort by:</label>
          <select id="laptop-sort" onchange="renderLaptops()" class="bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-semibold focus:outline-none focus:border-blue-600">
            <option value="featured">Featured First</option>
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="rating">Top Rated</option>
          </select>
        </div>
      </div>

      <!-- 4 Columns Desktop / 2 Mobile -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6" id="laptops-grid-container"></div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    let activeTag = 'all';

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('laptops');
      Components.renderFooter();

      // Check URL query parameters
      const params = App.getUrlParams();
      if (params.brand) activeTag = params.brand;
      if (params.use) activeTag = params.use;
      if (params.maxPrice === '15000') activeTag = 'under15k';
      if (params.minPrice === '15000') activeTag = 'under25k';

      renderLaptops();
    });

    function filterByTag(tag) {
      activeTag = tag;
      const pills = document.querySelectorAll('.pill-btn');
      pills.forEach(p => {
        p.className = 'pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0';
      });
      event.target.className = 'pill-btn px-3 py-1.5 rounded-full bg-blue-600 text-white font-semibold flex-shrink-0';
      renderLaptops();
    }

    function renderLaptops() {
      let list = PRODUCTS_DATA.filter(p => p.category === 'laptops');

      if (activeTag === 'under15k') {
        list = list.filter(p => p.price <= 15000);
      } else if (activeTag === 'under25k') {
        list = list.filter(p => p.price > 15000 && p.price <= 25000);
      } else if (activeTag === 'gaming') {
        list = list.filter(p => (p.subcategory || '').toLowerCase() === 'gaming');
      } else if (activeTag !== 'all') {
        list = list.filter(p =>
          p.brand.toLowerCase() === activeTag.toLowerCase() ||
          (p.subcategory && p.subcategory.toLowerCase() === activeTag.toLowerCase())
        );
      }

      const sort = document.getElementById('laptop-sort').value;
      if (sort === 'price-asc') list.sort((a, b) => a.price - b.price);
      if (sort === 'price-desc') list.sort((a, b) => b.price - a.price);
      if (sort === 'rating') list.sort((a, b) => b.rating - a.rating);

      document.getElementById('laptop-count-badge').textContent = `Showing ${list.length} Laptops`;
      ProductsEngine.renderProductsGrid('laptops-grid-container', list);
    }
  </script>
@endpush