/**
 * VANSH IT & COMM — REUSABLE NAVIGATION & UI COMPONENTS (Desktop)
 * Generates Desktop Header, Mega Menus, Modals, and 5-Column Footer.
 */

const Components = {
  renderAnnouncementBar() {
    return `
      <div class="bg-slate-900 text-slate-200 text-xs py-1.5 sm:py-2 border-b border-slate-800">
        <div class="container-custom flex items-center justify-between gap-2 lg:gap-4">
          <div class="flex items-center gap-2 sm:gap-4 lg:gap-6 overflow-hidden whitespace-nowrap text-[10px] sm:text-[11px] xl:text-xs font-medium">
            <span class="flex items-center gap-1.5"><i class="fa-solid fa-truck-fast text-blue-400"></i> Pan India Insured Delivery</span>
            <span class="text-slate-700 hidden sm:inline">|</span>
            <span class="hidden sm:flex items-center gap-1.5"><i class="fa-solid fa-file-invoice text-emerald-400"></i> 100% GST Invoice</span>
            <span class="text-slate-700 hidden md:inline">|</span>
            <span class="hidden md:flex items-center gap-1.5"><i class="fa-solid fa-shield-halved text-amber-400"></i> Up to 12M Warranty</span>
            <span class="text-slate-700 hidden lg:inline">|</span>
            <span class="hidden lg:flex items-center gap-1.5"><i class="fa-solid fa-screwdriver-wrench text-blue-400"></i> 20-Point Tested Devices</span>
          </div>
          <div class="flex items-center gap-2 sm:gap-3 lg:gap-4 text-[10px] sm:text-[11px] xl:text-xs font-medium flex-shrink-0">
            <a href="{{ route('track-order') }}" class="hover:text-blue-400 transition-colors flex items-center gap-1 whitespace-nowrap">
              <i class="fa-solid fa-location-crosshairs text-[9px]"></i> Track Order
            </a>
            <a href="{{ route('contact') }}" class="hover:text-blue-400 transition-colors hidden sm:flex items-center gap-1 whitespace-nowrap">
              <i class="fa-solid fa-headset text-[9px]"></i> Help & Support
            </a>
          </div>
        </div>
      </div>
    `;
  },

  // Convert template-style URLs (xyz.html, img/abc.png) to Laravel URLs
  fixDom(root) {
    const site = (window.SITE_URL || '').replace(/\/$/, '');
    const assets = window.ASSET_BASE || '/assets';

    root.querySelectorAll('[href], [action]').forEach(el => {
      ['href', 'action'].forEach(attr => {
        const v = el.getAttribute(attr);
        const m = v && v.match(/^([a-z0-9-]+)\.html(.*)$/i);
        if (m) {
          const page = m[1] === 'index' ? '' : m[1];
          el.setAttribute(attr, `${site}/${page}${m[2]}`);
        }
      });
    });

    root.querySelectorAll('img[src^="img/"]').forEach(img => {
      img.setAttribute('src', `${assets}/${img.getAttribute('src')}`);
    });
  },

  renderHeader(activePage = '') {
    const headerContainer = document.getElementById('site-header');
    if (!headerContainer) return;

    headerContainer.innerHTML = `
      ${this.renderAnnouncementBar()}

      <!-- Main Sticky Navigation Header -->
      <header class="header-sticky bg-white/95 backdrop-blur-md transition-all duration-200" id="main-header">
        <div class="container-custom">
          <!-- Top Row: Logo, Desktop Search, Action Icons -->
          <div class="flex items-center justify-between gap-2 sm:gap-3 lg:gap-6 py-2 sm:py-2.5 lg:py-3">
            
            <!-- Logo (Compact on mobile) -->
            <a href="{{ route('home') }}" class="flex items-center flex-shrink-0 group text-decoration-none py-0.5" aria-label="VANSH IT & COMM">
              <img 
                src="img/vanshitcomm-logo.png" 
                alt="VANSH IT & COMMUNICATION" 
                class="h-7 sm:h-8 md:h-10 lg:h-11 xl:h-12 w-auto max-w-[125px] sm:max-w-[150px] md:max-w-[200px] lg:max-w-[240px] xl:max-w-[260px] object-contain transition-transform duration-200 group-hover:scale-105" 
              />
            </a>

            <!-- Desktop Search Bar (Hidden on mobile < md) -->
            <div class="flex-1 max-w-md lg:max-w-lg xl:max-w-2xl relative hidden md:block">
              <form action="{{ route('shop') }}" method="GET" class="relative" onsubmit="App.handleSearchSubmit(event, this)">
                <div class="relative flex items-center">
                  <i class="fa-solid fa-magnifying-glass absolute left-3.5 lg:left-4 text-slate-400 text-xs lg:text-sm"></i>
                  <input 
                    type="text" 
                    id="header-search-input"
                    name="search"
                    placeholder="Search laptops, mobiles, accessories..." 
                    class="w-full bg-slate-50 border border-slate-200 rounded-full pl-9 lg:pl-11 pr-20 lg:pr-24 py-2 lg:py-2.5 text-xs lg:text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all"
                    autocomplete="off"
                    oninput="App.handleLiveSearch(this.value, 'search-autocomplete-dropdown')"
                  />
                  <button type="submit" class="absolute right-1 lg:right-1.5 px-3 lg:px-4 py-1 lg:py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-[11px] lg:text-xs font-semibold rounded-full transition-colors">
                    Search
                  </button>
                </div>
              </form>

              <!-- Live Autocomplete Dropdown -->
              <div id="search-autocomplete-dropdown" class="search-results-dropdown"></div>
            </div>

            <!-- Header Actions (All Circular Buttons) -->
            <div class="flex items-center gap-1.5 sm:gap-2 lg:gap-2.5 flex-shrink-0">
              <!-- Wishlist Link (Circular) -->
              <a 
                href="{{ route('wishlist') }}" 
                class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-blue-600 transition-all flex items-center justify-center flex-shrink-0 border border-slate-200/60"
                aria-label="Wishlist"
              >
                <i class="fa-regular fa-heart text-base sm:text-lg"></i>
                <span class="wishlist-count-badge absolute -top-1 -right-1 w-4 h-4 rounded-full bg-red-500 text-white text-[9px] font-bold items-center justify-center hidden border-2 border-white shadow-sm">0</span>
              </a>

              <!-- Account Link / Modal Trigger (Circular) -->
              <button 
                type="button" 
                onclick="App.openModal('auth-modal')"
                class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-blue-600 transition-all flex items-center justify-center flex-shrink-0 border border-slate-200/60"
                aria-label="Account"
              >
                <i class="fa-regular fa-user text-base sm:text-lg"></i>
              </button>

              <!-- Cart Button (Circular) -->
              <a 
                href="{{ route('cart') }}" 
                class="relative w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-blue-50 hover:bg-blue-600 text-blue-600 hover:text-white transition-all flex items-center justify-center flex-shrink-0 border border-blue-100 shadow-2xs group"
                aria-label="Shopping Cart"
              >
                <i class="fa-solid fa-cart-shopping text-sm sm:text-base"></i>
                <span class="cart-count-badge absolute -top-1 -right-1 w-4 h-4 sm:w-4.5 sm:h-4.5 rounded-full bg-blue-600 group-hover:bg-slate-900 text-white text-[9px] font-extrabold flex items-center justify-center hidden border-2 border-white shadow-sm">0</span>
              </a>

              <!-- Mobile Hamburger Menu Button (Circular) -->
              <button 
                type="button" 
                onclick="App.openMobileDrawer()" 
                class="lg:hidden w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50 hover:bg-slate-100 text-slate-700 hover:text-blue-600 transition-all flex items-center justify-center flex-shrink-0 border border-slate-200/60 text-base"
                aria-label="Open Navigation Menu"
              >
                <i class="fa-solid fa-bars"></i>
              </button>
            </div>
          </div>

          <!-- Mobile Dedicated Search Bar (New Bottom Row for Mobile) -->
          <div class="block md:hidden pb-2.5 pt-0.5 relative">
            <form action="{{ route('shop') }}" method="GET" class="relative" onsubmit="App.handleSearchSubmit(event, this)">
              <div class="relative flex items-center">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 text-slate-400 text-xs"></i>
                <input 
                  type="text" 
                  id="mobile-header-search-input"
                  name="search"
                  placeholder="Search laptops, mobiles, accessories..." 
                  class="w-full bg-slate-100/90 border border-slate-200 rounded-full pl-9 pr-20 py-2 text-xs text-slate-800 placeholder-slate-400 focus:outline-none focus:border-blue-600 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all shadow-inner"
                  autocomplete="off"
                  oninput="App.handleLiveSearch(this.value, 'mobile-search-autocomplete-dropdown')"
                />
                <button type="submit" class="absolute right-1 px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-[11px] font-bold rounded-full transition-colors shadow-sm">
                  Search
                </button>
              </div>
            </form>

            <!-- Mobile Live Autocomplete Dropdown -->
            <div id="mobile-search-autocomplete-dropdown" class="search-results-dropdown"></div>
          </div>

          <!-- Desktop Navigation Bar & Mega Menus (Centered) -->
          <nav class="hidden lg:flex items-center justify-center border-t border-slate-100 py-1" aria-label="Main Navigation">
            <ul class="flex items-center justify-center gap-0.5 xl:gap-1.5 font-medium whitespace-nowrap">
              <li>
                <a href="{{ route('home') }}" class="nav-link ${activePage === 'home' ? 'active' : ''}">
                  <i class="fa-solid fa-house text-xs"></i> Home
                </a>
              </li>

              <li>
                <a href="{{ route('categories') }}" class="nav-link ${activePage === 'categories' ? 'active' : ''}">
                  <i class="fa-solid fa-layer-group text-xs"></i> Categories
                </a>
              </li>

              <li>
                <a href="{{ route('shop') }}" class="nav-link ${activePage === 'shop' ? 'active' : ''}">
                  All Products
                </a>
              </li>

              <!-- Laptops with Mega Menu -->
              <li class="has-mega-menu">
                <a href="{{ route('laptops') }}" class="nav-link ${activePage === 'laptops' ? 'active' : ''}">
                  <i class="fa-solid fa-laptop text-xs"></i> Laptops <i class="fa-solid fa-chevron-down text-[9px] opacity-60"></i>
                </a>

                <!-- Mega Menu Box -->
                <div class="mega-menu">
                  <div class="container-custom py-6 xl:py-8">
                    <div class="grid grid-cols-6 gap-2.5 lg:gap-3.5 xl:gap-5 items-stretch">
                      <!-- Col 1: Usage -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">By Usage</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('laptops') }}?use=gaming" class="hover:text-blue-600 transition-colors">Gaming Laptops</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?use=coding" class="hover:text-blue-600 transition-colors">Coding & Devs</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?use=business" class="hover:text-blue-600 transition-colors">Business Ultrabooks</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?use=students" class="hover:text-blue-600 transition-colors">Students & Study</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?use=design" class="hover:text-blue-600 transition-colors">Video & Design</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?use=wfh" class="hover:text-blue-600 transition-colors">Work From Home</a></li>
                        </ul>
                      </div>

                      <!-- Col 2: RAM -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">By RAM</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('laptops') }}?ram=8" class="hover:text-blue-600 transition-colors">8 GB RAM</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?ram=16" class="hover:text-blue-600 transition-colors">16 GB (Popular)</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?ram=32" class="hover:text-blue-600 transition-colors">32 GB Workstation</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?ram=64" class="hover:text-blue-600 transition-colors">64 GB+ Ultra</a></li>
                        </ul>
                      </div>

                      <!-- Col 3: Storage -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">Storage</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('laptops') }}?storage=256" class="hover:text-blue-600 transition-colors">256 GB SSD</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?storage=512" class="hover:text-blue-600 transition-colors">512 GB SSD</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?storage=1000" class="hover:text-blue-600 transition-colors">1 TB SSD / Dual</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?storage=2000" class="hover:text-blue-600 transition-colors">2 TB SSD</a></li>
                        </ul>
                      </div>

                      <!-- Col 4: Top Brands -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">Top Brands</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('laptops') }}?brand=Dell" class="hover:text-blue-600 transition-colors font-medium">Dell Latitude</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?brand=Lenovo" class="hover:text-blue-600 transition-colors font-medium">Lenovo ThinkPad</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?brand=HP" class="hover:text-blue-600 transition-colors font-medium">HP EliteBook</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?brand=Apple" class="hover:text-blue-600 transition-colors font-medium">Apple MacBook</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?brand=Asus" class="hover:text-blue-600 transition-colors">Asus ROG / TUF</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?brand=Acer" class="hover:text-blue-600 transition-colors">Acer Aspire</a></li>
                        </ul>
                      </div>

                      <!-- Col 5: Price Ranges -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">Budget Range</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('laptops') }}?maxPrice=15000" class="hover:text-blue-600 font-semibold text-emerald-600">Under ₹15,000</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?minPrice=15000&maxPrice=25000" class="hover:text-blue-600">₹15K – ₹25K</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?minPrice=25000&maxPrice=35000" class="hover:text-blue-600">₹25K – ₹35K</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?minPrice=35000&maxPrice=50000" class="hover:text-blue-600">₹35K – ₹50K</a></li>
                          <li class="truncate"><a href="{{ route('laptops') }}?minPrice=50000" class="hover:text-blue-600">Flagships ₹50K+</a></li>
                        </ul>
                      </div>

                      <!-- Col 6: Promotional Card -->
                      <div class="bg-gradient-to-br from-slate-900 to-blue-950 p-3 xl:p-4 rounded-2xl text-white flex flex-col justify-between shadow-md border border-slate-700/60">
                        <div>
                          <span class="badge bg-blue-500 text-white text-[9px] xl:text-[10px] mb-2 font-bold whitespace-nowrap">20-PT TESTED</span>
                          <h4 class="font-extrabold text-xs xl:text-sm text-white leading-snug mb-1 truncate">Refurbished Laptops</h4>
                          <p class="text-[10px] xl:text-[11px] text-slate-300 mb-2 leading-tight">Tested & 12-Mo Warranty.</p>
                          <div class="text-[11px] xl:text-xs font-extrabold text-emerald-400">From ₹14,499*</div>
                        </div>
                        <a href="{{ route('laptops') }}" class="mt-2.5 btn-base btn-primary btn-sm text-[10px] xl:text-xs w-full py-1.5 justify-center font-bold">
                          Explore <i class="fa-solid fa-arrow-right text-[9px]"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <!-- Mobile Phones with Mega Menu -->
              <li class="has-mega-menu">
                <a href="{{ route('mobile-phones') }}" class="nav-link ${activePage === 'mobiles' ? 'active' : ''}">
                  <i class="fa-solid fa-mobile-screen-button text-xs"></i> Mobile Phones <i class="fa-solid fa-chevron-down text-[9px] opacity-60"></i>
                </a>

                <!-- Mega Menu Box -->
                <div class="mega-menu">
                  <div class="container-custom py-6 xl:py-8">
                    <div class="grid grid-cols-6 gap-2.5 lg:gap-3.5 xl:gap-5 items-stretch">
                      <!-- Col 1: Usage -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">Category</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?type=premium" class="hover:text-blue-600 transition-colors">Premium Flagships</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?type=camera" class="hover:text-blue-600 transition-colors">Camera Specialists</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?type=gaming" class="hover:text-blue-600 transition-colors">Gaming Phones</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?type=battery" class="hover:text-blue-600 transition-colors">5000mAh+ Battery</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?type=everyday" class="hover:text-blue-600 transition-colors">Everyday Value</a></li>
                        </ul>
                      </div>

                      <!-- Col 2: RAM -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">RAM</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?ram=4" class="hover:text-blue-600 transition-colors">4 GB RAM</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?ram=6" class="hover:text-blue-600 transition-colors">6 GB RAM</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?ram=8" class="hover:text-blue-600 transition-colors">8 GB RAM</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?ram=12" class="hover:text-blue-600 transition-colors">12 GB+ Flagship</a></li>
                        </ul>
                      </div>

                      <!-- Col 3: Storage -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">Storage</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?storage=64" class="hover:text-blue-600 transition-colors">64 GB Storage</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?storage=128" class="hover:text-blue-600 transition-colors">128 GB (Popular)</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?storage=256" class="hover:text-blue-600 transition-colors">256 GB Pro</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?storage=512" class="hover:text-blue-600 transition-colors">512 GB / 1 TB</a></li>
                        </ul>
                      </div>

                      <!-- Col 4: Brands -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">Top Brands</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?brand=Apple" class="hover:text-blue-600 font-medium">Apple iPhone</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?brand=Samsung" class="hover:text-blue-600 font-medium">Samsung Galaxy</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?brand=OnePlus" class="hover:text-blue-600 font-medium">OnePlus 5G</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?brand=Google" class="hover:text-blue-600 font-medium">Google Pixel</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?brand=Xiaomi" class="hover:text-blue-600">Xiaomi / Redmi</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?brand=Realme" class="hover:text-blue-600">Realme & Vivo</a></li>
                        </ul>
                      </div>

                      <!-- Col 5: Price Ranges -->
                      <div>
                        <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">Budget Range</h4>
                        <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?maxPrice=10000" class="hover:text-blue-600 font-semibold text-emerald-600">Under ₹10,000</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?minPrice=10000&maxPrice=15000" class="hover:text-blue-600">₹10K – ₹15K</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?minPrice=15000&maxPrice=25000" class="hover:text-blue-600">₹15K – ₹25K</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?minPrice=25000&maxPrice=40000" class="hover:text-blue-600">₹25K – ₹40K</a></li>
                          <li class="truncate"><a href="{{ route('mobile-phones') }}?minPrice=40000" class="hover:text-blue-600">Flagships ₹40K+</a></li>
                        </ul>
                      </div>

                      <!-- Col 6: Promotional Card -->
                      <div class="bg-gradient-to-br from-blue-900 to-slate-900 p-3 xl:p-4 rounded-2xl text-white flex flex-col justify-between shadow-md border border-slate-700/60">
                        <div>
                          <span class="badge bg-emerald-500 text-white text-[9px] xl:text-[10px] mb-2 font-bold whitespace-nowrap">BATTERY 85%+</span>
                          <h4 class="font-extrabold text-xs xl:text-sm text-white leading-snug mb-1 truncate">Refurbished Phones</h4>
                          <p class="text-[10px] xl:text-[11px] text-slate-300 mb-2 leading-tight">Original display & OEM parts.</p>
                          <div class="text-[11px] xl:text-xs font-extrabold text-emerald-400">From ₹6,999*</div>
                        </div>
                        <a href="{{ route('mobile-phones') }}" class="mt-2.5 btn-base btn-primary btn-sm text-[10px] xl:text-xs w-full py-1.5 justify-center font-bold">
                          Shop Mobiles <i class="fa-solid fa-arrow-right text-[9px]"></i>
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </li>

              <li>
                <a href="{{ route('accessories') }}" class="nav-link ${activePage === 'accessories' ? 'active' : ''}">
                  <i class="fa-solid fa-headphones text-xs"></i> Accessories
                </a>
              </li>

              <li>
                <a href="{{ route('repair') }}" class="nav-link ${activePage === 'repair' ? 'active' : ''}">
                  <i class="fa-solid fa-wrench text-xs text-blue-600"></i> Repair Services
                </a>
              </li>

              <li>
                <a href="{{ route('exchange') }}" class="nav-link ${activePage === 'exchange' ? 'active' : ''}">
                  <i class="fa-solid fa-rotate text-xs text-emerald-600"></i> Exchange & Upgrade
                </a>
              </li>
            </ul>
          </nav>
        </div>
      </header>

      ${this.renderModals(activePage)}
    `;

    this.fixDom(headerContainer);

    // Re-sync badge counts
    Cart.updateBadges();
    Wishlist.updateBadges();
  },

  renderMobileDrawer(activePage = '') {
    return `
      <!-- Mobile Navigation Slide-Over Drawer -->
      <div id="mobile-drawer" class="mobile-drawer-wrapper">
        <div class="mobile-drawer-backdrop" onclick="App.closeMobileDrawer()"></div>
        <div class="mobile-drawer-panel p-5">
          <!-- Drawer Top: Logo & Close Button -->
          <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <a href="{{ route('home') }}" onclick="App.closeMobileDrawer()">
              <img src="img/vanshitcomm-logo.png" alt="VANSH IT & COMM" class="h-9 w-auto object-contain" />
            </a>
            <button type="button" onclick="App.closeMobileDrawer()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>

          <!-- Quick Search in Drawer -->
          <form action="{{ route('shop') }}" method="GET" class="mb-5 relative" onsubmit="App.closeMobileDrawer()">
            <input 
              type="text" 
              name="search" 
              placeholder="Search laptops, phones, parts..." 
              class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-blue-600"
            />
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
          </form>

          <!-- Drawer Navigation Links -->
          <nav class="space-y-1 text-xs font-semibold text-slate-700 flex-1">
            <a href="{{ route('home') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'home' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-house w-4 text-center text-slate-400"></i> Home
            </a>
            <a href="{{ route('categories') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'categories' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-layer-group w-4 text-center text-blue-600"></i> All Categories Hub
            </a>
            <a href="{{ route('shop') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'shop' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-store w-4 text-center text-slate-400"></i> All Products Catalog
            </a>
            <a href="{{ route('laptops') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'laptops' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-laptop w-4 text-center text-slate-400"></i> Refurbished Laptops
            </a>
            <a href="{{ route('mobile-phones') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'mobiles' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-mobile-screen-button w-4 text-center text-slate-400"></i> Mobile Phones
            </a>
            <a href="{{ route('accessories') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'accessories' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-headphones w-4 text-center text-slate-400"></i> Computer Accessories
            </a>
            <a href="{{ route('repair') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'repair' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-wrench w-4 text-center text-blue-600"></i> Repair Services
            </a>
            <a href="{{ route('exchange') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'exchange' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-rotate w-4 text-center text-emerald-600"></i> Exchange & Upgrade
            </a>
            <a href="{{ route('blog') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'blog' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-newspaper w-4 text-center text-slate-400"></i> Tech Blog & Guides
            </a>
            <a href="{{ route('about') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'about' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-circle-info w-4 text-center text-slate-400"></i> About Us & 20-Pt Testing
            </a>
            <a href="{{ route('contact') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors ${activePage === 'contact' ? 'bg-blue-50 text-blue-600 font-bold' : ''}">
              <i class="fa-solid fa-headset w-4 text-center text-slate-400"></i> Contact Support
            </a>
            <a href="{{ route('faq') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
              <i class="fa-solid fa-circle-question w-4 text-center text-slate-400"></i> Frequently Asked Questions
            </a>
            <a href="{{ route('terms') }}" class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors">
              <i class="fa-solid fa-shield-halved w-4 text-center text-slate-400"></i> Terms & Store Policies
            </a>
          </nav>

          <!-- Drawer Bottom Contact & Action -->
          <div class="pt-4 border-t border-slate-100 space-y-2 mt-4">
            <a href="{{ route('contact') }}" class="btn-base btn-secondary btn-sm w-full text-xs py-2 justify-center font-bold">
              <i class="fa-solid fa-headset text-blue-600 mr-1.5"></i> Customer Desk
            </a>
            <button type="button" onclick="App.closeMobileDrawer(); App.openModal('auth-modal');" class="btn-base btn-primary btn-sm w-full text-xs py-2 justify-center font-bold">
              <i class="fa-regular fa-user mr-1.5"></i> My Account / Login
            </button>
          </div>
        </div>
      </div>
    `;
  },

  renderBottomNav(activePage = '') {
    return `
      <!-- Mobile Bottom Navigation Bar (Fixed for Mobile Screens) -->
      <div class="mobile-bottom-nav">
        <a href="{{ route('home') }}" class="flex flex-col items-center justify-center flex-1 py-1 text-center ${activePage === 'home' ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800'}">
          <i class="fa-solid fa-house text-base"></i>
          <span class="text-[10px] mt-0.5">Home</span>
        </a>
        <a href="{{ route('categories') }}" class="flex flex-col items-center justify-center flex-1 py-1 text-center ${activePage === 'categories' ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800'}">
          <i class="fa-solid fa-layer-group text-base"></i>
          <span class="text-[10px] mt-0.5">Categories</span>
        </a>
        <a href="{{ route('shop') }}" class="flex flex-col items-center justify-center flex-1 py-1 text-center ${activePage === 'shop' ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800'}">
          <i class="fa-solid fa-magnifying-glass text-base"></i>
          <span class="text-[10px] mt-0.5">Search</span>
        </a>
        <a href="{{ route('wishlist') }}" class="flex flex-col items-center justify-center flex-1 py-1 text-center relative ${activePage === 'wishlist' ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800'}">
          <div class="relative inline-block">
            <i class="fa-regular fa-heart text-base"></i>
            <span class="wishlist-count-badge absolute -top-1.5 -right-2.5 w-3.5 h-3.5 rounded-full bg-red-500 text-white text-[9px] font-bold items-center justify-center hidden">0</span>
          </div>
          <span class="text-[10px] mt-0.5">Wishlist</span>
        </a>
        <a href="{{ route('cart') }}" class="flex flex-col items-center justify-center flex-1 py-1 text-center relative ${activePage === 'cart' ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800'}">
          <div class="relative inline-block">
            <i class="fa-solid fa-cart-shopping text-base"></i>
            <span class="cart-count-badge absolute -top-1.5 -right-2.5 w-3.5 h-3.5 rounded-full bg-blue-600 text-white text-[9px] font-bold items-center justify-center hidden">0</span>
          </div>
          <span class="text-[10px] mt-0.5">Cart</span>
        </a>
      </div>
    `;
  },

  renderFooter() {
    const footerContainer = document.getElementById('site-footer');
    if (!footerContainer) return;

    footerContainer.innerHTML = `
      <footer class="bg-[#070D18] text-slate-300 pt-14 pb-20 lg:pb-12 border-t border-slate-800">
        <div class="container-custom">
          
          <!-- Top Trust Pillars (4 Key Guarantees) -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-12 pb-12 border-b border-slate-800/80">
            <div class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-slate-700 transition-colors">
              <div class="w-11 h-11 rounded-xl bg-blue-500/10 text-blue-400 border border-blue-500/20 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
              </div>
              <div>
                <h5 class="text-xs font-bold text-white font-heading">20-Point QC Tested</h5>
                <p class="text-[11px] text-slate-400 mt-0.5">Rigorous hardware & battery diagnostics.</p>
              </div>
            </div>

            <div class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-slate-700 transition-colors">
              <div class="w-11 h-11 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-rotate-left"></i>
              </div>
              <div>
                <h5 class="text-xs font-bold text-white font-heading">7-Day Easy Replacement</h5>
                <p class="text-[11px] text-slate-400 mt-0.5">100% money-back / replacement guarantee.</p>
              </div>
            </div>

            <div class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-slate-700 transition-colors">
              <div class="w-11 h-11 rounded-xl bg-indigo-500/10 text-indigo-400 border border-indigo-500/20 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-truck-fast"></i>
              </div>
              <div>
                <h5 class="text-xs font-bold text-white font-heading">Free Insured Shipping</h5>
                <p class="text-[11px] text-slate-400 mt-0.5">Safe doorstep delivery across all pin codes.</p>
              </div>
            </div>

            <div class="flex items-center gap-3.5 p-4 rounded-2xl bg-slate-900/60 border border-slate-800 hover:border-slate-700 transition-colors">
              <div class="w-11 h-11 rounded-xl bg-amber-500/10 text-amber-400 border border-amber-500/20 flex items-center justify-center text-lg flex-shrink-0">
                <i class="fa-solid fa-screwdriver-wrench"></i>
              </div>
              <div>
                <h5 class="text-xs font-bold text-white font-heading">Up to 12M Warranty</h5>
                <p class="text-[11px] text-slate-400 mt-0.5">Free technical support & service coverage.</p>
              </div>
            </div>
          </div>

          <!-- Weekly Inventory Drops & Newsletter Banner -->
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
                <input 
                  type="email" 
                  required 
                  placeholder="Enter your email address..." 
                  class="w-full bg-slate-950 border border-slate-700 text-white placeholder-slate-500 rounded-xl pl-9 pr-3.5 py-2.5 text-xs focus:outline-none focus:border-blue-500 transition-colors"
                />
              </div>
              <button type="submit" class="btn-base btn-primary text-xs px-5 py-2.5 font-bold rounded-xl whitespace-nowrap shadow-lg">
                Subscribe <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </button>
            </form>
          </div>

          <!-- Main 5-Column Grid with 12-Column Spans -->
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-12 gap-8 lg:gap-6 xl:gap-8 pb-12 border-b border-slate-800/80">
            
            <!-- Col 1: Brand & Contact (4 cols) -->
            <div class="sm:col-span-2 lg:col-span-4 space-y-4">
              <a href="{{ route('home') }}" class="inline-block group" aria-label="VANSH IT & COMM">
                <img src="img/vanshitcomm-logo-white.png" alt="VANSH IT & COMMUNICATION" class="h-9 w-auto object-contain transition-transform group-hover:scale-105" />
              </a>
              <div>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[11px] font-bold bg-blue-500/10 text-blue-400 border border-blue-500/20 whitespace-nowrap">
                  <i class="fa-solid fa-check-circle text-[10px] flex-shrink-0"></i> Certified Refurbished Hub
                </span>
              </div>
              <p class="text-xs text-slate-400 leading-relaxed font-body">
                Your trusted destination for certified pre-owned business laptops, verified smartphones, and genuine repair solutions.
              </p>
              
              <!-- Clean Contact List -->
              <div class="pt-2 space-y-2.5 text-xs font-body">
                <a href="tel:+919876543210" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition-colors">
                  <span class="w-6 h-6 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0 text-[10px]">
                    <i class="fa-solid fa-phone"></i>
                  </span>
                  <span class="whitespace-nowrap">+91 98765 43210 <span class="text-[10px] text-slate-500">(10 AM – 8 PM)</span></span>
                </a>
                <a href="mailto:support@vanshitcomm.com" class="flex items-center gap-2.5 text-slate-300 hover:text-white transition-colors">
                  <span class="w-6 h-6 rounded-lg bg-blue-500/10 border border-blue-500/20 text-blue-400 flex items-center justify-center flex-shrink-0 text-[10px]">
                    <i class="fa-solid fa-envelope"></i>
                  </span>
                  <span>support@vanshitcomm.com</span>
                </a>
                <div class="flex items-center gap-2.5 text-slate-400">
                  <span class="w-6 h-6 rounded-lg bg-slate-800 text-slate-400 flex items-center justify-center flex-shrink-0 text-[10px]">
                    <i class="fa-solid fa-location-dot"></i>
                  </span>
                  <span>Experience Store & QC Lab, India</span>
                </div>
              </div>
            </div>

            <!-- Col 2: Shop Tech (2 cols) -->
            <div class="lg:col-span-2">
              <h4 class="text-xs font-extrabold text-white uppercase tracking-wider font-heading mb-4 pb-1 border-b border-slate-800/60">
                Shop Hardware
              </h4>
              <ul class="space-y-2.5 font-body text-xs">
                <li><a href="{{ route('laptops') }}" class="footer-link">Refurbished Laptops</a></li>
                <li><a href="{{ route('mobile-phones') }}" class="footer-link">Refurbished Mobiles</a></li>
                <li><a href="{{ route('accessories') }}" class="footer-link">Computer Accessories</a></li>
                <li><a href="{{ route('laptops') }}?maxPrice=15000" class="footer-link text-emerald-400">Under ₹15,000 Budget</a></li>
                <li><a href="{{ route('shop') }}" class="footer-link">Deals & Clearance Hub</a></li>
                <li><a href="{{ route('categories') }}" class="footer-link">All Categories Hub</a></li>
              </ul>
            </div>

            <!-- Col 3: Services (2 cols) -->
            <div class="lg:col-span-2">
              <h4 class="text-xs font-extrabold text-white uppercase tracking-wider font-heading mb-4 pb-1 border-b border-slate-800/60">
                Expert Services
              </h4>
              <ul class="space-y-2.5 font-body text-xs">
                <li><a href="{{ route('repair') }}" class="footer-link">Screen & Battery Repair</a></li>
                <li><a href="{{ route('repair') }}" class="footer-link">Motherboard Diagnostics</a></li>
                <li><a href="{{ route('exchange') }}" class="footer-link">Old Device Exchange / Sell</a></li>
                <li><a href="product.html#video-call-drawer" class="footer-link text-blue-400">Video Call Product Demo</a></li>
                <li><a href="{{ route('track-order') }}" class="footer-link">Track Your Parcel</a></li>
                <li><a href="{{ route('warranty') }}" class="footer-link">Warranty & Claims</a></li>
              </ul>
            </div>

            <!-- Col 4: Company (2 cols) -->
            <div class="lg:col-span-2">
              <h4 class="text-xs font-extrabold text-white uppercase tracking-wider font-heading mb-4 pb-1 border-b border-slate-800/60">
                Company & Trust
              </h4>
              <ul class="space-y-2.5 font-body text-xs">
                <li><a href="{{ route('about') }}" class="footer-link">About VANSH IT & COMM</a></li>
                <li><a href="about.html#refurbish-process" class="footer-link">20-Point QC Testing</a></li>
                <li><a href="{{ route('blog') }}" class="footer-link">Tech Buying Guides & Blog</a></li>
                <li><a href="{{ route('faq') }}" class="footer-link">Frequently Asked Questions</a></li>
                <li><a href="{{ route('contact') }}" class="footer-link">Customer Helpdesk</a></li>
              </ul>
            </div>

            <!-- Col 5: Store Policies (2 cols) -->
            <div class="lg:col-span-2">
              <h4 class="text-xs font-extrabold text-white uppercase tracking-wider font-heading mb-4 pb-1 border-b border-slate-800/60">
                Store Policies
              </h4>
              <ul class="space-y-2.5 font-body text-xs">
                <li><a href="terms.html?tab=terms" class="footer-link">Terms & Conditions</a></li>
                <li><a href="{{ route('privacy') }}" class="footer-link">Privacy & Data Security</a></li>
                <li><a href="{{ route('returns') }}" class="footer-link">7-Day Replacement Policy</a></li>
                <li><a href="{{ route('shipping') }}" class="footer-link">Shipping & Logistics Policy</a></li>
                <li><a href="terms.html?tab=cookies" class="footer-link">Cookies Policy</a></li>
                <li><a href="{{ route('warranty') }}" class="footer-link">Warranty Guidelines</a></li>
              </ul>
            </div>

          </div>

          <!-- Bottom Footer Row: Socials & Copyright -->
          <div class="pt-8 flex flex-col md:flex-row items-center justify-between gap-5 text-xs text-slate-500 font-body">
            <div class="space-y-1 text-center md:text-left">
              <p>
                &copy; 2026 <strong class="text-slate-300 font-bold">VANSH IT & COMM</strong>. All rights reserved. 100% GST Tax Compliant.
              </p>
              <p class="text-[11px] text-slate-500">
                All brand trademarks, logos, and model names belong to their respective manufacturers.
              </p>
            </div>

            <!-- Social Circle Icons & Trust Tag -->
            <div class="flex items-center gap-3">
              <a href="#" onclick="event.preventDefault(); showToast('WhatsApp support connected.', 'info');" class="footer-social-btn wa" aria-label="WhatsApp" title="WhatsApp Support">
                <i class="fa-brands fa-whatsapp"></i>
              </a>
              <a href="#" onclick="event.preventDefault(); showToast('Instagram page coming soon.', 'info');" class="footer-social-btn ig" aria-label="Instagram" title="Instagram">
                <i class="fa-brands fa-instagram"></i>
              </a>
              <a href="#" onclick="event.preventDefault(); showToast('Facebook page coming soon.', 'info');" class="footer-social-btn fb" aria-label="Facebook" title="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
              </a>
              <a href="#" onclick="event.preventDefault(); showToast('YouTube channel coming soon.', 'info');" class="footer-social-btn yt" aria-label="YouTube" title="YouTube">
                <i class="fa-brands fa-youtube"></i>
              </a>
            </div>
          </div>
        </div>
      </footer>
    `;

    this.fixDom(footerContainer);
  },

  renderModals(activePage = '') {
    return `
      ${this.renderMobileDrawer(activePage)}
      ${this.renderBottomNav(activePage)}

      <!-- Quick View Modal Container -->
      <div id="quick-view-modal" class="modal-wrapper">
        <div class="modal-backdrop" onclick="App.closeModal('quick-view-modal')"></div>
        <div class="modal-box" id="quick-view-modal-content"></div>
      </div>

      <!-- Auth Demo Modal Container (Login / Register) -->
      <div id="auth-modal" class="modal-wrapper">
        <div class="modal-backdrop" onclick="App.closeModal('auth-modal')"></div>
        <div class="modal-box max-w-md p-6">
          <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <img src="img/vanshitcomm-logo.png" alt="VANSH IT & COMM" class="h-8 w-auto object-contain" />
            <button type="button" onclick="App.closeModal('auth-modal')" class="text-slate-400 hover:text-slate-700">
              <i class="fa-solid fa-xmark text-lg"></i>
            </button>
          </div>

          <!-- Tabs -->
          <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-xl mb-4 text-xs font-bold text-center">
            <button type="button" id="tab-login-btn" onclick="App.switchAuthTab('login')" class="py-2 rounded-lg bg-white shadow-sm text-blue-600">Login</button>
            <button type="button" id="tab-signup-btn" onclick="App.switchAuthTab('signup')" class="py-2 rounded-lg text-slate-600">Create Account</button>
          </div>

          <!-- Login Form -->
          <form id="form-login" class="space-y-3" onsubmit="App.handleAuthSubmit(event, 'login')">
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Mobile Number or Email</label>
              <input type="text" required placeholder="Enter mobile or email" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
              <input type="password" required placeholder="••••••••" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
            </div>
            <button type="submit" class="btn-base btn-primary w-full text-xs font-semibold py-2.5">
              Login to Account
            </button>
            <p class="text-[11px] text-slate-400 text-center pt-2">Frontend Demo Login. No real authentication required.</p>
          </form>

          <!-- Signup Form (Hidden by default) -->
          <form id="form-signup" class="space-y-3 hidden" onsubmit="App.handleAuthSubmit(event, 'signup')">
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name</label>
              <input type="text" required placeholder="Your full name" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Mobile Number</label>
              <input type="tel" required placeholder="10-digit mobile number" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
              <input type="email" required placeholder="name@example.com" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
            </div>
            <div>
              <label class="block text-xs font-semibold text-slate-700 mb-1">Create Password</label>
              <input type="password" required placeholder="••••••••" class="w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
            </div>
            <button type="submit" class="btn-base btn-primary w-full text-xs font-semibold py-2.5">
              Register Account
            </button>
          </form>
        </div>
      </div>

      <!-- Toast Container -->
      <div id="toast-container" aria-live="polite"></div>

      <!-- Floating Buttons Group -->
      <div class="floating-btn-group">
        <a 
          href="#" 
          class="floating-btn floating-whatsapp" 
          title="Chat with VANSH IT & COMM" 
          aria-label="Chat on WhatsApp"
          onclick="event.preventDefault(); showToast('WhatsApp support link will be connected to store phone number.', 'info');"
        >
          <i class="fa-brands fa-whatsapp text-2xl"></i>
        </a>
        <button 
          type="button" 
          id="back-to-top-btn" 
          class="floating-btn floating-back-to-top" 
          onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
          aria-label="Back to Top"
        >
          <i class="fa-solid fa-arrow-up text-lg"></i>
        </button>
      </div>
    `;
  }
};
