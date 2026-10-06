@extends('layouts.app')

@php
  $siteName = $setting?->site_name;
  $phoneRaw = $setting?->phone ? preg_replace('/[^\d+]/', '', $setting->phone) : null;
  $waRaw    = $setting?->whatsapp ? preg_replace('/\D/', '', $setting->whatsapp) : null;
  $iconColors = ['text-blue-600', 'text-emerald-600', 'text-purple-600', 'text-amber-600'];
@endphp

@section('title', 'Contact Us & Store Locations' . ($siteName ? ' | ' . $siteName : ''))
@section('meta_description', 'Get in touch with ' . ($siteName ?: 'us') . ' for product inquiries, repair bookings, trade-ins, or customer support.')

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
            Get In Touch{{ $siteName ? ' With ' . $siteName : '' }}
          </h1>
          <p class="text-xs sm:text-sm lg:text-base text-slate-300 leading-relaxed font-body">
            Have questions regarding laptop specifications, smartphone stock, repair quotes, or order tracking? Our customer assistance desk is ready to help.
          </p>
        </div>
      </div>

      <!-- Quick Contact Cards (from Settings) -->
      <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-2.5 sm:gap-4 lg:gap-6 mb-12 sm:mb-16">

        @if($setting?->phone)
          <div class="card-base p-3 sm:p-5 lg:p-6 text-center flex flex-col justify-between items-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center text-lg sm:text-xl mx-auto mb-2 sm:mb-3 flex-shrink-0">
              <i class="fa-solid fa-phone"></i>
            </div>
            <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-0.5 sm:mb-1 font-heading truncate w-full">Call Us</h3>
            <p class="text-[10px] sm:text-xs text-slate-500 mb-2 sm:mb-3 line-clamp-2 leading-tight">{{ $setting->phone }}</p>
            <a href="tel:{{ $phoneRaw }}" class="text-[10px] sm:text-[11px] font-semibold text-blue-600 hover:underline block truncate w-full">Call Now</a>
          </div>
        @endif

        @if($waRaw)
          <div class="card-base p-3 sm:p-5 lg:p-6 text-center flex flex-col justify-between items-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-lg sm:text-xl mx-auto mb-2 sm:mb-3 flex-shrink-0">
              <i class="fa-brands fa-whatsapp"></i>
            </div>
            <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-0.5 sm:mb-1 font-heading truncate w-full">WhatsApp Chat</h3>
            <p class="text-[10px] sm:text-xs text-slate-500 mb-2 sm:mb-3 line-clamp-2 leading-tight">{{ $setting->whatsapp }}</p>
            <a href="https://wa.me/{{ $waRaw }}" target="_blank" rel="noopener" class="btn-base btn-success btn-sm text-[10px] sm:text-xs py-1 sm:py-1.5 px-2.5 sm:px-3 w-full justify-center">
              Chat Now
            </a>
          </div>
        @endif

        @if($setting?->support_email)
          <div class="card-base p-3 sm:p-5 lg:p-6 text-center flex flex-col justify-between items-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-purple-50 text-purple-600 flex items-center justify-center text-lg sm:text-xl mx-auto mb-2 sm:mb-3 flex-shrink-0">
              <i class="fa-solid fa-envelope"></i>
            </div>
            <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-0.5 sm:mb-1 font-heading truncate w-full">Email Support</h3>
            <p class="text-[10px] sm:text-xs text-slate-500 mb-2 sm:mb-3 line-clamp-2 leading-tight break-all">{{ $setting->support_email }}</p>
            <a href="mailto:{{ $setting->support_email }}" class="text-[10px] sm:text-[11px] font-semibold text-purple-600 hover:underline block truncate w-full">Send Email</a>
          </div>
        @endif

        @if($setting?->business_address)
          <div class="card-base p-3 sm:p-5 lg:p-6 text-center flex flex-col justify-between items-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg sm:text-xl mx-auto mb-2 sm:mb-3 flex-shrink-0">
              <i class="fa-solid fa-location-dot"></i>
            </div>
            <h3 class="text-xs sm:text-sm font-bold text-slate-900 mb-0.5 sm:mb-1 font-heading truncate w-full">Visit Store</h3>
            <p class="text-[10px] sm:text-xs text-slate-500 mb-2 sm:mb-3 line-clamp-2 leading-tight">{{ $setting->business_address }}</p>
            @if($setting->google_map_url)
              <a href="{{ $setting->google_map_url }}" target="_blank" rel="noopener" class="text-[10px] sm:text-[11px] font-semibold text-amber-600 hover:underline block truncate w-full">Get Directions</a>
            @endif
          </div>
        @endif

      </div>

      <!-- Contact Form & Store Locator Grid -->
      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:gap-8 mb-12 sm:mb-16">

        <!-- Left: Inquiry Form -->
        <div class="lg:col-span-7 bg-white p-4 sm:p-8 lg:p-10 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm">
          <h3 class="text-lg sm:text-xl font-bold text-slate-900 mb-1.5 font-heading">Send Us a Message</h3>
          <p class="text-xs text-slate-500 mb-5 font-body">Fill out the inquiry form and our customer team will respond promptly.</p>

          <form id="contact-form" class="space-y-4" action="{{ route('contact.submit') }}" method="POST" onsubmit="handleContactSubmit(event)">
            @csrf
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Your Full Name *</label>
                <input type="text" name="name" id="contact-name" required placeholder="Enter full name" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Phone Number *</label>
                <input type="tel" name="mobile" id="contact-phone" required placeholder="10-digit mobile number" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5 sm:gap-4">
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" id="contact-email" placeholder="name@example.com" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white" />
              </div>
              <div>
                <label class="block text-xs font-bold text-slate-700 mb-1">Inquiry Subject *</label>
                <select name="inquiry_type" id="contact-subject" required class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white">
                  @foreach($inquiryTypes as $value => $label)
                    <option value="{{ $value }}">{{ $label }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold text-slate-700 mb-1">Your Message *</label>
              <textarea name="message" id="contact-message" rows="4" required placeholder="How can we help you today?" class="w-full bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600 focus:bg-white"></textarea>
            </div>

            <button type="submit" id="contact-submit-btn" class="btn-base btn-primary w-full py-3 text-xs sm:text-sm font-semibold justify-center shadow-lg shadow-blue-600/30">
              <i class="fa-solid fa-paper-plane mr-2"></i> Submit Inquiry
            </button>
          </form>
        </div>

        <!-- Right: Store Locations & Map -->
        <div class="lg:col-span-5 space-y-4 sm:space-y-6">

          @if($branches->count())
            <div class="bg-white p-4 sm:p-6 rounded-2xl sm:rounded-3xl border border-slate-200 shadow-sm space-y-3.5">
              <h3 class="text-base font-bold text-slate-900 font-heading">Store Locations</h3>

              @foreach($branches as $branch)
                <div class="p-3.5 sm:p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-1">
                  <div class="flex items-center gap-2 font-bold text-xs text-slate-900">
                    <i class="{{ $branch->icon ?: 'fa-solid fa-store' }} {{ $iconColors[$loop->index % count($iconColors)] }}"></i>
                    {{ $branch->title }}
                  </div>

                  @if($branch->subtitle)
                    <p class="text-xs text-slate-500">{{ $branch->subtitle }}</p>
                  @endif

                  @if($branch->address)
                    <p class="text-xs text-slate-500">{{ $branch->address }}</p>
                  @endif

                  @if($branch->phone)
                    <div class="text-[11px] text-slate-600">
                      <strong>Phone:</strong>
                      <a href="tel:{{ preg_replace('/[^\d+]/', '', $branch->phone) }}" class="hover:text-blue-600">{{ $branch->phone }}</a>
                    </div>
                  @endif

                  @if($branch->email)
                    <div class="text-[11px] text-slate-600 break-all">
                      <strong>Email:</strong>
                      <a href="mailto:{{ $branch->email }}" class="hover:text-blue-600">{{ $branch->email }}</a>
                    </div>
                  @endif

                  @if($branch->working_hours)
                    <div class="text-[11px] text-slate-600 pt-1">
                      <strong>Hours:</strong> {{ $branch->working_hours }}
                    </div>
                  @endif
                </div>
              @endforeach
            </div>
          @endif

          @if($setting?->google_map_url)
            @if(str_contains($setting->google_map_url, '/embed'))
              <div class="rounded-2xl sm:rounded-3xl border border-slate-200 overflow-hidden bg-slate-100 h-52 sm:h-64 shadow-sm">
                <iframe src="{{ $setting->google_map_url }}" class="w-full h-full border-0" loading="lazy" allowfullscreen referrerpolicy="no-referrer-when-downgrade" title="Store location map"></iframe>
              </div>
            @else
              <a href="{{ $setting->google_map_url }}" target="_blank" rel="noopener"
                 class="rounded-2xl sm:rounded-3xl border border-slate-200 bg-slate-100 hover:bg-slate-50 h-52 sm:h-64 flex flex-col items-center justify-center p-6 text-center shadow-sm">
                <i class="fa-solid fa-map-location-dot text-slate-400 text-3xl sm:text-4xl mb-2 sm:mb-3"></i>
                <span class="text-xs font-semibold text-blue-600">Open in Google Maps</span>
              </a>
            @endif
          @endif

        </div>

      </div>

    </div>
  </main>

@endsection

@push('scripts')
  <script>
    async function handleContactSubmit(event) {
      event.preventDefault();

      const form = event.target;
      const btn  = document.getElementById('contact-submit-btn');
      const originalHtml = btn.innerHTML;

      btn.disabled = true;
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Sending...';

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
          },
          body: new FormData(form)
        });

        const data = await response.json();

        if (response.ok && data.success) {
          form.reset();
          showToast(data.message, 'success');
        } else if (response.status === 422) {
          const firstError = Object.values(data.errors || {})[0];
          showToast(firstError ? firstError[0] : 'Please check the form and try again.', 'error');
        } else if (response.status === 429) {
          showToast('Too many attempts. Please try again in a minute.', 'error');
        } else {
          showToast('Something went wrong. Please try again.', 'error');
        }
      } catch (e) {
        showToast('Network error. Please try again.', 'error');
      } finally {
        btn.disabled = false;
        btn.innerHTML = originalHtml;
      }
    }
  </script>
@endpush