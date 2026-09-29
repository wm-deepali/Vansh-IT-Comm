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

      <!-- Blog Cards Grid (3 Columns Desktop / 2 Tablet / 1 Mobile) -->
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16" id="blog-grid-container">
        <!-- Dynamically rendered from BLOG_POSTS -->
      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    const BLOG_DETAIL_URL = "{{ route('blog.detail') }}";

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('blog');
      Components.renderFooter();
      renderBlogPosts();
    });

    function renderBlogPosts() {
      const container = document.getElementById('blog-grid-container');
      container.innerHTML = BLOG_POSTS.map(post => `
        <article class="card-base p-5 flex flex-col justify-between group hover:shadow-lg transition-all duration-300">
          <div>
            <a href="${BLOG_DETAIL_URL}?id=${post.id}" class="block aspect-[16/9] rounded-2xl overflow-hidden mb-4 bg-slate-100">
              <img
                src="${post.image}"
                alt="${post.title}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
              />
            </a>
            <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-400 mb-2">
              <span class="badge bg-blue-50 text-blue-700 text-[10px]">${post.category}</span>
              <span>•</span>
              <span>${post.date}</span>
              <span>•</span>
              <span>${post.readTime}</span>
            </div>
            <h2 class="text-base font-bold text-slate-900 group-hover:text-blue-600 transition-colors font-heading leading-snug mb-2">
              <a href="${BLOG_DETAIL_URL}?id=${post.id}">${post.title}</a>
            </h2>
            <p class="text-xs text-slate-600 font-body leading-relaxed mb-4 line-clamp-3">
              ${post.excerpt}
            </p>
          </div>
          <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
            <a href="${BLOG_DETAIL_URL}?id=${post.id}" class="text-xs font-bold text-blue-600 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
              Read Guide <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
            <button type="button" class="text-slate-400 hover:text-blue-600 cursor-pointer text-xs p-1" onclick="showToast('Article saved to bookmarks!', 'success')" aria-label="Bookmark">
              <i class="fa-regular fa-bookmark"></i>
            </button>
          </div>
        </article>
      `).join('');
    }
  </script>
@endpush