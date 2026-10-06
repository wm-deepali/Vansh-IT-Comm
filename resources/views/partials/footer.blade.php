{{-- resources/views/partials/footer.blade.php --}}
{{-- $footerCategories and $footerPages are supplied by the 'partials.footer' view composer (AppServiceProvider) --}}
{{-- $general (Setting row) is shared to every view by AppServiceProvider --}}
@php
    $g        = $general ?? null;
    $siteName = $g?->site_name ?: 'VANSH IT & COMM';

    // ── Branding / contact from Settings (each falls back so the footer never looks empty) ──
    $footerLogo  = $g?->footer_logo ? asset('storage/' . $g->footer_logo) : asset('assets/img/vanshitcomm-logo-white.png');
    $badgeText   = $g?->tagline ?: 'Certified Refurbished Hub';
    $aboutText   = $g?->footer_description ?: 'Your trusted destination for certified pre-owned business laptops, verified smartphones, and genuine repair solutions.';
    $phone       = $g?->phone;
    $phoneHref   = $phone ? 'tel:' . preg_replace('/[^0-9+]/', '', $phone) : null;
    $email       = $g?->support_email ?: $g?->admin_email;
    $address     = $g?->business_address;
    $copyright   = $g?->footer_copyright;

    $pillars = [
        ['blue', 'fa-shield-halved', '20-Point QC Tested', 'Rigorous hardware & battery diagnostics.'],
        ['emerald', 'fa-rotate-left', '7-Day Easy Replacement', '100% money-back / replacement guarantee.'],
        ['indigo', 'fa-truck-fast', 'Free Insured Shipping', 'Safe doorstep delivery across all pin codes.'],
        ['amber', 'fa-screwdriver-wrench', 'Up to 12M Warranty', 'Free technical support & service coverage.'],
    ];

    // Change this one line if your category listing route has a different name
    $categoryUrl = fn($category) => route('category.show', $category->slug);

    // Change this one line if your dynamic page route has a different name
    $pageUrl = fn($page) => route('policies', ['tab' => $page->page_name]);

    $columns = [
        // Dynamic: every active top-level category created in admin
        'Shop Now' => collect($footerCategories ?? [])
            ->map(fn($category) => [$category->name, $categoryUrl($category)])
            ->all(),

        'For Customers' => [
            ['Repair Services', route('repair')],
            ['Track Your Order', route('user.track-order')],
            ['Old Device Exchange / Sell', route('exchange')],
        ],

        'Company & Trust' => [
            ['About Us', route('about')],
            ['Contact Us', route('contact')],
            ['Blogs', route('blog')],
            ['FAQs', route('faq')],
        ],

        // Dynamic: every active dynamic page created in admin
        'Policies' => collect($footerPages ?? [])
            ->map(fn($page) => [$page->heading ?: $page->page_name, $pageUrl($page)])
            ->all(),
    ];

    // ── Social links from Settings: only the ones the admin has filled in are shown ──
    $socialUrl = fn($v) => $v ? (preg_match('#^https?://#i', $v) ? $v : 'https://' . ltrim($v, '/')) : null;
    $waDigits  = preg_replace('/\D/', '', (string) ($g?->whatsapp ?? ''));   // store with country code, e.g. 919876543210

    $socials = collect([
        ['wa', 'fa-whatsapp',    'WhatsApp',  $waDigits ? 'https://wa.me/' . $waDigits : null],
        ['ig', 'fa-instagram',   'Instagram', $socialUrl($g?->instagram)],
        ['fb', 'fa-facebook-f',  'Facebook',  $socialUrl($g?->facebook)],
        ['yt', 'fa-youtube',     'YouTube',   $socialUrl($g?->youtube)],
        ['',   'fa-twitter',     'Twitter',   $socialUrl($g?->twitter)],
        ['',   'fa-linkedin-in', 'LinkedIn',  $socialUrl($g?->linkedin)],
        ['',   'fa-pinterest-p', 'Pinterest', $socialUrl($g?->pinterest)],
    ])->filter(fn($s) => $s[3])->values();
@endphp

