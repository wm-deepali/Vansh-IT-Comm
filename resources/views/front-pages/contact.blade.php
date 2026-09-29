@extends('layouts.app')

@section('title', 'Contact Us & Store Locations | VANSH IT & COMM')
@section('meta_description', 'Get in touch with VANSH IT & COMM for product inquiries, repair bookings, trade-ins, or customer support.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Contact Us</span>
      </nav>

      <!-- Contact Hero -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-12 mb-8 sm:mb-12 border border-slate-800 shadow-xl">
        <div class="max-w-3xl space-y-2.5 sm:space-y-4">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] sm:text-xs px-2.5 py-0.5 sm:px-3 sm:py-1 font-bold">WE ARE HERE TO HELP</span>
          <h1 class="text-xl sm:text-3xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Get In Touch With VANSH IT & COMM
          </h1>
          <p class="text-xs sm:text-sm lg:text-base text-slate-300 leading-relaxed font-body">
            Have questions regarding laptop specifications, smartphone stock, repair quotes, or order tracking? Our customer assistance desk is ready to help.
          </p>
        </div>
      </div>

      <!-- 4 Quick Contact Cards (2 Mobile / 2 Tablet / 4 Desktop) -->
      <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4 lg:gap-6 mb-12 sm:mb-16">
        <div class="card-base p-3 sm:p-5 lg:p-6 text-center flex flex-col justify-between items-center">
          <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg sm:text-xl mx-auto mb-2 sm:mb-3 flex-shrink-0">
            <i class="fa-solid fa-phone"></i>
          </div>
          <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-0.5 sm:mb-1 font-heading truncate w-full">Call Us</h3>
          <p class="text-[10px] sm:text-xs text-slate-500 mb-2 sm:mb-3 line-clamp-2 leading-tight">+91 98765 43210</p>
          <a href="tel:+919876543210" class="text-[10px] sm:text-[11px] font-semibold text-blue-600 hover:underline block truncate w-full">10AM – 8PM</a>
        </div>

        <div class="card-base p-3 sm:p-5 lg:p-6 text-center flex flex-col justify-between items-center">
          <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg sm:text-xl mx-auto mb-2 sm:mb-3 flex-shrink-0">
            <i class="fa-brands fa-whatsapp"></i>
          </div>
          <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-0.5 sm:mb-1 font-heading truncate w-full">WhatsApp Chat</h3>
          <p class="text-[10px] sm:text-xs text-slate-500 mb-2 sm:mb-3 line-clamp-2 leading-tight">Photos & video</p>
          <a href="#" onclick="event.preventDefault(); showToast('WhatsApp support connected to store phone number.', 'info');" class="btn-base btn-success btn-sm text-[10px] sm:text-xs py-1 sm:py-1.5 px-2.5 sm:px-3 w-full justify-center">
            Chat Now
          </a>
        </div>

        <div class="card-base p-3 sm:p-5 lg:p-6 text-center flex flex-col justify-between items-center">
          <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg sm:text-xl mx-auto mb-2 sm:mb-3 flex-shrink-0">
            <i class="fa-solid fa-envelope"></i>
          </div>
          <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-0.5 sm:mb-1 font-heading truncate w-full">Email Support</h3>
          <p class="text-[10px] sm:text-xs text-slate-500 mb-2 sm:mb-3 line-clamp-2 leading-tight">support&#64;vansh.com</p>
          <span class="text-[10px] sm:text-[11px] font-semibold text-purple-600 block truncate w-full">Reply in 4h</span>
        </div>

        <div class="card-base p-3 sm:p-5 lg:p-6 text-center flex flex-col justify-between items-center">
          <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg sm:text-xl mx-auto mb-2 sm:mb-3 flex-shrink-0">
            <i class="fa-solid fa-location-dot"></i>
          </div>
          <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-0.5 sm:mb-1 font-heading truncate w-full">Visit Store</h3>
          <p class="text-[10px] sm:text-xs text-slate-500 mb-2 sm:mb-3 line-clamp-2 leading-tight">Experience Store</p>
          <span class="text-[10px] sm:text-[11px] font-semibold text-amber-600 block truncate w-full">Hub Open</span>
        </div>
      </div>

      <!-- Contact Form & Store Locator Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 mb-12 sm:mb-16">

        <!-- Left: Inquiry Form -->
        <div class="lg:col-span-7 bg-white p-4 sm:p-8 lg:p-10 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm">
          <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-1.5 font-heading">Send Us a Message</h3>
          <p class="text-xs text-slate-500 mb-5 font-body">Fill out the inquiry form and our customer team will respond promptly.</p>

          <form id="contact-form" class="space-y-4" onsubmit="handleContactSubmit(event)">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Your Full Name *</label>
                <input type="text" id="contact-name" required placeholder="Enter full name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number *</label>
                <input type="tel" id="contact-phone" required placeholder="10-digit mobile number" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                <input type="email" id="contact-email" placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Inquiry Subject *</label>
                <select id="contact-subject" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white">
                  <option value="Product Availability">Product Inquiry / Bulk Order</option>
                  <option value="Laptop/Mobile Repair">Repair Service Inquiry</option>
                  <option value="Device Exchange">Device Exchange / Upgrade</option>
                  <option value="Order Tracking">Order Status / Shipping</option>
                  <option value="Warranty Claim">Warranty Claim Assistance</option>
                  <option value="Other">Other Query</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1">Your Message *</label>
              <textarea id="contact-message" rows="4" required placeholder="How can we help you today?" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white"></textarea>
            </div>

            <button type="submit" class="btn-base btn-primary w-full py-3 text-xs sm:text-sm font-semibold justify-center shadow-lg shadow-blue-600/30">
              <i class="fa-solid fa-paper-plane mr-2"></i> Submit Inquiry
            </button>
          </form>
        </div>

        <!-- Right: Map Placeholder & Locations -->
        <div class="lg:col-span-5 space-y-4 sm:space-y-6">
          <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-3.5">
            <h3 class="text-base font-bold text-slate-900 font-heading">Store Locations</h3>

            <div class="p-3.5 sm:p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-1">
              <div class="flex items-center gap-2 font-bold text-xs text-slate-900">
                <i class="fa-solid fa-store text-blue-600"></i> Main Experience Store
              </div>
              <p class="text-xs text-slate-500">Experience Store & QC Lab, India</p>
              <div class="text-[11px] text-slate-600 pt-1">
                <strong>Hours:</strong> Mon – Sat: 10:00 AM – 8:30 PM
              </div>
            </div>

            <div class="p-3.5 sm:p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-1">
              <div class="flex items-center gap-2 font-bold text-xs text-slate-900">
                <i class="fa-solid fa-screwdriver-wrench text-emerald-600"></i> Repair Workshop
              </div>
              <p class="text-xs text-slate-500">Fast Diagnostics & Soldering Lab</p>
              <div class="text-[11px] text-slate-600 pt-1">
                <strong>Hours:</strong> Mon – Sat: 10:30 AM – 7:30 PM
              </div>
            </div>
          </div>

          <!-- Interactive Map Visual Placeholder -->
          <div class="rounded-2xl sm:rounded-3xl border border-slate-200 overflow-hidden bg-slate-100 h-52 sm:h-64 flex flex-col items-center justify-center p-6 text-center shadow-sm">
            <i class="fa-solid fa-map-location-dot text-slate-400 text-3xl sm:text-4xl mb-2 sm:mb-3"></i>
          </div>
        </div>

      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('contact');
      Components.renderFooter();
    });

    function handleContactSubmit(event) {
      event.preventDefault();
      const name = document.getElementById('contact-name').value.trim();
      document.getElementById('contact-form').reset();
      showToast(`Thank you, ${name}! Your inquiry has been received. Our team will contact you.`, 'success');
    }
  </script>
@endpush