@extends('layouts.app')

@php
  $siteName = $setting?->site_name;

  $deviceTypes  = $options->get('device_type', collect());
  $issues       = $options->get('issue', collect());
  $serviceModes = $options->get('service_mode', collect());

  // Full class strings so Tailwind can detect them
  $palette = [
    'blue'    => ['box' => 'bg-blue-50 text-blue-600',       'text' => 'text-blue-600'],
    'emerald' => ['box' => 'bg-emerald-50 text-emerald-600', 'text' => 'text-emerald-600'],
    'purple'  => ['box' => 'bg-purple-50 text-purple-600',   'text' => 'text-purple-600'],
    'amber'   => ['box' => 'bg-amber-50 text-amber-600',     'text' => 'text-amber-600'],
    'rose'    => ['box' => 'bg-rose-50 text-rose-600',       'text' => 'text-rose-600'],
    'indigo'  => ['box' => 'bg-indigo-50 text-indigo-600',   'text' => 'text-indigo-600'],
    'sky'     => ['box' => 'bg-sky-50 text-sky-600',         'text' => 'text-sky-600'],
    'slate'   => ['box' => 'bg-slate-100 text-slate-800',    'text' => 'text-slate-700'],
  ];
  $pick = fn ($key) => $palette[$key] ?? $palette['blue'];
@endphp

@section('title', $page->meta_title ?: 'Repair Services' . ($siteName ? ' | ' . $siteName : ''))
@if($page->meta_description)
  @section('meta_description', $page->meta_description)
