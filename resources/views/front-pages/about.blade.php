@extends('layouts.app')

@php
  $siteName = $setting?->site_name;

  // Full class strings so Tailwind can detect them
  $palette = [
    'blue'    => ['box' => 'bg-blue-50 text-blue-600 border-blue-100 group-hover:bg-blue-600 group-hover:text-white',          'card' => 'hover:border-blue-300',    'row' => 'hover:bg-blue-50/60',    'text' => 'text-blue-600'],
    'indigo'  => ['box' => 'bg-indigo-50 text-indigo-600 border-indigo-100 group-hover:bg-indigo-600 group-hover:text-white', 'card' => 'hover:border-indigo-300',  'row' => 'hover:bg-indigo-50/60',  'text' => 'text-indigo-600'],
    'emerald' => ['box' => 'bg-emerald-50 text-emerald-600 border-emerald-100 group-hover:bg-emerald-600 group-hover:text-white', 'card' => 'hover:border-emerald-300', 'row' => 'hover:bg-emerald-50/60', 'text' => 'text-emerald-600'],
    'purple'  => ['box' => 'bg-purple-50 text-purple-600 border-purple-100 group-hover:bg-purple-600 group-hover:text-white', 'card' => 'hover:border-purple-300',  'row' => 'hover:bg-purple-50/60',  'text' => 'text-purple-600'],
    'amber'   => ['box' => 'bg-amber-50 text-amber-600 border-amber-100 group-hover:bg-amber-600 group-hover:text-white',     'card' => 'hover:border-amber-300',   'row' => 'hover:bg-amber-50/60',   'text' => 'text-amber-600'],
    'rose'    => ['box' => 'bg-rose-50 text-rose-600 border-rose-100 group-hover:bg-rose-600 group-hover:text-white',           'card' => 'hover:border-rose-300',    'row' => 'hover:bg-rose-50/60',    'text' => 'text-rose-600'],
  ];
  $pick = fn ($key) => $palette[$key] ?? $palette['blue'];
@endphp

