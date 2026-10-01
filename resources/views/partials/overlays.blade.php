{{-- resources/views/partials/overlays.blade.php : mobile drawer, bottom nav, modals, floating buttons --}}
@php
    $activePage = $activePage ?? '';
    $isCustomer = auth('customer')->check();

    // POST targets for the modal. Same URI as the GET pages by default —
    // change these two if your POST routes use different URLs.
    $loginUrl = route('user.login');
    $registerUrl = Route::has('user.register') ? route('user.register') : url('/register');
    $googleUrl = Route::has('user.google') ? route('user.google') : null; // set to your Google redirect route name

    $drawerLinks = [
        ['home', 'home', 'fa-house', 'text-slate-400', 'Home'],
        ['categories', 'categories', 'fa-layer-group', 'text-blue-600', 'All Categories Hub'],
        ['shop', 'shop', 'fa-store', 'text-slate-400', 'All Products Catalog'],
        ['laptops', 'laptops', 'fa-laptop', 'text-slate-400', 'Refurbished Laptops'],
        ['mobile-phones', 'mobiles', 'fa-mobile-screen-button', 'text-slate-400', 'Mobile Phones'],
        ['accessories', 'accessories', 'fa-headphones', 'text-slate-400', 'Computer Accessories'],
        ['repair', 'repair', 'fa-wrench', 'text-blue-600', 'Repair Services'],
        ['exchange', 'exchange', 'fa-rotate', 'text-emerald-600', 'Exchange & Upgrade'],
        ['blog', 'blog', 'fa-newspaper', 'text-slate-400', 'Tech Blog & Guides'],
        ['about', 'about', 'fa-circle-info', 'text-slate-400', 'About Us & 20-Pt Testing'],
        ['contact', 'contact', 'fa-headset', 'text-slate-400', 'Contact Support'],
        ['faq', null, 'fa-circle-question', 'text-slate-400', 'Frequently Asked Questions'],
        ['terms', null, 'fa-shield-halved', 'text-slate-400', 'Terms & Store Policies'],
    ];

    $bottomLinks = [
        ['home', 'home', 'fa-solid fa-house', 'Home', null],
        ['categories', 'categories', 'fa-solid fa-layer-group', 'Categories', null],
        ['shop', 'shop', 'fa-solid fa-magnifying-glass', 'Search', null],
        ['wishlist', 'wishlist', 'fa-regular fa-heart', 'Wishlist', 'wishlist-count-badge bg-red-500'],
        ['cart', 'cart', 'fa-solid fa-cart-shopping', 'Cart', 'bg-blue-600'],
    ];

    $inputCls = 'w-full border border-slate-200 rounded-xl px-3.5 py-2.5 text-xs text-slate-800 focus:outline-none focus:border-blue-600';
@endphp

{{-- Mobile Drawer --}}
<div id="mobile-drawer" class="mobile-drawer-wrapper">
    <div class="mobile-drawer-backdrop" onclick="App.closeMobileDrawer()"></div>
    <div class="mobile-drawer-panel p-5">
        <div class="flex items-center justify-between pb-4 border-b border-slate-100 mb-4">
            <a href="{{ route('home') }}" onclick="App.closeMobileDrawer()">
                <img src="{{ asset('assets/img/vanshitcomm-logo.png') }}" alt="VANSH IT & COMM" class="h-9 w-auto object-contain" />
            </a>
            <button type="button" onclick="App.closeMobileDrawer()" class="w-8 h-8 rounded-full bg-slate-100 hover:bg-slate-200 text-slate-600 flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form action="{{ route('shop') }}" method="GET" class="mb-5 relative" onsubmit="App.closeMobileDrawer()">
            <input type="text" name="search" placeholder="Search laptops, phones, parts..."
                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-9 pr-3 py-2 text-xs text-slate-800 focus:outline-none focus:border-blue-600" />
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-2.5 text-slate-400 text-xs"></i>
        </form>

        <nav class="space-y-1 text-xs font-semibold text-slate-700 flex-1">
            @foreach ($drawerLinks as [$routeName, $key, $icon, $iconColor, $label])
                <a href="{{ Route::has($routeName) ? route($routeName) : '#' }}"
                   class="flex items-center gap-3 p-2.5 rounded-xl hover:bg-slate-50 transition-colors {{ $key && $activePage === $key ? 'bg-blue-50 text-blue-600 font-bold' : '' }}">
                    <i class="fa-solid {{ $icon }} w-4 text-center {{ $iconColor }}"></i> {{ $label }}
                </a>
            @endforeach
        </nav>

        <div class="pt-4 border-t border-slate-100 space-y-2 mt-4">
            <a href="{{ route('contact') }}" class="btn-base btn-secondary btn-sm w-full text-xs py-2 justify-center font-bold">
                <i class="fa-solid fa-headset text-blue-600 mr-1.5"></i> Customer Desk
            </a>

            @if ($isCustomer)
                <a href="{{ route('user.account') }}" class="btn-base btn-primary btn-sm w-full text-xs py-2 justify-center font-bold">
                    <i class="fa-regular fa-user mr-1.5"></i> My Account
                </a>
            @else
                <button type="button" onclick="App.closeMobileDrawer(); App.openModal('auth-modal');" class="btn-base btn-primary btn-sm w-full text-xs py-2 justify-center font-bold">
                    <i class="fa-regular fa-user mr-1.5"></i> Login / Register
                </button>
            @endif
        </div>
    </div>
