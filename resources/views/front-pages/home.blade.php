@extends('layouts.app')
@section('content')

    @php
        /* ───────────── helpers ───────────── */
        // json string or array -> array
        $arr = fn($v) => is_array($v) ? $v : (json_decode($v ?? '[]', true) ?: []);

        // active rows only, ordered
        $on = fn($c) => collect($c ?? [])->where('is_active', true)->sortBy('sort_order')->values();

        // route name | URL | #anchor  ->  real href
        $url = function ($v) {
            if (!$v) return '#';
            if (preg_match('#^(https?://|/|\#|mailto:|tel:)#', $v)) return $v;
            return \Illuminate\Support\Facades\Route::has($v) ? route($v) : url($v);
        };

        // section headings (home_section_headings, keyed by "key")
        $hRow  = fn($k) => ($headings ?? collect())->get($k);
        $hShow = fn($k) => !$hRow($k) || $hRow($k)->is_active;
        $hVal  = fn($k, $f, $d = null) => ($hRow($k)->$f ?? null) ?: $d;
        $hLink = fn($k, $fallback) => ($hRow($k) && $hRow($k)->linkValue('link')) ? $url($hRow($k)->linkValue('link')) : $fallback;

        // cta blocks (home_cta_blocks, keyed by "key")
        $cta = fn($k) => ($ctaBlocks ?? collect())->get($k);

        // active slides / lists
        $slideList = $on($slides ?? []);
        $trustList = $on($trustItems ?? []);
        $whyList   = $on($whyItems ?? []);
        $budgetList = $on($budgetCards ?? []);
        $guidedList = $on($guided ?? []);
        $stepList  = $on($steps ?? []);
        $storeList = $on($stores ?? []);

        /* ───────────── colour maps (full class names so Tailwind keeps them) ───────────── */
        $heroTheme = [
            'blue' => ['bg' => 'to-blue-950', 'badge' => 'bg-blue-500/20 border-blue-400/30 text-blue-300', 'badgeIcon' => 'text-amber-400', 'hl' => 'from-blue-400 to-sky-300', 'link' => 'text-sky-400 hover:text-sky-300', 'glow' => 'from-blue-600 to-cyan-500', 'top' => 'bg-blue-600', 'label' => 'text-blue-400', 'bottom' => 'text-emerald-400 border-emerald-500/30', 'btn' => 'shadow-blue-600/30'],
            'emerald' => ['bg' => 'to-emerald-950', 'badge' => 'bg-emerald-500/20 border-emerald-400/30 text-emerald-300', 'badgeIcon' => 'text-emerald-400', 'hl' => 'from-emerald-400 to-teal-300', 'link' => 'text-teal-400 hover:text-teal-300', 'glow' => 'from-emerald-600 to-teal-500', 'top' => 'bg-emerald-600', 'label' => 'text-emerald-400', 'bottom' => 'text-teal-300 border-teal-500/30', 'btn' => 'shadow-emerald-600/30'],
            'purple' => ['bg' => 'to-purple-950', 'badge' => 'bg-purple-500/20 border-purple-400/30 text-purple-300', 'badgeIcon' => 'text-purple-400', 'hl' => 'from-purple-400 to-pink-300', 'link' => 'text-purple-300 hover:text-purple-200', 'glow' => 'from-purple-600 to-pink-500', 'top' => 'bg-purple-600', 'label' => 'text-purple-400', 'bottom' => 'text-pink-300 border-pink-500/30', 'btn' => 'shadow-purple-600/30'],
            'amber' => ['bg' => 'to-amber-950', 'badge' => 'bg-amber-500/20 border-amber-400/30 text-amber-300', 'badgeIcon' => 'text-amber-400', 'hl' => 'from-amber-400 to-orange-300', 'link' => 'text-amber-300 hover:text-amber-200', 'glow' => 'from-amber-600 to-orange-500', 'top' => 'bg-amber-600', 'label' => 'text-amber-400', 'bottom' => 'text-amber-300 border-amber-500/30', 'btn' => 'shadow-amber-600/30'],
            'rose' => ['bg' => 'to-rose-950', 'badge' => 'bg-rose-500/20 border-rose-400/30 text-rose-300', 'badgeIcon' => 'text-rose-400', 'hl' => 'from-rose-400 to-pink-300', 'link' => 'text-rose-300 hover:text-rose-200', 'glow' => 'from-rose-600 to-pink-500', 'top' => 'bg-rose-600', 'label' => 'text-rose-400', 'bottom' => 'text-rose-300 border-rose-500/30', 'btn' => 'shadow-rose-600/30'],
            'indigo' => ['bg' => 'to-indigo-950', 'badge' => 'bg-indigo-500/20 border-indigo-400/30 text-indigo-300', 'badgeIcon' => 'text-indigo-400', 'hl' => 'from-indigo-400 to-sky-300', 'link' => 'text-indigo-300 hover:text-indigo-200', 'glow' => 'from-indigo-600 to-sky-500', 'top' => 'bg-indigo-600', 'label' => 'text-indigo-400', 'bottom' => 'text-sky-300 border-sky-500/30', 'btn' => 'shadow-indigo-600/30'],
        ];

        // small icon boxes (trust strip, why-us, store cards)
        $tone = [
            'blue' => 'bg-blue-50 text-blue-600 border-blue-100',
            'emerald' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
            'purple' => 'bg-purple-50 text-purple-600 border-purple-100',
            'amber' => 'bg-amber-50 text-amber-600 border-amber-100',
            'sky' => 'bg-sky-50 text-sky-600 border-sky-100',
            'rose' => 'bg-rose-50 text-rose-600 border-rose-100',
            'teal' => 'bg-teal-50 text-teal-600 border-teal-100',
            'indigo' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
        ];
        $iconText = [
            'blue' => 'text-blue-600', 'emerald' => 'text-emerald-600', 'purple' => 'text-purple-600', 'amber' => 'text-amber-600',
            'sky' => 'text-sky-600', 'rose' => 'text-rose-600', 'teal' => 'text-teal-600', 'indigo' => 'text-indigo-600',
        ];
        $badgeTone = [
            'blue' => 'bg-blue-50 text-blue-700 border-blue-200', 'emerald' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
            'purple' => 'bg-purple-50 text-purple-700 border-purple-200', 'amber' => 'bg-amber-50 text-amber-800 border-amber-200',
            'sky' => 'bg-sky-50 text-sky-700 border-sky-200', 'rose' => 'bg-rose-50 text-rose-700 border-rose-200',
            'teal' => 'bg-teal-50 text-teal-700 border-teal-200', 'indigo' => 'bg-indigo-50 text-indigo-700 border-indigo-200',
        ];
        $hoverBorder = [
            'blue' => 'hover:border-blue-500', 'emerald' => 'hover:border-emerald-500', 'purple' => 'hover:border-purple-500',
            'amber' => 'hover:border-amber-500', 'sky' => 'hover:border-sky-500', 'rose' => 'hover:border-rose-500',
            'teal' => 'hover:border-teal-500', 'indigo' => 'hover:border-indigo-500',
        ];
        $solid = [
            'blue' => 'bg-blue-600', 'emerald' => 'bg-emerald-600', 'purple' => 'bg-purple-600', 'amber' => 'bg-amber-600',
            'sky' => 'bg-sky-600', 'rose' => 'bg-rose-600', 'teal' => 'bg-teal-600', 'indigo' => 'bg-indigo-600',
        ];

        // guided cards
        $guidedTheme = [
            'blue' => ['bar' => 'from-blue-600 to-indigo-600', 'box' => 'bg-blue-50 border-blue-100 text-blue-600 group-hover:bg-blue-600', 'badge' => 'bg-blue-50 text-blue-700 border-blue-200', 'check' => 'bg-blue-100 text-blue-600', 'title' => 'group-hover:text-blue-600', 'btn' => 'bg-blue-600 hover:bg-blue-700 shadow-blue-600/20'],
            'emerald' => ['bar' => 'from-emerald-500 to-teal-600', 'box' => 'bg-emerald-50 border-emerald-100 text-emerald-600 group-hover:bg-emerald-600', 'badge' => 'bg-emerald-50 text-emerald-700 border-emerald-200', 'check' => 'bg-emerald-100 text-emerald-600', 'title' => 'group-hover:text-emerald-600', 'btn' => 'bg-emerald-600 hover:bg-emerald-700 shadow-emerald-600/20'],
            'amber' => ['bar' => 'from-amber-500 to-orange-600', 'box' => 'bg-amber-50 border-amber-100 text-amber-600 group-hover:bg-amber-600', 'badge' => 'bg-amber-50 text-amber-800 border-amber-200', 'check' => 'bg-amber-100 text-amber-700', 'title' => 'group-hover:text-amber-600', 'btn' => 'bg-slate-900 hover:bg-slate-800 shadow-slate-900/20'],
            'purple' => ['bar' => 'from-purple-500 to-pink-600', 'box' => 'bg-purple-50 border-purple-100 text-purple-600 group-hover:bg-purple-600', 'badge' => 'bg-purple-50 text-purple-700 border-purple-200', 'check' => 'bg-purple-100 text-purple-600', 'title' => 'group-hover:text-purple-600', 'btn' => 'bg-purple-600 hover:bg-purple-700 shadow-purple-600/20'],
            'rose' => ['bar' => 'from-rose-500 to-pink-600', 'box' => 'bg-rose-50 border-rose-100 text-rose-600 group-hover:bg-rose-600', 'badge' => 'bg-rose-50 text-rose-700 border-rose-200', 'check' => 'bg-rose-100 text-rose-600', 'title' => 'group-hover:text-rose-600', 'btn' => 'bg-rose-600 hover:bg-rose-700 shadow-rose-600/20'],
            'sky' => ['bar' => 'from-sky-500 to-blue-600', 'box' => 'bg-sky-50 border-sky-100 text-sky-600 group-hover:bg-sky-600', 'badge' => 'bg-sky-50 text-sky-700 border-sky-200', 'check' => 'bg-sky-100 text-sky-600', 'title' => 'group-hover:text-sky-600', 'btn' => 'bg-sky-600 hover:bg-sky-700 shadow-sky-600/20'],
        ];

        $placeholder = asset('assets/img/product-1588872657578-7efd1f1555ed.jpg');
    @endphp

    <!-- Main Content -->
    <main class="flex-grow">

        <!-- ==========================================
                 HERO SLIDER SECTION
                 ========================================== -->
        @if($slideList->isNotEmpty())
            <section class="relative bg-slate-950 text-white overflow-hidden" aria-label="Featured Offers">
                <div id="hero-slider"
                    class="relative min-h-[460px] sm:min-h-[480px] md:min-h-[460px] lg:min-h-[520px] flex items-center">

                    @foreach($slideList as $i => $s)
                        @php $t = $heroTheme[$s->theme] ?? $heroTheme['blue']; @endphp
                        <div
                            class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out flex items-center {{ $i === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0' }} bg-gradient-to-r from-slate-950 via-slate-900 {{ $t['bg'] }}">
                            <div class="container-custom py-8 sm:py-10 md:py-8 lg:py-10">
                                <div class="grid grid-cols-12 gap-4 md:gap-6 lg:gap-8 items-center">

                                    {{-- Text side --}}
                                    <div
                                        class="col-span-12 md:col-span-7 space-y-3 sm:space-y-4 md:space-y-3 lg:space-y-4 text-left">
                                        @if($s->badge_text)
                                            <div
                                                class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full border {{ $t['badge'] }} text-[10px] sm:text-xs font-bold tracking-wider uppercase">
                                                @if($s->badge_icon)<i class="{{ $s->badge_icon }} {{ $t['badgeIcon'] }}"></i>@endif
                                                {{ $s->badge_text }}
                                            </div>
                                        @endif

                                        <{{ $i === 0 ? 'h1' : 'h2' }}
                                            class="text-2xl sm:text-3xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-white tracking-tight leading-[1.15] font-heading">
                                            {{ $s->title_line_1 }}
                                            @if($s->title_highlight)
                                                <br /><span
                                                    class="text-transparent bg-clip-text bg-gradient-to-r {{ $t['hl'] }}">{{ $s->title_highlight }}</span>
                                            @endif
                                        </{{ $i === 0 ? 'h1' : 'h2' }}>

                                        @if($s->description)
                                            <p
                                                class="text-xs sm:text-sm md:text-xs lg:text-base text-slate-300 max-w-xl font-body leading-relaxed">
                                                {{ $s->description }}
                                            </p>
                                        @endif

                                        <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 pt-1 sm:pt-2">
                                            @if($s->btn_primary_text)
                                                <a href="{{ $url($s->linkValue('btn_primary')) }}"
                                                    class="btn-base btn-primary text-xs sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 font-semibold shadow-lg {{ $t['btn'] }}">
                                                    @if($s->btn_primary_icon)<i class="{{ $s->btn_primary_icon }}"></i>@endif
                                                    {{ $s->btn_primary_text }}
                                                </a>
                                            @endif
                                            @if($s->btn_secondary_text)
                                                <a href="{{ $url($s->linkValue('btn_secondary')) }}"
                                                    class="btn-base btn-secondary text-xs sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 font-semibold bg-white/10 text-white border-white/20 hover:bg-white/20 hover:text-white">
                                                    @if($s->btn_secondary_icon)<i class="{{ $s->btn_secondary_icon }}"></i>@endif
                                                    {{ $s->btn_secondary_text }}
                                                </a>
                                            @endif
                                            @if($s->link_text)
                                                <a href="{{ $url($s->linkValue('link')) }}"
                                                    class="inline-flex items-center gap-1.5 text-xs font-bold {{ $t['link'] }} py-1">
                                                    {{ $s->link_text }}
                                                </a>
                                            @endif
                                        </div>

                                        @php $points = $arr($s->trust_points); @endphp
                                        @if(count($points))
                                            <div
                                                class="pt-1 sm:pt-2 flex flex-wrap items-center gap-3 sm:gap-4 text-[10px] sm:text-xs text-slate-400">
                                                @foreach($points as $p)
                                                    <span class="inline-flex items-center gap-1.5">
                                                        <i class="{{ $p['icon'] ?? '' }} {{ $p['color'] ?? '' }} text-[10px]"></i>
                                                        {{ $p['text'] ?? '' }}
                                                    </span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Product card side --}}
                                    @if($s->card_title || $s->card_image)
                                        <div class="hidden md:flex md:col-span-5 justify-center">
                                            <div class="relative w-full max-w-md">
                                                <div
                                                    class="absolute -inset-1 bg-gradient-to-r {{ $t['glow'] }} rounded-3xl blur-xl opacity-40">
                                                </div>
                                                <div
                                                    class="relative bg-slate-900/90 border border-slate-700/60 rounded-3xl p-3.5 lg:p-4 shadow-2xl backdrop-blur-md">
                                                    <div class="relative overflow-hidden rounded-2xl mb-2.5 lg:mb-3 group">
                                                        @if($s->card_image)
                                                            <img src="{{ asset($s->card_image) }}"
                                                                alt="{{ $s->card_image_alt ?: $s->card_title }}"
                                                                @if($i > 0) loading="lazy" @endif
                                                                class="w-full h-44 lg:h-56 object-cover transform group-hover:scale-105 transition-transform duration-500 rounded-xl" />
                                                        @endif
                                                        @if($s->card_top_badge)
                                                            <span
                                                                class="absolute top-2.5 left-2.5 {{ $t['top'] }} text-white text-[9px] lg:text-[10px] font-extrabold uppercase px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-full shadow-md">
                                                                {{ $s->card_top_badge }}
                                                            </span>
                                                        @endif
                                                        @if($s->card_bottom_badge)
                                                            <span
                                                                class="absolute bottom-2.5 right-2.5 bg-slate-900/80 backdrop-blur-sm {{ $t['bottom'] }} text-[10px] lg:text-[11px] font-bold px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-lg border">
                                                                {{ $s->card_bottom_badge }}
                                                            </span>
                                                        @endif
                                                    </div>
                                                    <div class="flex items-center justify-between text-xs">
                                                        <div>
                                                            @if($s->card_label)
                                                                <span
                                                                    class="text-[9px] lg:text-[10px] uppercase font-bold {{ $t['label'] }} tracking-wider">{{ $s->card_label }}</span>
                                                            @endif
                                                            <div class="font-extrabold text-white text-xs lg:text-base">
                                                                {{ $s->card_title }}</div>
                                                            <span
                                                                class="text-[10px] lg:text-[11px] text-slate-400 font-body">{{ $s->card_subtitle }}</span>
                                                        </div>
                                                        <div class="text-right flex-shrink-0 pl-2">
                                                            @if($s->card_old_price)
                                                                <span
                                                                    class="text-[10px] lg:text-xs text-slate-400 line-through">{{ $s->card_old_price }}</span>
                                                            @endif
                                                            <div class="text-base lg:text-lg font-black text-emerald-400 font-heading">
                                                                {{ $s->card_price }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    @endforeach

                    @if($slideList->count() > 1)
                        <!-- Slider Navigation Controls -->
                        <button type="button" onclick="changeHeroSlide(-1)"
                            class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-slate-900/70 border border-slate-700 text-white hover:bg-blue-600 flex items-center justify-center transition-colors"
                            aria-label="Previous Slide">
                            <i class="fa-solid fa-chevron-left text-xs sm:text-sm"></i>
                        </button>
                        <button type="button" onclick="changeHeroSlide(1)"
                            class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 z-20 w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-slate-900/70 border border-slate-700 text-white hover:bg-blue-600 flex items-center justify-center transition-colors"
                            aria-label="Next Slide">
                            <i class="fa-solid fa-chevron-right text-xs sm:text-sm"></i>
                        </button>

                        <!-- Slider Dots -->
                        <div
                            class="absolute bottom-3 sm:bottom-4 left-1/2 -translate-x-1/2 z-20 flex items-center gap-1.5 sm:gap-2">
                            @foreach($slideList as $i => $s)
                                <button type="button" onclick="setHeroSlide({{ $i }})"
                                    class="hero-dot {{ $i === 0 ? 'w-6 sm:w-8 h-1.5 sm:h-2 rounded-full bg-blue-500 transition-all' : 'w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-slate-600 hover:bg-slate-400 transition-all' }}"
                                    aria-label="Slide {{ $i + 1 }}"></button>
                            @endforeach
                        </div>
                    @endif
                </div>
            </section>
        @endif

        <!-- ==========================================
                 TRUST STRIP
                 ========================================== -->
        @if($trustList->isNotEmpty())
            <section class="bg-white border-b border-slate-200 py-3.5 sm:py-4 shadow-sm" aria-label="Trust Badges">
                <div class="container-custom">
                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-5 text-slate-800">
                        @foreach($trustList as $item)
                            <div
                                class="flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-slate-50/80 border border-slate-100 lg:bg-transparent lg:border-none lg:p-0 min-w-0 {{ $loop->last && $loop->count % 2 === 1 ? 'col-span-2 sm:col-span-1' : '' }}">
                                <div
                                    class="w-8 h-8 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-xl border flex items-center justify-center flex-shrink-0 text-sm sm:text-base lg:text-lg {{ $tone[$item->color] ?? $tone['blue'] }}">
                                    <i class="{{ $item->icon }}"></i>
                                </div>
                                <div class="min-w-0">
                                    <h4
                                        class="text-xs lg:text-sm font-bold leading-tight whitespace-nowrap text-slate-900 font-heading">
                                        {{ $item->title }}</h4>
                                    @if($item->subtitle)
                                        <p class="text-[10px] sm:text-[11px] text-slate-500 leading-tight truncate font-body">
                                            {{ $item->subtitle }}</p>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 SHOP BY CATEGORY
                 ========================================== -->
        @if($hShow('categories') && ($homeCategories ?? collect())->isNotEmpty())
            <section class="section-padding bg-slate-50" aria-label="Categories">
                <div class="container-custom">
                    <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                        <div>
                            <span
                                class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('categories', 'eyebrow', 'Explore Collections') }}</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                                {{ $hVal('categories', 'title', 'Shop By Category') }}</h2>
                            @if($sub = $hVal('categories', 'subtitle'))
                                <p class="section-subtitle text-xs sm:text-sm">{{ $sub }}</p>
                            @endif
                        </div>
                        <a href="{{ $hLink('categories', route('shop')) }}"
                            class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 whitespace-nowrap">
                            {{ $hVal('categories', 'link_text', 'View All Products') }} <i
                                class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 lg:gap-4">
                        @foreach($homeCategories as $category)
                            <a href="{{ route('shop', ['category' => $category->slug]) }}"
                                class="category-card p-3 sm:p-4 lg:p-3.5 flex flex-col justify-between group text-decoration-none bg-white rounded-2xl border border-slate-200/90 hover:border-blue-600 hover:shadow-md transition-all">
                                <div
                                    class="w-full aspect-[4/3] sm:aspect-[16/10] lg:aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 mb-2.5 sm:mb-3 relative">
                                    <img src="{{ $category->image_url ?? $placeholder }}" alt="{{ $category->name }}"
                                        loading="lazy" onerror="this.onerror=null; this.src='{{ $placeholder }}';"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                                    <div
                                        class="absolute top-2 left-2 w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white/95 text-blue-600 flex items-center justify-center text-xs shadow-sm">
                                        <i class="fa-solid {{ $category->icon ?: 'fa-box' }}"></i>
                                    </div>
                                </div>
                                <div>
                                    <h3
                                        class="text-sm sm:text-base lg:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-tight font-heading">
                                        {{ $category->name }}
                                    </h3>
                                    @if($category->sub_title)
                                        <p class="text-[11px] sm:text-xs lg:text-[11px] text-slate-500 mb-2 leading-tight">
                                            {{ $category->sub_title }}</p>
                                    @endif
                                    <span
                                        class="text-xs font-bold text-blue-600 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">Explore
                                        →</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 BRAND PHILOSOPHY (CTA block: brand_philosophy)
                 ========================================== -->
        @php $bp = $cta('brand_philosophy'); @endphp
        @if($bp && $bp->is_active)
            <section class="py-8 sm:py-12 bg-slate-900 text-white relative overflow-hidden" aria-label="Brand Philosophy">
                <div class="container-custom relative z-10">
                    <div
                        class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 p-6 sm:p-8 md:p-10 lg:p-12 rounded-3xl border border-slate-700/60 shadow-xl">
                        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-center">
                            <div class="md:col-span-8 space-y-3 sm:space-y-4">
                                @if($bp->badge_text)
                                    <span
                                        class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1">{{ $bp->badge_text }}</span>
                                @endif
                                <h2
                                    class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
                                    {{ $bp->title }}
                                </h2>
                                @if($bp->description)
                                    <p class="text-xs sm:text-sm text-slate-300">{{ $bp->description }}</p>
                                @endif
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-xs sm:text-sm text-slate-300">
                                    @foreach($arr($bp->items) as $it)
                                        <div class="flex items-start gap-2.5">
                                            <i class="{{ $it['icon'] ?? 'fa-solid fa-circle-check' }} {{ $it['color'] ?? 'text-blue-400' }} mt-1"></i>
                                            <div>{!! $it['text'] ?? '' !!}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @if($bp->btn_1_text)
                                <div class="md:col-span-4 flex md:justify-end">
                                    <a href="{{ $url($bp->linkValue('btn_1')) }}"
                                        class="btn-base btn-primary px-6 sm:px-8 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold shadow-lg shadow-blue-600/30 w-full sm:w-auto text-center justify-center">
                                        {{ $bp->btn_1_text }}
                                        @if($bp->btn_1_icon)<i class="{{ $bp->btn_1_icon }} ml-2 text-xs"></i>@endif
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 FEATURED SECTION #1  (heading key: featured_1)
                 ========================================== -->
        @php $section = ($homeSections ?? collect())->get(0); @endphp
        @if($section && $hShow('featured_1'))
            @php $category = $section['category']; @endphp
            <section class="section-padding bg-white" aria-label="Featured {{ $category->name }}">
                <div class="container-custom">
                    <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                        <div>
                            <span
                                class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('featured_1', 'eyebrow', 'Featured Picks') }}</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                                {{ $hVal('featured_1', 'title', 'Featured ' . $category->name) }}
                            </h2>
                            @if($sub = $hVal('featured_1', 'subtitle', $category->sub_title))
                                <p class="section-subtitle text-xs sm:text-sm">{{ $sub }}</p>
                            @endif
                        </div>
                        <a href="{{ $hLink('featured_1', route('shop', ['category' => $category->slug])) }}"
                            class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 whitespace-nowrap">
                            {{ $hVal('featured_1', 'link_text', 'Browse All') }} <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                        @foreach($section['products'] as $product)
                            @include('partials.product-card', ['product' => $product, 'listingAttributes' => $section['listingAttributes']])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 BUDGET CARDS  (heading key: budget)
                 ========================================== -->
        @if($budgetList->isNotEmpty() && $hShow('budget'))
            <section class="py-8 sm:py-10 bg-slate-50 border-y border-slate-200" aria-label="Budget Laptops">
                <div class="container-custom">
                    <h3
                        class="text-lg sm:text-xl font-bold text-slate-900 mb-4 sm:mb-6 font-heading flex items-center gap-2">
                        <i class="fa-solid fa-tags text-blue-600"></i> {{ $hVal('budget', 'title', 'Shop Laptops By Budget') }}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3.5 sm:gap-4">
                        @foreach($budgetList as $b)
                            @php
                                $q = array_filter([
                                    'minPrice' => $b->min_price,
                                    'maxPrice' => $b->max_price,
                                    'category' => optional($b->category ?? null)->slug,
                                ]);
                            @endphp
                            <a href="{{ route('shop', $q) }}"
                                class="p-5 sm:p-6 rounded-2xl bg-gradient-to-br {{ $b->gradient ?: 'from-blue-900 to-slate-900' }} text-white shadow-md hover:shadow-lg transition-transform hover:-translate-y-1 block text-decoration-none">
                                @if($b->label)
                                    <span
                                        class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider {{ $b->label_color ?: 'text-emerald-400' }}">{{ $b->label }}</span>
                                @endif
                                <h4 class="text-lg sm:text-xl font-extrabold text-white mt-1 mb-1.5 sm:mb-2 font-heading">
                                    {{ $b->title }}</h4>
                                @if($b->description)
                                    <p class="text-xs text-slate-300 mb-3 sm:mb-4 leading-relaxed">{{ $b->description }}</p>
                                @endif
                                <span
                                    class="text-xs font-bold text-white {{ $b->button_color ?: 'bg-blue-600' }} px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-lg inline-flex items-center gap-1.5">{{ $b->button_text }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 FEATURED SECTION #2  (heading key: featured_2)
                 ========================================== -->
        @php $section = ($homeSections ?? collect())->get(1); @endphp
        @if($section && $hShow('featured_2'))
            @php $category = $section['category']; @endphp
            <section class="section-padding bg-white" aria-label="Featured {{ $category->name }}">
                <div class="container-custom">
                    <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                        <div>
                            <span
                                class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('featured_2', 'eyebrow', 'Featured Picks') }}</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                                {{ $hVal('featured_2', 'title', 'Featured ' . $category->name) }}
                            </h2>
                            @if($sub = $hVal('featured_2', 'subtitle', $category->sub_title))
                                <p class="section-subtitle text-xs sm:text-sm">{{ $sub }}</p>
                            @endif
                        </div>
                        <a href="{{ $hLink('featured_2', route('shop', ['category' => $category->slug])) }}"
                            class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 whitespace-nowrap">
                            {{ $hVal('featured_2', 'link_text', 'Browse All') }} <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                        @foreach($section['products'] as $product)
                            @include('partials.product-card', ['product' => $product, 'listingAttributes' => $section['listingAttributes']])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 GUIDED RECOMMENDATION  (heading key: guided)
                 ========================================== -->
        @if($guidedList->isNotEmpty() && $hShow('guided'))
            <section class="section-padding bg-slate-50/80 border-y border-slate-200/80" aria-label="Product Finder Guide">
                <div class="container-custom">
                    <div class="text-center max-w-2xl mx-auto mb-12">
                        <span
                            class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider">
                            <i class="fa-solid fa-compass text-blue-600"></i>
                            {{ $hVal('guided', 'eyebrow', 'Guided Recommendation') }}
                        </span>
                        <h2
                            class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading tracking-tight mt-3 mb-2">
                            {{ $hVal('guided', 'title', "What's Right For You?") }}
                        </h2>
                        @if($sub = $hVal('guided', 'subtitle'))
                            <p class="text-sm sm:text-base text-slate-600 font-body">{{ $sub }}</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">
                        @foreach($guidedList as $g)
                            @php $gt = $guidedTheme[$g->color] ?? $guidedTheme['blue']; @endphp
                            <div
                                class="bg-white rounded-2xl sm:rounded-3xl p-5 md:p-5 lg:p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                                <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r {{ $gt['bar'] }}"></div>
                                <div>
                                    <div class="flex items-center justify-between mb-3.5">
                                        <div
                                            class="w-12 h-12 md:w-11 md:h-11 lg:w-14 lg:h-14 rounded-xl sm:rounded-2xl border flex items-center justify-center text-xl md:text-lg lg:text-2xl group-hover:scale-110 group-hover:text-white transition-all duration-300 shadow-sm {{ $gt['box'] }}">
                                            <i class="{{ $g->icon }}"></i>
                                        </div>
                                        @if($g->badge)
                                            <span
                                                class="badge border text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full {{ $gt['badge'] }}">{{ $g->badge }}</span>
                                        @endif
                                    </div>

                                    <h3
                                        class="text-lg md:text-lg lg:text-xl font-extrabold text-slate-900 font-heading mb-1.5 transition-colors {{ $gt['title'] }}">
                                        {{ $g->title }}</h3>
                                    @if($g->description)
                                        <p
                                            class="text-xs md:text-xs lg:text-sm text-slate-600 mb-4 md:mb-4 lg:mb-5 leading-relaxed font-body">
                                            {{ $g->description }}</p>
                                    @endif

                                    @php $feat = $arr($g->features); @endphp
                                    @if(count($feat))
                                        <ul
                                            class="space-y-2 md:space-y-2 lg:space-y-2.5 text-xs md:text-xs lg:text-sm text-slate-700 mb-5 md:mb-5 lg:mb-6 bg-slate-50/80 p-3 md:p-3.5 lg:p-4 rounded-xl md:rounded-2xl border border-slate-100">
                                            @foreach($feat as $f)
                                                <li class="flex items-center gap-2">
                                                    <span
                                                        class="w-4 h-4 rounded-full flex items-center justify-center text-[9px] flex-shrink-0 font-bold {{ $gt['check'] }}"><i
                                                            class="fa-solid fa-check"></i></span>
                                                    <span class="truncate">{!! $f !!}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </div>

                                @if($g->button_text)
                                    <a href="{{ $url($g->linkValue('button')) }}"
                                        class="btn-base w-full py-2.5 md:py-2.5 lg:py-3 text-xs md:text-xs lg:text-sm font-bold text-white shadow-md flex items-center justify-center gap-2 group-hover:gap-3 transition-all rounded-xl {{ $gt['btn'] }}">
                                        <span>{{ $g->button_text }}</span> <i class="fa-solid fa-arrow-right text-xs"></i>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 FEATURED SECTION #3 / ACCESSORIES  (heading key: accessories)
                 ========================================== -->
        @php $section = ($homeSections ?? collect())->get(2); @endphp
        @if($section && $hShow('accessories'))
            @php $category = $section['category']; @endphp
            <section class="section-padding bg-white" aria-label="{{ $category->name }}">
                <div class="container-custom">
                    <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                        <div>
                            <span
                                class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('accessories', 'eyebrow', 'Gear & Upgrades') }}</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                                {{ $hVal('accessories', 'title', $category->name) }}</h2>
                            @if($sub = $hVal('accessories', 'subtitle', $category->sub_title))
                                <p class="section-subtitle text-xs sm:text-sm">{{ $sub }}</p>
                            @endif
                        </div>
                        <a href="{{ $hLink('accessories', route('shop', ['category' => $category->slug])) }}"
                            class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 whitespace-nowrap">
                            {{ $hVal('accessories', 'link_text', 'View All') }} <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                        @foreach($section['products'] as $product)
                            @include('partials.product-card', ['product' => $product, 'listingAttributes' => $section['listingAttributes']])
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 BRANDS  (heading key: brands)
                 ========================================== -->
        @if(($homeBrands ?? collect())->isNotEmpty() && $hShow('brands'))
            <section class="section-padding bg-slate-50 border-y border-slate-200" aria-label="Top Brands">
                <div class="container-custom">
                    <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                        <div>
                            <span
                                class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('brands', 'eyebrow', 'Certified Technology Partners') }}</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                                {{ $hVal('brands', 'title', 'Shop By Brand') }}</h2>
                            @if($sub = $hVal('brands', 'subtitle'))
                                <p class="section-subtitle text-xs sm:text-sm">{{ $sub }}</p>
                            @endif
                        </div>
                        <a href="{{ $hLink('brands', route('shop')) }}"
                            class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 font-body whitespace-nowrap">
                            {{ $hVal('brands', 'link_text', 'View All') }} <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">
                        @foreach($homeBrands as $brand)
                            <a href="{{ route('shop', ['brand' => [$brand->id]]) }}"
                                class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-blue-600 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                                <div class="h-12 sm:h-14 flex items-center justify-center w-full">
                                    @if($brand->logo_url)
                                        <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" loading="lazy"
                                            class="max-h-10 sm:max-h-12 w-auto max-w-[85%] object-contain group-hover:scale-105 transition-transform duration-200" />
                                    @else
                                        <span
                                            class="text-base sm:text-lg font-black text-slate-800 tracking-tight group-hover:scale-105 transition-transform duration-200 font-heading">{{ $brand->name }}</span>
                                    @endif
                                </div>
                                <div class="mt-1">
                                    <span
                                        class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">{{ $brand->name }}</span>
                                    @if($brand->products_count > 0)
                                        <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">
                                            {{ $brand->products_count }} {{ $brand->products_count === 1 ? 'Product' : 'Products' }}
                                        </span>
                                    @endif
                                </div>
                                <span
                                    class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                                    →</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 HOW WE REFURBISH  (heading key: refurbish)
                 ========================================== -->
        @if($stepList->isNotEmpty() && $hShow('refurbish'))
            <section class="section-padding bg-white" aria-label="Refurbishment Process" id="how-we-refurbish">
                <div class="container-custom">
                    <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12">
                        <span
                            class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('refurbish', 'eyebrow', 'Quality Control Protocol') }}</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                            {{ $hVal('refurbish', 'title', 'How We Refurbish') }}</h2>
                        @if($sub = $hVal('refurbish', 'subtitle'))
                            <p class="section-subtitle text-xs sm:text-sm">{{ $sub }}</p>
                        @endif
                    </div>

                    <div
                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 {{ $stepList->count() >= 6 ? 'lg:grid-cols-6' : 'lg:grid-cols-' . max($stepList->count(), 1) }} gap-3 sm:gap-4">
                        @foreach($stepList as $st)
                            <div
                                class="p-3.5 sm:p-5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 relative text-center flex flex-col items-center justify-start">
                                <div
                                    class="w-7 h-7 sm:w-8 sm:h-8 rounded-full text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 sm:mb-3 {{ $solid[$st->color] ?? $solid['blue'] }}">
                                    {{ $loop->iteration }}</div>
                                <h4 class="text-[11px] sm:text-xs font-bold text-slate-900 uppercase mb-1">{{ $st->title }}</h4>
                                @if($st->description)
                                    <p class="text-[10px] sm:text-[11px] text-slate-500 leading-snug">{{ $st->description }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 WHY CHOOSE US  (heading key: why_us)
                 ========================================== -->
        @if($whyList->isNotEmpty() && $hShow('why_us'))
            <section class="section-padding bg-slate-50" aria-label="Why Choose Us">
                <div class="container-custom">
                    <div class="text-center max-w-xl mx-auto mb-8 sm:mb-12">
                        <span
                            class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('why_us', 'eyebrow', 'The Standard We Set') }}</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                            {{ $hVal('why_us', 'title', 'Why VANSH IT & COMM') }}</h2>
                        @if($sub = $hVal('why_us', 'subtitle'))
                            <p class="section-subtitle text-xs sm:text-sm">{{ $sub }}</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                        @foreach($whyList as $w)
                            <div class="card-base p-4 sm:p-5">
                                <i
                                    class="{{ $w->icon }} {{ $iconText[$w->color] ?? 'text-blue-600' }} text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                                <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">{{ $w->title }}</h4>
                                @if($w->subtitle)
                                    <p class="text-[11px] sm:text-xs text-slate-500">{{ $w->subtitle }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 REPAIR CTA  (CTA block: repair_cta)
                 ========================================== -->
        @php $rc = $cta('repair_cta'); @endphp
        @if($rc && $rc->is_active)
            <section class="py-12 sm:py-16 bg-slate-950 text-white relative overflow-hidden"
                aria-label="Repair Call to Action">
                <div class="container-custom">
                    <div class="grid grid-cols-12 gap-6 sm:gap-8 items-center">
                        <div class="col-span-12 md:col-span-7 space-y-4">
                            @if($rc->badge_text)
                                <span
                                    class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1">{{ $rc->badge_text }}</span>
                            @endif
                            <h2
                                class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
                                {{ $rc->title }}
                            </h2>
                            @if($rc->description)
                                <p class="text-xs sm:text-sm text-slate-300 font-body leading-relaxed max-w-xl">
                                    {{ $rc->description }}</p>
                            @endif
                            <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-2">
                                @if($rc->btn_1_text)
                                    <a href="{{ $url($rc->linkValue('btn_1')) }}"
                                        class="btn-base btn-primary px-5 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold shadow-lg shadow-blue-600/30">
                                        @if($rc->btn_1_icon)<i class="{{ $rc->btn_1_icon }}"></i>@endif {{ $rc->btn_1_text }}
                                    </a>
                                @endif
                                @if($rc->btn_2_text)
                                    <a href="{{ $url($rc->linkValue('btn_2')) }}"
                                        class="btn-base btn-secondary bg-white/10 text-white border-white/20 px-5 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold hover:bg-white/20">
                                        @if($rc->btn_2_icon)<i class="{{ $rc->btn_2_icon }}"></i>@endif {{ $rc->btn_2_text }}
                                    </a>
                                @endif
                                @if($rc->btn_3_text)
                                    <a href="{{ $url($rc->linkValue('btn_3')) }}"
                                        class="btn-base btn-dark bg-slate-800 text-white border border-slate-700 px-5 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold hover:bg-slate-700">
                                        @if($rc->btn_3_icon)<i class="{{ $rc->btn_3_icon }}"></i>@endif {{ $rc->btn_3_text }}
                                    </a>
                                @endif
                            </div>
                        </div>

                        @php $fixes = $arr($rc->items); @endphp
                        @if(count($fixes))
                            <div class="col-span-12 md:col-span-5 mt-4 md:mt-0">
                                <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 sm:p-6 space-y-3">
                                    <h4
                                        class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider mb-2 font-heading">
                                        Common Fast Fixes</h4>
                                    @foreach($fixes as $fx)
                                        <div
                                            class="flex items-center justify-between gap-3 text-xs py-2 text-slate-300 {{ !$loop->last ? 'border-b border-slate-800' : '' }}">
                                            <span><i class="{{ $fx['icon'] ?? '' }} {{ $fx['color'] ?? '' }} mr-2"></i>
                                                {{ $fx['text'] ?? '' }}</span>
                                            @if(!empty($fx['tag']))
                                                <span class="text-emerald-400 font-bold text-right">{{ $fx['tag'] }}</span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 EXCHANGE CTA  (CTA block: exchange_cta)
                 ========================================== -->
        @php $ex = $cta('exchange_cta'); @endphp
        @if($ex && $ex->is_active)
            <section class="section-padding bg-slate-50" aria-label="Trade In and Upgrade">
                <div class="container-custom">
                    <div class="bg-white border border-slate-200 rounded-2xl sm:rounded-3xl p-6 sm:p-8 lg:p-12 shadow-sm">
                        <div class="grid grid-cols-12 gap-6 sm:gap-8 items-center">
                            <div class="col-span-12 md:col-span-8 space-y-3">
                                @if($ex->badge_text)
                                    <span
                                        class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-3 py-1">{{ $ex->badge_text }}</span>
                                @endif
                                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">{{ $ex->title }}
                                </h2>
                                @if($ex->description)
                                    <p class="text-xs sm:text-sm text-slate-600 max-w-xl font-body">{{ $ex->description }}</p>
                                @endif
                            </div>
                            @if($ex->btn_1_text)
                                <div class="col-span-12 md:col-span-4 flex md:justify-end">
                                    <a href="{{ $url($ex->linkValue('btn_1')) }}"
                                        class="btn-base btn-success px-5 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold shadow-md whitespace-nowrap">
                                        @if($ex->btn_1_icon)<i class="{{ $ex->btn_1_icon }} mr-2"></i>@endif
                                        {{ $ex->btn_1_text }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 STORE LOCATIONS  (heading key: store_locations)
                 ========================================== -->
        @if($storeList->isNotEmpty() && $hShow('store_locations'))
            <section class="py-10 sm:py-12 bg-white" aria-label="Store Locations">
                <div class="container-custom">
                    <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                        <div>
                            <span
                                class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('store_locations', 'eyebrow', 'Physical Hub & Logistics') }}</span>
                            <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">
                                {{ $hVal('store_locations', 'title', 'Store Locations & Hubs') }}</h2>
                            @if($sub = $hVal('store_locations', 'subtitle'))
                                <p class="section-subtitle text-xs sm:text-sm">{{ $sub }}</p>
                            @endif
                        </div>
                        @if($hVal('store_locations', 'link_text'))
                            <a href="{{ $hLink('store_locations', route('contact')) }}"
                                class="text-xs font-bold text-blue-600 hover:underline whitespace-nowrap">
                                {{ $hVal('store_locations', 'link_text') }}
                            </a>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
                        @foreach($storeList as $st)
                            <div
                                class="card-base p-5 sm:p-6 flex flex-col justify-between bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md transition-all {{ $hoverBorder[$st->color] ?? 'hover:border-blue-500' }}">
                                <div>
                                    <div class="flex items-center justify-between mb-3">
                                        <div
                                            class="w-10 h-10 rounded-xl flex items-center justify-center text-lg shadow-sm {{ $tone[$st->color] ?? $tone['blue'] }}">
                                            <i class="{{ $st->icon }}"></i>
                                        </div>
                                        @if($st->badge)
                                            <span
                                                class="badge border text-[10px] font-bold uppercase px-2 py-0.5 rounded-full {{ $badgeTone[$st->color] ?? $badgeTone['blue'] }}">{{ $st->badge }}</span>
                                        @endif
                                    </div>
                                    <h4 class="text-base font-bold text-slate-900 mb-1 font-heading">{{ $st->title }}</h4>
                                    @if($st->address)
                                        <p class="text-xs text-slate-500 mb-4 font-body">{{ $st->address }}</p>
                                    @endif
                                    <div class="text-xs text-slate-600 space-y-1.5 mb-5 font-body">
                                        @foreach($arr($st->details) as $d)
                                            <div class="flex items-center gap-2">
                                                <i class="{{ $d['icon'] ?? '' }} text-slate-400 w-3.5"></i>
                                                <span>{{ $d['text'] ?? '' }}</span>
                                            </div>
                                        @endforeach
                                        @if($st->phone)
                                            <div class="flex items-center gap-2">
                                                <i class="fa-solid fa-phone text-slate-400 w-3.5"></i>
                                                <a href="tel:{{ preg_replace('/[^0-9+]/', '', $st->phone) }}">{{ $st->phone }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                @if($st->button_text)
                                    <a href="{{ $url($st->linkValue('button')) }}"
                                        class="btn-base btn-secondary btn-sm w-full text-xs font-semibold py-2">{{ $st->button_text }}</a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 CUSTOMER REVIEWS  (heading key: reviews)
                 ========================================== -->
        @if($hShow('reviews'))
            <section class="section-padding bg-slate-50 border-t border-slate-200" aria-label="Customer Testimonials">
                <div class="container-custom">
                    <div class="text-center max-w-xl mx-auto mb-10">
                        <span
                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider mb-2">
                            <i class="fa-solid fa-star text-amber-400"></i>
                            {{ $hVal('reviews', 'eyebrow', 'Trusted by Buyers') }}
                        </span>
                        <h2 class="text-3xl font-extrabold text-slate-900 font-heading">
                            {{ $hVal('reviews', 'title', 'Customer Reviews') }}</h2>
                        @if($sub = $hVal('reviews', 'subtitle'))
                            <p class="text-xs text-slate-500 font-body">{{ $sub }}</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5" id="reviews-container">
                        <!-- Dynamically populated from REVIEWS_DATA -->
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 FAQ  (heading key: faq)
                 ========================================== -->
        @if(($homeFaqs ?? collect())->isNotEmpty() && $hShow('faq'))
            <section class="section-padding bg-white" aria-label="FAQs">
                <div class="container-custom max-w-4xl">
                    <div class="text-center mb-10">
                        <span
                            class="text-xs font-bold text-blue-600 uppercase tracking-wider">{{ $hVal('faq', 'eyebrow', 'Got Questions?') }}</span>
                        <h2 class="text-3xl font-extrabold text-slate-900 font-heading">
                            {{ $hVal('faq', 'title', 'Frequently Asked Questions') }}</h2>
                        @if($sub = $hVal('faq', 'subtitle'))
                            <p class="section-subtitle">{{ $sub }}</p>
                        @endif
                    </div>

                    <div class="space-y-3" id="faq-accordion-container">
                        @foreach($homeFaqs as $idx => $faq)
                            <div class="border border-slate-200 rounded-xl overflow-hidden">
                                <button type="button" onclick="toggleFaq({{ $idx }})"
                                    class="w-full flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100/80 text-left font-bold text-slate-900 text-sm transition-colors">
                                    <span>{{ $faq->question }}</span>
                                    <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform"
                                        id="faq-icon-{{ $idx }}"></i>
                                </button>
                                <div id="faq-ans-{{ $idx }}"
                                    class="hidden p-4 bg-white text-xs text-slate-600 border-t border-slate-100 leading-relaxed font-body">
                                    {!! $faq->answer !!}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        <!-- ==========================================
                 FINAL CTA  (CTA block: final_cta)
                 ========================================== -->
        @php $fc = $cta('final_cta'); @endphp
        @if($fc && $fc->is_active)
            <section class="py-16 bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950 text-white text-center"
                aria-label="Final Call to Action">
                <div class="container-custom max-w-3xl space-y-4">
                    @if($fc->badge_text)
                        <span
                            class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1">{{ $fc->badge_text }}</span>
                    @endif
                    <h2 class="text-4xl font-extrabold text-white tracking-tight font-heading">{{ $fc->title }}</h2>
                    @if($fc->description)
                        <p class="text-base text-slate-300 font-body leading-relaxed">{{ $fc->description }}</p>
                    @endif
                    <div class="flex flex-wrap items-center justify-center gap-3 pt-4">
                        @if($fc->btn_1_text)
                            <a href="{{ $url($fc->linkValue('btn_1')) }}"
                                class="btn-base btn-primary px-6 py-3 font-semibold shadow-lg shadow-blue-600/30">
                                @if($fc->btn_1_icon)<i class="{{ $fc->btn_1_icon }}"></i>@endif {{ $fc->btn_1_text }}
                            </a>
                        @endif
                        @if($fc->btn_2_text)
                            <a href="{{ $url($fc->linkValue('btn_2')) }}"
                                class="btn-base btn-secondary bg-white/10 text-white border-white/20 px-6 py-3 font-semibold hover:bg-white/20">
                                @if($fc->btn_2_icon)<i class="{{ $fc->btn_2_icon }}"></i>@endif {{ $fc->btn_2_text }}
                            </a>
                        @endif
                        @if($fc->btn_3_text)
                            <a href="{{ $url($fc->linkValue('btn_3')) }}"
                                class="btn-base btn-dark bg-slate-800 text-white border border-slate-700 px-6 py-3 font-semibold hover:bg-slate-700">
                                @if($fc->btn_3_icon)<i class="{{ $fc->btn_3_icon }}"></i>@endif {{ $fc->btn_3_text }}
                            </a>
                        @endif
                    </div>
                </div>
            </section>
        @endif

    </main>

@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            // Render Reviews (only if the static REVIEWS_DATA exists on this page)
            const revContainer = document.getElementById('reviews-container');
            if (revContainer && typeof REVIEWS_DATA !== 'undefined') {
                revContainer.innerHTML = REVIEWS_DATA.map(r => `
                    <div class="card-base p-5 flex flex-col justify-between h-full bg-white rounded-2xl border border-slate-200 hover:shadow-md transition-all">
                        <div>
                            <div class="flex items-center text-amber-400 text-xs mb-3 gap-0.5">
                                ${'<i class="fa-solid fa-star"></i>'.repeat(r.rating)}
                                <span class="text-slate-400 text-[10px] font-medium ml-2 font-body">${r.date || 'Verified'}</span>
                            </div>
                            <p class="text-xs text-slate-700 italic mb-5 leading-relaxed font-body">"${r.comment}"</p>
                        </div>
                        <div class="pt-3.5 border-t border-slate-100 flex items-center justify-between gap-2">
                            <div class="min-w-0 flex-1 pr-1">
                                <strong class="text-xs font-bold text-slate-900 block truncate font-heading">${r.name}</strong>
                                <span class="text-[10px] text-slate-400 block truncate font-body">${r.city} • ${r.product}</span>
                            </div>
                            <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9px] font-extrabold flex-shrink-0 whitespace-nowrap px-2 py-0.5 rounded-md inline-flex items-center gap-1 uppercase tracking-wider">
                                <i class="fa-solid fa-circle-check text-emerald-600"></i> ${r.badge}
                            </span>
                        </div>
                    </div>
                `).join('');
            }

            // Start Hero Slider Autoplay (only when there is more than one slide)
            if (document.querySelectorAll('.hero-slide').length > 1) startHeroSlider();
        });

        // Hero Slider Engine
        let currentSlide = 0;
        let sliderInterval = null;

        function setHeroSlide(index) {
            const slides = document.querySelectorAll('.hero-slide');
            const dots = document.querySelectorAll('.hero-dot');
            if (!slides.length) return;

            currentSlide = (index + slides.length) % slides.length;

            slides.forEach((slide, idx) => {
                if (idx === currentSlide) {
                    slide.classList.remove('opacity-0', 'z-0');
                    slide.classList.add('opacity-100', 'z-10');
                } else {
                    slide.classList.remove('opacity-100', 'z-10');
                    slide.classList.add('opacity-0', 'z-0');
                }
            });

            dots.forEach((dot, idx) => {
                if (idx === currentSlide) {
                    dot.className = 'hero-dot w-8 h-2 rounded-full bg-blue-500 transition-all';
                } else {
                    dot.className = 'hero-dot w-2 h-2 rounded-full bg-slate-600 hover:bg-slate-400 transition-all';
                }
            });
        }

        function changeHeroSlide(delta) {
            setHeroSlide(currentSlide + delta);
            resetHeroInterval();
        }

        function startHeroSlider() {
            sliderInterval = setInterval(() => {
                setHeroSlide(currentSlide + 1);
            }, 5000);
        }

        function resetHeroInterval() {
            clearInterval(sliderInterval);
            startHeroSlider();
        }

        function toggleFaq(idx) {
            const ans = document.getElementById(`faq-ans-${idx}`);
            const icon = document.getElementById(`faq-icon-${idx}`);
            if (!ans) return;
            ans.classList.toggle('hidden');
            if (icon) icon.classList.toggle('rotate-180');
        }
    </script>

@endpush