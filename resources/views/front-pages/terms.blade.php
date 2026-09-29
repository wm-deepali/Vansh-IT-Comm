@extends('layouts.app')

@section('title', 'Legal & Store Policies | VANSH IT & COMM')
@section('meta_description', 'Read our Terms of Service, Privacy Policy, Refunds & Cancellation Policy, Cookies Policy, and Warranty Guidelines.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold" id="policy-breadcrumb">Terms & Conditions</span>
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
            Last Updated: <span class="text-white font-semibold">September 2026</span> • Effective across all online and in-store transactions.
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
              <button
                type="button"
                onclick="switchPolicyTab('terms')"
                id="tab-btn-terms"
                class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-bold transition-all bg-blue-600 text-white shadow-sm"
              >
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-file-contract text-sm w-4 text-center text-white flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Terms & Conditions</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-80 flex-shrink-0"></i>
              </button>

              <button
                type="button"
                onclick="switchPolicyTab('privacy')"
                id="tab-btn-privacy"
                class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all"
              >
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-user-shield text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Privacy & Data Security</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </button>

              <button
                type="button"
                onclick="switchPolicyTab('refunds')"
                id="tab-btn-refunds"
                class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all"
              >
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-rotate-left text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">7-Day Replacement Policy</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </button>

              <a
                href="{{ route('shipping') }}"
                class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all"
              >
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-truck-fast text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Shipping & Logistics Policy</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </a>

              <button
                type="button"
                onclick="switchPolicyTab('cookies')"
                id="tab-btn-cookies"
                class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all"
              >
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-cookie-bite text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Cookies Policy</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </button>

              <button
                type="button"
                onclick="switchPolicyTab('warranty')"
                id="tab-btn-warranty"
                class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all"
              >
                <span class="flex items-center gap-2.5 min-w-0 pr-1">
                  <i class="fa-solid fa-shield-halved text-sm w-4 text-center text-slate-400 flex-shrink-0"></i>
                  <span class="truncate whitespace-nowrap">Warranty Guidelines</span>
                </span>
                <i class="fa-solid fa-chevron-right text-[10px] opacity-60 flex-shrink-0"></i>
              </button>
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

            <!-- SECTION 1: TERMS & CONDITIONS -->
            <div id="content-terms" class="space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed font-body">
              <div class="border-b border-slate-100 pb-5">
                <span class="badge bg-blue-50 text-blue-700 border border-blue-200 text-xs px-2.5 py-0.5 font-bold mb-2">AGREEMENT</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">Terms & Conditions</h2>
                <p class="text-xs text-slate-500 mt-1">General terms governing the use of VANSH IT & COMM services, platforms, and sales.</p>
              </div>

              <div class="space-y-5">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5 flex items-center gap-2">
                    <i class="fa-solid fa-check text-blue-600 text-xs"></i> 1. Acceptance of Terms
                  </h3>
                  <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    By accessing, browsing, or purchasing products and repair services from VANSH IT & COMM, you agree to be bound by these terms. If you disagree with any portion of these provisions, you should discontinue using our website and services.
                  </p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5 flex items-center gap-2">
                    <i class="fa-solid fa-check text-blue-600 text-xs"></i> 2. Product Descriptions & 20-Point Grading
                  </h3>
                  <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    All products listed on our platform are described with utmost technical accuracy. Refurbished and pre-owned devices are categorized into distinct cosmetic and functional grades (e.g., Grade A Pristine, Grade B Excellent). Each unit is verified via our 20-point diagnostic protocol before shipment. Minor cosmetic signs of previous handling may be present as detailed in the product condition report.
                  </p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5 flex items-center gap-2">
                    <i class="fa-solid fa-check text-blue-600 text-xs"></i> 3. Pricing, GST Invoices & Payment Terms
                  </h3>
                  <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    All displayed prices are in Indian Rupees (INR) and are inclusive of applicable GST taxes. We accept UPI (Google Pay, PhonePe, Paytm), Credit/Debit Cards, Net Banking, and Cash on Delivery (where eligible). A legally valid GST tax invoice is automatically issued for all dispatched orders.
                  </p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5 flex items-center gap-2">
                    <i class="fa-solid fa-check text-blue-600 text-xs"></i> 4. Order Verification & Video Call Inspection
                  </h3>
                  <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    Customers have the right to request a pre-dispatch video call inspection to examine the physical condition and technical specifications of their selected unit. Once confirmed and dispatched, orders cannot be cancelled mid-transit.
                  </p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5 flex items-center gap-2">
                    <i class="fa-solid fa-check text-blue-600 text-xs"></i> 5. Limitation of Liability
                  </h3>
                  <p class="text-xs sm:text-sm text-slate-600 leading-relaxed">
                    VANSH IT & COMM is not liable for indirect, incidental, or consequential damages resulting from data loss during hardware repairs or software installations. Customers are strongly encouraged to back up critical personal files before submitting devices for repair.
                  </p>
                </div>
              </div>
            </div>

            <!-- SECTION 2: PRIVACY POLICY -->
            <div id="content-privacy" class="space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed font-body hidden">
              <div class="border-b border-slate-100 pb-5">
                <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-2.5 py-0.5 font-bold mb-2">DATA SECURITY</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">Privacy & Data Security Policy</h2>
                <p class="text-xs text-slate-500 mt-1">How we collect, protect, and handle your personal data in compliance with IT rules.</p>
              </div>

              <div class="space-y-5">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">1. Information We Collect</h3>
                  <p class="text-xs sm:text-sm text-slate-600 mb-2">When you place an order, book a video call, or request a repair diagnostic, we collect necessary contact information including:</p>
                  <ul class="list-disc list-inside space-y-1 text-slate-600 pl-2 text-xs">
                    <li>Full Name, Delivery Address, PIN code</li>
                    <li>Phone Number / WhatsApp Contact</li>
                    <li>Email address for order receipts and GST invoices</li>
                    <li>Device serial number and diagnostic logs (for repair & warranty records)</li>
                  </ul>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">2. Use of Information</h3>
                  <p class="text-xs sm:text-sm text-slate-600">
                    Your personal data is solely used to process and deliver your orders, send real-time tracking updates, manage warranty claims, and provide prompt customer support. We <strong>never sell or lease</strong> your personal details to third-party marketing brokers.
                  </p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">3. Payment & Data Security</h3>
                  <p class="text-xs sm:text-sm text-slate-600">
                    All online payment transactions are processed through RBI-authorized, PCI-DSS compliant secure payment gateways. VANSH IT & COMM does not store raw credit card numbers or banking passwords on our servers.
                  </p>
                </div>
              </div>
            </div>

            <!-- SECTION 3: REFUNDS & CANCELLATION -->
            <div id="content-refunds" class="space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed font-body hidden">
              <div class="border-b border-slate-100 pb-5">
                <span class="badge bg-amber-50 text-amber-700 border border-amber-200 text-xs px-2.5 py-0.5 font-bold mb-2">GUARANTEE</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">7-Day Replacement & Refund Policy</h2>
                <p class="text-xs text-slate-500 mt-1">Clear rules regarding order cancellations, 7-day replacements, and refund timelines.</p>
              </div>

              <div class="space-y-5">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">1. 7-Day Replacement Guarantee</h3>
                  <p class="text-xs sm:text-sm text-slate-600">
                    In the rare event that a received laptop, smartphone, or accessory has a functional defect, screen anomaly, or transit damage, you are eligible for an instant <strong>7-Day Replacement</strong>. Our technician will test the unit, and a replacement unit or repair resolution will be executed.
                  </p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">2. Refund Processing Timelines</h3>
                  <p class="text-xs sm:text-sm text-slate-600">
                    If a replacement unit is unavailable for the identical model and specification, a 100% refund will be issued to your original payment method (Bank Account, UPI, or Card) within <strong>3 to 5 business days</strong> following receipt and verification at our central testing facility.
                  </p>
                </div>
              </div>
            </div>

            <!-- SECTION 4: COOKIES POLICY -->
            <div id="content-cookies" class="space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed font-body hidden">
              <div class="border-b border-slate-100 pb-5">
                <span class="badge bg-purple-50 text-purple-700 border border-purple-200 text-xs px-2.5 py-0.5 font-bold mb-2">PREFERENCES</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">Cookies & Local Storage Policy</h2>
                <p class="text-xs text-slate-500 mt-1">Information on how cookies and local browser storage are utilized to improve your shopping experience.</p>
              </div>

              <div class="space-y-5">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">1. What Are Cookies?</h3>
                  <p class="text-xs sm:text-sm text-slate-600">
                    Cookies and local browser storage are small text files stored on your computer or mobile device when you visit our website. They allow the website to remember your shopping cart items, wishlist preferences, and authentication sessions.
                  </p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">2. Types of Cookies We Use</h3>
                  <ul class="list-disc list-inside space-y-1.5 text-slate-600 pl-2 text-xs">
                    <li><strong>Essential Cookies:</strong> Required to maintain your cart contents, checkout session, and security tokens.</li>
                    <li><strong>Preference Cookies:</strong> Remember your selected filters, search history, and sort order.</li>
                    <li><strong>Analytics Cookies:</strong> Help us understand which laptop models and categories are most visited.</li>
                  </ul>
                </div>
              </div>
            </div>

            <!-- SECTION 5: WARRANTY TERMS -->
            <div id="content-warranty" class="space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed font-body hidden">
              <div class="border-b border-slate-100 pb-5">
                <span class="badge bg-indigo-50 text-indigo-700 border border-indigo-200 text-xs px-2.5 py-0.5 font-bold mb-2">WARRANTY PROTECTION</span>
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">Warranty Guidelines & Claims</h2>
                <p class="text-xs text-slate-500 mt-1">Detailed terms regarding our hardware testing warranty and claim resolution.</p>
              </div>

              <div class="space-y-5">
                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">1. Scope of Warranty Coverage</h3>
                  <p class="text-xs sm:text-sm text-slate-600">
                    All certified refurbished laptops include structured warranty coverage (ranging from 3 to 12 months as indicated on your GST invoice). Warranty covers motherboard failures, RAM/SSD faults, keyboard malfunction, display panel defects, and charging port issues under normal usage.
                  </p>
                </div>

                <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                  <h3 class="text-sm sm:text-base font-bold text-slate-900 font-heading mb-1.5">2. Fast Track Claim Process</h3>
                  <ol class="list-decimal list-inside space-y-1.5 text-slate-600 pl-2 text-xs">
                    <li>Contact our support team on WhatsApp or phone (+91 98765 43210) with your Order ID.</li>
                    <li>Our technician will perform a remote diagnostic check or arrange reverse pickup.</li>
                    <li>The device is serviced with genuine OEM parts and returned within 3 to 7 working days.</li>
                  </ol>
                </div>
              </div>
            </div>

          </div>
        </div>

      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    const TABS = ['terms', 'privacy', 'refunds', 'cookies', 'warranty'];

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader();
      Components.renderFooter();

      // Check query parameter ?tab=... or hash #...
      const urlParams = new URLSearchParams(window.location.search);
      const tabParam = urlParams.get('tab') || window.location.hash.replace('#', '') || 'terms';

      if (TABS.includes(tabParam)) {
        switchPolicyTab(tabParam);
      } else {
        switchPolicyTab('terms');
      }
    });

    function switchPolicyTab(tabKey) {
      TABS.forEach(t => {
        const btn = document.getElementById(`tab-btn-${t}`);
        const content = document.getElementById(`content-${t}`);
        if (btn && content) {
          const icon = btn.querySelector('i:first-child');
          const chevron = btn.querySelector('i:last-child');
          if (t === tabKey) {
            btn.className = 'w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-bold transition-all bg-blue-600 text-white shadow-sm';
            if (icon) {
              icon.className = icon.className.replace('text-slate-400', 'text-white');
            }
            if (chevron) {
              chevron.className = chevron.className.replace('opacity-60', 'opacity-80');
            }
            content.classList.remove('hidden');
          } else {
            btn.className = 'w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs font-semibold text-slate-700 hover:bg-slate-50 transition-all';
            if (icon) {
              icon.className = icon.className.replace('text-white', 'text-slate-400');
            }
            if (chevron) {
              chevron.className = chevron.className.replace('opacity-80', 'opacity-60');
            }
            content.classList.add('hidden');
          }
        }
      });

      // Update breadcrumb title
      const titleMap = {
        terms: 'Terms & Conditions',
        privacy: 'Privacy & Data Security',
        refunds: '7-Day Replacement Policy',
        cookies: 'Cookies Policy',
        warranty: 'Warranty Guidelines'
      };
      const breadcrumb = document.getElementById('policy-breadcrumb');
      if (breadcrumb && titleMap[tabKey]) {
        breadcrumb.textContent = titleMap[tabKey];
      }
    }
  </script>
@endpush