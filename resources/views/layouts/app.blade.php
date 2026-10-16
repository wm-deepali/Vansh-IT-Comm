{{-- resources/views/layouts/app.blade.php --}}
@php
    $activePage = trim($__env->yieldContent('active_page'));

    // Admin-managed SEO (Product / Category / Blog / DynamicPage / SeoPage record, ya null)
    $seo = getSeo();

    // @section values already escaped hote hain → decode, taaki {{ }} sirf ek baar escape kare
    $section = fn ($name) => html_entity_decode(trim($__env->yieldContent($name)), ENT_QUOTES);

    $siteName = 'VANSH IT & COMM';
    $defaultTitle = 'VANSH IT & COMM — Buy Smart. Upgrade Better.';
    $defaultDescription = "India's trusted destination for tested refurbished & new laptops, smartphones, computer accessories, and expert device repair services.";

    $metaTitle = filled($seo?->meta_title) ? $seo->meta_title : ($section('title') ?: $defaultTitle);
    $metaDescription = filled($seo?->meta_description) ? $seo->meta_description : ($section('meta_description') ?: $defaultDescription);

    // Canonical: query (filters/sort/page) hata di jati hai; policies me tab rakhna zaroori hai
    $canonical = url()->current();
    if (request()->routeIs('policies') && request()->filled('tab')) {
        $canonical .= '?tab=' . urlencode(request()->query('tab'));
    }

    // OG image: page ka @section('og_image') → default (1200×630) → logo
    $defaultOg = file_exists(public_path('assets/img/og-default.jpg'))
        ? asset('assets/img/og-default.jpg')
        : asset('assets/img/vanshitcomm-logo.png');
    $ogImage = $section('og_image') ?: $defaultOg;
    if (!\Illuminate\Support\Str::startsWith($ogImage, ['http://', 'https://'])) {
        $ogImage = url($ogImage);
    }
    $ogType = $section('og_type') ?: 'website';

    // Private / thin pages Google me index na ho
    $robots = (request()->routeIs('cart', 'wishlist', 'checkout', 'order.success', 'user.*')
        || (request()->routeIs('shop') && request()->filled('search')))
        ? 'noindex, follow' : 'index, follow';

    // Sirf home par: Organization + WebSite (sitelinks search box)
    $homeSchemas = [];
    if (request()->routeIs('home')) {
        $homeSchemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName,
            'url' => url('/'),
            'logo' => asset('assets/img/vanshitcomm-logo.png'),
        ];
        $homeSchemas[] = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/shop') . '?search={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }
@endphp

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $metaTitle }}</title>
    <meta name="description" content="{{ $metaDescription }}" />
    <meta name="robots" content="{{ $robots }}" />
    <link rel="canonical" href="{{ $canonical }}" />

    {{-- Open Graph / Twitter --}}
    <meta property="og:locale" content="en_IN" />
    <meta property="og:type" content="{{ $ogType }}" />
    <meta property="og:site_name" content="VANSH IT &amp; COMM" />
    <meta property="og:title" content="{{ $metaTitle }}" />
    <meta property="og:description" content="{{ $metaDescription }}" />
    <meta property="og:url" content="{{ $canonical }}" />
    <meta property="og:image" content="{{ $ogImage }}" />
    <meta property="og:image:alt" content="{{ $metaTitle }}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="{{ $metaTitle }}" />
    <meta name="twitter:description" content="{{ $metaDescription }}" />
    <meta name="twitter:image" content="{{ $ogImage }}" />
    @stack('meta')

    {{-- JSON-LD --}}
    @foreach($homeSchemas as $schema)
        @include('partials.json-ld', ['data' => $schema])
    @endforeach
    @stack('schema')

    <link rel="icon" type="image/png" href="{{ asset('assets/img/vanshitcomm-logo.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: { primary: '#2563EB', dark: '#0B1220', success: '#22C55E' },
                    fontFamily: { sans: ['Inter', 'sans-serif'], heading: ['Manrope', 'sans-serif'] }
                }
            }
        }
    </script>

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    @stack('styles')

    @include('layouts.tracking-head')

</head>

<body class="bg-[#F8FAFC] text-[#0F172A] flex flex-col min-h-screen">

    @include('layouts.tracking-body-top')

    <div id="site-header">
        @include('partials.header', ['activePage' => $activePage])
    </div>

    @yield('content')

    <div id="site-footer">
        @include('partials.footer')
    </div>

    <script>
        window.ASSET_BASE = "{{ asset('assets') }}";
        window.SITE_URL = "{{ url('/') }}";
        function fireTrackingEvents(events) {
            if (!events) return;

            if (events.ga4 && typeof gtag === 'function') {
                gtag('event', events.ga4.name, events.ga4.params);
            }

            if (events.meta && typeof fbq === 'function') {
                fbq('track', events.meta.name, events.meta.params);
            }
        }
    </script>
    @if (session('fire_login_event'))
        <script>fireTrackingEvents(@json(\App\Services\Tracking\PixelTracker::loginEvent()));</script>
    @endif

    @if (session('fire_signup_event'))
        <script>fireTrackingEvents(@json(\App\Services\Tracking\PixelTracker::signUpEvent(session('fire_signup_event'))));</script>
    @endif
    <script src="{{ asset('assets/js/data.js') }}"></script>
    <script src="{{ asset('assets/js/wishlist.js') }}"></script>
    <script src="{{ asset('assets/js/products.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('scripts')

    @include('layouts.tracking-body-bottom')

</body>

</html>