</div>

{{-- Mobile Bottom Nav --}}
<div class="mobile-bottom-nav">
    @foreach ($bottomLinks as [$routeName, $key, $icon, $label, $badge])
        <a href="{{ route($routeName) }}"
           class="flex flex-col items-center justify-center flex-1 py-1 text-center {{ $badge ? 'relative' : '' }} {{ $activePage === $key ? 'text-blue-600 font-bold' : 'text-slate-500 hover:text-slate-800' }}">
            @if ($routeName === 'cart')
                @php $n = (int) ($cartCount ?? 0); @endphp
                <div class="relative inline-block">
                    <i class="{{ $icon }} text-base"></i>
                    <span data-cart-count
                        class="{{ $badge }} absolute -top-1.5 -right-2.5 min-w-[14px] h-3.5 px-0.5 rounded-full text-white text-[9px] font-bold flex items-center justify-center {{ $n > 0 ? '' : 'hidden' }}">{{ $n > 99 ? '99+' : $n }}</span>
                </div>
            @elseif ($badge)
                <div class="relative inline-block">
                    <i class="{{ $icon }} text-base"></i>
                    <span class="{{ $badge }} absolute -top-1.5 -right-2.5 w-3.5 h-3.5 rounded-full text-white text-[9px] font-bold items-center justify-center hidden">0</span>
                </div>
            @else
                <i class="{{ $icon }} text-base"></i>
            @endif
            <span class="text-[10px] mt-0.5">{{ $label }}</span>
        </a>
    @endforeach
</div>

{{-- Quick View Modal --}}
<div id="quick-view-modal" class="modal-wrapper">
    <div class="modal-backdrop" onclick="App.closeModal('quick-view-modal')"></div>
    <div class="modal-box" id="quick-view-modal-content"></div>
</div>

{{-- Auth Modal (guests only) --}}
@unless ($isCustomer)
<div id="auth-modal" class="modal-wrapper">
    <div class="modal-backdrop" onclick="App.closeModal('auth-modal')"></div>
    <div class="modal-box max-w-md p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex items-center justify-between border-b border-slate-100 pb-3 mb-4">
            <img src="{{ asset('assets/img/vanshitcomm-logo.png') }}" alt="VANSH IT & COMM" class="h-8 w-auto object-contain" />
            <button type="button" onclick="App.closeModal('auth-modal')" class="text-slate-400 hover:text-slate-700">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <div class="grid grid-cols-2 gap-2 p-1 bg-slate-100 rounded-xl mb-4 text-xs font-bold text-center">
            <button type="button" id="tab-login-btn" onclick="App.switchAuthTab('login')" class="py-2 rounded-lg bg-white shadow-sm text-blue-600">Login</button>
            <button type="button" id="tab-signup-btn" onclick="App.switchAuthTab('signup')" class="py-2 rounded-lg text-slate-600">Create Account</button>
        </div>

        {{-- Login --}}
        <form id="form-login" class="space-y-3" onsubmit="Auth.submit(event, 'login')" novalidate>
            <div data-form-error class="hidden text-[11px] text-red-600 bg-red-50 border border-red-100 rounded-lg px-3 py-2"></div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" required autocomplete="email" placeholder="name@example.com" class="{{ $inputCls }}" />
                <p data-error="email" class="hidden text-[11px] text-red-500 mt-1"></p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Password</label>
                <input type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="{{ $inputCls }}" />
                <p data-error="password" class="hidden text-[11px] text-red-500 mt-1"></p>
            </div>
            <label class="flex items-center gap-2 text-[11px] text-slate-600 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded text-blue-600" /> Remember me
            </label>
            <button type="submit" class="btn-base btn-primary w-full text-xs font-semibold py-2.5 justify-center">Login to Account</button>
        </form>

        {{-- Sign up --}}
        <form id="form-signup" class="space-y-3 hidden" onsubmit="Auth.submit(event, 'register')" novalidate>
            <div data-form-error class="hidden text-[11px] text-red-600 bg-red-50 border border-red-100 rounded-lg px-3 py-2"></div>

            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Full Name</label>
                <input type="text" name="name" required autocomplete="name" placeholder="Your full name" class="{{ $inputCls }}" />
                <p data-error="name" class="hidden text-[11px] text-red-500 mt-1"></p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Email Address</label>
                <input type="email" name="email" required autocomplete="email" placeholder="name@example.com" class="{{ $inputCls }}" />
                <p data-error="email" class="hidden text-[11px] text-red-500 mt-1"></p>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Mobile Number</label>
                    <input type="tel" name="mobile" required maxlength="10" autocomplete="tel" placeholder="10-digit mobile" class="{{ $inputCls }}" />
                    <p data-error="mobile" class="hidden text-[11px] text-red-500 mt-1"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-700 mb-1">Alternate <span class="font-normal text-slate-400">(optional)</span></label>
                    <input type="tel" name="alternate_mobile" maxlength="10" placeholder="10-digit mobile" class="{{ $inputCls }}" />
                    <p data-error="alternate_mobile" class="hidden text-[11px] text-red-500 mt-1"></p>
                </div>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Create Password</label>
                <input type="password" name="password" required autocomplete="new-password" placeholder="Minimum 8 characters" class="{{ $inputCls }}" />
                <p data-error="password" class="hidden text-[11px] text-red-500 mt-1"></p>
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter password" class="{{ $inputCls }}" />
            </div>
            <button type="submit" class="btn-base btn-primary w-full text-xs font-semibold py-2.5 justify-center">Register Account</button>
        </form>

        @if ($googleUrl)
            <div class="flex items-center gap-3 my-4 text-[11px] text-slate-400">
                <span class="flex-1 h-px bg-slate-200"></span> or <span class="flex-1 h-px bg-slate-200"></span>
            </div>
            <a href="{{ $googleUrl }}" data-google-login
               class="btn-base btn-secondary w-full text-xs font-semibold py-2.5 justify-center">
                <i class="fa-brands fa-google mr-2 text-red-500"></i> Continue with Google
            </a>
        @endif
    </div>
