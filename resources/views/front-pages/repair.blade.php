@extends('layouts.app')

@section('title', 'Professional Laptop & Mobile Repair Services | VANSH IT & COMM')
@section('meta_description', 'Expert screen replacement, battery replacement, SSD/RAM upgrades, and motherboard repairs with genuine components and transparent pricing.')

@section('content')

  <main class="flex-grow py-6 sm:py-10">
    <div class="container-custom">

      <!-- Breadcrumb -->
      <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 font-semibold">Repair Services</span>
      </nav>

      <!-- Repair Hero -->
      <div class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-2xl sm:rounded-3xl p-4 sm:p-8 lg:p-10 mb-8 sm:mb-12 border border-slate-800 shadow-xl">
        <div class="max-w-3xl space-y-2.5 sm:space-y-4">
          <span class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-[10px] sm:text-xs px-2.5 py-0.5 sm:px-3 sm:py-1 font-bold">CERTIFIED TECHNICIANS</span>
          <h1 class="text-xl sm:text-3xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
            Professional Laptop & Mobile Repair Services
          </h1>
          <p class="text-xs sm:text-sm lg:text-base text-slate-300 leading-relaxed font-body">
            Fast, reliable, and transparent repair solutions for all major laptop and smartphone brands. Screen replacement, battery upgrades, hardware servicing, and chip-level motherboard diagnostics.
          </p>
          <div class="grid grid-cols-2 sm:flex sm:flex-wrap items-center gap-2 sm:gap-4 pt-1 sm:pt-2 text-xs">
            <a href="#booking-form" class="btn-base btn-primary px-3 sm:px-6 py-2 sm:py-3 font-semibold shadow-lg shadow-blue-600/30 text-center justify-center">
              <i class="fa-solid fa-calendar-check mr-1.5"></i> Book Repair
            </a>
            <a href="{{ route('contact') }}" class="btn-base btn-secondary bg-white/10 text-white border-white/20 px-3 sm:px-6 py-2 sm:py-3 font-semibold hover:bg-white/20 text-center justify-center">
              <i class="fa-solid fa-phone mr-1.5"></i> Call Expert
            </a>
          </div>
        </div>
      </div>

      <!-- Laptop Repair Services Grid -->
      <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
          <div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Hardware & Software Fixes</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Laptop Repair Services</h2>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-display"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Screen Replacement</h3>
            <p class="text-xs text-slate-600 mb-4">FHD, IPS, OLED & Touch screens replaced for Dell, HP, Lenovo, Asus, and MacBooks.</p>
            <span class="text-xs font-bold text-blue-600">Est. Time: 2–4 Hours</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-battery-three-quarters"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Battery Replacement</h3>
            <p class="text-xs text-slate-600 mb-4">Original grade replacement batteries with verified capacity and backup guarantee.</p>
            <span class="text-xs font-bold text-emerald-600">Est. Time: 30 Mins</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-hard-drive"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">SSD & RAM Speed Upgrade</h3>
            <p class="text-xs text-slate-600 mb-4">NVMe SSD upgrades with complete OS cloning and RAM expansion to speed up slow machines.</p>
            <span class="text-xs font-bold text-purple-600">Est. Time: 45 Mins</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-keyboard"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Keyboard & Trackpad</h3>
            <p class="text-xs text-slate-600 mb-4">Fix sticky keys, liquid spill damage, non-working keys, and erratic cursor issues.</p>
            <span class="text-xs font-bold text-amber-600">Est. Time: 2 Hours</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-fan"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Thermal Cleaning & Fan Service</h3>
            <p class="text-xs text-slate-600 mb-4">Deep dust cleanup, Arctic MX-4 thermal paste re-application, and overheat resolution.</p>
            <span class="text-xs font-bold text-rose-600">Est. Time: 1 Hour</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-microchip"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Motherboard Chip-Level Repair</h3>
            <p class="text-xs text-slate-600 mb-4">Short-circuit diagnostic, power IC replacement, charging port repair, and BIOS reprogramming.</p>
            <span class="text-xs font-bold text-indigo-600">Est. Time: 24–48 Hours</span>
          </div>
        </div>
      </section>

      <!-- Mobile Repair Services Grid -->
      <section class="mb-16">
        <div class="flex items-center justify-between mb-8">
          <div>
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Smartphones & Tablets</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Mobile Repair Services</h2>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-mobile-screen"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Mobile Screen & OLED Replacement</h3>
            <p class="text-xs text-slate-600 mb-4">High-refresh rate 120Hz OLED and LCD assemblies for iPhone, Samsung, OnePlus & Pixel.</p>
            <span class="text-xs font-bold text-blue-600">Est. Time: 1 Hour</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-battery-full"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Phone Battery Replacement</h3>
            <p class="text-xs text-slate-600 mb-4">Restore 100% battery health with genuine high-density Li-Po batteries.</p>
            <span class="text-xs font-bold text-emerald-600">Est. Time: 30 Mins</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-plug"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Charging Port & Jack Fix</h3>
            <p class="text-xs text-slate-600 mb-4">Fix loose Type-C or Lightning connectors, slow charging, and data transfer faults.</p>
            <span class="text-xs font-bold text-amber-600">Est. Time: 45 Mins</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-camera"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Camera & Glass Repair</h3>
            <p class="text-xs text-slate-600 mb-4">Blurry camera lens, cracked camera glass, and OIS sensor calibration.</p>
            <span class="text-xs font-bold text-purple-600">Est. Time: 1 Hour</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-sky-50 text-sky-600 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-volume-high"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Speaker & Mic Restoration</h3>
            <p class="text-xs text-slate-600 mb-4">Fix low ear-speaker volume, distorted loud-speakers, and call microphone issues.</p>
            <span class="text-xs font-bold text-sky-600">Est. Time: 45 Mins</span>
          </div>

          <div class="card-base p-6">
            <div class="w-12 h-12 rounded-2xl bg-slate-100 text-slate-800 flex items-center justify-center text-xl mb-4">
              <i class="fa-solid fa-shield"></i>
            </div>
            <h3 class="text-base font-bold text-slate-900 mb-1.5">Back Glass & Housing</h3>
            <p class="text-xs text-slate-600 mb-4">Laser back glass removal and full chassis replacement for pristine condition.</p>
            <span class="text-xs font-bold text-slate-700">Est. Time: 2 Hours</span>
          </div>
        </div>
      </section>

      <!-- Repair Booking Form Section -->
      <section id="booking-form" class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-12 mb-16 shadow-sm">
        <div class="max-w-3xl mx-auto">
          <div class="text-center mb-8">
            <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Fast Service Request</span>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">Book a Repair Service</h2>
            <p class="section-subtitle">Fill in your device details and our technician will contact you with diagnostic estimates.</p>
          </div>

          <form id="repair-booking-form" class="space-y-4" onsubmit="handleRepairSubmit(event)">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Your Full Name *</label>
                <input type="text" id="rep-name" required placeholder="Enter your full name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Mobile / WhatsApp Number *</label>
                <input type="tel" id="rep-phone" required placeholder="10-digit mobile number" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Device Type *</label>
                <select id="rep-device-type" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white">
                  <option value="Laptop">Laptop</option>
                  <option value="Mobile Phone">Mobile Phone</option>
                  <option value="Desktop PC">Desktop PC</option>
                  <option value="Tablet">Tablet / iPad</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Brand Name *</label>
                <input type="text" id="rep-brand" required placeholder="e.g. Dell, Apple, Lenovo, HP" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Model / Serial Number</label>
                <input type="text" id="rep-model" placeholder="e.g. Latitude 5420 / iPhone 13" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Primary Problem / Issue *</label>
                <select id="rep-issue" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white">
                  <option value="Screen Replacement">Screen Cracked / Blank Display</option>
                  <option value="Battery Health">Battery Draining Fast / Not Charging</option>
                  <option value="Slow Performance / SSD Upgrade">Slow Performance / SSD & RAM Upgrade</option>
                  <option value="Keyboard / Trackpad">Keyboard / Trackpad Not Responding</option>
                  <option value="Motherboard Fault">Device Not Turning On (Motherboard)</option>
                  <option value="Overheating">Overheating / Fan Noise</option>
                  <option value="Liquid Spill">Liquid Spill / Water Damage</option>
                  <option value="Other">Other Problem (Describe below)</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Preferred Service Mode</label>
                <select id="rep-mode" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white">
                  <option value="Store Drop-off">Drop-off at Store</option>
                  <option value="Courier Pickup">Doorstep Courier Pickup</option>
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1">Additional Issue Details</label>
              <textarea id="rep-desc" rows="3" placeholder="Describe any symptoms or specific requests..." class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white"></textarea>
            </div>

            <button type="submit" class="btn-base btn-primary w-full py-3.5 text-sm font-semibold justify-center shadow-lg shadow-blue-600/30">
              Submit Repair Booking
            </button>
            <p class="text-[11px] text-slate-400 text-center">No upfront payment required. You will receive an estimate before any work begins.</p>
          </form>
        </div>
      </section>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      Components.renderHeader('repair');
      Components.renderFooter();
    });

    function handleRepairSubmit(event) {
      event.preventDefault();
      const name = document.getElementById('rep-name').value.trim();
      const phone = document.getElementById('rep-phone').value.trim();

      if (!name || !phone) {
        showToast('Please fill all required fields.', 'error');
        return;
      }

      const reqId = `REP-${Math.floor(1000 + Math.random() * 9000)}`;

      // Reset form & show toast
      document.getElementById('repair-booking-form').reset();
      showToast(`Repair Ticket #${reqId} booked for ${name}! Our technician will call you shortly.`, 'success');
    }
  </script>
@endpush