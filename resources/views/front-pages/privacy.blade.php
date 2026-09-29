@extends('layouts.app')

@section('title', 'Privacy Policy | VANSH IT & COMM')
@section('meta_description', 'Read how VANSH IT & COMM protects customer privacy, handles data security, and manages transaction information.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('terms') }}" class="hover:text-blue-600">Legal</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Privacy Policy</span>
      </nav>

      <!-- Hero Header -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-10 border border-slate-800 shadow-xl">
        <div class="max-w-4xl space-y-3">
          <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-xs px-3 py-1 font-bold">DATA PROTECTION</span>
          <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Privacy Policy & Data Security
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            We value your trust. Learn how your data is safely gathered, stored, and used to complete orders, facilitate warranty claims, and secure live inspections.
          </p>
          <div class="text-[11px] text-slate-400 pt-1">
            Last Updated: <span class="text-white font-semibold">September 2026</span> • 100% IT Act Compliant.
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

              <a href="{{ route('privacy') }}" class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-bold transition-all bg-blue-600 text-white shadow-sm">
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-user-shield text-sm w-4 text-center text-white flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Privacy & Data Security</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-80 flex-shrink-0"></i>
              </a>

              <a href="{{ route('returns') }}" class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all">
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-rotate-left text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">7-Day Replacement Policy</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
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
              <i class="fa-solid fa-lock"></i>
            </div>
            <h4 class="font-extrabold text-sm font-heading text-white">Data Privacy Desk</h4>
            <p class="text-xs text-slate-300 leading-relaxed font-body">
              Have questions regarding data collection or request account information removal?
            </p>
            <div class="pt-2">
              <a href="{{ route('contact') }}" class="btn-base btn-primary btn-sm text-xs w-full py-2 justify-center font-bold text-white">
                <i class="fa-solid fa-envelope mr-1.5"></i> Contact Data Desk
              </a>
            </div>
          </div>
        </div>

        <!-- Right Main Content -->
        <div class="lg:col-span-8">
          <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-8">
            <div class="space-y-4 text-xs sm:text-sm text-slate-700 leading-relaxed font-body">
              <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">1. Commitment to Customer Privacy</h2>
                <p class="text-xs text-slate-500 mt-1">Our fundamental pledge to customer transparency and security.</p>
              </div>
              <p>
                At <strong>VANSH IT & COMM</strong>, we are committed to upholding transparency and safeguarding your personal information. This Privacy Policy details the types of personal data we gather through our website, in-store counters, and video consultation services.
              </p>

              <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading">2. Information We Collect</h3>
                <p class="text-slate-600 text-xs sm:text-sm">We collect the following personal identifiers when you interact with our platform:</p>
                <ul class="list-disc list-inside space-y-1.5 text-slate-600 pl-2 text-xs">
                  <li><strong>Contact Details:</strong> Customer Name, Phone Number, WhatsApp Number, Shipping & Billing Address.</li>
                  <li><strong>Transaction Records:</strong> Purchased device specifications, serial numbers, invoice amounts, and date of purchase.</li>
                  <li><strong>Technical Diagnostics:</strong> Device logs, model serials, and test benchmarks when you book a repair or device exchange inspection.</li>
                </ul>
              </div>

              <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading">3. How Your Information Is Used</h3>
                <ul class="list-disc list-inside space-y-1.5 text-slate-600 pl-2 text-xs">
                  <li>Fulfill order dispatches, generate GST tax invoices, and provide tracking links.</li>
                  <li>Schedule 1-on-1 video call product inspections via WhatsApp Video, Google Meet, or Zoom.</li>
                  <li>Track and service warranty claims within the 3–12 month coverage timeframe.</li>
                  <li>Prevent fraud and ensure verified hardware deliveries.</li>
                </ul>
              </div>

              <div class="p-5 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading">4. Payment & Data Security</h3>
                <p class="text-slate-600 text-xs sm:text-sm">
                  Online payments (UPI, NetBanking, Cards) are securely routed through PCI-DSS certified Indian payment gateways. VANSH IT & COMM does not hold or store sensitive banking PINs or CVV credentials.
                </p>
              </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4 text-xs text-slate-500">
              <span>Other Policies: <a href="{{ route('terms', ['tab' => 'terms']) }}" class="text-blue-600 font-semibold hover:underline">Terms & Conditions</a> • <a href="{{ route('returns') }}" class="text-blue-600 font-semibold hover:underline">Refunds Policy</a> • <a href="{{ route('warranty') }}" class="text-blue-600 font-semibold hover:underline">Warranty Terms</a></span>
              <a href="{{ route('terms') }}" class="btn-base btn-secondary btn-sm py-1.5 px-3 text-xs">All Legal Policies</a>
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