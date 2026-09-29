@extends('layouts.app')

@section('title', 'Frequently Asked Questions (FAQ) | VANSH IT & COMM')
@section('meta_description', 'Answers to common questions regarding refurbished device testing, warranty, returns, invoices, and repairs.')

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
                  oninput="filterFaqs(this.value)"
                />
              </div>
            </div>

            <div class="pt-2 border-t border-slate-100">
              <h4 class="text-xs font-bold text-slate-800 mb-2 font-heading">Filter by Topic:</h4>
              <div class="space-y-1 text-xs">
                <button type="button" onclick="filterFaqCategory('')" class="w-full text-left px-3 py-2 rounded-xl bg-blue-50 text-blue-600 font-bold flex items-center justify-between faq-cat-btn" data-cat="">
                  <span>All Topics</span>
                  <i class="fa-solid fa-check text-[10px]"></i>
                </button>
                <button type="button" onclick="filterFaqCategory('Warranty')" class="w-full text-left px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50 font-medium flex items-center justify-between faq-cat-btn" data-cat="Warranty">
                  <span>Warranty & Claims</span>
                </button>
                <button type="button" onclick="filterFaqCategory('Testing')" class="w-full text-left px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50 font-medium flex items-center justify-between faq-cat-btn" data-cat="Testing">
                  <span>20-Point QC Testing</span>
                </button>
                <button type="button" onclick="filterFaqCategory('Shipping')" class="w-full text-left px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50 font-medium flex items-center justify-between faq-cat-btn" data-cat="Shipping">
                  <span>Shipping & Returns</span>
                </button>
                <button type="button" onclick="filterFaqCategory('Payments')" class="w-full text-left px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50 font-medium flex items-center justify-between faq-cat-btn" data-cat="Payments">
                  <span>GST Billing & Payments</span>
                </button>
              </div>
            </div>
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
          <div class="space-y-3" id="faq-list-container"></div>
        </div>

      </div>
    </div>
  </main>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('faq');
      Components.renderFooter();
      renderAllFaqs(FAQS_DATA);
    });

    function renderAllFaqs(faqs) {
      const container = document.getElementById('faq-list-container');
      if (faqs.length === 0) {
        container.innerHTML = `
          <div class="text-center py-12 text-xs text-slate-500 bg-white p-8 rounded-2xl border border-slate-200">
            No FAQs matching your query.
          </div>
        `;
        return;
      }

      container.innerHTML = faqs.map((f, idx) => `
        <div class="border border-slate-200 rounded-2xl bg-white overflow-hidden shadow-sm">
          <button
            type="button"
            onclick="toggleFaq(${idx})"
            class="w-full flex items-center justify-between p-4 sm:p-5 bg-white hover:bg-slate-50 text-left font-bold text-slate-900 text-xs sm:text-sm transition-colors"
          >
            <span class="flex items-center gap-2.5">
              <i class="fa-regular fa-circle-question text-blue-600"></i> ${f.question}
            </span>
            <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform ml-2" id="faq-icon-${idx}"></i>
          </button>
          <div id="faq-ans-${idx}" class="hidden px-5 pb-5 text-xs text-slate-600 leading-relaxed font-body border-t border-slate-100 pt-3">
            ${f.answer}
          </div>
        </div>
      `).join('');
    }

    function toggleFaq(idx) {
      const ans = document.getElementById(`faq-ans-${idx}`);
      const icon = document.getElementById(`faq-icon-${idx}`);
      if (!ans) return;
      ans.classList.toggle('hidden');
      if (icon) icon.classList.toggle('rotate-180');
    }

    function filterFaqs(query) {
      const q = (query || '').toLowerCase().trim();
      const filtered = FAQS_DATA.filter(f =>
        f.question.toLowerCase().includes(q) ||
        f.answer.toLowerCase().includes(q) ||
        f.category.toLowerCase().includes(q)
      );
      renderAllFaqs(filtered);
    }

    function filterFaqCategory(cat) {
      document.querySelectorAll('.faq-cat-btn').forEach(btn => {
        if (btn.getAttribute('data-cat') === cat) {
          btn.className = 'w-full text-left px-3 py-2 rounded-xl bg-blue-50 text-blue-600 font-bold flex items-center justify-between faq-cat-btn';
          btn.innerHTML = `<span>${btn.querySelector('span').innerText}</span> <i class="fa-solid fa-check text-[10px]"></i>`;
        } else {
          btn.className = 'w-full text-left px-3 py-2 rounded-xl text-slate-600 hover:bg-slate-50 font-medium flex items-center justify-between faq-cat-btn';
          btn.innerHTML = `<span>${btn.querySelector('span').innerText}</span>`;
        }
      });

      if (!cat) {
        renderAllFaqs(FAQS_DATA);
      } else {
        const filtered = FAQS_DATA.filter(f => f.category.toLowerCase() === cat.toLowerCase());
        renderAllFaqs(filtered);
      }
    }
  </script>
@endpush