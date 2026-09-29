@extends('layouts.app')

@section('title', 'All Categories — Laptops, Mobiles, Accessories & Repair | VANSH IT & COMM')
@section('meta_description', 'Browse all electronics categories at VANSH IT & COMM: Refurbished & new laptops, certified smartphones, computer accessories, repairs, and trade-ins.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">All Categories</span>
      </nav>

      <!-- Category Hero Banner -->
      <div
        class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-10 mb-8 sm:mb-12 border border-slate-800 shadow-xl relative overflow-hidden">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-blue-600/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="max-w-3xl space-y-2.5 sm:space-y-4 relative z-10">
          <span
            class="inline-flex items-center badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] sm:text-xs px-2.5 py-0.5 sm:px-3 sm:py-1 font-bold uppercase tracking-wider">
            <i class="fa-solid fa-layer-group text-amber-400 mr-1.5"></i> Comprehensive Catalog
          </span>
          <h1
            class="text-xl sm:text-3xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Explore All Product & Service Categories
          </h1>
          <p class="text-xs sm:text-sm lg:text-base text-slate-300 leading-relaxed font-body">
            From 20-point tested business laptops and certified 5G smartphones to high-speed NVMe storage, GaN chargers,
            repair services, and trade-in upgrades.
          </p>
          <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 sm:gap-3 pt-1 sm:pt-2 text-xs">
            <a href="{{ route('shop') }}" class="btn-base btn-primary px-3 sm:px-5 py-2 sm:py-2.5 text-xs font-semibold shadow-lg shadow-blue-600/30 text-center justify-center">
              <i class="fa-solid fa-cart-shopping mr-1 sm:mr-1.5"></i> All Products <span class="hidden sm:inline">(24+)</span>
            </a>
            <a href="{{ route('repair') }}"
              class="btn-base btn-secondary bg-white/10 text-white border-white/20 px-3 sm:px-5 py-2 sm:py-2.5 text-xs font-semibold hover:bg-white/20 text-center justify-center">
              <i class="fa-solid fa-screwdriver-wrench mr-1 sm:mr-1.5"></i> Repair Workshop
            </a>
          </div>
        </div>
      </div>

      <!-- Main Categories Grid -->
      <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2.5 sm:gap-4 lg:gap-5 mb-12 sm:mb-16">

        <!-- Category 1: Laptops -->
        <div
          class="card-base p-2.5 sm:p-4 flex flex-col justify-between group hover:border-blue-500 hover:shadow-lg transition-all duration-300">
          <div>
            <div class="aspect-[16/10] rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 mb-2 sm:mb-3.5 relative">
              <img src="{{ asset('assets/img/product-1588872657578-7efd1f1555ed.jpg') }}" alt="Refurbished & New Laptops"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <span
                class="absolute top-1.5 left-1.5 badge bg-blue-600 text-white text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded shadow-sm leading-none">
                10+ Models
              </span>
              <span
                class="absolute bottom-1.5 right-1.5 bg-slate-900/90 backdrop-blur-sm text-emerald-400 text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded border border-emerald-500/30 leading-none">
                From ₹14,499
              </span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 mb-1 sm:mb-1.5">
              <div class="w-5 h-5 sm:w-7 sm:h-7 rounded-md sm:rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] sm:text-xs flex-shrink-0">
                <i class="fa-solid fa-laptop"></i>
              </div>
              <h2
                class="text-xs sm:text-base lg:text-lg font-bold sm:font-extrabold text-slate-900 font-heading group-hover:text-blue-600 transition-colors truncate">
                Laptops
              </h2>
            </div>

            <p class="text-[10px] sm:text-xs text-slate-600 leading-tight sm:leading-relaxed mb-2 sm:mb-3 line-clamp-2">
              Enterprise Dell Latitudes, ThinkPads, HP EliteBooks & MacBooks with 12-Month Warranty.
            </p>

            <div class="flex flex-wrap gap-1 mb-2.5 sm:mb-4 text-[9px] sm:text-[10.5px] font-medium sm:font-semibold">
              <a href="{{ route('laptops', ['use' => 'business']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 transition-colors">Business</a>
              <a href="{{ route('laptops', ['use' => 'coding']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 transition-colors">Coding</a>
              <a href="{{ route('laptops', ['use' => 'students']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 transition-colors">Students</a>
              <a href="{{ route('laptops', ['brand' => 'Apple']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-blue-50 hover:text-blue-600 text-slate-700 transition-colors">Apple</a>
            </div>
          </div>

          <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1">
            <span class="text-[9px] sm:text-[11px] font-bold text-slate-500 hidden sm:inline">20-Point QC</span>
            <a href="{{ route('laptops') }}" class="btn-base btn-primary btn-sm text-[10px] sm:text-xs font-semibold px-2 sm:px-3 py-1 sm:py-1.5 w-full sm:w-auto text-center justify-center">
              Browse <span class="hidden sm:inline">Laptops</span> <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] ml-1"></i>
            </a>
          </div>
        </div>

        <!-- Category 2: Mobile Phones -->
        <div
          class="card-base p-2.5 sm:p-4 flex flex-col justify-between group hover:border-purple-500 hover:shadow-lg transition-all duration-300">
          <div>
            <div class="aspect-[16/10] rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 mb-2 sm:mb-3.5 relative">
              <img src="{{ asset('assets/img/product-1511707171634-5f897ff02aa9.jpg') }}" alt="Certified Smartphones"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <span
                class="absolute top-1.5 left-1.5 badge bg-purple-600 text-white text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded shadow-sm leading-none">
                10+ Devices
              </span>
              <span
                class="absolute bottom-1.5 right-1.5 bg-slate-900/90 backdrop-blur-sm text-pink-300 text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded border border-pink-500/30 leading-none">
                85%+ Battery
              </span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 mb-1 sm:mb-1.5">
              <div class="w-5 h-5 sm:w-7 sm:h-7 rounded-md sm:rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-[10px] sm:text-xs flex-shrink-0">
                <i class="fa-solid fa-mobile-screen-button"></i>
              </div>
              <h2
                class="text-xs sm:text-base lg:text-lg font-bold sm:font-extrabold text-slate-900 font-heading group-hover:text-purple-600 transition-colors truncate">
                Mobile Phones
              </h2>
            </div>

            <p class="text-[10px] sm:text-xs text-slate-600 leading-tight sm:leading-relaxed mb-2 sm:mb-3 line-clamp-2">
              Apple iPhones, Samsung Galaxy flagships, Pixel AI cameras & OnePlus 5G smartphones.
            </p>

            <div class="flex flex-wrap gap-1 mb-2.5 sm:mb-4 text-[9px] sm:text-[10.5px] font-medium sm:font-semibold">
              <a href="{{ route('mobile-phones', ['brand' => 'Apple']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-purple-50 hover:text-purple-600 text-slate-700 transition-colors">iPhone</a>
              <a href="{{ route('mobile-phones', ['brand' => 'Samsung']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-purple-50 hover:text-purple-600 text-slate-700 transition-colors">Galaxy</a>
              <a href="{{ route('mobile-phones', ['brand' => 'OnePlus']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-purple-50 hover:text-purple-600 text-slate-700 transition-colors">OnePlus</a>
              <a href="{{ route('mobile-phones', ['brand' => 'Google']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-purple-50 hover:text-purple-600 text-slate-700 transition-colors">Pixel</a>
            </div>
          </div>

          <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1">
            <span class="text-[9px] sm:text-[11px] font-bold text-slate-500 hidden sm:inline">6-Mo Warranty</span>
            <a href="{{ route('mobile-phones') }}"
              class="btn-base btn-primary btn-sm text-[10px] sm:text-xs font-semibold px-2 sm:px-3 py-1 sm:py-1.5 bg-purple-600 hover:bg-purple-700 w-full sm:w-auto text-center justify-center">
              Browse <span class="hidden sm:inline">Phones</span> <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] ml-1"></i>
            </a>
          </div>
        </div>

        <!-- Category 3: Accessories -->
        <div
          class="card-base p-2.5 sm:p-4 flex flex-col justify-between group hover:border-indigo-500 hover:shadow-lg transition-all duration-300">
          <div>
            <div class="aspect-[16/10] rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 mb-2 sm:mb-3.5 relative">
              <img src="{{ asset('assets/img/product-1583863788434-e58a36330cf0.jpg') }}" alt="Computer & Mobile Accessories"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <span
                class="absolute top-1.5 left-1.5 badge bg-indigo-600 text-white text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded shadow-sm leading-none">
                Fast Chargers
              </span>
              <span
                class="absolute bottom-1.5 right-1.5 bg-slate-900/90 backdrop-blur-sm text-indigo-300 text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded border border-indigo-500/30 leading-none">
                From ₹499
              </span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 mb-1 sm:mb-1.5">
              <div class="w-5 h-5 sm:w-7 sm:h-7 rounded-md sm:rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-[10px] sm:text-xs flex-shrink-0">
                <i class="fa-solid fa-headphones"></i>
              </div>
              <h2
                class="text-xs sm:text-base lg:text-lg font-bold sm:font-extrabold text-slate-900 font-heading group-hover:text-indigo-600 transition-colors truncate">
                Accessories
              </h2>
            </div>

            <p class="text-[10px] sm:text-xs text-slate-600 leading-tight sm:leading-relaxed mb-2 sm:mb-3 line-clamp-2">
              GaN fast chargers, NVMe SSDs, DDR4/DDR5 RAM, mechanical keyboards & ANC earbuds.
            </p>

            <div class="flex flex-wrap gap-1 mb-2.5 sm:mb-4 text-[9px] sm:text-[10.5px] font-medium sm:font-semibold">
              <a href="{{ route('accessories', ['type' => 'chargers']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 transition-colors">Chargers</a>
              <a href="{{ route('accessories', ['type' => 'storage']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 transition-colors">SSD & RAM</a>
              <a href="{{ route('accessories', ['type' => 'peripherals']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 transition-colors">Keyboards</a>
              <a href="{{ route('accessories', ['type' => 'audio']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-indigo-50 hover:text-indigo-600 text-slate-700 transition-colors">Earbuds</a>
            </div>
          </div>

          <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1">
            <span class="text-[9px] sm:text-[11px] font-bold text-slate-500 hidden sm:inline">Universal Fit</span>
            <a href="{{ route('accessories') }}"
              class="btn-base btn-primary btn-sm text-[10px] sm:text-xs font-semibold px-2 sm:px-3 py-1 sm:py-1.5 bg-indigo-600 hover:bg-indigo-700 w-full sm:w-auto text-center justify-center">
              Browse <span class="hidden sm:inline">Gear</span> <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] ml-1"></i>
            </a>
          </div>
        </div>

        <!-- Category 4: Refurbished Tech Hub -->
        <div
          class="card-base p-2.5 sm:p-4 flex flex-col justify-between group hover:border-emerald-500 hover:shadow-lg transition-all duration-300">
          <div>
            <div class="aspect-[16/10] rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 mb-2 sm:mb-3.5 relative">
              <img src="{{ asset('assets/img/product-1541807084-5c52b6b3adef.jpg') }}" alt="Certified Refurbished"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <span
                class="absolute top-1.5 left-1.5 badge bg-emerald-600 text-white text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded shadow-sm leading-none">
                Up to 70% OFF
              </span>
              <span
                class="absolute bottom-1.5 right-1.5 bg-slate-900/90 backdrop-blur-sm text-emerald-300 text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded border border-emerald-500/30 leading-none">
                Grade A QC
              </span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 mb-1 sm:mb-1.5">
              <div class="w-5 h-5 sm:w-7 sm:h-7 rounded-md sm:rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] sm:text-xs flex-shrink-0">
                <i class="fa-solid fa-recycle"></i>
              </div>
              <h2
                class="text-xs sm:text-base lg:text-lg font-bold sm:font-extrabold text-slate-900 font-heading group-hover:text-emerald-600 transition-colors truncate">
                Refurbished
              </h2>
            </div>

            <p class="text-[10px] sm:text-xs text-slate-600 leading-tight sm:leading-relaxed mb-2 sm:mb-3 line-clamp-2">
              Corporate off-lease enterprise laptops and smartphones tested, cleaned and guaranteed.
            </p>

            <div class="flex flex-wrap gap-1 mb-2.5 sm:mb-4 text-[9px] sm:text-[10.5px] font-medium sm:font-semibold">
              <a href="{{ route('shop', ['condition' => 'Refurbished', 'cat' => 'laptops']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-700 transition-colors">Laptops</a>
              <a href="{{ route('shop', ['condition' => 'Refurbished', 'cat' => 'mobile-phones']) }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-700 transition-colors">Mobiles</a>
              <a href="{{ route('about') }}#refurbish-process"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-emerald-50 hover:text-emerald-600 text-slate-700 transition-colors">20-Pt QC</a>
            </div>
          </div>

          <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1">
            <span class="text-[9px] sm:text-[11px] font-bold text-slate-500 hidden sm:inline">100% GST Bill</span>
            <a href="{{ route('shop', ['condition' => 'Refurbished']) }}"
              class="btn-base btn-success btn-sm text-[10px] sm:text-xs font-semibold px-2 sm:px-3 py-1 sm:py-1.5 w-full sm:w-auto text-center justify-center">
              Explore <span class="hidden sm:inline">Deals</span> <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] ml-1"></i>
            </a>
          </div>
        </div>

        <!-- Category 5: Repair Services -->
        <div
          class="card-base p-2.5 sm:p-4 flex flex-col justify-between group hover:border-amber-500 hover:shadow-lg transition-all duration-300">
          <div>
            <div class="aspect-[16/10] rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 mb-2 sm:mb-3.5 relative">
              <img src="{{ asset('assets/img/product-1588872657578-7efd1f1555ed.jpg') }}" alt="Device Repair Services"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <span
                class="absolute top-1.5 left-1.5 badge bg-amber-600 text-white text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded shadow-sm leading-none">
                Same Day
              </span>
              <span
                class="absolute bottom-1.5 right-1.5 bg-slate-900/90 backdrop-blur-sm text-amber-300 text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded border border-amber-500/30 leading-none">
                OEM Parts
              </span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 mb-1 sm:mb-1.5">
              <div class="w-5 h-5 sm:w-7 sm:h-7 rounded-md sm:rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-[10px] sm:text-xs flex-shrink-0">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </div>
              <h2
                class="text-xs sm:text-base lg:text-lg font-bold sm:font-extrabold text-slate-900 font-heading group-hover:text-amber-600 transition-colors truncate">
                Repair Services
              </h2>
            </div>

            <p class="text-[10px] sm:text-xs text-slate-600 leading-tight sm:leading-relaxed mb-2 sm:mb-3 line-clamp-2">
              Fast diagnostics for screens, batteries, SSD upgrades, and motherboard chip soldering.
            </p>

            <div class="flex flex-wrap gap-1 mb-2.5 sm:mb-4 text-[9px] sm:text-[10.5px] font-medium sm:font-semibold">
              <a href="{{ route('repair') }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-amber-50 hover:text-amber-700 text-slate-700 transition-colors">Screen</a>
              <a href="{{ route('repair') }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-amber-50 hover:text-amber-700 text-slate-700 transition-colors">Battery</a>
              <a href="{{ route('repair') }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-amber-50 hover:text-amber-700 text-slate-700 transition-colors">SSD</a>
              <a href="{{ route('repair') }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-amber-50 hover:text-amber-700 text-slate-700 transition-colors">Chip Level</a>
            </div>
          </div>

          <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1">
            <span class="text-[9px] sm:text-[11px] font-bold text-slate-500 hidden sm:inline">Fast Turnaround</span>
            <a href="{{ route('repair') }}" class="btn-base btn-dark btn-sm text-[10px] sm:text-xs font-semibold px-2 sm:px-3 py-1 sm:py-1.5 w-full sm:w-auto text-center justify-center">
              Book <span class="hidden sm:inline">Repair</span> <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] ml-1"></i>
            </a>
          </div>
        </div>

        <!-- Category 6: Device Exchange & Trade-In -->
        <div class="card-base p-2.5 sm:p-4 flex flex-col justify-between group hover:border-sky-500 hover:shadow-lg transition-all duration-300">
          <div>
            <div class="aspect-[16/10] rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 mb-2 sm:mb-3.5 relative">
              <img src="{{ asset('assets/img/product-1592750475338-74b7b21085ab.jpg') }}" alt="Device Exchange & Trade-In"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
              <span
                class="absolute top-1.5 left-1.5 badge bg-sky-600 text-white text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded shadow-sm leading-none">
                Instant Valuation
              </span>
              <span
                class="absolute bottom-1.5 right-1.5 bg-slate-900/90 backdrop-blur-sm text-sky-300 text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded border border-sky-500/30 leading-none">
                Direct Credit
              </span>
            </div>

            <div class="flex items-center gap-1.5 sm:gap-2 mb-1 sm:mb-1.5">
              <div class="w-5 h-5 sm:w-7 sm:h-7 rounded-md sm:rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-[10px] sm:text-xs flex-shrink-0">
                <i class="fa-solid fa-rotate"></i>
              </div>
              <h2 class="text-xs sm:text-base lg:text-lg font-bold sm:font-extrabold text-slate-900 font-heading group-hover:text-sky-600 transition-colors truncate">
                Trade-In
              </h2>
            </div>

            <p class="text-[10px] sm:text-xs text-slate-600 leading-tight sm:leading-relaxed mb-2 sm:mb-3 line-clamp-2">
              Trade in your laptop or phone for maximum instant valuation credit toward any upgrade.
            </p>

            <div class="flex flex-wrap gap-1 mb-2.5 sm:mb-4 text-[9px] sm:text-[10.5px] font-medium sm:font-semibold">
              <a href="{{ route('exchange') }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-sky-50 hover:text-sky-600 text-slate-700 transition-colors">Laptop</a>
              <a href="{{ route('exchange') }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-sky-50 hover:text-sky-600 text-slate-700 transition-colors">Phone</a>
              <a href="{{ route('exchange') }}"
                class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 hover:bg-sky-50 hover:text-sky-600 text-slate-700 transition-colors">Calculator</a>
            </div>
          </div>

          <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1">
            <span class="text-[9px] sm:text-[11px] font-bold text-slate-500 hidden sm:inline">Fair Price</span>
            <a href="{{ route('exchange') }}"
              class="btn-base btn-primary btn-sm text-[10px] sm:text-xs font-semibold px-2 sm:px-3 py-1 sm:py-1.5 bg-sky-600 hover:bg-sky-700 w-full sm:w-auto text-center justify-center">
              Calculate <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] ml-1"></i>
            </a>
          </div>
        </div>

      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('categories');
      Components.renderFooter();
    });
  </script>
@endpush