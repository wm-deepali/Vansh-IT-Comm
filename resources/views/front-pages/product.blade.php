@extends('layouts.app')

@section('title', 'Product Details | VANSH IT & COMM')
@section('meta_description', 'View specifications, condition details, warranty, and pricing for tested technology products at VANSH IT & COMM.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6 flex-wrap" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('shop') }}" class="hover:text-blue-600" id="prod-bread-cat">Shop</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold truncate max-w-xs sm:max-w-md" id="prod-bread-title">Loading product...</span>
      </nav>

      <!-- Main Product View -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-12 mb-12 sm:mb-16 items-start">

        <!-- Left: Image Gallery & Video Request -->
        <div class="lg:col-span-6 space-y-3 sm:space-y-4">
          <div class="relative bg-white border border-slate-200 rounded-2xl sm:rounded-3xl p-4 sm:p-6 shadow-sm overflow-hidden flex items-center justify-center min-h-[260px] sm:min-h-[380px] lg:min-h-[420px]">
            <img
              id="main-product-image"
              src=""
              alt="Product"
              class="max-h-[240px] sm:max-h-[340px] lg:max-h-[380px] max-w-full object-contain transition-all duration-300 hover:scale-105 cursor-zoom-in"
              onclick="openImageLightbox()"
            />

            <div class="absolute top-3 sm:top-4 left-3 sm:left-4 z-10">
              <span id="prod-badge" class="badge badge-refurbished text-[10px] sm:text-xs px-2.5 sm:px-3 py-0.5 sm:py-1 font-bold">REFURBISHED</span>
            </div>

            <button
              type="button"
              id="prod-detail-wishlist-btn"
              class="heart-btn absolute top-3 sm:top-4 right-3 sm:right-4 z-10 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-slate-50/90 border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-white hover:text-red-500 shadow-sm transition-all"
              aria-label="Add to Wishlist"
            >
              <i class="fa-regular fa-heart text-sm sm:text-base"></i>
            </button>
          </div>

          <!-- Thumbnails -->
          <div class="flex items-center gap-2 sm:gap-3 overflow-x-auto no-scrollbar pb-1" id="prod-thumbnails-container"></div>

          <!-- Actual Product Photos & Video Block -->
          <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 p-3.5 sm:p-5 rounded-2xl text-white flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4 shadow-sm text-center sm:text-left">
            <div>
              <div class="flex items-center justify-center sm:justify-start gap-1.5 text-[10px] sm:text-xs font-bold text-blue-400 uppercase tracking-wider mb-0.5">
                <i class="fa-solid fa-camera-retro"></i> Actual Product Transparency
              </div>
              <h4 class="font-bold text-xs sm:text-sm text-white">Want to see live photos & video of this unit?</h4>
              <p class="text-[11px] sm:text-xs text-slate-300">Request actual unit serial number inspection before dispatch.</p>
            </div>
            <button
              type="button"
              onclick="openVideoCallDrawer()"
              class="btn-base btn-primary text-xs px-3.5 sm:px-4 py-2 font-semibold flex-shrink-0 w-full sm:w-auto text-center justify-center shadow-md"
            >
              <i class="fa-solid fa-video mr-1.5"></i> Video Call Demo
            </button>
          </div>
        </div>

        <!-- Right: Details, Pricing, Pincode Checker, Actions -->
        <div class="lg:col-span-6 sticky top-28 space-y-3.5 sm:space-y-4">
          <div class="space-y-3.5 sm:space-y-4">
            <!-- Brand & SKU -->
            <div class="flex items-center justify-between text-xs text-slate-500">
              <span class="font-bold text-blue-600 uppercase tracking-wider" id="prod-brand">DELL</span>
              <span id="prod-sku">SKU: VIC-LAP-01</span>
            </div>

            <!-- Title -->
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-slate-900 font-heading leading-tight" id="prod-name">
              Dell Latitude 5420 Business Laptop
            </h1>

            <!-- Ratings & Condition -->
            <div class="flex items-center gap-2 sm:gap-3 text-xs flex-wrap">
              <div id="prod-stars" class="flex items-center"></div>
              <span class="text-slate-300">•</span>
              <span class="text-slate-600 font-medium text-[11px] sm:text-xs" id="prod-reviews-count">142 reviews</span>
              <span class="text-slate-300">•</span>
              <span class="badge bg-emerald-50 text-emerald-700 font-bold text-[10px] sm:text-xs px-2 py-0.5"><i class="fa-solid fa-circle-check"></i> 20-Point QC</span>
            </div>

            <!-- Price Block -->
            <div class="p-3.5 sm:p-4 bg-slate-50 rounded-2xl border border-slate-200">
              <div class="flex items-baseline gap-2.5 sm:gap-3 flex-wrap">
                <span class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 font-body" id="prod-price">₹32,499</span>
                <span class="text-sm sm:text-base text-slate-400 line-through font-medium" id="prod-mrp">₹89,999</span>
                <span class="text-[10px] sm:text-xs font-extrabold text-emerald-700 bg-emerald-100 px-2 py-0.5 rounded-md" id="prod-discount">64% OFF</span>
              </div>
              <p class="text-[11px] sm:text-xs text-slate-500 mt-1">Inclusive of all taxes + 100% GST Input Invoice.</p>

              <div class="mt-2.5 pt-2.5 border-t border-slate-200/80 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-1 sm:gap-0 text-[11px] sm:text-xs text-slate-700">
                <span class="flex items-center gap-1.5"><i class="fa-solid fa-credit-card text-blue-600"></i> No Cost EMI from <strong>₹2,708/mo</strong></span>
                <span class="text-emerald-600 font-semibold flex items-center gap-1"><i class="fa-solid fa-truck text-emerald-600"></i> Free Delivery</span>
              </div>
            </div>

            <!-- Key Specs Quick Table -->
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 gap-2 sm:gap-2.5 bg-white p-3 sm:p-4 rounded-2xl border border-slate-200 shadow-sm" id="prod-key-specs"></div>

            <!-- Pincode Delivery Checker -->
            <div class="p-3 sm:p-3.5 bg-slate-50 rounded-xl border border-slate-200">
              <label for="pincode-input" class="block text-xs font-bold text-slate-700 mb-1.5 flex items-center gap-1.5">
                <i class="fa-solid fa-location-dot text-blue-600"></i> Check Delivery & COD Availability
              </label>
              <div class="flex items-center gap-2">
                <input
                  type="text"
                  id="pincode-input"
                  maxlength="6"
                  placeholder="Enter 6-digit PIN code (e.g. 110001)"
                  class="flex-1 bg-white border border-slate-200 rounded-xl px-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-blue-600"
                />
                <button type="button" onclick="checkPincode()" class="btn-base btn-secondary btn-sm text-xs font-semibold py-2 px-3">
                  Check
                </button>
              </div>
              <div id="pincode-status" class="text-xs mt-2 hidden"></div>
            </div>

            <!-- CTA Buttons -->
            <div class="space-y-2 pt-1 sm:pt-2">
              <div class="grid grid-cols-2 gap-2 sm:gap-3">
                <button
                  type="button"
                  id="prod-add-cart-btn"
                  class="btn-base btn-secondary py-2.5 sm:py-3.5 text-xs sm:text-sm font-semibold w-full justify-center shadow-sm"
                >
                  <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                </button>
                <button
                  type="button"
                  id="prod-buy-now-btn"
                  class="btn-base btn-primary py-2.5 sm:py-3.5 text-xs sm:text-sm font-semibold w-full justify-center shadow-lg shadow-blue-600/30"
                >
                  <i class="fa-solid fa-bolt"></i> Buy Now
                </button>
              </div>

              <button
                type="button"
                onclick="openVideoCallDrawer()"
                class="btn-base w-full bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-700 hover:from-blue-700 hover:to-indigo-800 text-white font-bold py-2.5 sm:py-3.5 px-3 sm:px-4 rounded-xl sm:rounded-2xl shadow-lg shadow-blue-600/25 flex items-center justify-center gap-2 transition-all transform hover:-translate-y-0.5 active:translate-y-0 text-xs sm:text-sm"
              >
                <i class="fa-solid fa-video text-amber-300 animate-pulse text-sm sm:text-base"></i>
                <span>View Product Through Video Call</span>
                <span class="bg-white/20 text-white text-[9px] sm:text-[10px] uppercase font-extrabold px-1.5 sm:px-2 py-0.5 rounded-full ml-1 border border-white/20">Live QC</span>
              </button>
            </div>

            <!-- Trust Bar -->
            <div class="grid grid-cols-3 gap-1.5 sm:gap-2 text-center pt-1 text-[10px] sm:text-[11px] text-slate-600">
              <div class="p-1.5 sm:p-2 rounded-xl bg-white border border-slate-100 shadow-2xs">
                <i class="fa-solid fa-shield-halved text-blue-600 text-xs sm:text-sm mb-0.5 sm:mb-1 block"></i>
                <span>Warranty Backed</span>
              </div>
              <div class="p-1.5 sm:p-2 rounded-xl bg-white border border-slate-100 shadow-2xs">
                <i class="fa-solid fa-arrow-rotate-left text-emerald-600 text-xs sm:text-sm mb-0.5 sm:mb-1 block"></i>
                <span>7-Day Returns</span>
              </div>
              <div class="p-1.5 sm:p-2 rounded-xl bg-white border border-slate-100 shadow-2xs">
                <i class="fa-solid fa-box text-purple-600 text-xs sm:text-sm mb-0.5 sm:mb-1 block"></i>
                <span>Insured Transit</span>
              </div>
            </div>

          </div>
        </div>

      </div>

      <!-- Specifications & Details Tabs -->
      <section class="bg-white border border-slate-200 rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-10 mb-12 sm:mb-16 shadow-sm">
        <div class="flex items-center gap-1.5 sm:gap-2 border-b border-slate-200 pb-3 overflow-x-auto no-scrollbar text-xs sm:text-sm font-bold">
          <button type="button" onclick="switchTab('specs')" id="tab-btn-specs" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl bg-blue-600 text-white flex-shrink-0">Technical Specifications</button>
          <button type="button" onclick="switchTab('condition')" id="tab-btn-condition" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-slate-600 hover:bg-slate-100 flex-shrink-0">Condition & 20-Point QC</button>
          <button type="button" onclick="switchTab('warranty')" id="tab-btn-warranty" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-slate-600 hover:bg-slate-100 flex-shrink-0">Warranty & Coverage</button>
          <button type="button" onclick="switchTab('shipping')" id="tab-btn-shipping" class="px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl text-slate-600 hover:bg-slate-100 flex-shrink-0">Shipping & Delivery</button>
        </div>

        <!-- Tab 1: Technical Specifications -->
        <div id="tab-content-specs" class="py-6">
          <h3 class="text-lg font-bold text-slate-900 mb-4 font-heading">Complete Technical Specifications</h3>
          <div class="overflow-x-auto">
            <table class="w-full text-xs text-left text-slate-700 border border-slate-200 rounded-xl overflow-hidden" id="prod-full-specs-table"></table>
          </div>
        </div>

        <!-- Tab 2: Condition & Testing -->
        <div id="tab-content-condition" class="py-6 hidden space-y-6 text-xs text-slate-700 leading-relaxed font-body">
          <div class="flex items-center justify-between flex-wrap gap-2">
            <div>
              <h3 class="text-lg font-bold text-slate-900 font-heading">Our 20-Point Diagnostics Checklist</h3>
              <p class="text-slate-500">Each unit is physically evaluated by senior technicians and stress-tested with industrial benchmark tools:</p>
            </div>
            <span class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-xs px-3 py-1 font-bold">
              <i class="fa-solid fa-circle-check mr-1 text-emerald-600"></i> Certified Pre-Inspected
            </span>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-4 pt-1">
            <!-- Card 1: Core Computing -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
              <div class="flex items-center gap-2.5 pb-2 border-b border-slate-200">
                <div class="w-8 h-8 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                  <i class="fa-solid fa-microchip"></i>
                </div>
                <div class="min-w-0">
                  <h4 class="font-bold text-slate-900 text-xs whitespace-nowrap">Core Computing</h4>
                  <span class="text-[10px] text-slate-500 whitespace-nowrap block">Processor & Motherboard</span>
                </div>
              </div>
              <div class="space-y-1.5 text-[11px]">
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> CPU / GPU Thermal Stress Test</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> RAM MemTest86 100% Stability</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> SSD SMART Health & Speeds</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> Motherboard Voltage Integrity</div>
              </div>
            </div>

            <!-- Card 2: Display & Optics -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
              <div class="flex items-center gap-2.5 pb-2 border-b border-slate-200">
                <div class="w-8 h-8 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                  <i class="fa-solid fa-display"></i>
                </div>
                <div class="min-w-0">
                  <h4 class="font-bold text-slate-900 text-xs whitespace-nowrap">Display & Optics</h4>
                  <span class="text-[10px] text-slate-500 whitespace-nowrap block">Screen & Camera</span>
                </div>
              </div>
              <div class="space-y-1.5 text-[11px]">
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> Zero Pixel & Bleed Audit</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> Brightness & Uniformity Check</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> Front / Rear HD Camera Test</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> True Tone & Light Sensors</div>
              </div>
            </div>

            <!-- Card 3: Power & Ports -->
            <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 space-y-3">
              <div class="flex items-center gap-2.5 pb-2 border-b border-slate-200">
                <div class="w-8 h-8 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-sm font-bold flex-shrink-0">
                  <i class="fa-solid fa-battery-half"></i>
                </div>
                <div class="min-w-0">
                  <h4 class="font-bold text-slate-900 text-xs whitespace-nowrap">Power & Ports</h4>
                  <span class="text-[10px] text-slate-500 whitespace-nowrap block">Battery & Chassis</span>
                </div>
              </div>
              <div class="space-y-1.5 text-[11px]">
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> 85%+ Certified Battery Capacity</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> USB-C & Thunderbolt Ports</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> Keyboard All-Key Feedback</div>
                <div class="flex items-center gap-2 p-1.5 rounded-lg bg-white border border-slate-100"><i class="fa-solid fa-circle-check text-emerald-500"></i> Wi-Fi 6 & Dual Microphones</div>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab 3: Warranty -->
        <div id="tab-content-warranty" class="py-6 hidden space-y-4 text-xs text-slate-700 leading-relaxed font-body">
          <h3 class="text-lg font-bold text-slate-900 font-heading">Warranty Policy & Claims</h3>
          <p>This product includes warranty as specified on invoice and product listing. It covers internal hardware faults, motherboard defects, and component failure during normal operational use.</p>
          <div class="p-4 bg-blue-50 text-blue-900 rounded-2xl border border-blue-100 space-y-1">
            <h4 class="font-bold">How to claim warranty support?</h4>
            <p>Simply message our support desk with your invoice number and video demonstration of the issue. Our technicians will guide repair or replacement within 3 to 7 working days.</p>
          </div>
        </div>

        <!-- Tab 4: Shipping -->
        <div id="tab-content-shipping" class="py-6 hidden space-y-4 text-xs text-slate-700 leading-relaxed font-body">
          <h3 class="text-lg font-bold text-slate-900 font-heading">Insured Pan-India Logistics</h3>
          <p>Orders are dispatched within 24 hours of confirmation through top-tier courier services (BlueDart, Delhivery, DTDC) with end-to-end live tracking.</p>
        </div>
      </section>

      <!-- Related Products -->
      <section class="mb-12">
        <div class="flex items-center justify-between gap-3 mb-6">
          <h3 class="text-lg sm:text-2xl font-bold text-slate-900 font-heading truncate">You Might Also Like</h3>
          <a href="{{ route('shop') }}" class="text-xs font-bold text-blue-600 hover:underline whitespace-nowrap flex-shrink-0">View All →</a>
        </div>
        <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4 lg:gap-6" id="related-products-grid"></div>
      </section>

    </div>
  </main>

  <!-- Slide-In Right Drawer for Live Video Inspection Call -->
  <div id="video-call-drawer" class="fixed inset-0 z-50 pointer-events-none opacity-0 transition-opacity duration-300 ease-in-out" aria-hidden="true">
    <div class="absolute inset-0 bg-slate-950/60 backdrop-blur-sm transition-opacity" onclick="closeVideoCallDrawer()"></div>

    <div class="absolute right-0 top-0 bottom-0 w-full max-w-md bg-white shadow-2xl flex flex-col justify-between transform translate-x-full transition-transform duration-300 ease-in-out z-10" id="video-call-drawer-box">
      <!-- Header -->
      <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between bg-slate-900 text-white flex-shrink-0">
        <div class="flex items-center gap-2.5">
          <div class="w-9 h-9 rounded-xl bg-blue-600 text-white flex items-center justify-center text-base shadow-md">
            <i class="fa-solid fa-video"></i>
          </div>
          <div>
            <h3 class="text-base font-extrabold font-heading text-white leading-tight">Live Video Call Inspection</h3>
            <p class="text-[11px] text-blue-300">Direct unit verification with technician</p>
          </div>
        </div>
        <button type="button" onclick="closeVideoCallDrawer()" class="w-8 h-8 rounded-full bg-slate-800 hover:bg-slate-700 text-slate-300 hover:text-white flex items-center justify-center transition-colors">
          <i class="fa-solid fa-xmark text-sm"></i>
        </button>
      </div>

      <!-- Drawer Scrollable Body -->
      <div class="p-5 sm:p-6 overflow-y-auto space-y-5 flex-1 text-xs">

        <div class="p-3.5 rounded-2xl bg-slate-50 border border-slate-200 flex items-center gap-3">
          <img id="drawer-prod-img" src="" alt="Product" class="w-14 h-14 object-contain rounded-xl bg-white p-1 border border-slate-200 flex-shrink-0" />
          <div class="flex-1 min-w-0">
            <span class="badge bg-emerald-100 text-emerald-800 text-[9px] font-bold"><i class="fa-solid fa-circle-check"></i> 20-Point QC Verified</span>
            <h4 class="font-extrabold text-slate-900 text-xs truncate mt-0.5" id="drawer-prod-name">Loading...</h4>
            <span class="text-xs font-black text-blue-600 font-heading" id="drawer-prod-price">₹0</span>
          </div>
        </div>

        <div class="p-3.5 rounded-2xl bg-blue-50/60 border border-blue-100 text-slate-700 space-y-1">
          <div class="font-bold text-blue-900 flex items-center gap-1.5">
            <i class="fa-solid fa-circle-info text-blue-600"></i> Why Book a Live Video Call?
          </div>
          <p class="text-[11px] text-slate-600 leading-relaxed">
            Inspect cosmetic condition, scratch-free screen, genuine battery health, ports, and keyboard live on video before making a payment.
          </p>
        </div>

        <!-- Inspection Form -->
        <form id="video-call-form" class="space-y-4" onsubmit="handleVideoCallBooking(event)">
          <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Your Full Name *</label>
            <input type="text" id="vcall-name" required placeholder="e.g. Amit Kumar" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition-all" />
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">WhatsApp / Mobile Number *</label>
            <div class="relative flex items-center">
              <span class="absolute left-3.5 text-slate-400 font-bold text-xs">+91</span>
              <input type="tel" id="vcall-phone" required maxlength="10" placeholder="10-digit mobile" class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-12 pr-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white transition-all" />
            </div>
          </div>

          <div class="grid grid-cols-2 gap-3">
            <div>
              <label class="block text-xs font-bold text-slate-800 mb-1">Platform</label>
              <select id="vcall-platform" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                <option value="WhatsApp Video">WhatsApp Video</option>
                <option value="Google Meet">Google Meet</option>
                <option value="Zoom">Zoom</option>
              </select>
            </div>
            <div>
              <label class="block text-xs font-bold text-slate-800 mb-1">Preferred Slot</label>
              <select id="vcall-slot" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600">
                <option value="Instant (Within 15 Mins)">Instant (15 Mins)</option>
                <option value="Morning (10 AM - 1 PM)">Morning (10AM - 1PM)</option>
                <option value="Afternoon (1 PM - 5 PM)">Afternoon (1PM - 5PM)</option>
                <option value="Evening (5 PM - 8 PM)">Evening (5PM - 8PM)</option>
              </select>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-800 mb-1.5">What would you like to inspect?</label>
            <div class="space-y-1.5 text-[11px] text-slate-700">
              <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded text-blue-600" /> Physical Body & Scratch Check</label>
              <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded text-blue-600" /> Screen Quality & Dead Pixel Test</label>
              <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded text-blue-600" /> Battery Health Cycle & Backup</label>
              <label class="flex items-center gap-2 cursor-pointer"><input type="checkbox" checked class="rounded text-blue-600" /> Original Charger & Serial Number</label>
            </div>
          </div>

          <div>
            <label class="block text-xs font-bold text-slate-800 mb-1">Specific Query / Requirement</label>
            <textarea id="vcall-notes" rows="2" placeholder="e.g. Can you show dual boot OS or boot speed?" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white"></textarea>
          </div>

          <button type="submit" class="btn-base btn-primary w-full py-3.5 text-xs font-bold justify-center shadow-lg shadow-blue-600/30">
            <i class="fa-solid fa-video mr-1.5"></i> Schedule Video Inspection Call
          </button>
        </form>

        <!-- Success View inside Drawer -->
        <div id="video-call-success" class="hidden text-center py-6 space-y-3">
          <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl mx-auto shadow-sm">
            <i class="fa-solid fa-circle-check"></i>
          </div>
          <h4 class="text-base font-extrabold text-slate-900 font-heading">Video Call Scheduled!</h4>
          <p class="text-xs text-slate-600 leading-relaxed max-w-xs mx-auto">
            Our technician will connect with you on <strong id="vcall-confirm-phone" class="text-slate-900"></strong> for live unit inspection.
          </p>
          <div class="pt-2">
            <button type="button" onclick="closeVideoCallDrawer()" class="btn-base btn-secondary btn-sm text-xs">
              Back to Product Details
            </button>
          </div>
        </div>

      </div>

      <!-- Footer Reassurance -->
      <div class="p-4 bg-slate-50 border-t border-slate-100 text-[11px] text-slate-500 text-center flex items-center justify-center gap-2 flex-shrink-0">
        <i class="fa-solid fa-lock text-slate-400"></i> No Obligation to Buy • 100% Free Live Demonstration
      </div>
    </div>
  </div>

@endsection

@push('scripts')
  <script>
    const ROUTE_URLS = {
      laptops: "{{ route('laptops') }}",
      mobiles: "{{ route('mobile-phones') }}",
      accessories: "{{ route('accessories') }}",
      checkout: "{{ route('checkout') }}"
    };

    let currentProduct = null;

    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('product');
      Components.renderFooter();

      const params = App.getUrlParams();
      const productId = params.id || 'lap-01'; // Default fallback

      const product = PRODUCTS_DATA.find(p => p.id === productId);
      if (product) {
        currentProduct = product;
        renderProductDetails(product);
      } else {
        document.getElementById('prod-name').textContent = 'Product Not Found';
      }
    });

    function renderProductDetails(p) {
      document.title = `${p.name} — VANSH IT & COMM`;
      document.getElementById('prod-bread-title').textContent = p.name;
      document.getElementById('prod-bread-cat').textContent = p.category === 'laptops' ? 'Laptops' : (p.category === 'mobile-phones' ? 'Mobile Phones' : 'Accessories');
      document.getElementById('prod-bread-cat').href = p.category === 'laptops' ? ROUTE_URLS.laptops : (p.category === 'mobile-phones' ? ROUTE_URLS.mobiles : ROUTE_URLS.accessories);

      document.getElementById('prod-brand').textContent = p.brand;
      document.getElementById('prod-sku').textContent = `SKU: VIC-${p.id.toUpperCase()}`;
      document.getElementById('prod-name').textContent = p.name;
      document.getElementById('prod-badge').textContent = p.badge || p.condition;
      document.getElementById('prod-badge').className = `badge ${ProductsEngine.getBadgeClass(p.badge || p.condition)} text-xs px-3 py-1`;

      document.getElementById('prod-price').textContent = ProductsEngine.formatPrice(p.price);
      document.getElementById('prod-mrp').textContent = ProductsEngine.formatPrice(p.mrp);
      document.getElementById('prod-discount').textContent = `${p.discount}% OFF`;
      document.getElementById('prod-stars').innerHTML = ProductsEngine.renderStars(p.rating);
      document.getElementById('prod-reviews-count').textContent = `${p.reviewsCount} verified reviews`;

      // Main image & gallery
      const mainImg = document.getElementById('main-product-image');
      mainImg.src = p.image;
      mainImg.alt = p.name;

      const thumbsContainer = document.getElementById('prod-thumbnails-container');
      const gallery = p.gallery && p.gallery.length ? p.gallery : [p.image];
      thumbsContainer.innerHTML = gallery.map((imgSrc, idx) => `
        <button
          type="button"
          onclick="setMainImage('${imgSrc}', this)"
          class="prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 ${idx === 0 ? 'border-blue-600' : 'border-slate-200'} bg-white p-1 flex-shrink-0 transition-all hover:border-blue-400"
        >
          <img src="${imgSrc}" alt="${p.name}" class="w-full h-full object-contain" />
        </button>
      `).join('');

      // Key specs summary (Modern Tile Design)
      const keySpecsBox = document.getElementById('prod-key-specs');
      if (p.category === 'laptops') {
        keySpecsBox.innerHTML = `
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-microchip"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Processor</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.processor}">${p.processor}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-memory"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">RAM</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.ram}">${p.ram}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-hard-drive"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Storage</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.storage}">${p.storage}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-display"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Display</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.display}">${p.display}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-battery-three-quarters"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Battery</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.batteryHealth || 'Certified 85%+'}">${p.batteryHealth || 'Certified 85%+'}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-laptop-code"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">OS</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.os || 'Windows 11'}">${p.os || 'Windows 11'}</strong>
            </div>
          </div>
        `;
      } else if (p.category === 'mobile-phones') {
        keySpecsBox.innerHTML = `
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-mobile-screen-button"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Display</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.display}">${p.display}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-camera"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Camera</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.camera}">${p.camera}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-hard-drive"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Storage</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.storage}">${p.storage}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-memory"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">RAM</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.ram}">${p.ram}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-battery-three-quarters"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Battery</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.batteryHealth}">${p.batteryHealth}</strong>
            </div>
          </div>
          <div class="p-2 sm:p-2.5 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2">
            <div class="w-6 h-6 rounded-lg bg-sky-50 text-sky-600 flex items-center justify-center text-[10px] flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">OS</span>
              <strong class="text-xs font-bold text-slate-800 leading-tight block truncate" title="${p.os}">${p.os}</strong>
            </div>
          </div>
        `;
      } else {
        keySpecsBox.innerHTML = `
          <div class="col-span-2 sm:col-span-3 p-3 rounded-xl bg-slate-50 border border-slate-200/80 flex items-start gap-2.5">
            <div class="w-7 h-7 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center text-xs flex-shrink-0 mt-0.5">
              <i class="fa-solid fa-star"></i>
            </div>
            <div class="min-w-0 flex-1">
              <span class="text-[9px] sm:text-[10px] font-bold text-slate-400 uppercase tracking-wider block">Highlights & Specs</span>
              <strong class="text-xs font-bold text-slate-800 leading-relaxed block">${p.description}</strong>
            </div>
          </div>
        `;
      }

      // Full Specs Table
      const specsTable = document.getElementById('prod-full-specs-table');
      const specRows = [
        ['Product Name', p.name],
        ['Brand', p.brand],
        ['Category', p.category.toUpperCase()],
        ['Condition', `${p.condition} — 20-Point Inspected`],
        ['Warranty', p.warranty || '12-Month Coverage'],
        ['Processor / Chipset', p.processor || 'N/A'],
        ['Memory (RAM)', p.ram || 'N/A'],
        ['Storage', p.storage || 'N/A'],
        ['Display / Screen', p.display || 'N/A'],
        ['Operating System', p.os || 'N/A'],
        ['Battery Condition', p.batteryHealth || 'Certified 85%+ Capacity']
      ];
      specsTable.innerHTML = specRows.map(([label, val]) => `
        <tr class="border-b border-slate-100 hover:bg-slate-50">
          <td class="py-2.5 px-4 font-bold text-slate-600 w-1/3 bg-slate-50/50">${label}</td>
          <td class="py-2.5 px-4 text-slate-800 font-medium">${val}</td>
        </tr>
      `).join('');

      // Add to Cart Button handler
      document.getElementById('prod-add-cart-btn').onclick = function() {
        ProductsEngine.handleAddToCart(p.id, this);
      };

      // Buy Now Button handler
      document.getElementById('prod-buy-now-btn').onclick = function() {
        Cart.addItem(p.id, 1);
        window.location.href = ROUTE_URLS.checkout;
      };

      // Related Products
      const related = PRODUCTS_DATA.filter(item => item.category === p.category && item.id !== p.id).slice(0, 4);
      ProductsEngine.renderProductsGrid('related-products-grid', related);
    }

    function setMainImage(src, btn) {
      document.getElementById('main-product-image').src = src;
      document.querySelectorAll('.prod-thumb').forEach(t => t.className = 'prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 border-slate-200 bg-white p-1 flex-shrink-0 transition-all hover:border-blue-400');
      btn.className = 'prod-thumb w-14 h-14 rounded-xl overflow-hidden border-2 border-blue-600 bg-white p-1 flex-shrink-0 transition-all';
    }

    function switchTab(tabId) {
      ['specs', 'condition', 'warranty', 'shipping'].forEach(t => {
        document.getElementById(`tab-content-${t}`).classList.add('hidden');
        document.getElementById(`tab-btn-${t}`).className = 'px-4 py-2 rounded-xl text-slate-600 hover:bg-slate-100 flex-shrink-0';
      });
      document.getElementById(`tab-content-${tabId}`).classList.remove('hidden');
      document.getElementById(`tab-btn-${tabId}`).className = 'px-4 py-2 rounded-xl bg-blue-600 text-white flex-shrink-0';
    }

    function checkPincode() {
      const pin = (document.getElementById('pincode-input').value || '').trim();
      const status = document.getElementById('pincode-status');
      status.classList.remove('hidden');

      if (pin.length === 6 && /^\d+$/.test(pin)) {
        status.innerHTML = `<span class="text-emerald-600 font-bold"><i class="fa-solid fa-circle-check"></i> Standard Delivery Available:</span> Estimated 3–5 business days to <strong>${pin}</strong>. Cash on Delivery supported.`;
      } else {
        status.innerHTML = `<span class="text-red-500 font-semibold"><i class="fa-solid fa-triangle-exclamation"></i> Please enter a valid 6-digit Indian PIN code.</span>`;
      }
    }

    // ==========================================
    // SLIDE-IN RIGHT DRAWER (Live Video Call)
    // ==========================================
    function openVideoCallDrawer() {
      const drawer = document.getElementById('video-call-drawer');
      const drawerBox = document.getElementById('video-call-drawer-box');
      if (!drawer || !drawerBox) return;

      if (currentProduct) {
        document.getElementById('drawer-prod-img').src = currentProduct.image;
        document.getElementById('drawer-prod-name').textContent = currentProduct.name;
        document.getElementById('drawer-prod-price').textContent = ProductsEngine.formatPrice(currentProduct.price);
      }

      drawer.classList.remove('pointer-events-none', 'opacity-0');
      drawer.classList.add('opacity-100');
      drawerBox.classList.remove('translate-x-full');
      drawerBox.classList.add('translate-x-0');
      document.body.style.overflow = 'hidden';
    }

    function closeVideoCallDrawer() {
      const drawer = document.getElementById('video-call-drawer');
      const drawerBox = document.getElementById('video-call-drawer-box');
      if (!drawer || !drawerBox) return;

      drawerBox.classList.remove('translate-x-0');
      drawerBox.classList.add('translate-x-full');
      drawer.classList.remove('opacity-100');
      drawer.classList.add('opacity-0', 'pointer-events-none');
      document.body.style.overflow = '';

      setTimeout(() => {
        const form = document.getElementById('video-call-form');
        const success = document.getElementById('video-call-success');
        if (form) form.classList.remove('hidden');
        if (success) success.classList.add('hidden');
      }, 300);
    }

    function handleVideoCallBooking(e) {
      e.preventDefault();
      const phone = document.getElementById('vcall-phone').value.trim();
      const platform = document.getElementById('vcall-platform').value;
      const slot = document.getElementById('vcall-slot').value;

      document.getElementById('video-call-form').classList.add('hidden');
      document.getElementById('video-call-success').classList.remove('hidden');
      document.getElementById('vcall-confirm-phone').textContent = `+91 ${phone}`;

      App.showToast(`Video call request sent for ${platform} (${slot})!`, 'success');
    }
  </script>
@endpush