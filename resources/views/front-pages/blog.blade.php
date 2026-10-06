@extends('layouts.app')

@section('title', 'Tech Insights & Buying Guides | VANSH IT & COMM Blog')
@section('meta_description', 'Expert advice on refurbished laptops, second-hand phone inspection, RAM vs SSD upgrades, and hardware repair tips.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Tech Blog</span>
      </nav>

      <!-- Blog Hero Banner -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-12 border border-slate-800 shadow-xl">
        <div class="max-w-2xl space-y-4">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1 font-bold">EXPERT ADVICE</span>
          <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Tech Guides & Insights
          </h1>
          <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-body">
            In-depth buying guides, hardware comparison benchmarks, pre-owned device inspection checklists, and maintenance advice from our engineering team.
          </p>
        </div>
      </div>

      <!-- Active tag filter -->
      @if(request('tag'))
        <div class="flex items-center gap-3 mb-6 text-sm">
          <span class="text-slate-500">Showing:</span>
          <span class="badge bg-blue-50 text-blue-700 font-bold text-xs px-3 py-1">{{ request('tag') }}</span>
          <a href="{{ route('blog') }}" class="text-xs font-bold text-blue-600 hover:underline">Clear filter</a>
        </div>
      @endif

      <!-- Blog Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10" id="blog-grid-container">
        @forelse($blogs as $post)
          @php $url = route('blog.detail', $post->slug); @endphp
          <article class="card-base p-5 flex flex-col justify-between group hover:shadow-lg transition-all duration-300">
            <div>
              <a href="{{ $url }}" class="block aspect-[16/9] rounded-2xl overflow-hidden mb-4 bg-slate-100">
                <img
                  src="{{ $post->image_url }}"
                  alt="{{ $post->title }}"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                  loading="lazy"
                />
              </a>
              <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-400 mb-2">
                <span class="badge bg-blue-50 text-blue-700 text-[10px]">{{ $post->first_tag }}</span>
                <span>•</span>
                <span>{{ $post->created_at->format('M d, Y') }}</span>
                <span>•</span>
                <span>{{ $post->read_time_minutes }} min read</span>
              </div>
              <h2 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors font-heading leading-snug mb-2">
                <a href="{{ $url }}">{{ $post->title }}</a>
              </h2>
              <p class="text-xs text-slate-600 font-body leading-relaxed mb-4 line-clamp-3">
                {{ $post->short_description }}
              </p>
            </div>
            <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
              <a href="{{ $url }}" class="text-xs font-bold text-blue-600 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
                Read Guide <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </a>
              <button type="button" class="text-slate-400 hover:text-blue-600 cursor-pointer text-xs p-1" onclick="showToast('Article saved to bookmarks!', 'success')" aria-label="Bookmark">
                <i class="fa-regular fa-bookmark"></i>
              </button>
            </div>
          </article>
        @empty
          <p class="col-span-full text-center text-sm text-slate-500 py-12">No articles found.</p>
        @endforelse
      </div>

      <div class="mb-16">
        {{ $blogs->links() }}
      </div>

    </div>
  </main>

@endsection