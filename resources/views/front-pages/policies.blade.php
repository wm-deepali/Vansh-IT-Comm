@extends('layouts.app')

@section('title', ($activePage->meta_title ?: $activePage->heading) . ' | VANSH IT & COMM')
@section('meta_description', $activePage->meta_description ?: 'Read our Terms of Service, Privacy Policy, Refunds & Cancellation Policy, Cookies Policy, and Warranty Guidelines.')

@push('styles')
  <style>
    /* Styling for CKEditor content inside each policy tab */
    .policy-content h2,
    .policy-content h3 {
      font-family: 'Manrope', sans-serif;
      font-weight: 700;
      color: #0F172A;
      line-height: 1.4;
      margin: 1.5rem 0 0.6rem;
    }
    .policy-content h2 { font-size: 1.15rem; }
    .policy-content h3 { font-size: 1rem; }
    .policy-content p {
      font-size: 0.875rem;
      line-height: 1.75;
      color: #475569;
      margin-bottom: 1rem;
    }
    .policy-content ul,
    .policy-content ol {
      font-size: 0.85rem;
      line-height: 1.7;
      color: #475569;
      margin: 0 0 1rem 1.25rem;
    }
    .policy-content ul { list-style: disc; }
    .policy-content ol { list-style: decimal; }
    .policy-content li { margin-bottom: 0.35rem; }
    .policy-content strong { color: #0F172A; }
    .policy-content a { color: #2563EB; text-decoration: underline; }
    .policy-content table { width: 100%; border-collapse: collapse; margin: 1rem 0; font-size: 0.85rem; }
    .policy-content th, .policy-content td { padding: 0.65rem 0.85rem; border: 1px solid #E2E8F0; }
  </style>
@endpush

@section('content')

  @php
    // Badge colours rotate by position, so new pages need no code change
    $badgePalette = [
      'bg-blue-50 text-blue-700 border-blue-200',
      'bg-emerald-50 text-emerald-700 border-emerald-200',
      'bg-amber-50 text-amber-700 border-amber-200',
      'bg-purple-50 text-purple-700 border-purple-200',
      'bg-indigo-50 text-indigo-700 border-indigo-200',
      'bg-rose-50 text-rose-700 border-rose-200',
    ];
  @endphp

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold" id="policy-breadcrumb">{{ $activePage->heading }}</span>
      </nav>

      <!-- Hero Header -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-10 border border-slate-800 shadow-xl">
        <div class="max-w-4xl space-y-3">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1 font-bold">LEGAL & TRUST HUB</span>
          <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Terms, Privacy & Store Policies
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            Transparent operating terms for purchases, refurbished device grading, privacy protection, warranty claims, and returns at VANSH IT & COMM.
          </p>
          <div class="text-[11px] text-slate-400 pt-1">
            Last Updated: <span class="text-white font-semibold">{{ $lastUpdated->format('F Y') }}</span> • Effective across all online and in-store transactions.
          </div>
        </div>
      </div>

      <!-- Master Full-Width 2-Column Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16 items-start">

        <!-- Left Column: Sticky Policy Navigation Sidebar -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
          <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200 shadow-sm space-y-2">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 px-3 pt-2 mb-2 font-heading">
              Store Policies Navigation
            </h3>

            <nav class="space-y-1">
              @foreach($pages as $page)
                @php $isActive = $page->page_name === $active; @endphp

                <button
                  type="button"
                  data-tab="{{ $page->page_name }}"
                  data-title="{{ $page->heading }}"
                  onclick="switchPolicyTab('{{ $page->page_name }}')"
                  class="policy-tab-btn w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs transition-all {{ $isActive ? 'bg-blue-600 text-white shadow-sm font-bold' : 'text-slate-700 hover:bg-slate-50 font-semibold' }}"
                >
                  <span class="flex items-center gap-2.5 min-w-0 pr-1">
                    <i class="fa-solid {{ $page->icon ?: 'fa-file-lines' }} policy-tab-icon text-sm w-4 text-center flex-shrink-0 {{ $isActive ? 'text-white' : 'text-slate-400' }}"></i>
                    <span class="truncate whitespace-nowrap">{{ $page->heading }}</span>
                  </span>
                  <i class="fa-solid fa-chevron-right policy-tab-chevron text-[10px] flex-shrink-0 {{ $isActive ? 'opacity-80' : 'opacity-60' }}"></i>
                </button>
              @endforeach

            </nav>
          </div>

          <!-- Customer Support Card in Sidebar -->
          <div class="bg-gradient-to-br from-slate-900 to-blue-950 p-6 rounded-3xl text-white border border-slate-800 shadow-md space-y-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-base">
              <i class="fa-solid fa-headset"></i>
            </div>
            <h4 class="font-extrabold text-sm font-heading text-white">Need Assistance?</h4>
            <p class="text-xs text-slate-300 leading-relaxed font-body">
              Our support team is available Monday – Saturday (10 AM to 8 PM) for any policy or order queries.
            </p>
            <div class="pt-2 space-y-2">
              <a href="tel:+919876543210" class="btn-base btn-primary btn-sm text-xs w-full py-2 justify-center font-bold text-white">
                <i class="fa-solid fa-phone mr-1.5"></i> Call +91 98765 43210
              </a>
              <a href="{{ route('contact') }}" class="btn-base bg-white/10 hover:bg-white/20 text-white btn-sm text-xs w-full py-2 justify-center font-bold transition-colors">
                <i class="fa-solid fa-envelope mr-1.5"></i> Contact Support Desk
              </a>
            </div>
          </div>
        </div>

        <!-- Right Column: Policy Content Container -->
        <div class="lg:col-span-8">
          <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm">

            @foreach($pages as $page)
              <div id="content-{{ $page->page_name }}" class="policy-panel space-y-6 {{ $page->page_name === $active ? '' : 'hidden' }}">
                <div class="border-b border-slate-100 pb-5">
                  <span class="badge {{ $badgePalette[$loop->index % count($badgePalette)] }} border text-xs px-2.5 py-0.5 font-bold mb-2">{{ $page->badge ?: 'POLICY' }}</span>
                  <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">{{ $page->heading }}</h2>
                  @if($page->summary)
                    <p class="text-xs text-slate-500 mt-1">{{ $page->summary }}</p>
                  @endif
                </div>

                <div class="policy-content">
                  {!! $page->content !!}
                </div>
              </div>
            @endforeach

          </div>
        </div>

      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    const ACTIVE_BTN   = ['bg-blue-600', 'text-white', 'shadow-sm', 'font-bold'];
    const INACTIVE_BTN = ['text-slate-700', 'hover:bg-slate-50', 'font-semibold'];

    document.addEventListener('DOMContentLoaded', () => {
      // ?tab=slug is handled by the server; this also supports #slug links
      const hash = window.location.hash.replace('#', '');
      if (hash && document.getElementById(`content-${hash}`)) {
        switchPolicyTab(hash, false);
      }
    });

    function switchPolicyTab(tabKey, updateUrl = true) {
      document.querySelectorAll('.policy-tab-btn').forEach(btn => {
        const isActive = btn.dataset.tab === tabKey;
        const icon = btn.querySelector('.policy-tab-icon');
        const chevron = btn.querySelector('.policy-tab-chevron');

        btn.classList.remove(...ACTIVE_BTN, ...INACTIVE_BTN);
        btn.classList.add(...(isActive ? ACTIVE_BTN : INACTIVE_BTN));

        if (icon) {
          icon.classList.toggle('text-white', isActive);
          icon.classList.toggle('text-slate-400', !isActive);
        }
        if (chevron) {
          chevron.classList.toggle('opacity-80', isActive);
          chevron.classList.toggle('opacity-60', !isActive);
        }

        if (isActive) {
          const breadcrumb = document.getElementById('policy-breadcrumb');
          if (breadcrumb) breadcrumb.textContent = btn.dataset.title;
        }
      });

      document.querySelectorAll('.policy-panel').forEach(panel => {
        panel.classList.toggle('hidden', panel.id !== `content-${tabKey}`);
      });

      if (updateUrl) {
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tabKey);
        url.hash = '';
        window.history.replaceState({}, '', url);
      }
    }
  </script>
@endpush