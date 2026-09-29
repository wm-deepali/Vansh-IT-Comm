@extends('layouts.app')

@section('title', 'Blog Article | VANSH IT & COMM Tech Insights')
@section('meta_description', 'Read expert tech guides, refurbished hardware buying tips, and device inspection advice from VANSH IT & COMM.')

@push('styles')
  <style>
    /* Reading Progress Bar */
    #reading-progress {
      position: fixed;
      top: 0;
      left: 0;
      height: 3.5px;
      background: linear-gradient(90deg, #2563EB, #38BDF8);
      z-index: 9999;
      width: 0%;
      transition: width 0.1s ease-out;
    }

    /* Blog Typography Content Styling */
    .article-content h2 {
      font-family: 'Manrope', sans-serif;
      font-size: 1.4rem;
      font-weight: 800;
      color: #0F172A;
      margin-top: 2rem;
      margin-bottom: 0.85rem;
      line-height: 1.35;
    }
    .article-content h3 {
      font-family: 'Manrope', sans-serif;
      font-size: 1.15rem;
      font-weight: 700;
      color: #1E293B;
      margin-top: 1.5rem;
      margin-bottom: 0.65rem;
      line-height: 1.4;
    }
    .article-content p {
      font-size: 0.925rem;
      line-height: 1.75;
      color: #334155;
      margin-bottom: 1.25rem;
    }
    .article-content ul, .article-content ol {
      margin-bottom: 1.25rem;
      padding-left: 1.25rem;
      font-size: 0.925rem;
      color: #334155;
    }
    .article-content li {
      margin-bottom: 0.4rem;
      line-height: 1.65;
    }
    .article-content table {
      width: 100%;
      border-collapse: collapse;
      margin: 1.5rem 0;
      font-size: 0.85rem;
    }
    .article-content th, .article-content td {
      padding: 0.75rem 1rem;
      border: 1px solid #E2E8F0;
    }
  </style>
@endpush

