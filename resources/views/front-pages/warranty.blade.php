@extends('layouts.app')

@section('title', 'Warranty Policy & Claim Process | VANSH IT & COMM')
@section('meta_description', 'Understand the warranty terms, covered issues, and simple claim steps for your purchased electronics.')

@section('content')

  @php
    $policyLinks = [
      ['label' => 'Terms & Conditions',         'icon' => 'fa-file-contract', 'url' => route('terms', ['tab' => 'terms']),   'active' => false],
      ['label' => 'Privacy & Data Security',    'icon' => 'fa-user-shield',   'url' => route('terms', ['tab' => 'privacy']), 'active' => false],
      ['label' => '7-Day Replacement Policy',   'icon' => 'fa-rotate-left',   'url' => route('terms', ['tab' => 'refunds']), 'active' => false],
      ['label' => 'Shipping & Logistics Policy','icon' => 'fa-truck-fast',    'url' => route('shipping'),                    'active' => false],
      ['label' => 'Cookies Policy',             'icon' => 'fa-cookie-bite',   'url' => route('terms', ['tab' => 'cookies']), 'active' => false],
      ['label' => 'Warranty Guidelines',        'icon' => 'fa-shield-halved', 'url' => route('warranty'),                    'active' => true],
    ];

    $covered = [
      'Motherboard component failure',
      'CPU, RAM, or NVMe SSD hardware faults',
      'Display lines or backlight defects (non-accidental)',
      'Keyboard / Trackpad internal circuit faults',
      'Charging controller or port manufacturing defects',
    ];

    $notCovered = [
      'Accidental physical drops or cracked glass',
      'Liquid immersion / water & moisture damage',
      'Unauthorized third-party tampering or modifications',
      'Natural battery capacity degradation after warranty period',
      'Software viruses, malware or OS corruption',
    ];

    $claimSteps = [
      ['Step 1: Contact Support',  'Send your invoice and a short video describing the fault on WhatsApp.'],
      ['Step 2: Diagnostic Check', 'Our technicians will troubleshoot remotely or arrange reverse pickup.'],
      ['Step 3: Repair or Replace','The device is serviced with genuine OEM parts and returned safely.'],
    ];
  @endphp

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('terms') }}" class="hover:text-blue-600">Legal</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Warranty Guidelines</span>
      </nav>

      <!-- Hero Header -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-10 border border-slate-800 shadow-xl">
        <div class="max-w-4xl space-y-3">
          <span class="badge bg-purple-500/20 text-purple-300 border border-purple-400/30 text-xs px-3 py-1 font-bold">PEACE OF MIND</span>
          <h1 class="text-2xl sm:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Warranty Guidelines & Coverage
          </h1>
          <p class="text-xs sm:text-sm text-slate-300 leading-relaxed font-body">
            Clear, transparent protection terms for refurbished laptops, smartphones, and new accessories.
          </p>
          <div class="text-[11px] text-slate-400 pt-1">
            Last Updated: <span class="text-white font-semibold">September 2026</span> • Up to 12-Month Coverage.
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
              @foreach ($policyLinks as $link)
                <a href="{{ $link['url'] }}"
                   class="w-full flex items-center justify-between px-3.5 py-3 rounded-2xl text-xs transition-all {{ $link['active'] ? 'font-bold bg-blue-600 text-white shadow-sm' : 'font-semibold text-slate-700 hover:bg-slate-50' }}">
                  <span class="flex items-center gap-2.5 min-w-0 pr-1">
                    <i class="fa-solid {{ $link['icon'] }} text-sm w-4 text-center flex-shrink-0 {{ $link['active'] ? 'text-white' : 'text-slate-400' }}"></i>
                    <span class="truncate whitespace-nowrap">{{ $link['label'] }}</span>
                  </span>
                  <i class="fa-solid fa-chevron-right text-[10px] flex-shrink-0 {{ $link['active'] ? 'opacity-80' : 'opacity-60' }}"></i>
                </a>
              @endforeach
            </nav>
          </div>

          <!-- Warranty Support Card -->
          <div class="bg-gradient-to-br from-slate-900 to-blue-950 p-6 rounded-3xl text-white border border-slate-800 shadow-md space-y-3">
            <div class="w-10 h-10 rounded-xl bg-blue-500/20 text-blue-400 flex items-center justify-center text-base">
              <i class="fa-solid fa-shield-halved"></i>
            </div>
            <h4 class="font-extrabold text-sm font-heading text-white">Need to File a Claim?</h4>
            <p class="text-xs text-slate-300 leading-relaxed font-body">
              Provide your GST invoice number and our technicians will initiate doorstep pickup or remote diagnostics.
            </p>
            <div class="pt-2">
              <a href="{{ route('contact') }}" class="btn-base btn-primary btn-sm text-xs w-full py-2 justify-center font-bold text-white">
                <i class="fa-solid fa-screwdriver-wrench mr-1.5"></i> File Warranty Claim
              </a>
            </div>
          </div>
        </div>

        <!-- Right Main Content -->
        <div class="lg:col-span-8">
          <div class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200 shadow-sm space-y-8">
            <div class="space-y-6 text-xs sm:text-sm text-slate-700 leading-relaxed font-body">
              <div class="border-b border-slate-100 pb-4">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">Hardware Warranty Structure</h2>
                <p class="text-xs text-slate-500 mt-1">Full breakdown of covered components and resolution workflows.</p>
              </div>

              <!-- Coverage -->
              <div class="space-y-4">
                <h3 class="text-base font-bold text-slate-900 font-heading">What Is Covered vs Not Covered</h3>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                  <div class="p-5 bg-emerald-50/60 border border-emerald-200 rounded-2xl space-y-3">
                    <h4 class="font-bold text-emerald-900 text-sm flex items-center gap-2">
                      <i class="fa-solid fa-circle-check text-emerald-600"></i> Covered Issues (100% Free Repair)
                    </h4>
                    <div class="space-y-2 text-xs text-slate-800">
                      @foreach ($covered as $item)
                        <div class="flex items-center gap-2 p-2 rounded-xl bg-white border border-emerald-100"><i class="fa-solid fa-check text-emerald-600"></i> {{ $item }}</div>
                      @endforeach
                    </div>
                  </div>

                  <div class="p-5 bg-red-50/60 border border-red-200 rounded-2xl space-y-3">
                    <h4 class="font-bold text-red-900 text-sm flex items-center gap-2">
                      <i class="fa-solid fa-circle-xmark text-red-600"></i> What Is Not Covered
                    </h4>
                    <div class="space-y-2 text-xs text-slate-800">
                      @foreach ($notCovered as $item)
                        <div class="flex items-center gap-2 p-2 rounded-xl bg-white border border-red-100"><i class="fa-solid fa-xmark text-red-500"></i> {{ $item }}</div>
                      @endforeach
                    </div>
                  </div>
                </div>
              </div>

              <!-- How to Claim -->
              <div class="space-y-3 pt-2">
                <h3 class="text-base font-bold text-slate-900 font-heading">3-Step Fast Track Claim Process</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-xs">
                  @foreach ($claimSteps as [$title, $text])
                    <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100">
                      <strong class="text-blue-600 block mb-1">{{ $title }}</strong>
                      <p class="text-slate-600">{{ $text }}</p>
                    </div>
                  @endforeach
                </div>
              </div>
            </div>

            <div class="pt-6 border-t border-slate-100 flex items-center justify-between flex-wrap gap-4 text-xs text-slate-500">
              <span>Other Policies:
                <a href="{{ route('terms', ['tab' => 'terms']) }}" class="text-blue-600 font-semibold hover:underline">Terms & Conditions</a> •
                <a href="{{ route('terms', ['tab' => 'refunds']) }}" class="text-blue-600 font-semibold hover:underline">7-Day Replacement</a> •
                <a href="{{ route('shipping') }}" class="text-blue-600 font-semibold hover:underline">Shipping Policy</a>
              </span>
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