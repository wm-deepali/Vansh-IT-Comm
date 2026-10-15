@extends('layouts.app')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Frequently Asked Questions</span>
      </nav>

      <!-- Hero Header -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-10 border border-slate-800 shadow-xl">
        <div class="max-w-4xl space-y-3">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1 font-bold">HELP & KNOWLEDGE BASE</span>
          <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Frequently Asked Questions
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            Instant answers regarding our 20-point diagnostic checks, warranty claims, 7-day replacements, GST billing, and pan-India express logistics.
          </p>
        </div>
      </div>

      <!-- Master Full-Width 2-Column Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16 items-start">

        <!-- Left Column: Search & Topic Filter Sidebar -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
          <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm space-y-4">
            <div>
              <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 mb-2 font-heading">
                Search Helpdesk
              </h3>
              <div class="relative">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-3 text-slate-400 text-xs"></i>
                <input
                  type="text"
                  id="faq-search-input"
                  placeholder="Type a keyword (warranty, test, GST)..."
                  class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-blue-600"
                  oninput="setFaqQuery(this.value)"
                />
              </div>
            </div>

            @if($categories->isNotEmpty())
              <div class="pt-2 border-t border-slate-100">
                <h4 class="text-xs font-bold text-slate-800 mb-2 font-heading">Filter by Topic:</h4>
                <div class="space-y-1 text-xs">
                  <button type="button" onclick="setFaqCategory('')" class="faq-cat-btn w-full text-left px-3 py-2 rounded-xl flex items-center justify-between" data-cat="">
                    <span>All Topics</span>
                    <i class="fa-solid fa-check text-[10px] faq-check"></i>
                  </button>
                  @foreach($categories as $key => $label)
                    <button type="button" onclick="setFaqCategory('{{ $key }}')" class="faq-cat-btn w-full text-left px-3 py-2 rounded-xl flex items-center justify-between" data-cat="{{ $key }}">
                      <span>{{ $label }}</span>
                      <i class="fa-solid fa-check text-[10px] faq-check"></i>
                    </button>
                  @endforeach
                </div>
              </div>
            @endif
          </div>

          <!-- Helpdesk Contact Box -->
          <div class="bg-gradient-to-br from-slate-900 to-blue-950 p-6 rounded-3xl text-white border border-slate-800 shadow-md space-y-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-base">
              <i class="fa-solid fa-headset"></i>
            </div>
            <h4 class="font-extrabold text-sm font-heading text-white">Still Have Questions?</h4>
            <p class="text-xs text-slate-300 leading-relaxed font-body">
              Chat directly with our support team or call our customer desk for immediate guidance.
            </p>
            <div class="pt-2">
              <a href="{{ route('contact') }}" class="btn-base btn-primary btn-sm text-xs w-full py-2 justify-center font-bold text-white">
                <i class="fa-solid fa-phone mr-1.5"></i> Contact Support Desk
              </a>
            </div>
          </div>
        </div>

        <!-- Right Column: Accordion List -->
        <div class="lg:col-span-8">
          <div class="space-y-3" id="faq-list-container">
            @foreach($faqs as $faq)
              <div class="faq-item border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm"
                   data-category="{{ $faq->category }}"
                   data-search="{{ strtolower($faq->question . ' ' . strip_tags($faq->answer) . ' ' . ($faq->category ? \App\Models\Faq::CATEGORIES[$faq->category] ?? $faq->category : '')) }}">
                <button
                  type="button"
                  onclick="toggleFaq({{ $faq->id }})"
                  class="w-full flex items-center justify-between p-4 sm:p-5 bg-white hover:bg-slate-50 text-left font-bold text-slate-900 text-xs sm:text-sm transition-colors"
                >
                  <span class="flex items-center gap-2.5">
                    <i class="fa-regular fa-circle-question text-blue-600"></i> {{ $faq->question }}
                  </span>
                  <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform ml-2" id="faq-icon-{{ $faq->id }}"></i>
                </button>
                <div id="faq-ans-{{ $faq->id }}" class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed font-body border-t border-slate-100 pt-3">
                  {!! nl2br(e($faq->answer)) !!}
                </div>
              </div>
            @endforeach
          </div>

          <div id="faq-empty" class="{{ $faqs->isEmpty() ? '' : 'hidden' }} text-center py-12 text-xs text-slate-500 bg-white p-8 rounded-2xl border border-slate-200">
            No FAQs matching your query.
          </div>
        </div>

      </div>
    </div>
  </main>

@endsection

@push('scripts')
  <script>
    let faqQuery = '';
    let faqCategory = '';

    const ACTIVE_CLASSES   = ['bg-blue-50', 'text-blue-600', 'font-bold'];
    const INACTIVE_CLASSES = ['text-slate-600', 'hover:bg-slate-50', 'font-medium'];

    document.addEventListener('DOMContentLoaded', () => {
      updateCategoryButtons();
    });

    function toggleFaq(id) {
      const ans = document.getElementById(`faq-ans-${id}`);
      const icon = document.getElementById(`faq-icon-${id}`);
      if (!ans) return;
      ans.classList.toggle('hidden');
      if (icon) icon.classList.toggle('rotate-180');
    }

    function setFaqQuery(value) {
      faqQuery = (value || '').toLowerCase().trim();
      applyFaqFilters();
    }

    function setFaqCategory(cat) {
      faqCategory = cat;
      updateCategoryButtons();
      applyFaqFilters();
    }

    function applyFaqFilters() {
      let visible = 0;

      document.querySelectorAll('.faq-item').forEach(item => {
        const matchesCat = !faqCategory || item.dataset.category === faqCategory;
        const matchesQuery = !faqQuery || item.dataset.search.includes(faqQuery);
        const show = matchesCat && matchesQuery;
        item.classList.toggle('hidden', !show);
        if (show) visible++;
      });

      document.getElementById('faq-empty').classList.toggle('hidden', visible > 0);
    }

    function updateCategoryButtons() {
      document.querySelectorAll('.faq-cat-btn').forEach(btn => {
        const active = btn.dataset.cat === faqCategory;
        btn.classList.remove(...ACTIVE_CLASSES, ...INACTIVE_CLASSES);
        btn.classList.add(...(active ? ACTIVE_CLASSES : INACTIVE_CLASSES));
        const check = btn.querySelector('.faq-check');
        if (check) check.classList.toggle('hidden', !active);
      });
    }
  </script>
@endpush