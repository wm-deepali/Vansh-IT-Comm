{{-- resources/views/partials/footer.blade.php --}}
@php
    $pillars = [
        ['blue', 'fa-shield-halved', '20-Point QC Tested', 'Rigorous hardware & battery diagnostics.'],
        ['emerald', 'fa-rotate-left', '7-Day Easy Replacement', '100% money-back / replacement guarantee.'],
        ['indigo', 'fa-truck-fast', 'Free Insured Shipping', 'Safe doorstep delivery across all pin codes.'],
        ['amber', 'fa-screwdriver-wrench', 'Up to 12M Warranty', 'Free technical support & service coverage.'],
    ];

    $columns = [
        'Shop Hardware' => [
            ['Refurbished Laptops', route('home')],
            ['Refurbished Mobiles', route('home')],
            ['Computer Accessories', route('home')],
            ['Under ₹15,000 Budget', route('home', ['maxPrice' => 15000]), 'text-emerald-400'],
            ['Deals & Clearance Hub', route('shop')],
            ['All Categories Hub', route('categories')],
        ],
        'Expert Services' => [
            ['Screen & Battery Repair', route('repair')],
            ['Motherboard Diagnostics', route('repair')],
            ['Old Device Exchange / Sell', route('exchange')],
            ['Video Call Product Demo', url('product') . '#video-call-drawer', 'text-blue-400'],
            ['Track Your Parcel', route('track-order')],
            ['Warranty & Claims', route('warranty')],
        ],
        'Company & Trust' => [
            ['About VANSH IT & COMM', route('about')],
            ['20-Point QC Testing', route('about') . '#refurbish-process'],
            ['Tech Buying Guides & Blog', route('blog')],
            ['Frequently Asked Questions', route('faq')],
            ['Customer Helpdesk', route('contact')],
        ],
        'Store Policies' => [
            ['Terms & Conditions', route('terms', ['tab' => 'terms'])],
            ['Privacy & Data Security', route('privacy')],
            ['7-Day Replacement Policy', route('returns')],
            ['Shipping & Logistics Policy', route('shipping')],
            ['Cookies Policy', route('terms', ['tab' => 'cookies'])],
            ['Warranty Guidelines', route('warranty')],
        ],
    ];

    $socials = [
        ['wa', 'fa-whatsapp', 'WhatsApp', 'WhatsApp support connected.'],
        ['ig', 'fa-instagram', 'Instagram', 'Instagram page coming soon.'],
        ['fb', 'fa-facebook-f', 'Facebook', 'Facebook page coming soon.'],
        ['yt', 'fa-youtube', 'YouTube', 'YouTube channel coming soon.'],
    ];
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
                <a href="{{ route('home') }}" class="inline-block group" aria-label="VANSH IT & COMM">
                    <img src="{{ asset('assets/img/vanshitcomm-logo-white.png') }}" alt="VANSH IT & COMMUNICATION" class="h-9 w-auto object-contain transition-transform group-hover:scale-105" />
                </a>
                <div>
                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20 whitespace-nowrap">
                        <i class="fa-solid fa-check-circle text-[10px] flex-shrink-0"></i> Certified Refurbished Hub
                    </span>
                </div>
                <p class="text-xs text-slate-400 leading-relaxed font-body">
                    Your trusted destination for certified pre-owned business laptops, verified smartphones, and genuine repair solutions.
                </p>

                <div class="pt-2 space-y-2.5 text-xs font-body">
                    <a href="tel:+919876543210" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition-colors">
                        <span class="w-6 h-6 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0 text-[10px]"><i class="fa-solid fa-phone"></i></span>
                        <span class="whitespace-nowrap">+91 98765 43210 <span class="text-[10px] text-slate-500">(10 AM – 8 PM)</span></span>
                    </a>
                    <a href="mailto:support@vanshitcomm.com" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition-colors">
                        <span class="w-6 h-6 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0 text-[10px]"><i class="fa-solid fa-envelope"></i></span>
                        <span>support@vanshitcomm.com</span>
                    </a>
                    <div class="flex items-center gap-2.5 text-slate-400">
                        <span class="w-6 h-6 rounded-lg bg-slate-800 text-slate-400 flex items-center justify-center flex-shrink-0 text-[10px]"><i class="fa-solid fa-location-dot"></i></span>
                        <span>Experience Store & QC Lab, India</span>
                    </div>
                </div>
            </div>

            @foreach ($columns as $heading => $links)
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
                <p>&copy; {{ date('Y') }} <strong class="text-slate-300 font-bold">VANSH IT & COMM</strong>. All rights reserved. 100% GST Tax Compliant.</p>
                <p class="text-[11px] text-slate-500">All brand trademarks, logos, and model names belong to their respective manufacturers.</p>
            </div>

            <div class="flex items-center gap-3">
                @foreach ($socials as [$cls, $icon, $label, $msg])
                    <a href="#" onclick="event.preventDefault(); showToast('{{ $msg }}', 'info');"
                       class="footer-social-btn {{ $cls }}" aria-label="{{ $label }}" title="{{ $label }}">
                        <i class="fa-brands {{ $icon }}"></i>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</footer>