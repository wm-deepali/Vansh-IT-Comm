@extends('layouts.app')

@section('title', $page->meta_title ?: 'Device Exchange & Upgrade Program | VANSH IT & COMM')
@section('meta_description', $page->meta_description)

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
          @if($page->hero_badge)
            <span class="badge bg-emerald-500/20 text-emerald-300 border border-emerald-400/30 text-[10px] sm:text-xs px-2.5 py-0.5 sm:px-3 sm:py-1 font-bold">{{ $page->hero_badge }}</span>
          @endif
          <h1 class="text-xl sm:text-3xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
            {{ $page->hero_title }}
          </h1>
          <p class="text-xs sm:text-sm lg:text-base text-slate-300 leading-relaxed font-body">
            {{ $page->hero_description }}
          </p>
        </div>
      </div>

      <!-- Steps Timeline -->
      @if($steps->count())
      <section class="mb-16">
        <div class="text-center max-w-xl mx-auto mb-10">
          <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $page->steps_badge }}</span>
          <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">{{ $page->steps_title }}</h2>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-{{ min($steps->count(), 5) }} gap-4 text-center">
          @foreach($steps as $step)
            <div class="card-base p-5">
              <div class="w-10 h-10 rounded-full bg-{{ $step->color }}-50 text-{{ $step->color }}-600 font-extrabold text-sm flex items-center justify-center mx-auto mb-3">{{ $loop->iteration }}</div>
              <h4 class="text-xs font-bold text-slate-900 mb-1">{{ $step->title }}</h4>
              <p class="text-[11px] text-slate-500">{{ $step->description }}</p>
            </div>
          @endforeach
        </div>
      </section>
      @endif

      <!-- Exchange Valuation Calculator Form -->
      <section class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-12 mb-16 shadow-sm">
        <div class="max-w-3xl mx-auto">
          <div class="text-center mb-8">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-wider">{{ $page->calc_badge }}</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">{{ $page->calc_title }}</h2>
            <p class="section-subtitle">{{ $page->calc_subtitle }}</p>
          </div>

          <form id="exchange-calc-form" class="space-y-4" onsubmit="calculateExchangeValue(event)">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Device Category *</label>
                <select id="exc-category" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  @foreach($options->get('category', collect()) as $opt)
                    <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                  @endforeach
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
                  @foreach($options->get('condition', collect()) as $opt)
                    <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Device Age</label>
                <select id="exc-age" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  @foreach($options->get('age', collect()) as $opt)
                    <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                  @endforeach
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">RAM / Storage</label>
                <input type="text" id="exc-specs" placeholder="e.g. 8GB RAM / 256GB SSD" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Original Charger Available?</label>
                <select id="exc-charger" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                  @foreach($options->get('charger', collect()) as $opt)
                    <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <button type="submit" id="exc-submit" class="btn-base btn-success w-full py-3.5 text-sm font-semibold justify-center shadow-md">
              <i class="fa-solid fa-calculator mr-2"></i> {{ $page->calc_button_text ?: 'Get Estimated Exchange Value' }}
            </button>
          </form>

          <!-- Result Display Box -->
          <div id="exchange-result-box" class="hidden mt-8 p-6 rounded-2xl bg-emerald-50 border border-emerald-200 text-center space-y-3">
            <span class="badge bg-emerald-600 text-white text-xs px-3 py-1">{{ $page->result_badge }}</span>
            <div class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-body" id="estimated-val-amount"></div>
            <p class="text-xs text-slate-600 max-w-md mx-auto" id="estimated-val-text"></p>
            <div class="pt-2 flex flex-wrap justify-center gap-3">
              <a href="#" class="btn-base btn-primary text-xs font-semibold py-2.5 px-4">
                {{ $page->result_shop_text }}
              </a>
              <a href="{{ route('contact') }}" class="btn-base btn-secondary text-xs font-semibold py-2.5 px-4">
                {{ $page->result_pickup_text }}
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

    async function calculateExchangeValue(event) {
      event.preventDefault();

      const btn = document.getElementById('exc-submit');
      const payload = {
        category:  document.getElementById('exc-category').value,
        brand:     document.getElementById('exc-brand').value.trim(),
        model:     document.getElementById('exc-model').value.trim(),
        condition: document.getElementById('exc-condition').value,
        age:       document.getElementById('exc-age').value,
        specs:     document.getElementById('exc-specs').value.trim(),
        charger:   document.getElementById('exc-charger').value
      };

      btn.disabled = true;

      try {
        const res = await fetch("{{ route('exchange.calculate') }}", {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify(payload)
        });
        const data = await res.json();

        if (!res.ok || !data.success) {
          showToast(data.message || 'Could not calculate value. Please check the details.', 'error');
          return;
        }

        document.getElementById('estimated-val-amount').textContent =
          `₹${Number(data.min).toLocaleString('en-IN')} – ₹${Number(data.max).toLocaleString('en-IN')}*`;
        document.getElementById('estimated-val-text').textContent = data.text;
        document.getElementById('exchange-result-box').classList.remove('hidden');

        showToast('Estimated exchange value computed!', 'success');
      } catch (e) {
        showToast('Something went wrong. Please try again.', 'error');
      } finally {
        btn.disabled = false;
      }
    }
  </script>
@endpush