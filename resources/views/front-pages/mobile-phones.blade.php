@extends('layouts.app')

@section('title', 'Refurbished & New Smartphones — iPhone, Samsung, OnePlus | VANSH IT & COMM')
@section('meta_description', 'Certified pre-owned and new smartphones with 85%+ verified battery health, original OEM parts, and warranty.')

@section('content')

  <main class="flex-grow py-6 sm:py-8">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('shop') }}" class="hover:text-blue-600">Shop</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Mobile Phones</span>
      </nav>

      <!-- Category Hero Banner -->
      <div class="bg-gradient-to-r from-blue-950 via-slate-900 to-slate-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 border border-slate-800 shadow-md">
        <div class="max-w-2xl space-y-2">
          <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] sm:text-xs px-2.5 py-0.5">85%+ BATTERY HEALTH</span>
          <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight font-heading">
            Refurbished & New Mobile Phones
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            Apple iPhones, Samsung Galaxy flagships, Google Pixel camera phones, and OnePlus 5G smartphones with pristine screens, original cameras, and warranty.
          </p>
        </div>

        <!-- Quick Filter Pills -->
        <div class="flex items-center gap-2 mt-5 overflow-x-auto no-scrollbar pb-1 text-xs">
          <button type="button" onclick="filterByTag('all')" class="pill-btn px-3 py-1.5 rounded-full bg-blue-600 text-white font-semibold flex-shrink-0">All Phones</button>
          <button type="button" onclick="filterByTag('Apple')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Apple iPhone</button>
          <button type="button" onclick="filterByTag('Samsung')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Samsung Galaxy</button>
          <button type="button" onclick="filterByTag('OnePlus')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">OnePlus</button>
          <button type="button" onclick="filterByTag('Google Pixel')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">Pixel</button>
          <button type="button" onclick="filterByTag('under10k')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-emerald-400 font-semibold border border-slate-700 flex-shrink-0">Under ₹10,000</button>
          <button type="button" onclick="filterByTag('under15k')" class="pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0">₹10K – ₹15K</button>
        </div>
      </div>

      <!-- Sorting & Info Bar -->
      <div class="flex items-center justify-between bg-white p-3.5 rounded-xl border border-slate-200 mb-6 text-xs">
        <span class="text-slate-700 font-semibold" id="mobile-count-badge">Loading mobiles...</span>
        <div class="flex items-center gap-2">
          <label for="mobile-sort" class="text-slate-500 font-medium hidden sm:inline">Sort by:</label>
          <select id="mobile-sort" onchange="renderMobiles()" class="bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-semibold focus:outline-none focus:border-blue-600">
            <option value="featured">Featured First</option>
            <option value="price-asc">Price: Low to High</option>
            <option value="price-desc">Price: High to Low</option>
            <option value="rating">Top Rated</option>
          </select>
        </div>
      </div>

      <!-- 4 Columns Desktop / 2 Mobile -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6" id="mobiles-grid-container"></div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    let activeTag = 'all';

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('mobiles');
      Components.renderFooter();

      const params = App.getUrlParams();
      if (params.brand) activeTag = params.brand;
      if (params.type) activeTag = params.type;
      if (params.maxPrice === '10000') activeTag = 'under10k';
      if (params.maxPrice === '15000') activeTag = 'under15k';

      renderMobiles();
    });

    function filterByTag(tag) {
      activeTag = tag;
      const pills = document.querySelectorAll('.pill-btn');
      pills.forEach(p => {
        p.className = 'pill-btn px-3 py-1.5 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-200 font-semibold border border-slate-700 flex-shrink-0';
      });
      event.target.className = 'pill-btn px-3 py-1.5 rounded-full bg-blue-600 text-white font-semibold flex-shrink-0';
      renderMobiles();
    }

    function renderMobiles() {
      let list = PRODUCTS_DATA.filter(p => p.category === 'mobile-phones');

      if (activeTag === 'under10k') {
        list = list.filter(p => p.price <= 10000);
      } else if (activeTag === 'under15k') {
        list = list.filter(p => p.price > 10000 && p.price <= 15000);
      } else if (activeTag !== 'all') {
        list = list.filter(p =>
          p.brand.toLowerCase() === activeTag.toLowerCase() ||
          (p.subcategory && p.subcategory.toLowerCase() === activeTag.toLowerCase())
        );
      }

      const sort = document.getElementById('mobile-sort').value;
      if (sort === 'price-asc') list.sort((a, b) => a.price - b.price);
      if (sort === 'price-desc') list.sort((a, b) => b.price - a.price);
      if (sort === 'rating') list.sort((a, b) => b.rating - a.rating);

      document.getElementById('mobile-count-badge').textContent = `Showing ${list.length} Mobile Phones`;
      ProductsEngine.renderProductsGrid('mobiles-grid-container', list);
    }
  </script>
@endpush