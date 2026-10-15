@extends('layouts.app')

@section('title', $category->name . ' | VANSH IT & COMM')
@section('meta_description', $category->sub_title ?: 'Buy certified ' . $category->name . ' with up to 12-month warranty at VANSH IT & COMM.')

@section('content')

@php
  $pillBase = 'pill-btn px-3 py-1.5 rounded-full font-semibold flex-shrink-0';
  $pillOn = 'bg-blue-600 text-white';
  $pillOff = 'bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700';
  $pillUrl = fn($tag) => route('category.show', ['slug' => $category->slug, 'tag' => $tag, 'sort' => $sort !== 'featured' ? $sort : null]);
@endphp

@php
  $categorySchema = [
    '@context' => 'https://schema.org',
    '@type' => 'CollectionPage',
    'name' => $category->name,
    'description' => $category->sub_title,
    'url' => route('category.show', $category->slug),
    'mainEntity' => [
      '@type' => 'ItemList',
      'numberOfItems' => $products->total(),
      'itemListElement' => $products->getCollection()->values()->map(fn($p, $i) => [
        '@type' => 'ListItem',
        'position' => ($products->firstItem() ?? 1) + $i,
        'url' => route('product.show', $p->slug),
        'name' => $p->name,
      ])->all(),
    ],
  ];
@endphp

@section('og_image', data_get($category, 'image') ? asset('storage/' . $category->image) : '')

  @push('schema')
    @include('partials.json-ld', ['data' => $categorySchema])
  @endpush

  <main class="flex-grow py-6 sm:py-8">
    <div class="container-custom">

      <!-- Breadcrumb -->
      @include('partials.breadcrumbs', [
        'class' => 'mb-3',
        'crumbs' => [
          ['name' => 'Home', 'url' => route('home')],
          ['name' => 'Categories', 'url' => route('categories')],
          ['name' => $category->name, 'url' => route('category.show', $category->slug)],
        ]
      ])

      <!-- Category Hero Banner -->
      <div
        class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 border border-slate-800 shadow-md">
        <div class="max-w-2xl space-y-2">
          <span
            class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] sm:text-xs px-2.5 py-0.5">20-POINT
            CERTIFIED</span>
          <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight font-heading">
            {{ $category->name }}
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            {{ $category->sub_title ?: 'Certified products tested with genuine accessories and up to 12-Month Warranty.' }}
          </p>
        </div>

        <!-- Quick Filter Pills -->
        <div class="flex items-center gap-2 mt-5 overflow-x-auto no-scrollbar pb-1 text-xs">
          <a href="{{ $pillUrl('all') }}" class="{{ $pillBase }} {{ $activeTag === 'all' ? $pillOn : $pillOff }}">All
            {{ $category->name }}</a>

          <a href="{{ $pillUrl('under15k') }}"
            class="{{ $pillBase }} {{ $activeTag === 'under15k' ? $pillOn : 'bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-slate-700' }}">Under
            ₹15,000</a>

          <a href="{{ $pillUrl('under25k') }}"
            class="{{ $pillBase }} {{ $activeTag === 'under25k' ? $pillOn : $pillOff }}">₹15K – ₹25K</a>

          @foreach($category->children as $child)
            <a href="{{ $pillUrl($child->slug) }}"
              class="{{ $pillBase }} {{ $activeTag === $child->slug ? $pillOn : $pillOff }}">{{ $child->name }}</a>
          @endforeach
        </div>
      </div>

      <!-- Products Grid & Sort Header -->
      <div class="flex items-center justify-between bg-white p-3.5 rounded-xl border border-slate-200 mb-6 text-xs">
        <span class="text-slate-700 font-semibold">Showing {{ $products->total() }} {{ $category->name }}</span>
        <form method="GET" action="{{ route('category.show', $category->slug) }}" class="flex items-center gap-2">
          @if($activeTag !== 'all') <input type="hidden" name="tag" value="{{ $activeTag }}"> @endif
          <label for="sort" class="text-slate-500 font-medium hidden sm:inline">Sort by:</label>
          <select id="sort" name="sort" onchange="this.form.submit()"
            class="bg-slate-50 border border-slate-200 rounded-lg px-2.5 py-1.5 text-xs font-semibold focus:outline-none focus:border-blue-600">
            <option value="featured" @selected($sort === 'featured')>Featured First</option>
            <option value="price-asc" @selected($sort === 'price-asc')>Price: Low to High</option>
            <option value="price-desc" @selected($sort === 'price-desc')>Price: High to Low</option>
            <option value="rating" @selected($sort === 'rating')>Top Rated</option>
          </select>
        </form>
      </div>

      <!-- 4 Columns Desktop / 2 Mobile -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
        @forelse($products as $product)
          @include('partials.product-card', ['product' => $product])
        @empty
          <div class="col-span-full text-center py-16 px-4 bg-white rounded-2xl border border-slate-200">
            <div
              class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
              <i class="fa-solid fa-box-open"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">No products found</h3>
            <p class="text-slate-500 text-sm max-w-sm mx-auto mb-6">Try adjusting your filters or search keywords to find
              what you're looking for.</p>
            <a href="{{ route('category.show', $category->slug) }}" class="btn-base btn-secondary btn-sm">Reset Filters</a>
          </div>
        @endforelse
      </div>

      <div class="mt-8">{{ $products->links() }}</div>

    </div>
  </main>

  @include('partials.quick-view')

@endsection

@push('scripts')
  @include('partials.cart-helpers')
  @include('partials.cart-js')
  @include('partials.wishlist-js')
@endpush