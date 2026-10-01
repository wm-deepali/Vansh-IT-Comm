{{-- resources/views/partials/header.blade.php --}}
@php
    $activePage = $activePage ?? '';

    $laptopCols = [
        [
            'By Usage',
            [
                ['Gaming Laptops', ['use' => 'gaming']],
                ['Coding & Devs', ['use' => 'coding']],
                ['Business Ultrabooks', ['use' => 'business']],
                ['Students & Study', ['use' => 'students']],
                ['Video & Design', ['use' => 'design']],
                ['Work From Home', ['use' => 'wfh']],
            ]
        ],
        [
            'By RAM',
            [
                ['8 GB RAM', ['ram' => 8]],
                ['16 GB (Popular)', ['ram' => 16]],
                ['32 GB Workstation', ['ram' => 32]],
                ['64 GB+ Ultra', ['ram' => 64]],
            ]
        ],
        [
            'Storage',
            [
                ['256 GB SSD', ['storage' => 256]],
                ['512 GB SSD', ['storage' => 512]],
                ['1 TB SSD / Dual', ['storage' => 1000]],
                ['2 TB SSD', ['storage' => 2000]],
            ]
        ],
        [
            'Top Brands',
            [
                ['Dell Latitude', ['brand' => 'Dell'], 'font-medium'],
                ['Lenovo ThinkPad', ['brand' => 'Lenovo'], 'font-medium'],
                ['HP EliteBook', ['brand' => 'HP'], 'font-medium'],
                ['Apple MacBook', ['brand' => 'Apple'], 'font-medium'],
                ['Asus ROG / TUF', ['brand' => 'Asus']],
                ['Acer Aspire', ['brand' => 'Acer']],
            ]
        ],
        [
            'Budget Range',
            [
                ['Under ₹15,000', ['maxPrice' => 15000], 'font-semibold text-emerald-600'],
                ['₹15K – ₹25K', ['minPrice' => 15000, 'maxPrice' => 25000]],
                ['₹25K – ₹35K', ['minPrice' => 25000, 'maxPrice' => 35000]],
                ['₹35K – ₹50K', ['minPrice' => 35000, 'maxPrice' => 50000]],
                ['Flagships ₹50K+', ['minPrice' => 50000]],
            ]
        ],
    ];

    $laptopPromo = [
        'gradient' => 'from-slate-900 to-blue-950',
        'badgeClass' => 'bg-blue-500',
        'badge' => '20-PT TESTED',
        'title' => 'Refurbished Laptops',
        'text' => 'Tested & 12-Mo Warranty.',
        'price' => 'From ₹14,499*',
        'btn' => 'Explore',
    ];

    $mobileCols = [
        [
            'Category',
            [
                ['Premium Flagships', ['type' => 'premium']],
                ['Camera Specialists', ['type' => 'camera']],
                ['Gaming Phones', ['type' => 'gaming']],
                ['5000mAh+ Battery', ['type' => 'battery']],
                ['Everyday Value', ['type' => 'everyday']],
            ]
        ],
        [
            'RAM',
            [
                ['4 GB RAM', ['ram' => 4]],
                ['6 GB RAM', ['ram' => 6]],
                ['8 GB RAM', ['ram' => 8]],
                ['12 GB+ Flagship', ['ram' => 12]],
            ]
        ],
        [
            'Storage',
            [
                ['64 GB Storage', ['storage' => 64]],
                ['128 GB (Popular)', ['storage' => 128]],
                ['256 GB Pro', ['storage' => 256]],
                ['512 GB / 1 TB', ['storage' => 512]],
            ]
        ],
        [
            'Top Brands',
            [
                ['Apple iPhone', ['brand' => 'Apple'], 'font-medium'],
                ['Samsung Galaxy', ['brand' => 'Samsung'], 'font-medium'],
                ['OnePlus 5G', ['brand' => 'OnePlus'], 'font-medium'],
                ['Google Pixel', ['brand' => 'Google'], 'font-medium'],
                ['Xiaomi / Redmi', ['brand' => 'Xiaomi']],
                ['Realme & Vivo', ['brand' => 'Realme']],
            ]
        ],
        [
            'Budget Range',
            [
                ['Under ₹10,000', ['maxPrice' => 10000], 'font-semibold text-emerald-600'],
                ['₹10K – ₹15K', ['minPrice' => 10000, 'maxPrice' => 15000]],
                ['₹15K – ₹25K', ['minPrice' => 15000, 'maxPrice' => 25000]],
                ['₹25K – ₹40K', ['minPrice' => 25000, 'maxPrice' => 40000]],
                ['Flagships ₹40K+', ['minPrice' => 40000]],
            ]
        ],
    ];

    $mobilePromo = [
        'gradient' => 'from-blue-900 to-slate-900',
        'badgeClass' => 'bg-emerald-500',
        'badge' => 'BATTERY 85%+',
        'title' => 'Refurbished Phones',
        'text' => 'Original display & OEM parts.',
        'price' => 'From ₹6,999*',
        'btn' => 'Shop Mobiles',
    ];
