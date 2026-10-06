{{-- resources/views/partials/header.blade.php --}}
{{-- $navCategories is supplied by App\View\Composers\NavCategoriesComposer --}}
{{-- $announcements + $cartCount are supplied by the partials.header composer in AppServiceProvider --}}
@php
    $activePage = $activePage ?? '';
    $navCategories = $navCategories ?? collect();
    $activeCategorySlugs = (array) request()->query('category', []);

    // Logo + site name come from Settings (fallback to the bundled logo)
    $logo     = !empty($general?->header_logo) ? asset('storage/' . $general->header_logo) : asset('assets/img/vanshitcomm-logo.png');
    $siteName = $general->site_name ?? 'VANSH IT & COMM';

    // Announcement bar: 1st item always visible, the others appear as the screen gets wider
    $announceShow = ['flex', 'hidden sm:flex', 'hidden md:flex', 'hidden lg:flex'];
    $announceSep  = ['', 'hidden sm:inline', 'hidden md:inline', 'hidden lg:inline'];

    // link can be a full URL, a /path, #anchor, or a plain path like "repair"
    $announceHref = function ($v) {
        if (!$v) return null;
        return preg_match('#^(https?://|/|\#|mailto:|tel:)#', $v) ? $v : url($v);
    };
@endphp

{{-- Announcement Bar --}}
<div class="bg-slate-900 text-slate-200 text-xs py-1.5 sm:py-2 border-b border-slate-800">
    <div class="container-custom flex items-center justify-between gap-2 lg:gap-4">
        <div
            class="flex items-center gap-2 sm:gap-4 lg:gap-6 overflow-hidden whitespace-nowrap text-[10px] sm:text-[11px] xl:text-xs font-medium">
            @foreach(($announcements ?? collect()) as $a)
                @php $href = $announceHref($a->link); @endphp

                @if(!$loop->first)
                    <span class="text-slate-700 {{ $announceSep[$loop->index] ?? 'hidden xl:inline' }}">|</span>
                @endif

                <span class="{{ $announceShow[$loop->index] ?? 'hidden xl:flex' }} items-center gap-1.5">
                    <i class="fa-solid fa-bullhorn text-blue-400"></i>
                    @if($href)
                        <a href="{{ $href }}" class="hover:text-blue-400 transition-colors">{{ $a->title }}</a>
                    @else
                        {{ $a->title }}
                    @endif
                </span>
            @endforeach
        </div>
        <div
            class="flex items-center gap-2 sm:gap-3 lg:gap-4 text-[10px] sm:text-[11px] xl:text-xs font-medium flex-shrink-0">
            <a href="{{ route('user.track-order') }}"
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
                aria-label="{{ $siteName }}">
                <img src="{{ $logo }}" alt="{{ $siteName }}"
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
                            autocomplete="off" value="{{ request('search') }}"
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
                        autocomplete="off" value="{{ request('search') }}"
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
                    <a href="{{ route('shop') }}" class="nav-link {{ $activePage === 'shop' && empty($activeCategorySlugs) ? 'active' : '' }}">All
                        Products</a>
                </li>

                {{-- One mega menu per active category (created in admin) --}}
                @foreach($navCategories as $nav)
                    @php
                        $cat = $nav['category'];
                        $isActive = in_array($cat->slug, $activeCategorySlugs, true);
                    @endphp
                    <li class="has-mega-menu">
                        <a href="{{ route('shop', ['category' => [$cat->slug]]) }}"
                            class="nav-link {{ $isActive ? 'active' : '' }}">
                            {{ $cat->name }}
                            <i class="fa-solid fa-chevron-down text-[9px] opacity-60"></i>
                        </a>
                        {{-- routeName 'shop': every item's params become a shop-page filter query string --}}
                        @include('partials.mega-menu', ['cols' => $nav['cols'], 'routeName' => 'shop', 'promo' => $nav['promo']])
                    </li>
                @endforeach

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

<script>
    // Used by App.handleLiveSearch / App.handleSearchSubmit (public/assets/js/app.js)
    window.SEARCH_SUGGEST_URL = @json(route('search.suggest'));
    window.SEARCH_SHOP_URL    = @json(route('shop'));
</script>