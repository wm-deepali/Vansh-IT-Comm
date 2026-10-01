@extends('layouts.app')

@section('title', 'All Categories — Laptops, Mobiles, Accessories & Repair | VANSH IT & COMM')
@section('meta_description', 'Browse all electronics categories at VANSH IT & COMM: Refurbished & new laptops, certified smartphones, computer accessories, repairs, and trade-ins.')

@section('content')

  @php
    // ⚠️ Change route name / param here if yours is different (only place)
    $categoryUrl = fn ($c, array $query = []) => route('category.show', ['slug' => $c->slug] + $query);

    // Card colour themes, cycled per category
    $themes = [
      ['border' => 'hover:border-blue-500',   'badge' => 'bg-blue-600',   'icon' => 'bg-blue-50 text-blue-600',     'title' => 'group-hover:text-blue-600',   'chip' => 'hover:bg-blue-50 hover:text-blue-600',     'btn' => ''],
      ['border' => 'hover:border-purple-500', 'badge' => 'bg-purple-600', 'icon' => 'bg-purple-50 text-purple-600', 'title' => 'group-hover:text-purple-600', 'chip' => 'hover:bg-purple-50 hover:text-purple-600', 'btn' => 'bg-purple-600 hover:bg-purple-700'],
      ['border' => 'hover:border-indigo-500', 'badge' => 'bg-indigo-600', 'icon' => 'bg-indigo-50 text-indigo-600', 'title' => 'group-hover:text-indigo-600', 'chip' => 'hover:bg-indigo-50 hover:text-indigo-600', 'btn' => 'bg-indigo-600 hover:bg-indigo-700'],
    ];

    $fallbackImg = asset('assets/img/product-1588872657578-7efd1f1555ed.jpg');
  @endphp

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
              <i class="fa-solid fa-cart-shopping mr-1 sm:mr-1.5"></i> All Products
              @if(($totalProducts ?? 0) > 0)
                <span class="hidden sm:inline">({{ $totalProducts }})</span>
              @endif
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

        @foreach($categories as $cat)
          @php
            $t        = $themes[$loop->index % count($themes)];
            $stats    = $categoryStats[$cat->id] ?? ['count' => 0, 'min' => null, 'brands' => collect()];
            $count    = $stats['count'];
            $minPrice = $stats['min'];
            $brands   = $stats['brands'];
          @endphp

          <div class="card-base p-2.5 sm:p-4 flex flex-col justify-between group {{ $t['border'] }} hover:shadow-lg transition-all duration-300">
            <div>
              <div class="aspect-[16/10] rounded-lg sm:rounded-xl overflow-hidden bg-slate-100 mb-2 sm:mb-3.5 relative">
                <a href="{{ $categoryUrl($cat) }}" class="block w-full h-full">
                  <img src="{{ $cat->image_url ?? $fallbackImg }}" alt="{{ $cat->name }}" loading="lazy"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
                </a>

                
                {{-- Minimum product price of this category --}}
                @if($minPrice !== null)
                  <span
                    class="absolute bottom-1.5 right-1.5 bg-slate-900/90 backdrop-blur-sm text-white text-[9px] sm:text-[11px] font-bold px-1.5 sm:px-2 py-0.5 rounded border border-white/20 leading-none pointer-events-none">
                    From ₹{{ number_format($minPrice) }}
                  </span>
                @endif
              </div>

              <div class="flex items-center gap-1.5 sm:gap-2 mb-1 sm:mb-1.5">
                <div class="w-5 h-5 sm:w-7 sm:h-7 rounded-md sm:rounded-lg {{ $t['icon'] }} flex items-center justify-center text-[10px] sm:text-xs flex-shrink-0">
                  <i class="fa-solid {{ $cat->icon ?: 'fa-tag' }}"></i>
                </div>
                <h2
                  class="text-xs sm:text-base lg:text-lg font-bold sm:font-extrabold text-slate-900 font-heading {{ $t['title'] }} transition-colors truncate">
                  <a href="{{ $categoryUrl($cat) }}">{{ $cat->name }}</a>
                </h2>
              </div>

              @if($cat->sub_title)
                <p class="text-[10px] sm:text-xs text-slate-600 leading-tight sm:leading-relaxed mb-2 sm:mb-3 line-clamp-2">
                  {{ $cat->sub_title }}
                </p>
              @endif

              {{-- Chips: brands linked to this category → category page --}}
              @if($brands->isNotEmpty())
                <div class="flex flex-wrap gap-1 mb-2.5 sm:mb-4 text-[9px] sm:text-[10.5px] font-medium sm:font-semibold">
                  @foreach($brands as $brand)
                    <a href="{{ $categoryUrl($cat, ['brand' => $brand->id]) }}"
                      class="px-1.5 sm:px-2 py-0.5 rounded bg-slate-100 {{ $t['chip'] }} text-slate-700 transition-colors">{{ $brand->name }}</a>
                  @endforeach
                </div>
              @endif
            </div>

            <div class="pt-2 sm:pt-3 border-t border-slate-100 flex items-center justify-between gap-1">
              {{-- Footer: product count --}}
              <span class="text-[9px] sm:text-[11px] font-bold text-slate-500 hidden sm:inline">
                {{ $count }} {{ \Illuminate\Support\Str::plural('Product', $count) }}
              </span>
              <a href="{{ $categoryUrl($cat) }}"
                class="btn-base btn-primary btn-sm text-[10px] sm:text-xs font-semibold px-2 sm:px-3 py-1 sm:py-1.5 {{ $t['btn'] }} w-full sm:w-auto text-center justify-center">
                Browse <span class="hidden sm:inline">{{ $cat->name }}</span> <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px] ml-1"></i>
              </a>
            </div>
          </div>
        @endforeach

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