@extends('layouts.app')

@section('title', 'Returns & Replacement Policy | VANSH IT & COMM')
@section('meta_description', 'Read about our 7-day replacement window, return conditions, and refund process.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('terms') }}" class="hover:text-blue-600">Legal</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">7-Day Replacement Policy</span>
      </nav>

      <!-- Hero Header -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-10 border border-slate-800 shadow-xl">
        <div class="max-w-4xl space-y-3">
          <span class="badge bg-amber-500/20 text-amber-300 border border-amber-400/30 text-xs px-3 py-1 font-bold">100% PEACE OF MIND</span>
          <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
            7-Day Replacement & Returns Policy
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            7-day doorstep replacement window for any hardware defects, transit issues, or performance discrepancies.
          </p>
          <div class="text-[11px] text-slate-400 pt-1">
            Last Updated: <span class="text-white font-semibold">September 2026</span> • Valid across all pre-owned & refurbished hardware.
          </div>
        </div>
      </div>

      <!-- Master Full-Width 2-Column Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 mb-16 items-start">

        <!-- Left Sidebar Navigation -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-28">
          <div class="bg-white p-4 sm:p-5 rounded-3xl border border-slate-200 shadow-sm space-y-2">
            <h3 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 px-3 pt-2 mb-2 font-heading">
              Store Policies
            </h3>
            <nav class="space-y-1">
              <a href="{{ route('terms', ['tab' => 'terms']) }}" class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all">
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-file-contract text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Terms & Conditions</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </a>

              <a href="{{ route('privacy') }}" class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all">
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-user-shield text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Privacy & Data Security</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </a>

              <a href="{{ route('returns') }}" class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-bold transition-all bg-blue-600 text-white shadow-sm">
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-rotate-left text-sm w-4 text-center text-white flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">7-Day Replacement Policy</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-80 flex-shrink-0"></i>
              </a>

              <a href="{{ route('shipping') }}" class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all">
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-truck-fast text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Shipping & Logistics Policy</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </a>

              <a href="{{ route('terms', ['tab' => 'cookies']) }}" class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all">
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-cookie-bite text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Cookies Policy</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </a>

              <a href="{{ route('warranty') }}" class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all">
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-shield-halved text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Warranty Guidelines</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </a>
            </nav>
          </div>

          <!-- Customer Support Card -->
          <div class="bg-gradient-to-br from-slate-900 to-blue-950 p-6 rounded-3xl text-white border border-slate-800 shadow-md space-y-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-base">
              <i class="fa-solid fa-box-open"></i>
            </div>
            <h4 class="font-extrabold text-sm font-heading text-white">Need to Initiate a Return?</h4>
            <p class="text-xs text-slate-300 leading-relaxed font-body">
              Our claims team will assist you with doorstep reverse pickup and replacement testing.
            </p>
            <div class="pt-2">
              <a href="{{ route('contact') }}" class="btn-base btn-primary btn-sm text-xs w-full py-2 justify-center font-bold text-white">
                <i class="fa-solid fa-headset mr-1.5"></i> Request Replacement
              </a>
            </div>
          </div>
        </div>

        <!-- Right Main Content -->
        <div class="lg:col-span-8">
          <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-8">
            <div class="space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed font-body">
              <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">7-Day Replacement Guidelines</h2>
                <p class="text-xs text-slate-500 mt-1">Our commitment to ensuring 100% satisfaction with your device.</p>
              </div>

              <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 space-y-3">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                  <i class="fa-solid fa-clipboard-check text-blue-600"></i> Requirements for Return & Replacement:
                </h3>
                <div class="space-y-2 text-xs text-slate-700">
                  <div class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-slate-200">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                    <span>Item must include all original supplied accessories (charger, power cord, invoice).</span>
                  </div>
                  <div class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-slate-200">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                    <span>Device security serial tags must be intact without physical tampering.</span>
                  </div>
                  <div class="flex items-center gap-2 p-2.5 rounded-xl bg-white border border-slate-200">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm"></i>
                    <span>Unboxing video is strongly recommended for damaged package transit claims.</span>
                  </div>
                </div>
              </div>

              <div class="space-y-3">
                <h3 class="text-base font-bold text-slate-900 font-heading">7-Day Window vs Long-Term Warranty</h3>
                <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                  Within the first 7 calendar days after delivery, verified issues qualify for a <strong>direct replacement unit</strong>. After 7 days, your product is fully protected under our comprehensive <strong>6 to 12 Month Repair Warranty</strong>, where internal component diagnostics, parts replacements, and repairs are performed free of charge.
                </p>
              </div>

              <div class="p-5 bg-emerald-50/60 rounded-2xl border border-emerald-200 text-xs text-emerald-900 space-y-1">
                <div class="font-bold flex items-center gap-2"><i class="fa-solid fa-shield-halved text-emerald-600"></i> 100% Tax Invoiced Guarantee</div>
                <p class="text-emerald-800">All replacements and warranty claims are backed by your original GST tax invoice.</p>
              </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4 text-xs text-slate-500">
              <span>Other Policies: <a href="{{ route('terms', ['tab' => 'terms']) }}" class="text-blue-600 font-semibold hover:underline">Terms & Conditions</a> • <a href="{{ route('shipping') }}" class="text-blue-600 font-semibold hover:underline">Shipping Policy</a> • <a href="{{ route('warranty') }}" class="text-blue-600 font-semibold hover:underline">Warranty Terms</a></span>
              <a href="{{ route('terms') }}" class="btn-base btn-secondary btn-sm py-1.5 px-3 text-xs">All Store Policies</a>
            </div>
          </div>
        </div>

      </div>
    </div>
  </main>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader();
      Components.renderFooter();
    });
  </script>
@endpush