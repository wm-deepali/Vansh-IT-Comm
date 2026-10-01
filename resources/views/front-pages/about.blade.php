@extends('layouts.app')

@section('content')

    <main class="flex-grow py-6 sm:py-10">
        <div class="container-custom">

            <!-- Breadcrumb -->
            <nav class="flex items-center gap-2 text-xs text-slate-500 mb-6" aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="hover:text-blue-600">Home</a>
                <i class="fa-solid fa-chevron-right text-[10px]"></i>
                <span class="text-slate-800 font-semibold">About Us</span>
            </nav>

            <!-- Hero Section -->
            <div
                class="bg-gradient-to-r from-slate-950 via-slate-900 to-blue-950 text-white rounded-3xl p-8 sm:p-12 mb-16 border border-slate-800 shadow-xl">
                <div class="max-w-3xl space-y-4">
                    <span
                        class="badge bg-blue-500/20 text-blue-300 border border-blue-400/30 text-xs px-3 py-1 font-bold">OUR
                        MISSION</span>
                    <h1
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-white tracking-tight leading-tight font-heading">
                        Technology That Fits Your Needs.
                    </h1>
                    <p class="text-sm sm:text-base text-slate-300 leading-relaxed font-body">
                        "Tested Technology. Trusted Value." At VANSH IT & COMM, we bridge the gap between premium
                        electronics and accessible value through rigorous engineering, transparent condition grading, and
                        reliable customer warranty support.
                    </p>
                </div>
            </div>

            <!-- Who We Are & What We Sell -->
            <section class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center mb-16">
                <div class="space-y-4">
                    <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Who We Are</span>
                    <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 font-heading">
                        Your Trusted Technology Partner
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-body">
                        Founded on the principle of giving high-end technology a smarter lifecycle, VANSH IT & COMM serves
                        thousands of students, developers, remote professionals, and corporate teams across India.
                    </p>
                    <p class="text-xs sm:text-sm text-slate-600 leading-relaxed font-body">
                        We specialize in business-class laptops (Dell Latitude, Lenovo ThinkPad, HP EliteBook, Apple
                        MacBook), certified smartphones, essential computer accessories, and expert hardware repair
                        solutions.
                    </p>
                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
                            <div class="text-2xl font-extrabold text-blue-600 font-heading">20+</div>
                            <div class="text-xs font-bold text-slate-800">Diagnostic Checkpoints</div>
                        </div>
                        <div class="p-4 rounded-2xl bg-white border border-slate-200 shadow-sm">
                            <div class="text-2xl font-extrabold text-emerald-600 font-heading">100%</div>
                            <div class="text-xs font-bold text-slate-800">GST Invoice Compliant</div>
                        </div>
                    </div>
                </div>

                <div class="relative">
                    <div class="rounded-3xl overflow-hidden border border-slate-200 shadow-lg bg-slate-900">
                        <img src="img/product-1588872657578-7efd1f1555ed.jpg" alt="Quality Testing Workshop"
                            class="w-full h-80 object-cover" />
                    </div>
                </div>
            </section>

            <!-- 20-Point Testing Detailed Protocol -->
            <section class="bg-white border border-slate-200 rounded-3xl p-6 sm:p-12 mb-16 shadow-sm"
                id="refurbish-process">
                <div class="text-center max-w-2xl mx-auto mb-10">
                    <span
                        class="badge bg-blue-50 text-blue-700 border border-blue-200 text-xs px-3.5 py-1 font-extrabold uppercase tracking-wider">
                        <i class="fa-solid fa-microchip mr-1.5 text-blue-600"></i> Engineering Rigor
                    </span>
                    <h2 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-slate-900 font-heading mt-2">
                        Our 20-Point Testing Approach
                    </h2>
                    <p class="text-xs sm:text-sm text-slate-500 mt-1 max-w-xl mx-auto">
                        Every laptop and smartphone undergoes rigorous multi-tier hardware diagnostics, thermal
                        benchmarking, and quality grading before certification.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 lg:gap-6">

                    <!-- Card 1: Core Computing -->
                    <div
                        class="card-base p-5 lg:p-6 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-lg hover:border-blue-300 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="pb-3.5 mb-4 border-b border-slate-100">
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 border border-blue-100 flex items-center justify-center text-base shadow-sm group-hover:scale-105 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                        <i class="fa-solid fa-microchip"></i>
                                    </div>
                                    <span
                                        class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2.5 py-1 whitespace-nowrap flex-shrink-0 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i> 4/4 Checked
                                    </span>
                                </div>
                                <div>
                                    <h3
                                        class="text-sm lg:text-base font-bold text-slate-900 font-heading leading-tight whitespace-nowrap">
                                        Core Computing</h3>
                                    <span
                                        class="text-[11px] text-slate-500 font-medium mt-0.5 block whitespace-nowrap">Processor
                                        & Motherboard</span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-blue-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">CPU & GPU Thermal Throttling
                                        Test</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-blue-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">RAM MemTest86 Stress
                                        Verification</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-blue-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">NVMe SSD SMART Health & Speeds</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-blue-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">Motherboard VRM Voltage
                                        Stability</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="font-medium flex items-center gap-1.5"><i
                                    class="fa-solid fa-gauge-high text-blue-600"></i> Peak Performance</span>
                            <span class="text-emerald-600 font-bold">Passed 100%</span>
                        </div>
                    </div>

                    <!-- Card 2: Display & Optics -->
                    <div
                        class="card-base p-5 lg:p-6 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-lg hover:border-indigo-300 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="pb-3.5 mb-4 border-b border-slate-100">
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 border border-indigo-100 flex items-center justify-center text-base shadow-sm group-hover:scale-105 group-hover:bg-indigo-600 group-hover:text-white transition-all">
                                        <i class="fa-solid fa-display"></i>
                                    </div>
                                    <span
                                        class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2.5 py-1 whitespace-nowrap flex-shrink-0 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i> 4/4 Checked
                                    </span>
                                </div>
                                <div>
                                    <h3
                                        class="text-sm lg:text-base font-bold text-slate-900 font-heading leading-tight whitespace-nowrap">
                                        Display & Optics</h3>
                                    <span
                                        class="text-[11px] text-slate-500 font-medium mt-0.5 block whitespace-nowrap">Screen
                                        & Visual Quality</span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-indigo-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">Screen Pixel Defect & Bleed
                                        Audit</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-indigo-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">Color Gamut & Brightness
                                        Balance</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-indigo-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">Front / Rear Cameras &
                                        Autofocus</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-indigo-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">True Tone & Ambient Light
                                        Sensors</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="font-medium flex items-center gap-1.5"><i
                                    class="fa-solid fa-eye text-indigo-600"></i> Grade A Clarity</span>
                            <span class="text-emerald-600 font-bold">Certified</span>
                        </div>
                    </div>

                    <!-- Card 3: Power & Ports -->
                    <div
                        class="card-base p-5 lg:p-6 rounded-2xl bg-white border border-slate-200 shadow-sm hover:shadow-lg hover:border-emerald-300 transition-all duration-300 flex flex-col justify-between group">
                        <div>
                            <div class="pb-3.5 mb-4 border-b border-slate-100">
                                <div class="flex items-center justify-between mb-3">
                                    <div
                                        class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 border border-emerald-100 flex items-center justify-center text-base shadow-sm group-hover:scale-105 group-hover:bg-emerald-600 group-hover:text-white transition-all">
                                        <i class="fa-solid fa-battery-half"></i>
                                    </div>
                                    <span
                                        class="badge bg-emerald-50 text-emerald-700 border border-emerald-200 text-[10px] font-bold px-2.5 py-1 whitespace-nowrap flex-shrink-0 flex items-center gap-1">
                                        <i class="fa-solid fa-circle-check text-emerald-600 text-[10px]"></i> 4/4 Checked
                                    </span>
                                </div>
                                <div>
                                    <h3
                                        class="text-sm lg:text-base font-bold text-slate-900 font-heading leading-tight whitespace-nowrap">
                                        Power & Ports</h3>
                                    <span
                                        class="text-[11px] text-slate-500 font-medium mt-0.5 block whitespace-nowrap">Battery
                                        & Connectivity</span>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-emerald-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">85%+ Certified Battery
                                        Capacity</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-emerald-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">Thunderbolt & Type-C Power
                                        Delivery</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-emerald-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">Wi-Fi 6 & Bluetooth Signal
                                        Strength</span>
                                </div>
                                <div
                                    class="flex items-center gap-2.5 p-2.5 rounded-xl bg-slate-50/80 hover:bg-emerald-50/60 border border-slate-100 transition-colors">
                                    <i class="fa-solid fa-circle-check text-emerald-500 text-sm flex-shrink-0"></i>
                                    <span class="text-xs font-semibold text-slate-700">Microphones, Speakers & Audio
                                        Jacks</span>
                                </div>
                            </div>
                        </div>

                        <div
                            class="mt-4 pt-3 border-t border-slate-100 flex items-center justify-between text-[11px] text-slate-500">
                            <span class="font-medium flex items-center gap-1.5"><i
                                    class="fa-solid fa-bolt text-emerald-600"></i> Fast Charging</span>
                            <span class="text-emerald-600 font-bold">Verified</span>
                        </div>
                    </div>

                </div>

                <!-- Testing Quality Banner at bottom of section -->
                <div
                    class="mt-8 p-4 rounded-2xl bg-gradient-to-r from-blue-950 via-slate-900 to-slate-950 text-white flex flex-col sm:flex-row items-center justify-between gap-4 border border-slate-800 shadow-md">
                    <div class="flex items-center gap-3 text-center sm:text-left">
                        <div
                            class="w-10 h-10 rounded-xl bg-blue-600/30 border border-blue-400/40 text-blue-300 flex items-center justify-center text-lg flex-shrink-0">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <div>
                            <h4 class="text-xs font-bold text-white leading-tight">100% Quality Assurance Certificate with
                                Every Device</h4>
                            <p class="text-[11px] text-slate-300">Each dispatched unit includes an individual technician
                                sign-off sheet and serial-linked warranty.</p>
                        </div>
                    </div>
                    <a href="{{ route('shop') }}" class="btn-base btn-primary btn-sm text-xs py-2 px-4 whitespace-nowrap">
                        Shop Tested Tech <i class="fa-solid fa-arrow-right ml-1 text-[10px]"></i>
                    </a>
                </div>
            </section>

            <!-- Our Commitments -->
            <section class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-16">
                <div class="card-base p-6">
                    <i class="fa-solid fa-hand-holding-heart text-blue-600 text-2xl mb-3"></i>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5 font-heading">No False Claims</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-body">We provide transparent condition grading and
                        clear warranty durations without confusing fine print.</p>
                </div>

                <div class="card-base p-6">
                    <i class="fa-solid fa-boxes-packing text-emerald-600 text-2xl mb-3"></i>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5 font-heading">Secure Packaging</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-body">Multi-layer bubble wrapping and reinforced
                        boxes ensure damage-free transit across India.</p>
                </div>

                <div class="card-base p-6">
                    <i class="fa-solid fa-headset text-purple-600 text-2xl mb-3"></i>
                    <h3 class="text-base font-bold text-slate-900 mb-1.5 font-heading">Dedicated Support</h3>
                    <p class="text-xs text-slate-600 leading-relaxed font-body">Our technical support team is available to
                        assist you before and after your device purchase.</p>
                </div>
            </section>

        </div>
    </main>

@endsection

@push('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            Components.renderHeader('about');
            Components.renderFooter();
        });
    </script>

@endpush