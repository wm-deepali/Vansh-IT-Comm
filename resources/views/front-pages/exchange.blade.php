@extends('layouts.app')

@section('title', 'Device Exchange & Upgrade Program | VANSH IT & COMM')
@section('meta_description', 'Calculate your old laptop or smartphone trade-in value and upgrade to certified refurbished or new technology.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Device Exchange</span>
      </nav>

      <!-- Hero Banner -->
      <div class="bg-gradient-to-r from-emerald-950 via-slate-900 to-slate-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-10 mb-8 sm:mb-12 border border-slate-800 shadow-xl">
        <div class="max-w-3xl space-y-2.5 sm:space-y-4">
          <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] sm:text-xs px-2.5 py-0.5 sm:px-3 sm:py-1 font-bold">SMART TRADE-IN</span>
          <h1 class="text-xl sm:text-3xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Your Old Device. Your Next Upgrade.
          </h1>
          <p class="text-xs sm:text-sm lg:text-base text-slate-300 leading-relaxed font-body">
            Trade in your pre-owned laptop or mobile phone to get instant store credit towards certified refurbished laptops or premium smartphones.
          </p>
        </div>
      </div>

      <!-- 5-Step Process Timeline -->
      <section class="mb-16">
        <div class="text-center max-w-xl mx-auto mb-10">
          <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">How It Works</span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">5 Simple Steps to Upgrade</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-4 text-center">
          <div class="card-base p-5">
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 font-extrabold text-sm flex items-center justify-center mx-auto mb-3">1</div>
            <h4 class="text-xs font-bold text-slate-900 mb-1">Tell Us About Device</h4>
            <p class="text-[11px] text-slate-500">Select brand, model, and physical condition.</p>
          </div>

          <div class="card-base p-5">
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 font-extrabold text-sm flex items-center justify-center mx-auto mb-3">2</div>
            <h4 class="text-xs font-bold text-slate-900 mb-1">Get Instant Value</h4>
            <p class="text-[11px] text-slate-500">Receive fair algorithmic estimated credit.</p>
          </div>

          <div class="card-base p-5">
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 font-extrabold text-sm flex items-center justify-center mx-auto mb-3">3</div>
            <h4 class="text-xs font-bold text-slate-900 mb-1">Device Inspection</h4>
            <p class="text-[11px] text-slate-500">Drop off at store or free doorstep pickup.</p>
          </div>

          <div class="card-base p-5">
            <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 font-extrabold text-sm flex items-center justify-center mx-auto mb-3">4</div>
            <h4 class="text-xs font-bold text-slate-900 mb-1">Exchange or Sell</h4>
            <p class="text-[11px] text-slate-500">Accept final valuation discount or cash.</p>
          </div>

          <div class="card-base p-5">
            <div class="w-10 h-10 rounded-full bg-emerald-50 text-emerald-600 font-extrabold text-sm flex items-center justify-center mx-auto mb-3">5</div>
            <h4 class="text-xs font-bold text-slate-900 mb-1">Upgrade Tech</h4>
            <p class="text-[11px] text-slate-500">Take home your new high-performance device!</p>
          </div>
        </div>
      </section>

      <!-- Exchange Valuation Calculator Form -->
      <section class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-12 mb-16 shadow-sm">
        <div class="max-w-3xl mx-auto">
          <div class="text-center mb-8">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Instant Valuation</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Calculate Exchange Value</h2>
            <p class="section-subtitle">Get an instant estimated trade-in price for your laptop or smartphone.</p>
          </div>

          <form id="exchange-calc-form" class="space-y-4" onsubmit="calculateExchangeValue(event)">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Device Category *</label>
                <select id="exc-category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  <option value="laptop">Laptop / Notebook</option>
                  <option value="phone">Mobile Phone / Smartphone</option>
                  <option value="tablet">Tablet / iPad</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Brand Name *</label>
                <input type="text" id="exc-brand" required placeholder="e.g. Dell, HP, Apple, Samsung" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Model Name / Number *</label>
                <input type="text" id="exc-model" required placeholder="e.g. Latitude 3490 / iPhone 11" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Working Condition *</label>
                <select id="exc-condition" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  <option value="excellent">Flawless / Excellent (No major scratches, 100% working)</option>
                  <option value="good">Good (Minor cosmetic scratches, fully working)</option>
                  <option value="average">Fair (Visible dents/marks, working battery)</option>
                  <option value="damaged">Faulty / Broken (Cracked screen or dead battery)</option>
                </select>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Device Age</label>
                <select id="exc-age" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  <option value="1">Less than 1 Year</option>
                  <option value="2">1 to 2 Years</option>
                  <option value="3">2 to 4 Years</option>
                  <option value="5">4+ Years</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">RAM / Storage</label>
                <input type="text" id="exc-specs" placeholder="e.g. 8GB RAM / 256GB SSD" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Original Charger Available?</label>
                <select id="exc-charger" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  <option value="yes">Yes, Original Charger Included</option>
                  <option value="no">No Charger</option>
                </select>
              </div>
            </div>

            <button type="submit" class="btn-base btn-success w-full py-3.5 text-sm font-semibold justify-center shadow-md">
              <i class="fa-solid fa-calculator mr-2"></i> Get Estimated Exchange Value
            </button>
          </form>

          <!-- Result Display Box -->
          <div id="exchange-result-box" class="hidden mt-8 p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-center space-y-3">
            <span class="badge bg-emerald-600 text-white text-xs px-3 py-1">ESTIMATED TRADE-IN VALUE</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-body" id="estimated-val-amount">₹12,500 – ₹15,000*</div>
            <p class="text-xs text-slate-600 max-w-md mx-auto" id="estimated-val-text">
              Based on your details, your device qualifies for instant trade-in discount toward any laptop or smartphone.
            </p>
            <div class="pt-2 flex flex-wrap justify-center gap-3">
              <a href="{{ route('laptops') }}" class="btn-base btn-primary text-xs font-semibold py-2.5 px-4">
                Shop Laptops with Credit
              </a>
              <a href="{{ route('contact') }}" class="btn-base btn-secondary text-xs font-semibold py-2.5 px-4">
                Book Device Pickup
              </a>
            </div>
          </div>
        </div>
      </section>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('exchange');
      Components.renderFooter();
    });

    function calculateExchangeValue(event) {
      event.preventDefault();
      const cat = document.getElementById('exc-category').value;
      const brand = document.getElementById('exc-brand').value.trim();
      const model = document.getElementById('exc-model').value.trim();
      const cond = document.getElementById('exc-condition').value;

      let baseMin = cat === 'laptop' ? 8000 : 4000;
      let baseMax = cat === 'laptop' ? 14000 : 8000;

      if (brand.toLowerCase().includes('apple')) {
        baseMin += 8000;
        baseMax += 12000;
      } else if (brand.toLowerCase().includes('dell') || brand.toLowerCase().includes('samsung')) {
        baseMin += 3000;
        baseMax += 5000;
      }

      if (cond === 'excellent') {
        baseMin = Math.round(baseMin * 1.2);
        baseMax = Math.round(baseMax * 1.25);
      } else if (cond === 'damaged') {
        baseMin = Math.round(baseMin * 0.4);
        baseMax = Math.round(baseMax * 0.5);
      }

      document.getElementById('estimated-val-amount').textContent = `₹${baseMin.toLocaleString('en-IN')} – ₹${baseMax.toLocaleString('en-IN')}*`;
      document.getElementById('estimated-val-text').textContent = `Estimated value for your ${brand} ${model}. Final credit applied after physical testing.`;
      document.getElementById('exchange-result-box').classList.remove('hidden');

      showToast('Estimated exchange value computed!', 'success');
    }
  </script>
@endpush