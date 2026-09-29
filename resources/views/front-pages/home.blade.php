@extends('layouts.app')
@section('content')


    <!-- Main Content -->
    <main class="flex-grow">

        <!-- ==========================================
             HERO SLIDER SECTION (Responsive Mobile, Tablet & Desktop)
             ========================================== -->
        <section class="relative bg-slate-950 text-white overflow-hidden" aria-label="Featured Offers">
            <div id="hero-slider"
                class="relative min-h-[460px] sm:min-h-[480px] md:min-h-[460px] lg:min-h-[520px] flex items-center">

                <!-- Slide 1 (Primary Hero: All-in-One Certified Tech) -->
                <div
                    class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out flex items-center opacity-100 z-10 bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950">
                    <div class="container-custom py-8 sm:py-10 md:py-8 lg:py-10">
                        <div class="grid grid-cols-12 gap-4 md:gap-6 lg:gap-8 items-center">

                            <!-- Left Content -->
                            <div
                                class="col-span-12 md:col-span-7 space-y-3 sm:space-y-4 md:space-y-3 lg:space-y-4 text-left">
                                <div
                                    class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-[10px] sm:text-xs font-bold tracking-wider uppercase">
                                    <i class="fa-solid fa-bolt text-amber-400"></i> Tested Technology. Trusted Value.
                                </div>
                                <h1
                                    class="text-2xl sm:text-3xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-white tracking-tight leading-[1.15] font-heading">
                                    TECH THAT WORKS <br /><span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-sky-300">FOR
                                        YOU.</span>
                                </h1>
                                <p
                                    class="text-xs sm:text-sm md:text-xs lg:text-base text-slate-300 max-w-xl font-body leading-relaxed">
                                    New & refurbished laptops, smartphones, and accessories. 20-point tested, transparent
                                    condition grading, and reliable warranty support from VANSH IT & COMM.
                                </p>
                                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 pt-1 sm:pt-2">
                                    <a href="laptops.html"
                                        class="btn-base btn-primary text-xs sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 font-semibold shadow-lg shadow-blue-600/30">
                                        <i class="fa-solid fa-laptop"></i> SHOP LAPTOPS
                                    </a>
                                    <a href="mobile-phones.html"
                                        class="btn-base btn-secondary text-xs sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 font-semibold bg-white/10 text-white border-white/20 hover:bg-white/20 hover:text-white">
                                        <i class="fa-solid fa-mobile-screen-button"></i> SHOP MOBILES
                                    </a>
                                    <a href="repair.html"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-sky-400 hover:text-sky-300 py-1">
                                        Need a Repair? Book Now â†’
                                    </a>
                                </div>
                                <!-- Trust Points -->
                                <div
                                    class="pt-1 sm:pt-2 flex flex-wrap items-center gap-3 sm:gap-4 text-[10px] sm:text-xs text-slate-400">
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i> Up to 12-Mo
                                        Warranty</span>
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-truck-fast text-blue-400 text-[10px]"></i> Pan-India Insured
                                        Parcel</span>
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-file-invoice text-amber-400 text-[10px]"></i> GST Input
                                        Credit</span>
                                </div>
                            </div>

                            <!-- Right Image Showcase Card -->
                            <div class="hidden md:flex md:col-span-5 justify-center">
                                <div class="relative w-full max-w-md">
                                    <div
                                        class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-cyan-500 rounded-3xl blur-xl opacity-40">
                                    </div>
                                    <div
                                        class="relative bg-slate-900/90 border border-slate-700/60 rounded-3xl p-3.5 lg:p-4 shadow-2xl backdrop-blur-md">
                                        <div class="relative overflow-hidden rounded-2xl mb-2.5 lg:mb-3 group">
                                            <img src="{{ asset('assets/img/product-1593642632823-8f785ba67e45.jpg')}}"
                                                alt="Dell Latitude 5420 Business Laptop"
                                                class="w-full h-44 lg:h-56 object-cover transform group-hover:scale-105 transition-transform duration-500 rounded-xl" />
                                            <span
                                                class="absolute top-2.5 left-2.5 bg-blue-600 text-white text-[9px] lg:text-[10px] font-extrabold uppercase px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-full shadow-md">
                                                ðŸ”¥ Best Seller â€¢ 64% OFF
                                            </span>
                                            <span
                                                class="absolute bottom-2.5 right-2.5 bg-slate-900/80 backdrop-blur-sm text-emerald-400 text-[10px] lg:text-[11px] font-bold px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-lg border border-emerald-500/30">
                                                20-Point Verified
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs">
                                            <div>
                                                <span
                                                    class="text-[9px] lg:text-[10px] uppercase font-bold text-blue-400 tracking-wider">Enterprise
                                                    Grade</span>
                                                <div class="font-extrabold text-white text-xs lg:text-base">Dell Latitude
                                                    5420 i5 11th Gen</div>
                                                <span class="text-[10px] lg:text-[11px] text-slate-400 font-body">16GB RAM
                                                    â€¢ 512GB SSD â€¢ 14" FHD IPS</span>
                                            </div>
                                            <div class="text-right flex-shrink-0 pl-2">
                                                <span
                                                    class="text-[10px] lg:text-xs text-slate-400 line-through">â‚¹89,999</span>
                                                <div class="text-base lg:text-lg font-black text-emerald-400 font-heading">
                                                    â‚¹32,499</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Slide 2 (Refurbished Business Laptops) -->
                <div
                    class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out flex items-center opacity-0 z-0 bg-gradient-to-r from-slate-950 via-slate-900 to-indigo-950">
                    <div class="container-custom py-8 sm:py-10 md:py-8 lg:py-10">
                        <div class="grid grid-cols-12 gap-4 md:gap-6 lg:gap-8 items-center">

                            <!-- Left Content -->
                            <div
                                class="col-span-12 md:col-span-7 space-y-3 sm:space-y-4 md:space-y-3 lg:space-y-4 text-left">
                                <div
                                    class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-emerald-500/20 border border-emerald-400/30 text-emerald-300 text-[10px] sm:text-xs font-bold tracking-wider uppercase">
                                    <i class="fa-solid fa-percent text-emerald-400"></i> UP TO 70% SAVINGS
                                </div>
                                <h2
                                    class="text-2xl sm:text-3xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-white tracking-tight leading-[1.15] font-heading">
                                    PREMIUM REFURBISHED <br /><span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 to-teal-300">BUSINESS
                                        LAPTOPS</span>
                                </h2>
                                <p
                                    class="text-xs sm:text-sm md:text-xs lg:text-base text-slate-300 max-w-xl font-body leading-relaxed">
                                    Tested. Trusted. Ready to Work. Quality enterprise ThinkPads, MacBooks, and Dell
                                    Latitudes engineered for developers, students, and businesses starting from â‚¹14,499.
                                </p>
                                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 pt-1 sm:pt-2">
                                    <a href="laptops.html"
                                        class="btn-base btn-primary text-xs sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 font-semibold shadow-lg shadow-blue-600/30">
                                        <i class="fa-solid fa-laptop"></i> Shop Laptops
                                    </a>
                                    <a href="shop.html?badge=deal"
                                        class="btn-base btn-secondary text-xs sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 font-semibold bg-white/10 text-white border-white/20 hover:bg-white/20 hover:text-white">
                                        <i class="fa-solid fa-fire text-amber-400"></i> Explore Deals
                                    </a>
                                    <a href="about.html#diagnostic"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-400 hover:text-teal-300 py-1">
                                        Our 20-Point Checklist â†’
                                    </a>
                                </div>
                                <!-- Trust Points -->
                                <div
                                    class="pt-1 sm:pt-2 flex flex-wrap items-center gap-3 sm:gap-4 text-[10px] sm:text-xs text-slate-400">
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-circle-check text-emerald-400 text-[10px]"></i> Grade A
                                        Flawless Body</span>
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-battery-three-quarters text-emerald-400 text-[10px]"></i>
                                        80%+ Battery Health</span>
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-rotate-left text-teal-400 text-[10px]"></i> 7-Day
                                        Replacement</span>
                                </div>
                            </div>

                            <!-- Right Image Showcase Card -->
                            <div class="hidden md:flex md:col-span-5 justify-center">
                                <div class="relative w-full max-w-md">
                                    <div
                                        class="absolute -inset-1 bg-gradient-to-r from-emerald-600 to-teal-500 rounded-3xl blur-xl opacity-40">
                                    </div>
                                    <div
                                        class="relative bg-slate-900/90 border border-slate-700/60 rounded-3xl p-3.5 lg:p-4 shadow-2xl backdrop-blur-md">
                                        <div class="relative overflow-hidden rounded-2xl mb-2.5 lg:mb-3 group">
                                            <img src="{{ asset('assets/img/product-1588872657578-7efd1f1555ed.jpg')}}"
                                                alt="Lenovo ThinkPad T480s Business Laptop"
                                                class="w-full h-44 lg:h-56 object-cover transform group-hover:scale-105 transition-transform duration-500 rounded-xl" />
                                            <span
                                                class="absolute top-2.5 left-2.5 bg-emerald-600 text-white text-[9px] lg:text-[10px] font-extrabold uppercase px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-full shadow-md">
                                                âš¡ Developer's Choice â€¢ 74% OFF
                                            </span>
                                            <span
                                                class="absolute bottom-2.5 right-2.5 bg-slate-900/80 backdrop-blur-sm text-teal-300 text-[10px] lg:text-[11px] font-bold px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-lg border border-teal-500/30">
                                                Original Charger Included
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs">
                                            <div>
                                                <span
                                                    class="text-[9px] lg:text-[10px] uppercase font-bold text-emerald-400 tracking-wider">Refurbished
                                                    Grade A</span>
                                                <div class="font-extrabold text-white text-xs lg:text-base">Lenovo ThinkPad
                                                    T480s i5 8th Gen</div>
                                                <span class="text-[10px] lg:text-[11px] text-slate-400 font-body">16GB RAM
                                                    â€¢ 512GB SSD â€¢ Dual Battery</span>
                                            </div>
                                            <div class="text-right flex-shrink-0 pl-2">
                                                <span
                                                    class="text-[10px] lg:text-xs text-slate-400 line-through">â‚¹78,000</span>
                                                <div class="text-base lg:text-lg font-black text-emerald-400 font-heading">
                                                    â‚¹19,999</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Slide 3 (Certified 5G Smartphones) -->
                <div
                    class="hero-slide absolute inset-0 transition-opacity duration-700 ease-in-out flex items-center opacity-0 z-0 bg-gradient-to-r from-slate-950 via-slate-900 to-purple-950">
                    <div class="container-custom py-8 sm:py-10 md:py-8 lg:py-10">
                        <div class="grid grid-cols-12 gap-4 md:gap-6 lg:gap-8 items-center">

                            <!-- Left Content -->
                            <div
                                class="col-span-12 md:col-span-7 space-y-3 sm:space-y-4 md:space-y-3 lg:space-y-4 text-left">
                                <div
                                    class="inline-flex items-center gap-1.5 sm:gap-2 px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full bg-purple-500/20 border border-purple-400/30 text-purple-300 text-[10px] sm:text-xs font-bold tracking-wider uppercase">
                                    <i class="fa-solid fa-mobile-screen text-purple-400"></i> CERTIFIED SMARTPHONES
                                </div>
                                <h2
                                    class="text-2xl sm:text-3xl md:text-3xl lg:text-4xl xl:text-5xl font-extrabold text-white tracking-tight leading-[1.15] font-heading">
                                    NEW & REFURBISHED <br /><span
                                        class="text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-300">FLAGSHIP
                                        MOBILES</span>
                                </h2>
                                <p
                                    class="text-xs sm:text-sm md:text-xs lg:text-base text-slate-300 max-w-xl font-body leading-relaxed">
                                    Upgrade to Apple iPhones, Samsung Galaxy S-Series, and OnePlus 5G flagships. 100%
                                    genuine parts, 85%+ battery health guarantee, and doorstep exchange bonus.
                                </p>
                                <div class="flex flex-wrap items-center gap-2.5 sm:gap-3 pt-1 sm:pt-2">
                                    <a href="mobile-phones.html"
                                        class="btn-base btn-primary text-xs sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 font-semibold shadow-lg shadow-purple-600/30 bg-purple-600 hover:bg-purple-700">
                                        <i class="fa-solid fa-mobile-screen-button"></i> Shop Mobiles
                                    </a>
                                    <a href="exchange.html"
                                        class="btn-base btn-secondary text-xs sm:text-sm px-4 sm:px-6 py-2.5 sm:py-3 font-semibold bg-white/10 text-white border-white/20 hover:bg-white/20 hover:text-white">
                                        <i class="fa-solid fa-repeat text-pink-400"></i> Exchange Old Phone
                                    </a>
                                    <a href="warranty.html"
                                        class="inline-flex items-center gap-1.5 text-xs font-bold text-purple-300 hover:text-purple-200 py-1">
                                        Warranty Coverage â†’
                                    </a>
                                </div>
                                <!-- Trust Points -->
                                <div
                                    class="pt-1 sm:pt-2 flex flex-wrap items-center gap-3 sm:gap-4 text-[10px] sm:text-xs text-slate-400">
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-circle-check text-purple-400 text-[10px]"></i> 85%+ Battery
                                        Guarantee</span>
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-shield-halved text-pink-400 text-[10px]"></i> 6-Month
                                        Warranty</span>
                                    <span class="inline-flex items-center gap-1.5"><i
                                            class="fa-solid fa-box-open text-purple-400 text-[10px]"></i> Cable
                                        Included</span>
                                </div>
                            </div>

                            <!-- Right Image Showcase Card -->
                            <div class="hidden md:flex md:col-span-5 justify-center">
                                <div class="relative w-full max-w-md">
                                    <div
                                        class="absolute -inset-1 bg-gradient-to-r from-purple-600 to-pink-500 rounded-3xl blur-xl opacity-40">
                                    </div>
                                    <div
                                        class="relative bg-slate-900/90 border border-slate-700/60 rounded-3xl p-3.5 lg:p-4 shadow-2xl backdrop-blur-md">
                                        <div class="relative overflow-hidden rounded-2xl mb-2.5 lg:mb-3 group">
                                            <img src="{{ asset('assets/img/product-1592750475338-74b7b21085ab.jpg')}}"
                                                alt="Apple iPhone 13 Certified Refurbished"
                                                class="w-full h-44 lg:h-56 object-cover transform group-hover:scale-105 transition-transform duration-500 rounded-xl" />
                                            <span
                                                class="absolute top-2.5 left-2.5 bg-purple-600 text-white text-[9px] lg:text-[10px] font-extrabold uppercase px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-full shadow-md">
                                                ðŸŒŸ Top Flagship â€¢ 47% OFF
                                            </span>
                                            <span
                                                class="absolute bottom-2.5 right-2.5 bg-slate-900/80 backdrop-blur-sm text-pink-300 text-[10px] lg:text-[11px] font-bold px-2 py-0.5 lg:px-2.5 lg:py-1 rounded-lg border border-pink-500/30">
                                                88% Battery Health
                                            </span>
                                        </div>
                                        <div class="flex items-center justify-between text-xs">
                                            <div>
                                                <span
                                                    class="text-[9px] lg:text-[10px] uppercase font-bold text-purple-400 tracking-wider">Certified
                                                    Apple</span>
                                                <div class="font-extrabold text-white text-xs lg:text-base">Apple iPhone 13
                                                    128GB Midnight</div>
                                                <span class="text-[10px] lg:text-[11px] text-slate-400 font-body">Super
                                                    Retina XDR â€¢ A15 Bionic â€¢ 5G</span>
                                            </div>
                                            <div class="text-right flex-shrink-0 pl-2">
                                                <span
                                                    class="text-[10px] lg:text-xs text-slate-400 line-through">â‚¹69,900</span>
                                                <div class="text-base lg:text-lg font-black text-emerald-400 font-heading">
                                                    â‚¹36,999</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

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
                    <button type="button" onclick="setHeroSlide(0)"
                        class="hero-dot w-6 sm:w-8 h-1.5 sm:h-2 rounded-full bg-blue-500 transition-all"
                        aria-label="Slide 1"></button>
                    <button type="button" onclick="setHeroSlide(1)"
                        class="hero-dot w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-slate-600 hover:bg-slate-400 transition-all"
                        aria-label="Slide 2"></button>
                    <button type="button" onclick="setHeroSlide(2)"
                        class="hero-dot w-1.5 sm:w-2 h-1.5 sm:h-2 rounded-full bg-slate-600 hover:bg-slate-400 transition-all"
                        aria-label="Slide 3"></button>
                </div>
            </div>
        </section>

        <!-- ==========================================
             TRUST STRIP (Responsive 2/3/5 Columns)
             ========================================== -->
        <section class="bg-white border-b border-slate-200 py-3.5 sm:py-4 shadow-sm" aria-label="Trust Badges">
            <div class="container-custom">
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-5 text-slate-800">
                    <div
                        class="flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-slate-50/80 border border-slate-100 lg:bg-transparent lg:border-none lg:p-0 min-w-0">
                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center flex-shrink-0 text-sm sm:text-base lg:text-lg">
                            <i class="fa-solid fa-clipboard-check"></i>
                        </div>
                        <div class="min-w-0">
                            <h4
                                class="text-xs sm:text-xs lg:text-sm font-bold leading-tight whitespace-nowrap text-slate-900 font-heading">
                                20+ Point Tested</h4>
                            <p class="text-[10px] sm:text-[11px] text-slate-500 leading-tight truncate font-body">Hardware &
                                screen verified</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-slate-50/80 border border-slate-100 lg:bg-transparent lg:border-none lg:p-0 min-w-0">
                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center flex-shrink-0 text-sm sm:text-base lg:text-lg">
                            <i class="fa-solid fa-receipt"></i>
                        </div>
                        <div class="min-w-0">
                            <h4
                                class="text-xs sm:text-xs lg:text-sm font-bold leading-tight whitespace-nowrap text-slate-900 font-heading">
                                GST Invoice</h4>
                            <p class="text-[10px] sm:text-[11px] text-slate-500 leading-tight truncate font-body">Claim 18%
                                input credit</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-slate-50/80 border border-slate-100 lg:bg-transparent lg:border-none lg:p-0 min-w-0">
                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-xl bg-purple-50 text-purple-600 border border-purple-100 flex items-center justify-center flex-shrink-0 text-sm sm:text-base lg:text-lg">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div class="min-w-0">
                            <h4
                                class="text-xs sm:text-xs lg:text-sm font-bold leading-tight whitespace-nowrap text-slate-900 font-heading">
                                Warranty Covered</h4>
                            <p class="text-[10px] sm:text-[11px] text-slate-500 leading-tight truncate font-body">Up to
                                12-Mo protection</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-slate-50/80 border border-slate-100 lg:bg-transparent lg:border-none lg:p-0 min-w-0">
                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-xl bg-amber-50 text-amber-600 border border-amber-100 flex items-center justify-center flex-shrink-0 text-sm sm:text-base lg:text-lg">
                            <i class="fa-solid fa-box-open"></i>
                        </div>
                        <div class="min-w-0">
                            <h4
                                class="text-xs sm:text-xs lg:text-sm font-bold leading-tight whitespace-nowrap text-slate-900 font-heading">
                                Secure Shipping</h4>
                            <p class="text-[10px] sm:text-[11px] text-slate-500 leading-tight truncate font-body">Pan-India
                                insured parcel</p>
                        </div>
                    </div>

                    <div
                        class="flex items-center gap-2.5 sm:gap-3 p-2 sm:p-2.5 rounded-xl bg-slate-50/80 border border-slate-100 lg:bg-transparent lg:border-none lg:p-0 min-w-0 col-span-2 sm:col-span-1 lg:col-span-1">
                        <div
                            class="w-8 h-8 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-xl bg-sky-50 text-sky-600 border border-sky-100 flex items-center justify-center flex-shrink-0 text-sm sm:text-base lg:text-lg">
                            <i class="fa-solid fa-headset"></i>
                        </div>
                        <div class="min-w-0">
                            <h4
                                class="text-xs sm:text-xs lg:text-sm font-bold leading-tight whitespace-nowrap text-slate-900 font-heading">
                                Expert Support</h4>
                            <p class="text-[10px] sm:text-[11px] text-slate-500 leading-tight truncate font-body">Direct
                                technical help</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             SHOP BY CATEGORY (Responsive Grid & Larger Images)
             ========================================== -->
        <section class="section-padding bg-slate-50" aria-label="Categories">
            <div class="container-custom">
                <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Explore Collections</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Shop By Category</h2>
                        <p class="section-subtitle text-xs sm:text-sm">Verified laptops, smartphones, accessories, and
                            certified repair solutions.</p>
                    </div>
                    <a href="shop.html"
                        class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 whitespace-nowrap">
                        View All Products <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4 lg:gap-4">

                    <!-- Category 1: Laptops -->
                    <a href="laptops.html"
                        class="category-card p-3 sm:p-4 lg:p-3.5 flex flex-col justify-between group text-decoration-none bg-white rounded-2xl border border-slate-200/90 hover:border-blue-600 hover:shadow-md transition-all">
                        <div
                            class="w-full aspect-[4/3] sm:aspect-[16/10] lg:aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 mb-2.5 sm:mb-3 relative">
                            <img src="{{ asset('assets/img/product-1588872657578-7efd1f1555ed.jpg')}}" alt="Laptops"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div
                                class="absolute top-2 left-2 w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white/95 text-blue-600 flex items-center justify-center text-xs shadow-sm">
                                <i class="fa-solid fa-laptop"></i>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-sm sm:text-base lg:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-tight font-heading">
                                Laptops</h3>
                            <p class="text-[11px] sm:text-xs lg:text-[11px] text-slate-500 mb-2 leading-tight">Dell,
                                ThinkPad, HP, Mac</p>
                            <span
                                class="text-xs font-bold text-blue-600 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">Explore
                                â†’</span>
                        </div>
                    </a>

                    <!-- Category 2: Mobile Phones -->
                    <a href="mobile-phones.html"
                        class="category-card p-3 sm:p-4 lg:p-3.5 flex flex-col justify-between group text-decoration-none bg-white rounded-2xl border border-slate-200/90 hover:border-blue-600 hover:shadow-md transition-all">
                        <div
                            class="w-full aspect-[4/3] sm:aspect-[16/10] lg:aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 mb-2.5 sm:mb-3 relative">
                            <img src="{{ asset('assets/img/product-1511707171634-5f897ff02aa9.jpg')}}" alt="Mobiles"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div
                                class="absolute top-2 left-2 w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white/95 text-blue-600 flex items-center justify-center text-xs shadow-sm">
                                <i class="fa-solid fa-mobile-screen-button"></i>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-sm sm:text-base lg:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-tight font-heading">
                                Mobile Phones</h3>
                            <p class="text-[11px] sm:text-xs lg:text-[11px] text-slate-500 mb-2 leading-tight">iPhones,
                                Galaxy, OnePlus</p>
                            <span
                                class="text-xs font-bold text-blue-600 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">Explore
                                â†’</span>
                        </div>
                    </a>

                    <!-- Category 3: Accessories -->
                    <a href="accessories.html"
                        class="category-card p-3 sm:p-4 lg:p-3.5 flex flex-col justify-between group text-decoration-none bg-white rounded-2xl border border-slate-200/90 hover:border-blue-600 hover:shadow-md transition-all">
                        <div
                            class="w-full aspect-[4/3] sm:aspect-[16/10] lg:aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 mb-2.5 sm:mb-3 relative">
                            <img src="{{ asset('assets/img/product-1583863788434-e58a36330cf0.jpg')}}" alt="Accessories"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div
                                class="absolute top-2 left-2 w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white/95 text-blue-600 flex items-center justify-center text-xs shadow-sm">
                                <i class="fa-solid fa-headphones"></i>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-sm sm:text-base lg:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-tight font-heading">
                                Accessories</h3>
                            <p class="text-[11px] sm:text-xs lg:text-[11px] text-slate-500 mb-2 leading-tight">Chargers,
                                SSD, RAM, Mice</p>
                            <span
                                class="text-xs font-bold text-blue-600 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">Explore
                                â†’</span>
                        </div>
                    </a>

                    <!-- Category 4: Refurbished Tech -->
                    <a href="shop.html?condition=Refurbished"
                        class="category-card p-3 sm:p-4 lg:p-3.5 flex flex-col justify-between group text-decoration-none bg-white rounded-2xl border border-slate-200/90 hover:border-blue-600 hover:shadow-md transition-all">
                        <div
                            class="w-full aspect-[4/3] sm:aspect-[16/10] lg:aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 mb-2.5 sm:mb-3 relative">
                            <img src="{{ asset('assets/img/product-1541807084-5c52b6b3adef.jpg')}}" alt="Refurbished"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div
                                class="absolute top-2 left-2 w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white/95 text-emerald-600 flex items-center justify-center text-xs shadow-sm">
                                <i class="fa-solid fa-recycle"></i>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-sm sm:text-base lg:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-tight font-heading">
                                Refurbished</h3>
                            <p class="text-[11px] sm:text-xs lg:text-[11px] text-slate-500 mb-2 leading-tight">20-Point
                                Certified Devices</p>
                            <span
                                class="text-xs font-bold text-blue-600 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">Explore
                                â†’</span>
                        </div>
                    </a>

                    <!-- Category 5: Repair Services -->
                    <a href="repair.html"
                        class="category-card p-3 sm:p-4 lg:p-3.5 flex flex-col justify-between group text-decoration-none bg-white rounded-2xl border border-slate-200/90 hover:border-blue-600 hover:shadow-md transition-all">
                        <div
                            class="w-full aspect-[4/3] sm:aspect-[16/10] lg:aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 mb-2.5 sm:mb-3 relative">
                            <img src="{{ asset('assets/img/product-1588872657578-7efd1f1555ed.jpg')}}" alt="Repair"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div
                                class="absolute top-2 left-2 w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white/95 text-amber-600 flex items-center justify-center text-xs shadow-sm">
                                <i class="fa-solid fa-screwdriver-wrench"></i>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-sm sm:text-base lg:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-tight font-heading">
                                Repair Services</h3>
                            <p class="text-[11px] sm:text-xs lg:text-[11px] text-slate-500 mb-2 leading-tight">Screens,
                                Batteries & OS</p>
                            <span
                                class="text-xs font-bold text-blue-600 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">Book
                                â†’</span>
                        </div>
                    </a>

                    <!-- Category 6: Device Exchange -->
                    <a href="exchange.html"
                        class="category-card p-3 sm:p-4 lg:p-3.5 flex flex-col justify-between group text-decoration-none bg-white rounded-2xl border border-slate-200/90 hover:border-blue-600 hover:shadow-md transition-all">
                        <div
                            class="w-full aspect-[4/3] sm:aspect-[16/10] lg:aspect-[4/3] rounded-xl overflow-hidden bg-slate-100 mb-2.5 sm:mb-3 relative">
                            <img src="{{ asset('assets/img/product-1592750475338-74b7b21085ab.jpg')}}" alt="Exchange"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div
                                class="absolute top-2 left-2 w-7 h-7 sm:w-8 sm:h-8 rounded-lg bg-white/95 text-purple-600 flex items-center justify-center text-xs shadow-sm">
                                <i class="fa-solid fa-rotate"></i>
                            </div>
                        </div>
                        <div>
                            <h3
                                class="text-sm sm:text-base lg:text-sm font-bold text-slate-900 group-hover:text-blue-600 transition-colors leading-tight font-heading">
                                Exchange Tech</h3>
                            <p class="text-[11px] sm:text-xs lg:text-[11px] text-slate-500 mb-2 leading-tight">Upgrade Your
                                Old Device</p>
                            <span
                                class="text-xs font-bold text-blue-600 inline-flex items-center gap-1 group-hover:translate-x-1 transition-transform">Calculate
                                â†’</span>
                        </div>
                    </a>
                </div>
            </div>
        </section>

        <!-- ==========================================
             SPECIAL BLOCK: THE SMARTER WAY TO BUY TECH
             ========================================== -->
        <section class="py-8 sm:py-12 bg-slate-900 text-white relative overflow-hidden" aria-label="Brand Philosophy">
            <div class="container-custom relative z-10">
                <div
                    class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 p-6 sm:p-8 md:p-10 lg:p-12 rounded-3xl border border-slate-700/60 shadow-xl">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 md:gap-8 items-center">
                        <div class="md:col-span-8 space-y-3 sm:space-y-4">
                            <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1">THE
                                VANSH ADVANTAGE</span>
                            <h2
                                class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
                                THE SMARTER WAY TO BUY TECH
                            </h2>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 pt-2 text-xs sm:text-sm text-slate-300">
                                <div class="flex items-start gap-2.5">
                                    <i class="fa-solid fa-circle-check text-blue-400 mt-1"></i>
                                    <div><strong>New</strong> when you want the latest release.</div>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <i class="fa-solid fa-circle-check text-emerald-400 mt-1"></i>
                                    <div><strong>Refurbished</strong> when you want maximum value.</div>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <i class="fa-solid fa-circle-check text-amber-400 mt-1"></i>
                                    <div><strong>Repair</strong> when you want to extend your device life.</div>
                                </div>
                                <div class="flex items-start gap-2.5">
                                    <i class="fa-solid fa-circle-check text-purple-400 mt-1"></i>
                                    <div><strong>Exchange</strong> when you're ready for an upgrade.</div>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-4 flex md:justify-end">
                            <a href="shop.html"
                                class="btn-base btn-primary px-6 sm:px-8 py-3 sm:py-3.5 text-xs sm:text-sm font-semibold shadow-lg shadow-blue-600/30 w-full sm:w-auto text-center justify-center">
                                Explore All Offerings <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             FEATURED LAPTOPS SECTION (Responsive 2/3/4 Columns)
             ========================================== -->
        <section class="section-padding bg-white" aria-label="Featured Laptops">
            <div class="container-custom">
                <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Enterprise Performance</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Featured Laptops</h2>
                        <p class="section-subtitle text-xs sm:text-sm">Tested technology for work, study, creativity, and
                            coding.</p>
                    </div>
                    <a href="laptops.html"
                        class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 whitespace-nowrap">
                        Browse All (10+) <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6"
                    id="featured-laptops-grid">
                    <!-- Dynamically populated from PRODUCTS_DATA -->
                </div>
            </div>
        </section>

        <!-- ==========================================
             BUDGET LAPTOP CARDS (Responsive 1/3 Columns)
             ========================================== -->
        <section class="py-8 sm:py-10 bg-slate-50 border-y border-slate-200" aria-label="Budget Laptops">
            <div class="container-custom">
                <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-4 sm:mb-6 font-heading flex items-center gap-2">
                    <i class="fa-solid fa-tags text-blue-600"></i> Shop Laptops By Budget
                </h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 md:grid-cols-3 gap-3.5 sm:gap-4">
                    <a href="laptops.html?maxPrice=15000"
                        class="p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-blue-900 to-slate-900 text-white shadow-md hover:shadow-lg transition-transform hover:-translate-y-1 block text-decoration-none">
                        <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-emerald-400">Entry &
                            Students</span>
                        <h4 class="text-lg sm:text-xl font-extrabold text-white mt-1 mb-1.5 sm:mb-2 font-heading">Laptops
                            Under â‚¹15,000</h4>
                        <p class="text-xs text-slate-300 mb-3 sm:mb-4 leading-relaxed">Fast SSDs, ideal for online study,
                            office docs, and browsing.</p>
                        <span
                            class="text-xs font-bold text-white bg-blue-600 hover:bg-blue-700 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-lg inline-flex items-center gap-1.5">View
                            Products â†’</span>
                    </a>

                    <a href="laptops.html?minPrice=15000&maxPrice=25000"
                        class="p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-indigo-900 to-slate-900 text-white shadow-md hover:shadow-lg transition-transform hover:-translate-y-1 block text-decoration-none">
                        <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-blue-300">Most
                            Popular</span>
                        <h4 class="text-lg sm:text-xl font-extrabold text-white mt-1 mb-1.5 sm:mb-2 font-heading">Laptops
                            â‚¹15K â€“ â‚¹25K</h4>
                        <p class="text-xs text-slate-300 mb-3 sm:mb-4 leading-relaxed">Core i5 8th Gen, 16GB RAM, ThinkPads
                            & Dell Latitudes.</p>
                        <span
                            class="text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-700 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-lg inline-flex items-center gap-1.5">View
                            Products â†’</span>
                    </a>

                    <a href="laptops.html?minPrice=25000&maxPrice=35000"
                        class="p-5 sm:p-6 rounded-2xl bg-gradient-to-br from-slate-900 to-blue-950 text-white shadow-md hover:shadow-lg transition-transform hover:-translate-y-1 block text-decoration-none">
                        <span class="text-[10px] sm:text-[11px] font-bold uppercase tracking-wider text-amber-300">Pro &
                            Developers</span>
                        <h4 class="text-lg sm:text-xl font-extrabold text-white mt-1 mb-1.5 sm:mb-2 font-heading">Laptops
                            â‚¹25K â€“ â‚¹35K</h4>
                        <p class="text-xs text-slate-300 mb-3 sm:mb-4 leading-relaxed">Core i5 11th Gen / M1 MacBooks with
                            512GB NVMe SSD.</p>
                        <span
                            class="text-xs font-bold text-white bg-slate-700 hover:bg-slate-600 px-3.5 py-1.5 sm:px-4 sm:py-2 rounded-lg inline-flex items-center gap-1.5">View
                            Products â†’</span>
                    </a>
                </div>
            </div>
        </section>

        <!-- ==========================================
             FEATURED MOBILE PHONES SECTION (Responsive 2/3/4 Columns)
             ========================================== -->
        <section class="section-padding bg-white" aria-label="Featured Mobile Phones">
            <div class="container-custom">
                <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Certified Smartphones</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Featured Mobile Phones
                        </h2>
                        <p class="section-subtitle text-xs sm:text-sm">Flagships, gaming devices, and everyday smartphones
                            at smarter prices.</p>
                    </div>
                    <a href="mobile-phones.html"
                        class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 whitespace-nowrap">
                        Browse All (10+) <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6"
                    id="featured-mobiles-grid">
                    <!-- Dynamically populated from PRODUCTS_DATA -->
                </div>
            </div>
        </section>

        <!-- ==========================================
             GUIDED RECOMMENDATION (3 Columns Desktop)
             ========================================== -->
        <section class="section-padding bg-slate-50/80 border-y border-slate-200/80" aria-label="Product Finder Guide">
            <div class="container-custom">
                <div class="text-center max-w-2xl mx-auto mb-12">
                    <span
                        class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider">
                        <i class="fa-solid fa-compass text-blue-600"></i> Guided Recommendation
                    </span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 font-heading tracking-tight mt-3 mb-2">
                        What's Right For You?
                    </h2>
                    <p class="text-sm sm:text-base text-slate-600 font-body">
                        Find the exact technology tailored to your performance, budget, and daily workflow.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">

                    <!-- Option 1: Laptop -->
                    <div
                        class="bg-white rounded-2xl sm:rounded-3xl p-5 md:p-5 lg:p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                        <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r from-blue-600 to-indigo-600"></div>
                        <div>
                            <div class="flex items-center justify-between mb-3.5">
                                <div
                                    class="w-12 h-12 md:w-11 md:h-11 lg:w-14 lg:h-14 rounded-xl sm:rounded-2xl bg-blue-50 border border-blue-100 text-blue-600 flex items-center justify-center text-xl md:text-lg lg:text-2xl group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fa-solid fa-laptop"></i>
                                </div>
                                <span
                                    class="badge bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full">High
                                    Performance</span>
                            </div>

                            <h3
                                class="text-lg md:text-lg lg:text-xl font-extrabold text-slate-900 font-heading mb-1.5 group-hover:text-blue-600 transition-colors">
                                Need a Laptop?</h3>
                            <p
                                class="text-xs md:text-xs lg:text-sm text-slate-600 mb-4 md:mb-4 lg:mb-5 leading-relaxed font-body">
                                Tailored configurations for coding, business multitasking, CAD/design, and academic study.
                            </p>

                            <ul
                                class="space-y-2 md:space-y-2 lg:space-y-2.5 text-xs md:text-xs lg:text-sm text-slate-700 mb-5 md:mb-5 lg:mb-6 bg-slate-50/80 p-3 md:p-3.5 lg:p-4 rounded-xl md:rounded-2xl border border-slate-100">
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate"><strong>8GB to 32GB</strong> RAM options</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate">Fast NVMe SSD storage</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-blue-100 text-blue-600 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate"><strong>Up to 12-Month</strong> Warranty</span>
                                </li>
                            </ul>
                        </div>

                        <a href="laptops.html"
                            class="btn-base btn-primary w-full py-2.5 md:py-2.5 lg:py-3 text-xs md:text-xs lg:text-sm font-bold shadow-md shadow-blue-600/20 flex items-center justify-center gap-2 group-hover:gap-3 transition-all rounded-xl">
                            <span>Find My Laptop</span> <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <!-- Option 2: Mobile -->
                    <div
                        class="bg-white rounded-2xl sm:rounded-3xl p-5 md:p-5 lg:p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                        <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r from-emerald-500 to-teal-600"></div>
                        <div>
                            <div class="flex items-center justify-between mb-3.5">
                                <div
                                    class="w-12 h-12 md:w-11 md:h-11 lg:w-14 lg:h-14 rounded-xl sm:rounded-2xl bg-emerald-50 border border-emerald-100 text-emerald-600 flex items-center justify-center text-xl md:text-lg lg:text-2xl group-hover:scale-110 group-hover:bg-emerald-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fa-solid fa-mobile-screen-button"></i>
                                </div>
                                <span
                                    class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full">5G
                                    & Flagships</span>
                            </div>

                            <h3
                                class="text-lg md:text-lg lg:text-xl font-extrabold text-slate-900 font-heading mb-1.5 group-hover:text-emerald-600 transition-colors">
                                Need a Phone?</h3>
                            <p
                                class="text-xs md:text-xs lg:text-sm text-slate-600 mb-4 md:mb-4 lg:mb-5 leading-relaxed font-body">
                                High-end camera sensors, long-lasting battery life, and vivid AMOLED 120Hz high refresh
                                screens.</p>

                            <ul
                                class="space-y-2 md:space-y-2 lg:space-y-2.5 text-xs md:text-xs lg:text-sm text-slate-700 mb-5 md:mb-5 lg:mb-6 bg-slate-50/80 p-3 md:p-3.5 lg:p-4 rounded-xl md:rounded-2xl border border-slate-100">
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate"><strong>85%+ Verified</strong> Battery Health</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate">100% Original OEM components</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate"><strong>5G Connectivity</strong> & Dual SIM</span>
                                </li>
                            </ul>
                        </div>

                        <a href="mobile-phones.html"
                            class="btn-base w-full py-2.5 md:py-2.5 lg:py-3 text-xs md:text-xs lg:text-sm font-bold bg-emerald-600 hover:bg-emerald-700 text-white shadow-md shadow-emerald-600/20 flex items-center justify-center gap-2 group-hover:gap-3 transition-all rounded-xl">
                            <span>Find My Phone</span> <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                    <!-- Option 3: Repair -->
                    <div
                        class="bg-white rounded-2xl sm:rounded-3xl p-5 md:p-5 lg:p-7 border border-slate-200/80 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 flex flex-col justify-between group relative overflow-hidden">
                        <div class="h-1.5 w-full absolute top-0 left-0 bg-gradient-to-r from-amber-500 to-orange-600"></div>
                        <div>
                            <div class="flex items-center justify-between mb-3.5">
                                <div
                                    class="w-12 h-12 md:w-11 md:h-11 lg:w-14 lg:h-14 rounded-xl sm:rounded-2xl bg-amber-50 border border-amber-100 text-amber-600 flex items-center justify-center text-xl md:text-lg lg:text-2xl group-hover:scale-110 group-hover:bg-amber-600 group-hover:text-white transition-all duration-300 shadow-sm">
                                    <i class="fa-solid fa-screwdriver-wrench"></i>
                                </div>
                                <span
                                    class="badge bg-amber-50 text-amber-800 border border-amber-200 text-[10px] font-extrabold uppercase px-2.5 py-0.5 rounded-full">Expert
                                    Service</span>
                            </div>

                            <h3
                                class="text-lg md:text-lg lg:text-xl font-extrabold text-slate-900 font-heading mb-1.5 group-hover:text-amber-600 transition-colors">
                                Need a Repair?</h3>
                            <p
                                class="text-xs md:text-xs lg:text-sm text-slate-600 mb-4 md:mb-4 lg:mb-5 leading-relaxed font-body">
                                Expert diagnosis for screens, batteries, keyboards, charging ports, and OS speedup.</p>

                            <ul
                                class="space-y-2 md:space-y-2 lg:space-y-2.5 text-xs md:text-xs lg:text-sm text-slate-700 mb-5 md:mb-5 lg:mb-6 bg-slate-50/80 p-3 md:p-3.5 lg:p-4 rounded-xl md:rounded-2xl border border-slate-100">
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate"><strong>Transparent</strong> repair quotation</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate">Quality tested replacement parts</span>
                                </li>
                                <li class="flex items-center gap-2">
                                    <span
                                        class="w-4 h-4 rounded-full bg-amber-100 text-amber-700 flex items-center justify-center text-[9px] flex-shrink-0 font-bold"><i
                                            class="fa-solid fa-check"></i></span>
                                    <span class="truncate"><strong>Quick turnaround</strong> times</span>
                                </li>
                            </ul>
                        </div>

                        <a href="repair.html"
                            class="btn-base w-full py-2.5 md:py-2.5 lg:py-3 text-xs md:text-xs lg:text-sm font-bold bg-slate-900 hover:bg-slate-800 text-white shadow-md shadow-slate-900/20 flex items-center justify-center gap-2 group-hover:gap-3 transition-all rounded-xl">
                            <span>Book Repair Service</span> <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                    </div>

                </div>
            </div>
        </section>

        <!-- ==========================================
             ACCESSORIES SECTION (4 Columns Desktop)
             ========================================== -->
        <section class="section-padding bg-white" aria-label="Accessories">
            <div class="container-custom">
                <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Gear & Upgrades</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Computer & Mobile
                            Accessories</h2>
                        <p class="section-subtitle text-xs sm:text-sm">GaN fast chargers, NVMe SSDs, mechanical keyboards,
                            ergonomic stands, and audio.</p>
                    </div>
                    <a href="accessories.html"
                        class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 whitespace-nowrap">
                        View All <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6"
                    id="accessories-grid">
                    <!-- Dynamically populated from PRODUCTS_DATA -->
                </div>
            </div>
        </section>

        <!-- ==========================================
             TRUSTED MANUFACTURERS â€” SHOP BY BRAND (Responsive Grid)
             ========================================== -->
        <section class="section-padding bg-slate-50 border-y border-slate-200" aria-label="Top Brands">
            <div class="container-custom">
                <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Certified Technology
                            Partners</span>
                        <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Shop By Brand</h2>
                        <p class="section-subtitle text-xs sm:text-sm">Browse top laptop and smartphone manufacturers tested
                            across 20 diagnostic points.</p>
                    </div>
                    <a href="shop.html"
                        class="text-xs sm:text-sm font-bold text-blue-600 hover:text-blue-700 inline-flex items-center gap-1 font-body whitespace-nowrap">
                        View All <i class="fa-solid fa-arrow-right text-xs"></i>
                    </a>
                </div>

                <!-- 12 Official Brand Cards Grid (2 Col Mobile / 4 Col Tablet / 6 Col Desktop) -->
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3 sm:gap-4">

                    <!-- 1. Apple -->
                    <a href="shop.html?brand=Apple"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-slate-800 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <svg class="h-8 sm:h-9 w-auto max-w-[85%] fill-current text-slate-900 group-hover:scale-110 transition-transform duration-200"
                                viewBox="0 0 170 170" aria-label="Apple">
                                <path
                                    d="M150.37 130.25c-2.45 5.66-5.35 10.87-8.71 15.66-4.58 6.53-8.33 11.05-11.22 13.56-4.48 4.12-9.28 6.23-14.42 6.35-3.69 0-8.14-1.05-13.32-3.18-5.19-2.12-9.97-3.17-14.34-3.17-4.58 0-9.49 1.05-14.75 3.17-5.26 2.13-9.5 3.24-12.74 3.35-4.35.13-9.16-1.9-14.42-6.08-3.7-3.04-7.65-7.79-11.85-14.24-6.3-9.67-11.23-20.76-14.78-33.28-3.56-12.51-5.34-24.36-5.34-35.53 0-14.65 3.75-26.65 11.25-36 7.5-9.35 16.89-14.15 28.16-14.4 5.25 0 11.08 1.45 17.47 4.35 6.39 2.91 10.37 4.42 11.95 4.54 1.34-.12 5.56-1.69 12.66-4.72 7.1-3.03 13.06-4.44 17.88-4.22 13.8.76 24.58 5.64 32.34 14.65-12.02 7.33-17.9 17.1-17.65 29.31.25 9.75 4.08 17.9 11.5 24.45 7.42 6.55 16.32 10.3 26.7 11.26-2.53 7.85-5.69 15.69-9.48 23.51zM119.22 33.15c0-7.37 2.65-14.17 7.95-20.4 5.3-6.23 11.83-10.23 19.59-12 0 1.25.07 2.47.2 3.65-.13 7.62-2.9 14.65-8.31 21.09-5.41 6.44-12.14 10.15-20.19 11.13-.13-1.12-.24-2.28-.24-3.47z" />
                            </svg>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Apple</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">MacBook
                                & iPhone</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 2. Dell -->
                    <a href="laptops.html?brand=Dell"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-blue-600 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <svg class="h-5 sm:h-6 w-auto max-w-[85%] group-hover:scale-105 transition-transform duration-200"
                                viewBox="0 0 110 32" fill="#0076CE" aria-label="Dell">
                                <path
                                    d="M0 2.4h11.2c8.8 0 15.2 5.3 15.2 13.6s-6.4 13.6-15.2 13.6H0V2.4zm7.8 21.6h3.2c4.7 0 7.6-3.3 7.6-8s-2.9-8-7.6-8H7.8V24zM44.5 19.3l-12.4-4.4 2.6-7.2 13.6 4.8 2-5.6-19.8-7-8.7 24.8 20.3 7.2 2-5.7-14.1-4.9 2.5-7.1 12 4.3zM52.3 2.4h7.9v21.6h12.2v5.6H52.3V2.4zm23 0h7.9v21.6h12.2v5.6H75.3V2.4z" />
                            </svg>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Dell</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">Latitude
                                & Precision</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 3. Lenovo -->
                    <a href="laptops.html?brand=Lenovo"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-red-600 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <div
                                class="bg-[#E2231A] text-white px-2.5 sm:px-3.5 py-1 sm:py-1.5 rounded font-black tracking-tight text-xs sm:text-sm font-sans leading-none shadow-sm group-hover:scale-105 transition-transform duration-200 uppercase">
                                Lenovo
                            </div>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Lenovo</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">ThinkPad
                                & IdeaPad</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 4. HP -->
                    <a href="laptops.html?brand=HP"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-sky-600 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <svg class="h-8 sm:h-10 w-8 sm:w-10 max-w-[85%] group-hover:scale-110 transition-transform duration-200"
                                viewBox="0 0 100 100" aria-label="HP">
                                <circle cx="50" cy="50" r="48" fill="#0096D6" />
                                <g fill="#FFFFFF">
                                    <path d="M37.5 18 L26.5 82 h9.5 L47 24.5 Z" />
                                    <path d="M50 18 L39 82 h9.5 L59.5 24.5 Z" />
                                    <path d="M46 45 h20.5 l-1.8 10.5 H44.2 Z" />
                                    <path d="M64 18 L53 82 h9.5 L73.5 24.5 Z" />
                                </g>
                            </svg>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">HP</span>
                            <span
                                class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">EliteBook
                                & ProBook</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 5. Samsung -->
                    <a href="mobile-phones.html?brand=Samsung"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-blue-800 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center px-1">
                            <svg class="h-4 sm:h-5 w-auto max-w-[90%] group-hover:scale-105 transition-transform duration-200"
                                viewBox="0 0 180 32" fill="#1428A0" aria-label="Samsung">
                                <path
                                    d="M17.5 8.2c-2.3-1.3-4.8-1.9-7.3-1.9-3.8 0-6 1.8-6 4.3 0 2.8 2.8 3.9 6.8 4.9 5.8 1.4 10.9 3.2 10.9 9.3 0 6.6-5.5 10.2-12.7 10.2-3.8 0-7.8-.9-11.2-2.8l2.2-5.4c2.8 1.7 5.8 2.5 8.9 2.5 4.3 0 6.6-1.8 6.6-4.6 0-3.1-2.9-4.2-7.2-5.3C3 18 0 15.8 0 10.6 0 4.6 5-0.1 11.8-0.1c3.5 0 7 .8 9.9 2.3l-4.2 6zM46.7 0h6.6l14.7 34.3h-6.7l-3.3-8.2H42l-3.3 8.2h-6.7L46.7 0zm8.8 20.8l-5.5-13.6-5.5 13.6h11zM72 0h7.3l9.4 17.5L98.1 0h7.3v34.3h-6.1V12.7L90.4 28.5h-3.4L78.1 12.7v21.6H72V0zm40.5 8.2c-2.3-1.3-4.8-1.9-7.3-1.9-3.8 0-6 1.8-6 4.3 0 2.8 2.8 3.9 6.8 4.9 5.8 1.4 10.9 3.2 10.9 9.3 0 6.6-5.5 10.2-12.7 10.2-3.8 0-7.8-.9-11.2-2.8l2.2-5.4c2.8 1.7 5.8 2.5 8.9 2.5 4.3 0 6.6-1.8 6.6-4.6 0-3.1-2.9-4.2-7.2-5.3C99 18 96 15.8 96 10.6c0-6 5-10.7 11.8-10.7 3.5 0 7 .8 9.9 2.3l-5.2 6zm20.8-8.2h6.4v21.6c0 4.8 2.8 7.3 6.9 7.3 4.1 0 6.9-2.5 6.9-7.3V0h6.4v21.3c0 8.7-5.5 13.6-13.3 13.6-7.8 0-13.3-4.9-13.3-13.6V0zm34.2 0h6.4l14.2 20.5V0h6.4v34.3h-6.4L173.9 13.8v20.5h-6.4V0z" />
                            </svg>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Samsung</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">Galaxy S
                                & M Series</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 6. OnePlus -->
                    <a href="mobile-phones.html?brand=OnePlus"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-red-600 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <div class="flex items-center gap-1.5 group-hover:scale-105 transition-transform duration-200">
                                <div
                                    class="w-6 sm:w-7 h-6 sm:h-7 bg-[#EB0028] text-white rounded-md flex items-center justify-center font-bold text-xs shadow-sm relative">
                                    <span class="font-black text-xs">1</span>
                                    <span class="absolute top-0.5 right-0.5 text-[8px] font-black leading-none">+</span>
                                </div>
                                <span
                                    class="font-black text-[11px] sm:text-xs tracking-wider text-slate-900 font-sans">ONEPLUS</span>
                            </div>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">OnePlus</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">Flagship
                                & Nord 5G</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 7. Google Pixel -->
                    <a href="mobile-phones.html?brand=Google"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-blue-500 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <svg class="h-8 sm:h-9 w-8 sm:w-9 max-w-[85%] group-hover:scale-110 transition-transform duration-200"
                                viewBox="0 0 48 48" aria-label="Google">
                                <path fill="#EA4335"
                                    d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z" />
                                <path fill="#4285F4"
                                    d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z" />
                                <path fill="#FBBC05"
                                    d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z" />
                                <path fill="#34A853"
                                    d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z" />
                            </svg>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Google
                                Pixel</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">Tensor
                                AI Cameras</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 8. Asus -->
                    <a href="laptops.html?brand=Asus"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-blue-600 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center px-1">
                            <svg class="h-4 sm:h-5 w-auto max-w-[90%] group-hover:scale-105 transition-transform duration-200"
                                viewBox="0 0 140 28" fill="#00539B" aria-label="Asus">
                                <path
                                    d="M13.2 0L0 27.5h7.8l2.9-6.3h14.5l2.9 6.3h8L22.9 0h-9.7zm3.1 6.5l5.1 10.5h-10.2L16.3 6.5zM43.7 7.7c-2.3-1.1-4.8-1.7-7.4-1.7-4 0-6.4 1.8-6.4 4.4 0 3 3.1 4.1 7.2 5.2 6.1 1.5 11.5 3.4 11.5 9.9 0 7-5.9 10.8-13.5 10.8-4 0-8.3-1-11.9-3l2.3-5.7c3 1.8 6.2 2.7 9.5 2.7 4.6 0 7-1.9 7-4.9 0-3.3-3.1-4.5-7.7-5.6C28.4 18.7 25 16.3 25 10.8c0-6.4 5.3-11.4 12.5-11.4 3.7 0 7.4.9 10.5 2.5l-4.3 5.8zm27.4-7.7h7.2v17.2c0 3.8 2.2 5.8 5.5 5.8 3.3 0 5.5-2 5.5-5.8V0h7.2v17c0 7.5-4.4 11.6-12.7 11.6-8.3 0-12.7-4.1-12.7-11.6V0zm34.8 7.7c-2.3-1.1-4.8-1.7-7.4-1.7-4 0-6.4 1.8-6.4 4.4 0 3 3.1 4.1 7.2 5.2 6.1 1.5 11.5 3.4 11.5 9.9 0 7-5.9 10.8-13.5 10.8-4 0-8.3-1-11.9-3l2.3-5.7c3 1.8 6.2 2.7 9.5 2.7 4.6 0 7-1.9 7-4.9 0-3.3-3.1-4.5-7.7-5.6-5.8-1.5-9.2-3.9-9.2-9.4 0-6.4 5.3-11.4 12.5-11.4 3.7 0 7.4.9 10.5 2.5l-4.3 5.8z" />
                            </svg>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Asus</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">TUF &
                                ROG Gaming</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 9. Xiaomi -->
                    <a href="mobile-phones.html?brand=Xiaomi"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-orange-500 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <div
                                class="w-9 sm:w-10 h-9 sm:h-10 bg-[#FF6900] text-white rounded-xl sm:rounded-2xl flex items-center justify-center font-bold text-base sm:text-lg shadow-sm group-hover:scale-110 transition-transform duration-200 font-sans">
                                <span class="font-extrabold tracking-tighter">mi</span>
                            </div>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Xiaomi</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">Redmi &
                                Pro 5G</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 10. Realme -->
                    <a href="mobile-phones.html?brand=Realme"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-amber-500 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <span
                                class="text-xl sm:text-2xl font-black text-[#F5B50A] tracking-tight group-hover:scale-110 transition-transform duration-200 font-sans">realme</span>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Realme</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">Narzo &
                                GT Series</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 11. Acer -->
                    <a href="laptops.html?brand=Acer"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-lime-600 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center px-1">
                            <svg class="h-5 sm:h-6 w-auto max-w-[90%] group-hover:scale-105 transition-transform duration-200"
                                viewBox="0 0 110 30" fill="#83B81A" aria-label="Acer">
                                <path
                                    d="M14.5 7.5C7.2 7.5 1.5 12.7 1.5 19.5c0 6.8 5.7 12 13 12 4.6 0 8.5-2.2 10.7-5.5l-4.6-2.8c-1.4 2-3.6 3.3-6.1 3.3-4.2 0-7.3-2.9-7.7-6.9h20.6c.1-.7.1-1.3.1-2 0-6.1-4.5-10.1-13-10.1zm-7.7 9.5c.5-3.8 3.5-6.5 7.7-6.5 4.2 0 7.2 2.7 7.7 6.5H6.8zm33.8-9.5c-7.3 0-13 5.3-13 12.2 0 6.9 5.7 12.2 13 12.2 5.5 0 10.1-3 12-7.5l-4.8-2.3c-1.2 2.8-4 4.5-7.2 4.5-4.4 0-7.7-3.1-7.7-6.9s3.3-6.9 7.7-6.9c3.2 0 6 1.7 7.2 4.5l4.8-2.3c-1.9-4.5-6.5-7.5-12-7.5zm27.4 0c-7.2 0-13 5.2-13 12 0 6.8 5.7 12 13 12 4.6 0 8.5-2.2 10.7-5.5l-4.6-2.8c-1.4 2-3.6 3.3-6.1 3.3-4.2 0-7.3-2.9-7.7-6.9h20.6c.1-.7.1-1.3.1-2 0-6.1-4.5-10.1-13-10.1zm-7.7 9.5c.5-3.8 3.5-6.5 7.7-6.5 4.2 0 7.2 2.7 7.7 6.5H60.3zm31.2-9h-5.2v23.4h5.5v-11.2c0-4.5 3.3-7.2 7.7-7.2.7 0 1.5.1 2.2.3V7.8c-.8-.2-1.7-.3-2.5-.3-3.6 0-6.4 1.8-7.7 4.8V8z" />
                            </svg>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Acer</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">Aspire &
                                Nitro</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                    <!-- 12. Microsoft -->
                    <a href="laptops.html?brand=Microsoft"
                        class="card-base p-3.5 sm:p-4 lg:p-5 flex flex-col items-center justify-between text-center group hover:border-sky-500 transition-all text-decoration-none min-h-[140px] sm:min-h-[150px] lg:min-h-[160px] bg-white rounded-xl sm:rounded-2xl border border-slate-200 hover:shadow-md">
                        <div class="h-12 sm:h-14 flex items-center justify-center">
                            <div class="flex items-center gap-2 group-hover:scale-105 transition-transform duration-200">
                                <div class="grid grid-cols-2 gap-0.5 w-5 sm:w-6 h-5 sm:h-6">
                                    <div class="bg-[#F25022] rounded-[1px]"></div>
                                    <div class="bg-[#7FBA00] rounded-[1px]"></div>
                                    <div class="bg-[#00A4EF] rounded-[1px]"></div>
                                    <div class="bg-[#FFB900] rounded-[1px]"></div>
                                </div>
                                <span
                                    class="font-bold text-[11px] sm:text-xs text-slate-900 font-sans tracking-tight">Microsoft</span>
                            </div>
                        </div>
                        <div class="mt-1">
                            <span
                                class="font-extrabold text-xs sm:text-sm text-slate-900 block group-hover:text-blue-600 transition-colors font-heading">Microsoft</span>
                            <span class="text-[10px] sm:text-[11px] text-slate-500 font-body block mt-0.5 truncate">Surface
                                Pro & Studio</span>
                        </div>
                        <span
                            class="text-[10px] font-bold text-blue-600 mt-1 opacity-0 group-hover:opacity-100 transition-opacity font-body">Explore
                            Series â†’</span>
                    </a>

                </div>
            </div>
        </section>

        <!-- ==========================================
             HOW WE REFURBISH (6-Step Timeline Responsive)
             ========================================== -->
        <section class="section-padding bg-white" aria-label="Refurbishment Process" id="how-we-refurbish">
            <div class="container-custom">
                <div class="text-center max-w-2xl mx-auto mb-8 sm:mb-12">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Quality Control Protocol</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">How We Refurbish</h2>
                    <p class="section-subtitle text-xs sm:text-sm">Every device undergoes our strict 6-stage engineering and
                        testing cycle.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-3 lg:grid-cols-6 gap-3 sm:gap-4">
                    <div
                        class="p-3.5 sm:p-5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 relative text-center flex flex-col items-center justify-start">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-blue-600 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 sm:mb-3">
                            1</div>
                        <h4 class="text-[11px] sm:text-xs font-bold text-slate-900 uppercase mb-1">Device Sourced</h4>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 leading-snug">Corporate off-lease or open box
                            origin check.</p>
                    </div>

                    <div
                        class="p-3.5 sm:p-5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 relative text-center flex flex-col items-center justify-start">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-blue-600 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 sm:mb-3">
                            2</div>
                        <h4 class="text-[11px] sm:text-xs font-bold text-slate-900 uppercase mb-1">Inspection</h4>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 leading-snug">Physical body, hinges, keyboard,
                            port grading.</p>
                    </div>

                    <div
                        class="p-3.5 sm:p-5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 relative text-center flex flex-col items-center justify-start">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-blue-600 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 sm:mb-3">
                            3</div>
                        <h4 class="text-[11px] sm:text-xs font-bold text-slate-900 uppercase mb-1">Hardware Test</h4>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 leading-snug">20-Point Motherboard, RAM, SSD &
                            battery stress test.</p>
                    </div>

                    <div
                        class="p-3.5 sm:p-5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 relative text-center flex flex-col items-center justify-start">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-blue-600 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 sm:mb-3">
                            4</div>
                        <h4 class="text-[11px] sm:text-xs font-bold text-slate-900 uppercase mb-1">Thermal Clean</h4>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 leading-snug">Fan dust clearing & thermal paste
                            re-application.</p>
                    </div>

                    <div
                        class="p-3.5 sm:p-5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 relative text-center flex flex-col items-center justify-start">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-blue-600 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 sm:mb-3">
                            5</div>
                        <h4 class="text-[11px] sm:text-xs font-bold text-slate-900 uppercase mb-1">QC & Software</h4>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 leading-snug">Clean OS installation & genuine
                            driver testing.</p>
                    </div>

                    <div
                        class="p-3.5 sm:p-5 rounded-xl sm:rounded-2xl bg-slate-50 border border-slate-200 relative text-center flex flex-col items-center justify-start">
                        <div
                            class="w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-emerald-600 text-white font-extrabold text-xs flex items-center justify-center mx-auto mb-2.5 sm:mb-3">
                            6</div>
                        <h4 class="text-[11px] sm:text-xs font-bold text-slate-900 uppercase mb-1">Dispatched</h4>
                        <p class="text-[10px] sm:text-[11px] text-slate-500 leading-snug">Multi-layer bubble pack with
                            charger & warranty.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             WHY VANSH IT & COMM (Responsive Grid)
             ========================================== -->
        <section class="section-padding bg-slate-50" aria-label="Why Choose Us">
            <div class="container-custom">
                <div class="text-center max-w-xl mx-auto mb-8 sm:mb-12">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">The Standard We Set</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Why VANSH IT & COMM</h2>
                    <p class="section-subtitle text-xs sm:text-sm">Transparent condition, genuine components, and honest
                        customer support.</p>
                </div>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 lg:gap-6">
                    <div class="card-base p-4 sm:p-5">
                        <i class="fa-solid fa-shield-virus text-blue-600 text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">20+ Point Tested</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500">Full diagnostic hardware evaluation.</p>
                    </div>

                    <div class="card-base p-4 sm:p-5">
                        <i class="fa-solid fa-file-invoice text-emerald-600 text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">GST Tax Invoice</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500">Claim 18% input credit for businesses.</p>
                    </div>

                    <div class="card-base p-4 sm:p-5">
                        <i class="fa-solid fa-award text-purple-600 text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Warranty Included</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500">Warranty as specified on product.</p>
                    </div>

                    <div class="card-base p-4 sm:p-5">
                        <i class="fa-solid fa-battery-three-quarters text-amber-600 text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Battery Health Check</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500">85%+ retention certified backup.</p>
                    </div>

                    <div class="card-base p-4 sm:p-5">
                        <i class="fa-solid fa-truck-shield text-sky-600 text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Secure Delivery</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500">Insured logistics with tracking.</p>
                    </div>

                    <div class="card-base p-4 sm:p-5">
                        <i class="fa-solid fa-headset text-rose-600 text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Expert Support</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500">Direct technical help when needed.</p>
                    </div>

                    <div class="card-base p-4 sm:p-5">
                        <i class="fa-solid fa-magnifying-glass-chart text-teal-600 text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Transparent Grading</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500">Actual device photos upon request.</p>
                    </div>

                    <div class="card-base p-4 sm:p-5">
                        <i class="fa-solid fa-hand-holding-dollar text-indigo-600 text-xl sm:text-2xl mb-2.5 sm:mb-3"></i>
                        <h4 class="text-xs sm:text-sm font-bold text-slate-900 mb-1">Value Pricing</h4>
                        <p class="text-[11px] sm:text-xs text-slate-500">Up to 70% lower than brand new MRP.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             REPAIR CTA SECTION (Responsive Grid)
             ========================================== -->
        <section class="py-12 sm:py-16 bg-slate-950 text-white relative overflow-hidden" aria-label="Repair Call to Action">
            <div class="container-custom">
                <div class="grid grid-cols-12 gap-6 sm:gap-8 items-center">
                    <div class="col-span-12 md:col-span-7 space-y-4">
                        <span
                            class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1">PROFESSIONAL
                            WORKSHOP</span>
                        <h2
                            class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-white tracking-tight leading-tight font-heading">
                            Need a Laptop or Mobile Repair?
                        </h2>
                        <p class="text-xs sm:text-sm text-slate-300 font-body leading-relaxed max-w-xl">
                            From screen replacements to charging issues, get professional device support. Tell us what went
                            wrong and our team can help identify the right solution.
                        </p>
                        <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-2">
                            <a href="repair.html"
                                class="btn-base btn-primary px-5 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold shadow-lg shadow-blue-600/30">
                                <i class="fa-solid fa-wrench"></i> Book a Repair
                            </a>
                            <a href="contact.html"
                                class="btn-base btn-secondary bg-white/10 text-white border-white/20 px-5 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold hover:bg-white/20">
                                <i class="fa-solid fa-comments"></i> Talk to Technician
                            </a>
                        </div>
                    </div>

                    <div class="col-span-12 md:col-span-5 mt-4 md:mt-0">
                        <div class="bg-slate-900 border border-slate-800 rounded-2xl p-5 sm:p-6 space-y-3">
                            <h4 class="text-xs sm:text-sm font-bold text-white uppercase tracking-wider mb-2 font-heading">
                                Common Fast Fixes</h4>
                            <div
                                class="flex items-center justify-between text-xs py-2 border-b border-slate-800 text-slate-300">
                                <span><i class="fa-solid fa-display text-blue-400 mr-2"></i> Laptop / Mobile Screen
                                    Replacement</span>
                                <span class="text-emerald-400 font-bold">Same Day Available</span>
                            </div>
                            <div
                                class="flex items-center justify-between text-xs py-2 border-b border-slate-800 text-slate-300">
                                <span><i class="fa-solid fa-battery-half text-amber-400 mr-2"></i> OEM Battery
                                    Replacement</span>
                                <span class="text-slate-400">Tested Capacity</span>
                            </div>
                            <div class="flex items-center justify-between text-xs py-2 text-slate-300">
                                <span><i class="fa-solid fa-bolt text-purple-400 mr-2"></i> SSD / RAM Upgrade & Speed
                                    Boost</span>
                                <span class="text-blue-400 font-bold">In 30 Minutes</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             DEVICE EXCHANGE / UPGRADE CTA (Responsive)
             ========================================== -->
        <section class="section-padding bg-slate-50" aria-label="Trade In and Upgrade">
            <div class="container-custom">
                <div class="bg-white border border-slate-200 rounded-2xl sm:rounded-3xl p-6 sm:p-8 lg:p-12 shadow-sm">
                    <div class="grid grid-cols-12 gap-6 sm:gap-8 items-center">
                        <div class="col-span-12 md:col-span-8 space-y-3">
                            <span
                                class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-3 py-1">UPGRADE
                                PROGRAM</span>
                            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                                Your Old Device. Your Next Upgrade.
                            </h2>
                            <p class="text-xs sm:text-sm text-slate-600 max-w-xl font-body">
                                Trade in your working or used laptop and smartphone to get instant credit towards any
                                refurbished or new product.
                            </p>
                        </div>
                        <div class="col-span-12 md:col-span-4 flex md:justify-end">
                            <a href="exchange.html"
                                class="btn-base btn-success px-5 sm:px-6 py-2.5 sm:py-3 text-xs sm:text-sm font-semibold shadow-md whitespace-nowrap">
                                <i class="fa-solid fa-calculator mr-2"></i> Calculate Trade-In Value
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ==========================================
             STORE LOCATIONS (4-Card Responsive Grid)
             ========================================== -->
        <section class="py-10 sm:py-12 bg-white" aria-label="Store Locations">
            <div class="container-custom">
                <div class="flex flex-row items-end justify-between mb-6 sm:mb-8">
                    <div>
                        <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Physical Hub &
                            Logistics</span>
                        <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900 font-heading">Store Locations & Hubs
                        </h2>
                        <p class="section-subtitle text-xs sm:text-sm">Visit our experience store, service workshop, or
                            track express dispatch centers.</p>
                    </div>
                    <a href="contact.html" class="text-xs font-bold text-blue-600 hover:underline whitespace-nowrap">
                        View All Details â†’
                    </a>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">

                    <!-- Card 1: Main Experience Store -->
                    <div
                        class="card-base p-5 sm:p-6 flex flex-col justify-between bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-blue-500 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg shadow-sm">
                                    <i class="fa-solid fa-store"></i>
                                </div>
                                <span
                                    class="badge bg-blue-50 text-blue-700 border border-blue-200 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full">Retail
                                    Store</span>
                            </div>
                            <h4 class="text-base font-bold text-slate-900 mb-1 font-heading">Main Experience Store</h4>
                            <p class="text-xs text-slate-500 mb-4 font-body">[Store location will be updated here.]</p>
                            <div class="text-xs text-slate-600 space-y-1.5 mb-5 font-body">
                                <div class="flex items-center gap-2"><i
                                        class="fa-regular fa-clock text-slate-400 w-3.5"></i> <span>Mon â€“ Sat: 10:00 AM
                                        â€“ 8:30 PM</span></div>
                                <div class="flex items-center gap-2"><i class="fa-solid fa-phone text-slate-400 w-3.5"></i>
                                    <span>[Add business phone number]</span>
                                </div>
                            </div>
                        </div>
                        <a href="contact.html"
                            class="btn-base btn-secondary btn-sm w-full text-xs font-semibold py-2">Contact Store</a>
                    </div>

                    <!-- Card 2: Repair & Service Center -->
                    <div
                        class="card-base p-5 sm:p-6 flex flex-col justify-between bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-emerald-500 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg shadow-sm">
                                    <i class="fa-solid fa-screwdriver-wrench"></i>
                                </div>
                                <span
                                    class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full">Fast
                                    Repair</span>
                            </div>
                            <h4 class="text-base font-bold text-slate-900 mb-1 font-heading">Repair & Service Center</h4>
                            <p class="text-xs text-slate-500 mb-4 font-body">[Service center address coming soon.]</p>
                            <div class="text-xs text-slate-600 space-y-1.5 mb-5 font-body">
                                <div class="flex items-center gap-2"><i
                                        class="fa-regular fa-clock text-slate-400 w-3.5"></i> <span>Mon â€“ Sat: 10:30 AM
                                        â€“ 7:30 PM</span></div>
                                <div class="flex items-center gap-2"><i
                                        class="fa-solid fa-headset text-slate-400 w-3.5"></i> <span>Technician Support
                                        Available</span></div>
                            </div>
                        </div>
                        <a href="repair.html" class="btn-base btn-secondary btn-sm w-full text-xs font-semibold py-2">Book
                            Service</a>
                    </div>

                    <!-- Card 3: Online Hub & Warehouse -->
                    <div
                        class="card-base p-5 sm:p-6 flex flex-col justify-between bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-purple-500 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg shadow-sm">
                                    <i class="fa-solid fa-warehouse"></i>
                                </div>
                                <span
                                    class="badge bg-purple-50 text-purple-700 border border-purple-200 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full">QA
                                    Hub</span>
                            </div>
                            <h4 class="text-base font-bold text-slate-900 mb-1 font-heading">Online Hub & Warehouse</h4>
                            <p class="text-xs text-slate-500 mb-4 font-body">Direct dispatches across India with 24-hr QA.
                            </p>
                            <div class="text-xs text-slate-600 space-y-1.5 mb-5 font-body">
                                <div class="flex items-center gap-2"><i
                                        class="fa-solid fa-truck-fast text-slate-400 w-3.5"></i> <span>Same-Day Dispatch
                                        Available</span></div>
                                <div class="flex items-center gap-2"><i
                                        class="fa-solid fa-shield-halved text-slate-400 w-3.5"></i> <span>100% Insured
                                        Shipping</span></div>
                            </div>
                        </div>
                        <a href="shop.html" class="btn-base btn-secondary btn-sm w-full text-xs font-semibold py-2">Browse
                            Inventory</a>
                    </div>

                    <!-- Card 4: Pan India Dispatch Hub -->
                    <div
                        class="card-base p-5 sm:p-6 flex flex-col justify-between bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md hover:border-indigo-500 transition-all">
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <div
                                    class="w-10 h-10 rounded-xl bg-sky-50 text-sky-600 flex items-center justify-center text-lg shadow-sm">
                                    <i class="fa-solid fa-truck-fast"></i>
                                </div>
                                <span
                                    class="badge bg-sky-50 text-sky-700 border border-sky-200 text-[10px] font-bold uppercase px-2 py-0.5 rounded-full">Pan-India</span>
                            </div>
                            <h4 class="text-base font-bold text-slate-900 mb-1 font-heading">Pan India Dispatch Hub</h4>
                            <p class="text-xs text-slate-500 mb-4 font-body">Express Courier Packing & Dispatch Unit.</p>
                            <div class="text-xs text-slate-600 space-y-1.5 mb-5 font-body">
                                <div class="flex items-center gap-2"><i class="fa-solid fa-box text-slate-400 w-3.5"></i>
                                    <span>19,000+ Pincodes Covered</span>
                                </div>
                                <div class="flex items-center gap-2"><i
                                        class="fa-solid fa-shield-halved text-slate-400 w-3.5"></i> <span>Insured Transit
                                        Packaging</span></div>
                            </div>
                        </div>
                        <a href="track-order.html"
                            class="btn-base btn-secondary btn-sm w-full text-xs font-semibold py-2">Track Dispatch</a>
                    </div>

                </div>
            </div>
        </section>

        <!-- ==========================================
             CUSTOMER REVIEWS (4 Columns Desktop)
             ========================================== -->
        <section class="section-padding bg-slate-50 border-t border-slate-200" aria-label="Customer Testimonials">
            <div class="container-custom">
                <div class="text-center max-w-xl mx-auto mb-10">
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-500/10 border border-blue-200 text-blue-700 text-xs font-bold uppercase tracking-wider mb-2">
                        <i class="fa-solid fa-star text-amber-400"></i> Trusted by Buyers
                    </span>
                    <h2 class="text-3xl font-extrabold text-slate-900 font-heading">Customer Reviews</h2>
                    <p class="text-xs text-slate-500 font-body">Sample feedback from verified customers across India.</p>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-5" id="reviews-container">
                    <!-- Dynamically populated from REVIEWS_DATA -->
                </div>
            </div>
        </section>

        <!-- ==========================================
             FREQUENTLY ASKED QUESTIONS (FAQ Desktop)
             ========================================== -->
        <section class="section-padding bg-white" aria-label="FAQs">
            <div class="container-custom max-w-4xl">
                <div class="text-center mb-10">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Got Questions?</span>
                    <h2 class="text-3xl font-extrabold text-slate-900 font-heading">Frequently Asked Questions</h2>
                    <p class="section-subtitle">Clear information regarding testing, warranty, returns, and repairs.</p>
                </div>

                <div class="space-y-3" id="faq-accordion-container">
                    <!-- Dynamically populated from FAQS_DATA -->
                </div>
            </div>
        </section>

        <!-- ==========================================
             FINAL CTA SECTION (Desktop)
             ========================================== -->
        <section class="py-16 bg-gradient-to-br from-slate-900 via-slate-950 to-blue-950 text-white text-center"
            aria-label="Final Call to Action">
            <div class="container-custom max-w-3xl space-y-4">
                <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1">BUY SMART.
                    UPGRADE BETTER.</span>
                <h2 class="text-4xl font-extrabold text-white tracking-tight font-heading">
                    READY TO UPGRADE?
                </h2>
                <p class="text-base text-slate-300 font-body leading-relaxed">
                    Find the right device, get expert help, or give your current device a second life with VANSH IT & COMM.
                </p>
                <div class="flex flex-wrap items-center justify-center gap-3 pt-4">
                    <a href="laptops.html"
                        class="btn-base btn-primary px-6 py-3 font-semibold shadow-lg shadow-blue-600/30">
                        Explore Laptops
                    </a>
                    <a href="mobile-phones.html"
                        class="btn-base btn-secondary bg-white/10 text-white border-white/20 px-6 py-3 font-semibold hover:bg-white/20">
                        Explore Mobiles
                    </a>
                    <a href="repair.html"
                        class="btn-base btn-dark bg-slate-800 text-white border border-slate-700 px-6 py-3 font-semibold hover:bg-slate-700">
                        Book a Repair
                    </a>
                </div>
            </div>
        </section>

    </main>