<footer class="bg-[#070D18] text-slate-300 pt-14 pb-20 lg:pb-12 border-t border-slate-800">
    <div class="container-custom">

        {{-- Trust Pillars --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-12 pb-12 border-b border-slate-800/80">
            @foreach ($pillars as [$c, $icon, $title, $text])
                <div class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-slate-700 transition-colors">
                    <div class="w-11 h-11 rounded-xl bg-{{ $c }}-500/10 text-{{ $c }}-400 border border-{{ $c }}-500/20 flex items-center justify-center text-lg flex-shrink-0">
                        <i class="fa-solid {{ $icon }}"></i>
                    </div>
                    <div>
                        <h5 class="text-xs font-bold text-white font-heading">{{ $title }}</h5>
                        <p class="text-[11px] text-slate-400 mt-0.5">{{ $text }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Newsletter --}}
        <div class="bg-gradient-to-r from-blue-950/60 via-slate-900/90 to-slate-950 rounded-3xl p-6 sm:p-8 border border-blue-500/20 mb-14 flex flex-col lg:flex-row items-center justify-between gap-6 shadow-xl">
            <div class="flex items-center gap-4 text-center sm:text-left">
                <div class="w-12 h-12 rounded-2xl bg-blue-600/20 text-blue-400 border border-blue-500/30 flex items-center justify-center text-xl flex-shrink-0">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <div>
                    <div class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-500/20 text-blue-300 border border-blue-500/30 mb-1">
                        WEEKLY DEALS & STOCK ALERTS
                    </div>
                    <h4 class="text-base font-extrabold text-white font-heading leading-tight">Join 15,000+ Smart Tech Buyers</h4>
                    <p class="text-xs text-slate-400 mt-0.5">Get instant alerts on fresh laptop arrivals, mobile clearance sales & exclusive coupons.</p>
                </div>
            </div>

            <form class="flex items-center gap-2 max-w-md w-full" onsubmit="App.handleNewsletter(event, this)">
                <div class="relative flex-1">
                    <i class="fa-regular fa-envelope absolute left-3.5 top-3 text-slate-500 text-xs"></i>
                    <input type="email" required placeholder="Enter your email address..."
                        class="w-full bg-slate-950 border border-slate-700 text-white placeholder-slate-500 rounded-xl pl-9 pr-3.5 py-2.5 text-xs focus:outline-none focus:border-blue-500 transition-colors" />
                </div>
                <button type="submit" class="btn-base btn-primary text-xs px-5 py-2.5 font-bold rounded-xl whitespace-nowrap shadow-lg">
                    Subscribe <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </button>
            </form>
        </div>

        {{-- Main Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-6 xl:gap-8 pb-12 border-b border-slate-800/80">

            <div class="sm:col-span-2 lg:col-span-4 space-y-4">
                <a href="{{ route('home') }}" class="inline-block group" aria-label="{{ $siteName }}">
                    <img src="{{ $footerLogo }}" alt="{{ $siteName }}" class="h-9 w-auto object-contain transition-transform group-hover:scale-105" />
                </a>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20 whitespace-nowrap">
                        <i class="fa-solid fa-check-circle text-[10px] flex-shrink-0"></i> {{ $badgeText }}
                    </span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed font-body">{{ $aboutText }}</p>

                @if($phone || $email || $address)
                    <div class="pt-2 space-y-2.5 text-xs font-body">
                        @if($phone)
                            <a href="{{ $phoneHref }}" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition-colors">
                                <span class="w-6 h-6 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0 text-[10px]"><i class="fa-solid fa-phone"></i></span>
                                <span class="whitespace-nowrap">{{ $phone }}</span>
                            </a>
                        @endif
                        @if($email)
                            <a href="mailto:{{ $email }}" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition-colors">
                                <span class="w-6 h-6 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0 text-[10px]"><i class="fa-solid fa-envelope"></i></span>
                                <span class="break-all">{{ $email }}</span>
                            </a>
                        @endif
                        @if($address)
                            <div class="flex items-start gap-2.5 text-slate-400">
                                <span class="w-6 h-6 rounded-lg bg-slate-800 text-slate-400 flex items-center justify-center flex-shrink-0 text-[10px]"><i class="fa-solid fa-location-dot"></i></span>
                                <span class="leading-relaxed">{!! nl2br(e($address)) !!}</span>
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            @foreach ($columns as $heading => $links)
                {{-- Hide a column entirely if it has no links (e.g. no categories / pages created yet) --}}
                @continue(empty($links))

                <div class="lg:col-span-2">
                    <h4 class="text-xs font-extrabold text-white uppercase tracking-wider font-heading mb-4 pb-1 border-b border-slate-800/60">{{ $heading }}</h4>
                    <ul class="space-y-2.5 font-body text-xs">
                        @foreach ($links as $link)
                            <li><a href="{{ $link[1] }}" class="footer-link {{ $link[2] ?? '' }}">{{ $link[0] }}</a></li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        {{-- Bottom Row --}}
        <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-5 text-xs text-slate-500 font-body">
            <div class="space-y-1 text-center md:text-left">
                @if($copyright)
                    <p>{{ $copyright }}</p>
                @else
                    <p>&copy; {{ date('Y') }} <strong class="text-slate-300 font-bold">{{ $siteName }}</strong>. All rights reserved. 100% GST Tax Compliant.</p>
                @endif
                <p class="text-[11px] text-slate-500">All brand trademarks, logos, and model names belong to their respective manufacturers.</p>
            </div>

            @if($socials->isNotEmpty())
                <div class="flex items-center gap-3">
                    @foreach ($socials as [$cls, $icon, $label, $href])
                        <a href="{{ $href }}" target="_blank" rel="noopener noreferrer"
                           class="footer-social-btn {{ $cls }}" aria-label="{{ $label }}" title="{{ $label }}">
                            <i class="fa-brands {{ $icon }}"></i>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</footer>