@endphp

{{-- Announcement Bar --}}
<div class="bg-slate-900 text-slate-200 text-xs py-1.5 sm:py-2 border-b border-slate-800">
    <div class="container-custom flex items-center justify-between gap-2 lg:gap-4">
        <div
            class="flex items-center gap-2 sm:gap-4 lg:gap-6 overflow-hidden whitespace-nowrap text-[10px] sm:text-[11px] xl:text-xs font-medium">
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-truck-fast text-blue-400"></i> Pan India
                Insured Delivery</span>
            <span class="text-slate-700 hidden sm:inline">|</span>
            <span class="hidden sm:flex items-center gap-1.5"><i class="fa-solid fa-file-invoice text-emerald-400"></i>
                100% GST Invoice</span>
            <span class="text-slate-700 hidden md:inline">|</span>
            <span class="hidden md:flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-amber-400"></i>
                Up to 12M Warranty</span>
            <span class="text-slate-700 hidden lg:inline">|</span>
            <span class="hidden lg:flex items-center gap-1.5"><i
                    class="fa-solid fa-screwdriver-wrench text-blue-400"></i> 20-Point Tested Devices</span>
        </div>
        <div
            class="flex items-center gap-2 sm:gap-3 lg:gap-4 text-[10px] sm:text-[11px] xl:text-xs font-medium flex-shrink-0">
            <a href="{{ route('track-order') }}"
                class="hover:text-blue-400 transition-colors flex items-center gap-1 whitespace-nowrap">
                <i class="fa-solid fa-location-crosshairs text-[9px]"></i> Track Order
            </a>
            <a href="{{ route('contact') }}"
                class="hover:text-blue-400 transition-colors hidden sm:flex items-center gap-1 whitespace-nowrap">
                <i class="fa-solid fa-headset text-[9px]"></i> Help & Support
            </a>
        </div>
    </div>
</div>

