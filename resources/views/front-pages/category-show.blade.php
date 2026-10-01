@extends('layouts.app')

@section('title', ($category->meta_title ?? $category->name) . ' | VANSH IT & COMM')
@section('meta_description', $category->meta_description ?? $category->sub_title ?? 'Buy certified products with warranty and pan-India delivery.')

@section('content')

  @php
    $pillBase = 'pill-btn px-3 py-1.5 rounded-full font-semibold flex-shrink-0';
    $pillOn   = 'bg-blue-600 text-white';
    $pillOff  = 'bg-slate-800 hover:bg-slate-700 text-slate-200 border border-slate-700';
    $pillUrl  = fn ($tag) => route('category.show', ['slug' => $category->slug, 'tag' => $tag, 'sort' => $sort !== 'featured' ? $sort : null]);
  @endphp

  <main class="flex-grow py-6 sm:py-8">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-3" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('categories') }}" class="hover:text-blue-600">Categories</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">{{ $category->name }}</span>
      </nav>

      <!-- Category Hero Banner -->
      <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-6 lg:p-8 mb-6 sm:mb-8 border border-slate-800 shadow-md">
        <div class="max-w-2xl space-y-2">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] sm:text-xs px-2.5 py-0.5">20-POINT CERTIFIED</span>
          <h1 class="text-xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight font-heading">
            {{ $category->name }}
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            {{ $category->sub_title ?: 'Certified products tested with genuine accessories and up to 12-Month Warranty.' }}
          </p>
        </div>

        <!-- Quick Filter Pills -->
        <div class="flex items-center gap-2 mt-5 overflow-x-auto no-scrollbar pb-1 text-xs">
          <a href="{{ $pillUrl('all') }}" class="{{ $pillBase }} {{ $activeTag === 'all' ? $pillOn : $pillOff }}">All {{ $category->name }}</a>

          <a href="{{ $pillUrl('under15k') }}"
            class="{{ $pillBase }} {{ $activeTag === 'under15k' ? $pillOn : 'bg-slate-800 hover:bg-slate-700 text-emerald-400 border border-slate-700' }}">Under ₹15,000</a>

          <a href="{{ $pillUrl('under25k') }}" class="{{ $pillBase }} {{ $activeTag === 'under25k' ? $pillOn : $pillOff }}">₹15K – ₹25K</a>

          @foreach($category->children as $child)
            <a href="{{ $pillUrl($child->slug) }}" class="{{ $pillBase }} {{ $activeTag === $child->slug ? $pillOn : $pillOff }}">{{ $child->name }}</a>
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
            <option value="featured"   @selected($sort === 'featured')>Featured First</option>
            <option value="price-asc"  @selected($sort === 'price-asc')>Price: Low to High</option>
            <option value="price-desc" @selected($sort === 'price-desc')>Price: High to Low</option>
            <option value="rating"     @selected($sort === 'rating')>Top Rated</option>
          </select>
        </form>
      </div>

      <!-- 4 Columns Desktop / 2 Mobile -->
      <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-6">
        @forelse($products as $product)
          @include('partials.product-card', ['product' => $product])
        @empty
          <div class="col-span-full text-center py-16 px-4 bg-white rounded-2xl border border-slate-200">
            <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
              <i class="fa-solid fa-box-open"></i>
            </div>
            <h3 class="text-lg font-bold text-slate-800 mb-1">No products found</h3>
            <p class="text-slate-500 text-sm max-w-sm mx-auto mb-6">Try adjusting your filters or search keywords to find what you're looking for.</p>
            <a href="{{ route('category.show', $category->slug) }}" class="btn-base btn-secondary btn-sm">Reset Filters</a>
          </div>
        @endforelse
      </div>

      <div class="mt-8">{{ $products->links() }}</div>

    </div>
  </main>

  <!-- Quick View Modal -->
  <div id="qv-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4" onclick="if(event.target===this) QuickView.close()">
    <div id="qv-content" class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto"></div>
  </div>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('categories');
      Components.renderFooter();
    });

    const QuickView = {
      esc(s) {
        return String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
      },

      stars(rating) {
        const full = Math.floor(rating);
        const half = rating % 1 >= 0.5;
        let html = '<div class="flex items-center text-amber-400 text-[9px] sm:text-xs gap-0.5">';
        for (let i = 0; i < 5; i++) {
          if (i < full) html += '<i class="fa-solid fa-star"></i>';
          else if (i === full && half) html += '<i class="fa-solid fa-star-half-stroke"></i>';
          else html += '<i class="fa-regular fa-star text-slate-300"></i>';
        }
        html += `<span class="text-slate-500 font-bold ml-1 text-[9px] sm:text-xs">${Number(rating).toFixed(1)}</span></div>`;
        return html;
      },

      open(id) {
        const card = document.querySelector(`.product-card[data-product-id="${id}"]`);
        if (!card) return;
        const p = JSON.parse(card.dataset.quickview);
        const e = this.esc.bind(this);

        const specs = (p.specs || []).map(s => `
          <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 truncate">
            <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">${e(s[0])}</span>
            <strong class="text-xs font-bold text-slate-800 truncate block">${e(s[1])}</strong>
          </div>`).join('');

        document.getElementById('qv-content').innerHTML = `
          <div class="p-6">
            <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
              <div class="flex items-center gap-2">
                <span class="badge ${e(p.badgeClass)}">${e(p.badge)}</span>
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider bg-slate-100 px-2 py-0.5 rounded">${e(p.brand)}</span>
              </div>
              <button type="button" onclick="QuickView.close()" class="text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center transition-colors text-lg" aria-label="Close">
                <i class="fa-solid fa-xmark"></i>
              </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
              <div class="bg-slate-50 rounded-2xl p-6 flex items-center justify-center border border-slate-100 min-h-[260px]">
                <img src="${e(p.image)}" alt="${e(p.name)}" class="max-h-56 max-w-full object-contain"
                  onerror="this.onerror=null; this.src='${e(p.fallback)}';" />
              </div>

              <div class="flex flex-col justify-between">
                <div>
                  <h2 class="font-extrabold text-slate-900 text-xl font-heading leading-snug mb-2">${e(p.name)}</h2>
                  <div class="mb-3">${this.stars(p.rating)}</div>

                  <div class="flex items-baseline gap-3 mb-4 flex-wrap">
                    <span class="text-2xl font-black text-slate-900 font-heading">${e(p.price)}</span>
                    ${p.mrp ? `<span class="text-sm text-slate-400 line-through">${e(p.mrp)}</span>` : ''}
                    ${p.discount ? `<span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded">${e(p.discount)}% OFF</span>` : ''}
                  </div>

                  <p class="text-xs text-slate-600 mb-4 line-clamp-3 leading-relaxed">${e(p.description)}</p>

                  <div class="grid grid-cols-2 gap-2 text-xs text-slate-700 mb-5">
                    ${specs}
                    <div class="col-span-2 p-2 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 font-semibold text-xs flex items-center gap-1.5">
                      <i class="fa-solid fa-shield-halved"></i>${e(p.warranty)}
                    </div>
                  </div>
                </div>

                <div class="flex items-center gap-3">
                  <button type="button" data-add-to-cart="${e(p.id)}" onclick="QuickView.close()"
                    class="btn-base btn-primary flex-1 py-2.5 font-bold text-xs shadow-md shadow-blue-600/20">
                    <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                  </button>
                  <a href="${e(p.url)}" class="btn-base btn-secondary px-4 py-2.5 font-bold text-xs">
                    Full Specs <i class="fa-solid fa-arrow-right text-[10px]"></i>
                  </a>
                </div>
              </div>
            </div>
          </div>
        `;

        const modal = document.getElementById('qv-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
      },

      close() {
        const modal = document.getElementById('qv-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
      }
    };

    document.addEventListener('keydown', ev => { if (ev.key === 'Escape') QuickView.close(); });
  </script>
@endpush