@section('title', 'About Us' . ($siteName ? ' | ' . $siteName : ''))

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">About Us</span>
      </nav>

      <!-- Hero Section -->
      @if($about->hero_title || $about->hero_description)
        <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-16 border border-slate-800 shadow-xl">
          <div class="max-w-3xl space-y-4">
            @if($about->hero_badge)
              <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1 font-bold uppercase">{{ $about->hero_badge }}</span>
            @endif

            @if($about->hero_title)
              <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
                {{ $about->hero_title }}
              </h1>
            @endif

            @if($about->hero_description)
              <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-body">
                {{ $about->hero_description }}
              </p>
            @endif
          </div>
        </div>
      @endif

      <!-- Who We Are -->
      @if($about->who_title || $about->who_description || $stats->count() || $about->who_image_url)
        <section class="grid grid-cols-1 {{ $about->who_image_url ? 'lg:grid-cols-2' : 'lg:grid-cols-1' }} gap-8 lg:gap-12 items-center mb-16">
          <div class="space-y-4">
            @if($about->who_badge)
              <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $about->who_badge }}</span>
            @endif

            @if($about->who_title)
              <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                {{ $about->who_title }}
              </h2>
            @endif

            @foreach($about->who_paragraphs as $paragraph)
              <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-body">{{ $paragraph }}</p>
            @endforeach

            @if($stats->count())
              <div class="grid grid-cols-2 gap-4 pt-2">
                @foreach($stats as $stat)
                  <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
                    <div class="text-2xl font-extrabold {{ $pick($stat->color)['text'] }} font-heading">{{ $stat->value }}</div>
                    <div class="text-xs font-bold text-slate-800">{{ $stat->label }}</div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>

          @if($about->who_image_url)
            <div class="relative">
              <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-lg bg-slate-900">
                <img src="{{ $about->who_image_url }}" alt="{{ $about->who_title ?: 'About us' }}" class="w-full h-80 object-cover" />
              </div>
            </div>
          @endif
        </section>
      @endif

      <!-- Testing Protocol -->
      @if($groups->count() || $about->testing_title)
        <section class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-12 mb-16 shadow-sm" id="refurbish-process">

          @if($about->testing_badge || $about->testing_title || $about->testing_description)
            <div class="text-center max-w-2xl mx-auto mb-10">
              @if($about->testing_badge)
                <span class="badge bg-blue-50 text-blue-700 border border-blue-200 text-xs px-3.5 py-1 font-extrabold uppercase tracking-wider">
                  <i class="fa-solid fa-microchip mr-1.5 text-blue-600"></i> {{ $about->testing_badge }}
                </span>
              @endif

              @if($about->testing_title)
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 font-heading mt-2">
                  {{ $about->testing_title }}
                </h2>
              @endif

              @if($about->testing_description)
                <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xl mx-auto">
                  {{ $about->testing_description }}
                </p>
              @endif
            </div>
          @endif

          @if($groups->count())
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">

              @foreach($groups as $group)
                @php
                  $c     = $pick($group->color);
                  $total = $group->items->count();
                @endphp

                <div class="card-base p-5 lg:p-6 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-lg {{ $c['card'] }} transition-all duration-300 flex flex-col justify-between group">
                  <div>
                    <div class="pb-3.5 mb-4 border-b border-slate-100">
                      <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-xl {{ $c['box'] }} border flex items-center justify-center text-base shadow-sm group-hover:scale-105 transition-all">
                          <i class="{{ $group->icon }}"></i>
                        </div>

                        @if($total)
                          <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2.5 py-1 whitespace-nowrap flex-shrink-0 flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i> {{ $total }}/{{ $total }} Checked
                          </span>
                        @endif
                      </div>

                      <div>
                        <h3 class="text-sm lg:text-base font-bold text-slate-900 font-heading leading-tight whitespace-nowrap">{{ $group->title }}</h3>
                        @if($group->subtitle)
                          <span class="text-[11px] text-slate-500 font-medium mt-0.5 block whitespace-nowrap">{{ $group->subtitle }}</span>
                        @endif
                      </div>
                    </div>

                    @if($total)
                      <div class="space-y-2">
                        @foreach($group->items as $item)
                          <div class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 {{ $c['row'] }} border border-slate-100 transition-colors">
                            <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                            <span class="text-xs font-semibold text-slate-700">{{ $item->title }}</span>
                          </div>
                        @endforeach
                      </div>
                    @endif
                  </div>

                  @if($group->footer_label || $group->footer_value)
                    <div class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                      @if($group->footer_label)
                        <span class="font-medium flex items-center gap-1.5">
                          @if($group->footer_icon)
                            <i class="{{ $group->footer_icon }} {{ $c['text'] }}"></i>
                          @endif
                          {{ $group->footer_label }}
                        </span>
                      @endif
                      @if($group->footer_value)
                        <span class="text-emerald-600 font-bold">{{ $group->footer_value }}</span>
                      @endif
                    </div>
                  @endif
                </div>
              @endforeach

            </div>
          @endif

          <!-- Quality banner -->
          @if($about->banner_title)
            <div class="mt-8 p-4 rounded-2xl bg-gradient-to-r from-blue-950 via-slate-900 to-slate-950 text-white flex flex-col sm:flex-row items-center justify-between gap-4 border border-slate-800 shadow-md">
              <div class="flex items-center gap-3 text-center sm:text-left">
                <div class="w-10 h-10 rounded-xl bg-blue-600/30 border border-blue-400/40 text-blue-300 flex items-center justify-center text-lg flex-shrink-0">
                  <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                  <h4 class="text-xs font-bold text-white leading-tight">{{ $about->banner_title }}</h4>
                  @if($about->banner_text)
                    <p class="text-[11px] text-slate-300">{{ $about->banner_text }}</p>
                  @endif
                </div>
              </div>

              @if($about->banner_button_text)
                <a href="{{ $about->banner_button_url ?: route('shop') }}" class="btn-base btn-primary btn-sm text-xs py-2 px-4 whitespace-nowrap">
                  {{ $about->banner_button_text }} <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                </a>
              @endif
            </div>
          @endif
        </section>
      @endif

      <!-- Our Commitments -->
      @if($commitments->count())
        <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16">
          @foreach($commitments as $item)
            <div class="card-base p-6">
              <i class="{{ $item->icon }} {{ $pick($item->color)['text'] }} text-2xl mb-3"></i>
              <h3 class="text-base font-bold text-slate-900 mb-1.5 font-heading">{{ $item->title }}</h3>
              @if($item->description)
                <p class="text-xs text-slate-600 leading-relaxed font-body">{{ $item->description }}</p>
              @endif
            </div>
          @endforeach
        </section>
      @endif

    </div>
  </main>

@endsection