<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title', 'VANSH IT & COMM — Buy Smart. Upgrade Better.')</title>
    <meta name="description"
        content="@yield('meta_description', 'India\'s trusted destination for tested refurbished & new laptops, smartphones, computer accessories, and expert device repair services.')" />

    <!-- Favicon / Icons -->
    <link rel="icon" type="image/png" href="{{ asset('assets/img/vanshitcomm-logo.png')}}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2563EB',
                        dark: '#0B1220',
                        success: '#22C55E'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                        heading: ['Manrope', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    @stack('styles')

</head>

<body class="bg-[#F8FAFC] text-[#0F172A] flex flex-col min-h-screen">

    <!-- Header Placeholder -->
    <div id="site-header"></div>


    @yield('content')


    <!-- Footer Placeholder -->
    <div id="site-footer"></div>

    <!-- JavaScript Modules -->
    <script>
        window.ASSET_BASE = "{{ asset('assets') }}";
        window.SITE_URL = "{{ url('/') }}";
    </script>
    <script src="{{ asset('assets/js/data.js') }}"></script>
    <script src="{{ asset('assets/js/cart.js') }}"></script>
    <script src="{{ asset('assets/js/wishlist.js') }}"></script>
    <script src="{{ asset('assets/js/products.js') }}"></script>
    <script src="{{ asset('assets/js/components.js') }}"></script>
    <script src="{{ asset('assets/js/app.js') }}"></script>

    @stack('scripts')


</body>

</html>