@endsection

@push('scripts')

    <script>
        // Initialize Homepage Content & Slider
        document.addEventListener('DOMContentLoaded', () => {
            // Render Header & Footer
            Components.renderHeader('home');
            Components.renderFooter();

            // Render Featured Laptops (first 4 laptops)
            const laptops = PRODUCTS_DATA.filter(p => p.category === 'laptops').slice(0, 4);
            ProductsEngine.renderProductsGrid('featured-laptops-grid', laptops);

            // Render Featured Mobiles (first 4 mobiles)
            const mobiles = PRODUCTS_DATA.filter(p => p.category === 'mobile-phones').slice(0, 4);
            ProductsEngine.renderProductsGrid('featured-mobiles-grid', mobiles);

            // Render Accessories (first 4 accessories)
            const accessories = PRODUCTS_DATA.filter(p => p.category === 'accessories').slice(0, 4);
            ProductsEngine.renderProductsGrid('accessories-grid', accessories);

            // Render Reviews
            const revContainer = document.getElementById('reviews-container');
            if (revContainer) {
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
                    <span class="text-[10px] text-slate-400 block truncate font-body">${r.city} â€¢ ${r.product}</span>
                  </div>
                  <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-[9px] font-extrabold flex-shrink-0 whitespace-nowrap px-2 py-0.5 rounded-md inline-flex items-center gap-1 uppercase tracking-wider">
                    <i class="fa-solid fa-circle-check text-emerald-600"></i> ${r.badge}
                  </span>
                </div>
              </div>
            `).join('');
            }

            // Render FAQs
            const faqContainer = document.getElementById('faq-accordion-container');
            if (faqContainer) {
                faqContainer.innerHTML = FAQS_DATA.slice(0, 6).map((f, idx) => `
              <div class="border border-slate-200 rounded-xl overflow-hidden">
                <button 
                  type="button" 
                  onclick="toggleFaq(${idx})" 
                  class="w-full flex items-center justify-between p-4 bg-slate-50 hover:bg-slate-100/80 text-left font-bold text-slate-900 text-sm transition-colors"
                >
                  <span>${f.question}</span>
                  <i class="fa-solid fa-chevron-down text-xs text-slate-400 transition-transform" id="faq-icon-${idx}"></i>
                </button>
                <div id="faq-ans-${idx}" class="hidden p-4 bg-white text-xs text-slate-600 border-t border-slate-100 leading-relaxed font-body">
                  ${f.answer}
                </div>
              </div>
            `).join('');
            }

            // Start Hero Slider Autoplay
            startHeroSlider();
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
                changeHeroSlide(1);
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