{{-- Main Sticky Header --}}
<header class="header-sticky bg-white/95 backdrop-blur-md transition-all duration-200" id="main-header">
    <div class="container-custom">
        <div class="flex items-center justify-between gap-2 sm:gap-3 lg:gap-6 py-2 sm:py-2.5 lg:py-3">

            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0 group text-decoration-none py-0.5"
                aria-label="VANSH IT & COMM">
                <img src="{{ asset('assets/img/vanshitcomm-logo.png') }}" alt="VANSH IT & COMMUNICATION"
                    class="h-7 sm:h-8 md:h-10 lg:h-11 xl:h-12 w-auto max-w-[125px] sm:max-w-[150px] md:max-w-[200px] lg:max-w-[240px] xl:max-w-[260px] object-contain transition-transform duration-200 group-hover:scale-105" />
            </a>

            {{-- Desktop Search --}}
            <div class="flex-1 max-w-md lg:max-w-lg xl:max-w-2xl relative hidden md:block">
                <form action="{{ route('shop') }}" method="GET" class="relative"
                    onsubmit="App.handleSearchSubmit(event, this)">
                    <div class="relative flex items-center">
                        <i
                            class="fa-solid fa-magnifying-glass absolute left-3.5 lg:left-4 text-slate-400 text-xs lg:text-sm"></i>
                        <input type="text" id="header-search-input" name="search"
                            placeholder="Search laptops, mobiles, accessories..."
                            class="w-full bg-slate-50 border border-slate-200 rounded-full pl-9 lg:pl-11 pr-20 lg:pr-24 py-2 lg:py-2.5 text-xs lg:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all"
                            autocomplete="off"
                            oninput="App.handleLiveSearch(this.value, 'search-autocomplete-dropdown')" />
                        <button type="submit"
                            class="absolute right-1 lg:right-1.5 px-3 lg:px-4 py-1 lg:py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[11px] lg:text-xs font-semibold rounded-full transition-colors">
                            Search
                        </button>
                    </div>
                </form>
                <div id="search-autocomplete-dropdown" class="search-results-dropdown"></div>
            </div>

            {{-- Header Actions --}}
            <div class="flex items-center gap-1.5 sm:gap-2 lg:gap-2.5 flex-shrink-0">
                <a href="{{ route('wishlist') }}" aria-label="Wishlist"
                    class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-blue-600 transition-all flex items-center justify-center flex-shrink-0 border border-slate-200/60">
                    <i class="fa-regular fa-heart text-base sm:text-lg"></i>
                    <span
                        class="wishlist-count-badge absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white text-[9px] font-bold items-center justify-center hidden border-2 border-white shadow-sm">0</span>
                </a>

                @if(auth('customer')->check())
                    <a href="{{ route('user.account') }}" aria-label="My Account"
                        class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-blue-600 transition-all flex items-center justify-center flex-shrink-0 border border-slate-200/60">
                        <i class="fa-regular fa-user text-base sm:text-lg"></i>
                    </a>
                @else
                    <button type="button" onclick="App.openModal('auth-modal')" aria-label="Login or Register"
                        class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-blue-600 transition-all flex items-center justify-center flex-shrink-0 border border-slate-200/60">
                        <i class="fa-regular fa-user text-base sm:text-lg"></i>
                    </button>
                @endif

                <a href="{{ route('cart') }}" aria-label="Shopping Cart"
                    class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white transition-all flex items-center justify-center flex-shrink-0 border border-blue-100 shadow-2xs group">
                    <i class="fa-solid fa-cart-shopping text-sm sm:text-base"></i>
                    <span data-cart-count
                        class="cart-count-badge absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-blue-600 group-hover:bg-slate-900 text-white text-[10px] font-extrabold flex items-center justify-center border-2 border-white shadow-sm {{ ($cartCount ?? 0) > 0 ? '' : 'hidden' }}">{{ ($cartCount ?? 0) > 99 ? '99+' : ($cartCount ?? 0) }}</span>
                </a>

                <button type="button" onclick="App.openMobileDrawer()" aria-label="Open Navigation Menu"
                    class="lg:hidden w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-blue-600 transition-all flex items-center justify-center flex-shrink-0 border border-slate-200/60 text-base">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Search --}}
        <div class="block md:hidden pb-2.5 pt-0.5 relative">
            <form action="{{ route('shop') }}" method="GET" class="relative"
                onsubmit="App.handleSearchSubmit(event, this)">
                <div class="relative flex items-center">
                    <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-xs"></i>
                    <input type="text" id="mobile-header-search-input" name="search"
                        placeholder="Search laptops, mobiles, accessories..."
                        class="w-full bg-slate-100/90 border border-slate-200 rounded-full pl-9 pr-20 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all shadow-inner"
                        autocomplete="off"
                        oninput="App.handleLiveSearch(this.value, 'mobile-search-autocomplete-dropdown')" />
                    <button type="submit"
                        class="absolute right-1 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold rounded-full transition-colors shadow-sm">
                        Search
                    </button>
                </div>
            </form>
            <div id="mobile-search-autocomplete-dropdown" class="search-results-dropdown"></div>
        </div>

        {{-- Desktop Nav --}}
        <nav class="hidden lg:flex items-center justify-center border-t border-slate-100 py-1"
            aria-label="Main Navigation">
            <ul class="flex items-center justify-center gap-0.5 xl:gap-1.5 font-medium whitespace-nowrap">
                <li>
                    <a href="{{ route('home') }}" class="nav-link {{ $activePage === 'home' ? 'active' : '' }}">
                        <i class="fa-solid fa-house text-xs"></i> Home
                    </a>
                </li>
                <li>
                    <a href="{{ route('categories') }}"
                        class="nav-link {{ $activePage === 'categories' ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group text-xs"></i> Categories
                    </a>
                </li>
                <li>
                    <a href="{{ route('shop') }}" class="nav-link {{ $activePage === 'shop' ? 'active' : '' }}">All
                        Products</a>
                </li>

                <li class="has-mega-menu">
                    <a href="#" class="nav-link {{ $activePage === 'laptops' ? 'active' : '' }}">
                        <i class="fa-solid fa-laptop text-xs"></i> Laptops <i
                            class="fa-solid fa-chevron-down text-[9px] opacity-60"></i>
                    </a>
                    @include('partials.mega-menu', ['cols' => $laptopCols, 'routeName' => 'laptops', 'promo' => $laptopPromo])
                </li>

                <li class="has-mega-menu">
                    <a href="#" class="nav-link {{ $activePage === 'mobiles' ? 'active' : '' }}">
                        <i class="fa-solid fa-mobile-screen-button text-xs"></i> Mobile Phones <i
                            class="fa-solid fa-chevron-down text-[9px] opacity-60"></i>
                    </a>
                    @include('partials.mega-menu', ['cols' => $mobileCols, 'routeName' => 'mobile-phones', 'promo' => $mobilePromo])
                </li>

                <li>
                    <a href="#" class="nav-link {{ $activePage === 'accessories' ? 'active' : '' }}">
                        <i class="fa-solid fa-headphones text-xs"></i> Accessories
                    </a>
                </li>
                <li>
                    <a href="{{ route('repair') }}" class="nav-link {{ $activePage === 'repair' ? 'active' : '' }}">
                        <i class="fa-solid fa-wrench text-xs text-blue-600"></i> Repair Services
                    </a>
                </li>
                <li>
                    <a href="{{ route('exchange') }}" class="nav-link {{ $activePage === 'exchange' ? 'active' : '' }}">
                        <i class="fa-solid fa-rotate text-xs text-emerald-600"></i> Exchange & Upgrade
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</header>

@include('partials.overlays', ['activePage' => $activePage])