@section('content')

  <!-- Reading Progress Bar -->
  <div id="reading-progress"></div>

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb Navigation -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('blog') }}" class="hover:text-blue-600">Tech Blog</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold truncate max-w-xs sm:max-w-md" id="breadcrumb-article-title">Article</span>
      </nav>

      <!-- Main Layout (Article on Left, Sidebar on Right) -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start mb-16">

        <!-- Left: Article Content Area (8 Cols on Desktop) -->
        <article class="lg:col-span-8 bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-8">

          <!-- Article Header -->
          <div class="space-y-4 pb-6 border-b border-slate-100">
            <div class="flex items-center gap-2 flex-wrap">
              <span class="badge bg-blue-50 text-blue-700 font-bold text-xs px-3 py-1" id="article-badge">Buying Guide</span>
              <span class="text-xs text-slate-400">•</span>
              <span class="text-xs text-slate-500" id="article-date">Sep 12, 2026</span>
              <span class="text-xs text-slate-400">•</span>
              <span class="text-xs text-slate-500 flex items-center gap-1" id="article-read-time"><i class="fa-regular fa-clock"></i> 5 min read</span>
            </div>

            <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 font-heading leading-tight tracking-tight" id="article-heading">
              Article Title Loading...
            </h1>

            <!-- Author & Share Row -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pt-2">
              <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full overflow-hidden bg-slate-100 border border-slate-200 flex-shrink-0">
                  <img id="author-img" src="" alt="Author" class="w-full h-full object-cover" />
                </div>
                <div>
                  <h4 class="text-xs font-bold text-slate-900" id="author-name">Author Name</h4>
                  <p class="text-[11px] text-slate-500" id="author-role">Hardware Specialist</p>
                </div>
              </div>

              <!-- Social Share Buttons -->
              <div class="flex items-center gap-2">
                <span class="text-xs text-slate-400 font-semibold mr-1">Share:</span>
                <button type="button" onclick="shareArticle('whatsapp')" class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white flex items-center justify-center transition-colors text-xs" title="Share on WhatsApp">
                  <i class="fa-brands fa-whatsapp"></i>
                </button>
                <button type="button" onclick="shareArticle('twitter')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-700 hover:bg-slate-900 hover:text-white flex items-center justify-center transition-colors text-xs" title="Share on X / Twitter">
                  <i class="fa-brands fa-x-twitter"></i>
                </button>
                <button type="button" onclick="shareArticle('linkedin')" class="w-8 h-8 rounded-full bg-blue-50 text-blue-700 hover:bg-blue-700 hover:text-white flex items-center justify-center transition-colors text-xs" title="Share on LinkedIn">
                  <i class="fa-brands fa-linkedin-in"></i>
                </button>
                <button type="button" onclick="shareArticle('copy')" class="w-8 h-8 rounded-full bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white flex items-center justify-center transition-colors text-xs" title="Copy Link">
                  <i class="fa-solid fa-link"></i>
                </button>
              </div>
            </div>
          </div>

          <!-- Featured Hero Image -->
          <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 shadow-inner">
            <img
              id="article-featured-img"
              src=""
              alt="Featured Image"
              class="w-full h-full object-cover"
            />
          </div>

          <!-- Article HTML Body -->
          <div class="article-content" id="article-body-content">
            <!-- Populated via JavaScript -->
          </div>

          <!-- Author Bio Footer Box -->
          <div class="p-6 rounded-2xl bg-slate-50 border border-slate-200 flex flex-col sm:flex-row items-center sm:items-start gap-4 text-center sm:text-left">
            <div class="w-14 h-14 rounded-2xl overflow-hidden bg-white border border-slate-200 flex-shrink-0">
              <img id="author-bio-img" src="" alt="Author" class="w-full h-full object-cover" />
            </div>
            <div class="space-y-1">
              <h4 class="text-sm font-bold text-slate-900 font-heading" id="author-bio-name">Author Name</h4>
              <p class="text-xs text-blue-600 font-semibold" id="author-bio-role">Hardware Specialist</p>
              <p class="text-xs text-slate-600 leading-relaxed font-body">
                Senior engineering lead at VANSH IT & COMM. Dedicated to rigorous hardware diagnostics, component benchmark verification, and making reliable electronics affordable.
              </p>
            </div>
          </div>

        </article>

        <!-- Right: Sticky Sidebar (4 Cols on Desktop) -->
        <aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">

          <!-- Live Video Call Consultation Box -->
          <div class="p-6 rounded-3xl bg-gradient-to-br from-slate-900 to-blue-950 text-white border border-slate-800 shadow-xl space-y-4">
            <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] font-extrabold uppercase px-2.5 py-0.5">
              Live Video Inspection
            </span>
            <h3 class="text-lg font-bold font-heading text-white leading-snug">Need Help Selecting A Device?</h3>
            <p class="text-xs text-slate-300 leading-relaxed font-body">
              Schedule a 1-on-1 live video call with our hardware technicians to inspect cosmetic grade, battery health, and test benchmarks in real-time.
            </p>
            <div class="pt-2 flex flex-col gap-2">
              <a href="{{ route('shop') }}" class="btn-base btn-primary text-xs py-2.5 justify-center font-bold text-white">
                Browse Tested Inventory <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </a>
              <a href="{{ route('contact') }}" class="btn-base bg-white/10 hover:bg-white/20 text-white text-xs py-2.5 justify-center font-bold transition-colors">
                <i class="fa-brands fa-whatsapp text-emerald-400"></i> Chat on WhatsApp
              </a>
            </div>
          </div>

          <!-- Other Top Articles List -->
          <div class="p-6 bg-white rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider font-heading pb-2 border-b border-slate-100 flex items-center justify-between">
              <span>Trending Guides</span>
              <i class="fa-solid fa-fire text-amber-500"></i>
            </h3>
            <div class="space-y-3" id="sidebar-trending-posts">
              <!-- Dynamically populated -->
            </div>
          </div>

          <!-- Category Quick Badges -->
          <div class="p-6 bg-white rounded-3xl border border-slate-200 shadow-sm space-y-3">
            <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider font-heading pb-2 border-b border-slate-100">
              Popular Topics
            </h3>
            <div class="flex flex-wrap gap-2 text-xs">
              <a href="{{ route('laptops') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-blue-600 font-semibold transition-colors">Refurbished Laptops</a>
              <a href="{{ route('mobile-phones') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-blue-600 font-semibold transition-colors">Smartphones</a>
              <a href="{{ route('about') }}#refurbish-process" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-blue-600 font-semibold transition-colors">20-Point Testing</a>
              <a href="{{ route('warranty') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-blue-600 font-semibold transition-colors">Warranty & Coverage</a>
              <a href="{{ route('repair') }}" class="px-3 py-1.5 rounded-xl bg-slate-100 hover:bg-blue-50 hover:text-blue-600 font-semibold transition-colors">Screen & Battery Repair</a>
            </div>
          </div>

        </aside>

      </div>

      <!-- Related Guides Bottom Section -->
      <section class="mb-12 sm:mb-16">
        <div class="flex items-center justify-between gap-3 mb-6">
          <div class="min-w-0 flex-1">
            <h2 class="text-base sm:text-xl lg:text-2xl font-extrabold text-slate-900 font-heading truncate sm:overflow-visible">Related Articles & Guides</h2>
            <p class="text-[11px] sm:text-xs text-slate-500 mt-0.5 truncate sm:overflow-visible">Explore more practical tech buying and maintenance tips.</p>
          </div>
          <a href="{{ route('blog') }}" class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1 flex-shrink-0 whitespace-nowrap">
            View All <i class="fa-solid fa-arrow-right text-[10px]"></i>
          </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6" id="related-posts-grid">
          <!-- Dynamically populated -->
        </div>
      </section>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    const BLOG_DETAIL_URL = "{{ route('blog.detail') }}";
    const DEFAULT_AUTHOR_AVATAR = "{{ asset('assets/img/product-1588872657578-7efd1f1555ed.jpg') }}";

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('blog');
      Components.renderFooter();
      loadArticleDetails();
      initReadingProgressBar();
    });

    function loadArticleDetails() {
      const urlParams = new URLSearchParams(window.location.search);
      const articleId = urlParams.get('id') || 'blog-01';

      const post = BLOG_POSTS.find(p => p.id === articleId) || BLOG_POSTS[0];

      // Page Title & Meta
      document.title = `${post.title} | VANSH IT & COMM Tech Blog`;
      document.getElementById('breadcrumb-article-title').textContent = post.title;
      document.getElementById('article-heading').textContent = post.title;
      document.getElementById('article-badge').textContent = post.category;
      document.getElementById('article-date').textContent = post.date;
      document.getElementById('article-read-time').innerHTML = `<i class="fa-regular fa-clock"></i> ${post.readTime}`;

      // Images
      const featImg = document.getElementById('article-featured-img');
      featImg.src = post.image;
      featImg.alt = post.title;

      // Author details
      const author = post.author || {
        name: 'Vansh Sharma',
        role: 'Hardware Diagnostic Lead',
        avatar: DEFAULT_AUTHOR_AVATAR
      };

      document.getElementById('author-img').src = author.avatar;
      document.getElementById('author-name').textContent = author.name;
      document.getElementById('author-role').textContent = author.role;
      document.getElementById('author-bio-img').src = author.avatar;
      document.getElementById('author-bio-name').textContent = author.name;
      document.getElementById('author-bio-role').textContent = author.role;

      // Article Content
      document.getElementById('article-body-content').innerHTML = post.content || `<p>${post.excerpt}</p>`;

      // Render Sidebar Trending Posts
      renderSidebarPosts(post.id);

      // Render Related Posts
      renderRelatedPosts(post.id, post.category);
    }

    function renderSidebarPosts(currentId) {
      const container = document.getElementById('sidebar-trending-posts');
      const otherPosts = BLOG_POSTS.filter(p => p.id !== currentId).slice(0, 3);

      container.innerHTML = otherPosts.map(p => `
        <a href="${BLOG_DETAIL_URL}?id=${p.id}" class="flex items-center gap-3 group p-2 rounded-xl hover:bg-slate-50 transition-colors">
          <img src="${p.image}" alt="${p.title}" class="w-14 h-14 object-cover rounded-xl flex-shrink-0 bg-slate-100" />
          <div class="min-w-0">
            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-wider">${p.category}</span>
            <h4 class="text-xs font-bold text-slate-800 group-hover:text-blue-600 transition-colors line-clamp-2 leading-snug">
              ${p.title}
            </h4>
          </div>
        </a>
      `).join('');
    }

    function renderRelatedPosts(currentId, category) {
      const container = document.getElementById('related-posts-grid');
      let related = BLOG_POSTS.filter(p => p.id !== currentId && p.category === category);
      if (related.length < 3) {
        const others = BLOG_POSTS.filter(p => p.id !== currentId && !related.includes(p));
        related = related.concat(others).slice(0, 3);
      }

      container.innerHTML = related.map(p => `
        <article class="card-base p-5 flex flex-col justify-between group">
          <div>
            <div class="aspect-[16/9] rounded-2xl overflow-hidden mb-4 bg-slate-100">
              <img
                src="${p.image}"
                alt="${p.title}"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300"
                loading="lazy"
              />
            </div>
            <div class="flex items-center gap-2 text-[11px] font-semibold text-slate-400 mb-2">
              <span class="badge bg-blue-50 text-blue-700 text-[10px]">${p.category}</span>
              <span>•</span>
              <span>${p.readTime}</span>
            </div>
            <h3 class="text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors font-heading leading-snug mb-2">
              ${p.title}
            </h3>
            <p class="text-xs text-slate-600 font-body leading-relaxed mb-4 line-clamp-2">
              ${p.excerpt}
            </p>
          </div>
          <div class="pt-3 border-t border-slate-100 flex items-center justify-between">
            <a href="${BLOG_DETAIL_URL}?id=${p.id}" class="text-xs font-bold text-blue-600 group-hover:translate-x-1 transition-transform inline-flex items-center gap-1">
              Read Guide <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
          </div>
        </article>
      `).join('');
    }

    function initReadingProgressBar() {
      window.addEventListener('scroll', () => {
        const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
        const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrolled = (winScroll / height) * 100;
        const bar = document.getElementById('reading-progress');
        if (bar) bar.style.width = scrolled + '%';
      });
    }

    function shareArticle(platform) {
      const url = encodeURIComponent(window.location.href);
      const title = encodeURIComponent(document.title);

      if (platform === 'whatsapp') {
        window.open(`https://api.whatsapp.com/send?text=${title}%20${url}`, '_blank');
      } else if (platform === 'twitter') {
        window.open(`https://twitter.com/intent/tweet?text=${title}&url=${url}`, '_blank');
      } else if (platform === 'linkedin') {
        window.open(`https://www.linkedin.com/sharing/share-offsite/?url=${url}`, '_blank');
      } else if (platform === 'copy') {
        navigator.clipboard.writeText(window.location.href).then(() => {
          showToast('Article link copied to clipboard!', 'success');
        });
      }
    }
  </script>
@endpush