@endif

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Repair Services</span>
      </nav>

      <!-- Repair Hero -->
      @if($page->hero_title || $page->hero_description)
        <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-10 mb-8 sm:mb-12 border border-slate-800 shadow-xl">
          <div class="max-w-3xl space-y-2.5 sm:space-y-4">
            @if($page->hero_badge)
              <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] sm:text-xs px-2.5 py-0.5 sm:px-3 sm:py-1 font-bold uppercase">{{ $page->hero_badge }}</span>
            @endif

            @if($page->hero_title)
              <h1 class="text-xl sm:text-3xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
                {{ $page->hero_title }}
              </h1>
            @endif

            @if($page->hero_description)
              <p class="text-xs sm:text-sm lg:text-base text-slate-300 leading-relaxed font-body">
                {{ $page->hero_description }}
              </p>
            @endif

            @if($page->hero_primary_text || $page->hero_secondary_text)
              <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 sm:gap-4 pt-1 sm:pt-2 text-xs">
                @if($page->hero_primary_text)
                  <a href="#booking-form" class="btn-base btn-primary px-3 sm:px-6 py-2 sm:py-3 font-semibold shadow-lg shadow-blue-600/30 text-center justify-center">
                    <i class="fa-solid fa-calendar-check mr-1.5"></i> {{ $page->hero_primary_text }}
                  </a>
                @endif
                @if($page->hero_secondary_text)
                  <a href="{{ route('contact') }}" class="btn-base btn-secondary bg-white/10 text-white border-white/20 px-3 sm:px-6 py-2 sm:py-3 font-semibold hover:bg-white/20 text-center justify-center">
                    <i class="fa-solid fa-phone mr-1.5"></i> {{ $page->hero_secondary_text }}
                  </a>
                @endif
              </div>
            @endif
          </div>
        </div>
      @endif

      <!-- Service categories -->
      @foreach($categories as $category)
        <section class="mb-16">
          <div class="flex items-center justify-between mb-8">
            <div>
              @if($category->eyebrow)
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $category->eyebrow }}</span>
              @endif
              <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">{{ $category->title }}</h2>
            </div>
          </div>

          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            @foreach($category->activeServices as $service)
              @php $c = $pick($service->color); @endphp
              <div class="card-base p-6">
                <div class="w-12 h-12 rounded-2xl {{ $c['box'] }} flex items-center justify-center text-xl mb-4">
                  <i class="{{ $service->icon }}"></i>
                </div>
                <h3 class="text-base font-bold text-slate-900 mb-1.5">{{ $service->title }}</h3>
                @if($service->description)
                  <p class="text-xs text-slate-600 mb-4">{{ $service->description }}</p>
                @endif
                @if($service->estimated_time)
                  <span class="text-xs font-bold {{ $c['text'] }}">Est. Time: {{ $service->estimated_time }}</span>
                @endif
              </div>
            @endforeach
          </div>
        </section>
      @endforeach

      <!-- Repair Booking Form Section -->
      <section id="booking-form" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-12 mb-16 shadow-sm">
        <div class="max-w-3xl mx-auto">

          @if($page->booking_badge || $page->booking_title || $page->booking_description)
            <div class="text-center mb-8">
              @if($page->booking_badge)
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $page->booking_badge }}</span>
              @endif
              @if($page->booking_title)
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">{{ $page->booking_title }}</h2>
              @endif
              @if($page->booking_description)
                <p class="section-subtitle">{{ $page->booking_description }}</p>
              @endif
            </div>
          @endif

          <form id="repair-booking-form" class="space-y-4" action="{{ route('repair.book') }}" method="POST" onsubmit="handleRepairSubmit(event)">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Your Full Name *</label>
                <input type="text" name="name" required placeholder="Enter your full name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Mobile / WhatsApp Number *</label>
                <input type="tel" name="mobile" required placeholder="10-digit mobile number" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
            </div>

            <div class="grid grid-cols-1 {{ $deviceTypes->count() ? 'sm:grid-cols-3' : 'sm:grid-cols-2' }} gap-4">
              @if($deviceTypes->count())
                <div>
                  <label class="block text-xs font-bold text-slate-700 mb-1">Device Type *</label>
                  <select name="device_type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white">
                    @foreach($deviceTypes as $opt)
                      <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                    @endforeach
                  </select>
                </div>
              @endif
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Brand Name *</label>
                <input type="text" name="brand" required placeholder="e.g. Dell, Apple, Lenovo, HP" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Model / Serial Number</label>
                <input type="text" name="model" placeholder="e.g. Latitude 5420 / iPhone 13" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
            </div>

            @if($issues->count() || $serviceModes->count())
              <div class="grid grid-cols-1 {{ ($issues->count() && $serviceModes->count()) ? 'sm:grid-cols-2' : '' }} gap-4">
                @if($issues->count())
                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Primary Problem / Issue *</label>
                    <select name="issue" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white">
                      @foreach($issues as $opt)
                        <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                      @endforeach
                    </select>
                  </div>
                @endif
                @if($serviceModes->count())
                  <div>
                    <label class="block text-xs font-bold text-slate-700 mb-1">Preferred Service Mode</label>
                    <select name="service_mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white">
                      @foreach($serviceModes as $opt)
                        <option value="{{ $opt->value }}">{{ $opt->label }}</option>
                      @endforeach
                    </select>
                  </div>
                @endif
              </div>
            @endif

            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1">Additional Issue Details</label>
              <textarea name="description" rows="3" placeholder="Describe any symptoms or specific requests..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white"></textarea>
            </div>

            <button type="submit" id="repair-submit-btn" class="btn-base btn-primary w-full py-3.5 text-sm font-semibold justify-center shadow-lg shadow-blue-600/30">
              Submit Repair Booking
            </button>

            @if($page->booking_note)
              <p class="text-[11px] text-slate-400 text-center">{{ $page->booking_note }}</p>
            @endif
          </form>
        </div>
      </section>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    async function handleRepairSubmit(event) {
      event.preventDefault();

      const form = event.target;
      const btn  = document.getElementById('repair-submit-btn');
      const originalHtml = btn.innerHTML;

      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Submitting...';

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
          },
          body: new FormData(form)
        });

        const data = await response.json();

        if (response.ok && data.success) {
          form.reset();
          showToast(data.message, 'success');
        } else if (response.status === 422) {
          const firstError = Object.values(data.errors || {})[0];
          showToast(firstError ? firstError[0] : 'Please check the form and try again.', 'error');
        } else if (response.status === 429) {
          showToast('Too many attempts. Please try again in a minute.', 'error');
        } else {
          showToast('Something went wrong. Please try again.', 'error');
        }
      } catch (e) {
        showToast('Network error. Please try again.', 'error');
      } finally {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
      }
    }
  </script>
@endpush