</div>

<script>
    const Auth = {
        redirect: null,           // set when a [data-requires-login] link opens the modal
        csrf: @json(csrf_token()),
        urls: { login: @json($loginUrl), register: @json($registerUrl) },

        setErrors(form, errors = {}, message = '') {
            form.querySelectorAll('[data-error]').forEach(p => { p.textContent = ''; p.classList.add('hidden'); });

            const top = form.querySelector('[data-form-error]');
            top.textContent = message;
            top.classList.toggle('hidden', !message);

            Object.entries(errors).forEach(([field, msgs]) => {
                const p = form.querySelector(`[data-error="${field}"]`);
                if (p) { p.textContent = msgs[0]; p.classList.remove('hidden'); }
            });
        },

        async submit(e, type) {
            e.preventDefault();
            const form = e.target;
            const btn = form.querySelector('button[type="submit"]');
            const label = btn.textContent;

            const body = Object.fromEntries(new FormData(form).entries());
            body.remember = form.querySelector('[name="remember"]')?.checked ? 1 : 0;
            body.redirect = this.redirect || window.location.href;

            this.setErrors(form);
            btn.disabled = true;
            btn.classList.add('opacity-70');
            btn.textContent = 'Please wait...';

            try {
                const res = await fetch(this.urls[type], {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': this.csrf,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: JSON.stringify(body),
                });
                const data = await res.json().catch(() => ({}));

                if (res.ok && data.status) {
                    window.location.assign(data.redirect || window.location.href);
                    return;
                }

                if (res.status === 422 && data.errors) {
                    this.setErrors(form, data.errors);
                } else if (res.status === 419) {
                    this.setErrors(form, {}, 'Your session expired. Please refresh the page and try again.');
                } else {
                    this.setErrors(form, {}, data.message || 'Something went wrong. Please try again.');
                }
            } catch (err) {
                this.setErrors(form, {}, 'Network error. Please check your connection and try again.');
            }

            btn.disabled = false;
            btn.classList.remove('opacity-70');
            btn.textContent = label;
        },
    };

    // Any link/button with data-requires-login opens the modal for guests,
    // then sends them to that link's URL after a successful login.
    document.addEventListener('click', e => {
        const el = e.target.closest('[data-requires-login]');
        if (el) {
            e.preventDefault();
            Auth.redirect = el.getAttribute('href') || null;
            App.openModal('auth-modal');
            return;
        }

        // Google login returns to the page the customer was on
        const g = e.target.closest('[data-google-login]');
        if (g) {
            const url = new URL(g.href, window.location.origin);
            url.searchParams.set('redirect', Auth.redirect || window.location.href);
            g.href = url.toString();
        }
    });
</script>
@endunless

<div id="toast-container" aria-live="polite"></div>

{{-- Floating Buttons --}}
<div class="floating-btn-group">
    <a href="#" class="floating-btn floating-whatsapp" title="Chat with VANSH IT & COMM" aria-label="Chat on WhatsApp"
        onclick="event.preventDefault(); showToast('WhatsApp support link will be connected to store phone number.', 'info');">
        <i class="fa-brands fa-whatsapp text-2xl"></i>
    </a>
    <button type="button" id="back-to-top-btn" class="floating-btn floating-back-to-top"
        onclick="window.scrollTo({top: 0, behavior: 'smooth'})" aria-label="Back to Top">
        <i class="fa-solid fa-arrow-up text-lg"></i>
    </button>
</div>