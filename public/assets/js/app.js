/**
 * VANSH IT & COMM — MAIN APPLICATION CONTROLLER
 * Global search autocomplete (server-side), sticky headers, modals, toasts, form validation, and tracking simulator.
 *
 * Needs two globals printed by partials/header.blade.php:
 *   window.SEARCH_SUGGEST_URL  -> route('search.suggest')
 *   window.SEARCH_SHOP_URL     -> route('shop')
 */

const App = {
  init() {
    this.bindScrollEvents();
    this.bindGlobalShortcuts();
    this.closeSearchOnClickOutside();
  },

  // ==========================================
  // TOAST NOTIFICATIONS
  // ==========================================
  showToast(message, type = 'info') {
    const container = document.getElementById('toast-container');
    if (!container) return;

    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;

    let icon = '<i class="fa-solid fa-circle-info text-blue-400"></i>';
    if (type === 'success') icon = '<i class="fa-solid fa-circle-check text-emerald-400"></i>';
    if (type === 'error') icon = '<i class="fa-solid fa-triangle-exclamation text-red-400"></i>';

    toast.innerHTML = `
      ${icon}
      <span class="flex-1 text-xs leading-snug">${message}</span>
      <button type="button" class="text-slate-400 hover:text-white ml-2 text-sm" onclick="this.parentElement.remove()">&times;</button>
    `;

    container.appendChild(toast);

    setTimeout(() => {
      if (toast.parentElement) {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(50px)';
        toast.style.transition = 'all 0.3s ease';
        setTimeout(() => toast.remove(), 300);
      }
    }, 3500);
  },

  // ==========================================
  // MODALS
  // ==========================================
  openModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.add('open');
    document.body.style.overflow = 'hidden';
  },

  closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (!modal) return;
    modal.classList.remove('open');
    document.body.style.overflow = '';
  },

  // ==========================================
  // MOBILE NAVIGATION DRAWER
  // ==========================================
  openMobileDrawer() {
    const drawer = document.getElementById('mobile-drawer');
    if (drawer) {
      drawer.classList.add('open');
      document.body.style.overflow = 'hidden';
    }
  },

  closeMobileDrawer() {
    const drawer = document.getElementById('mobile-drawer');
    if (drawer) {
      drawer.classList.remove('open');
      document.body.style.overflow = '';
    }
  },

  toggleDrawerAccordion(accordionId) {
    const acc = document.getElementById(accordionId);
    const icon = document.getElementById(`${accordionId}-icon`);
    if (!acc) return;
    acc.classList.toggle('hidden');
    if (icon) {
      icon.classList.toggle('rotate-180');
    }
  },

  toggleMobileSearch() {
    const searchBar = document.getElementById('mobile-search-bar');
    if (searchBar) {
      searchBar.classList.toggle('hidden');
      if (!searchBar.classList.contains('hidden')) {
        const input = searchBar.querySelector('input');
        if (input) input.focus();
      }
    }
  },

  // ==========================================
  // LIVE SEARCH & AUTOCOMPLETE (server-side)
  // ==========================================
  _searchTimer: null,
  _searchAbort: null,

  // Escape anything that is printed into innerHTML
  esc(s) {
    return String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
  },

  conditionBadge(cond) {
    return {
      'New': 'bg-emerald-50 text-emerald-700',
      'Refurbished': 'bg-blue-50 text-blue-700',
      'Open Box': 'bg-amber-50 text-amber-800',
    }[cond] || 'bg-slate-100 text-slate-600';
  },

  handleLiveSearch(query, dropdownId = 'search-autocomplete-dropdown') {
    const dropdown = document.getElementById(dropdownId);
    if (!dropdown) return;

    const q = (query || '').trim();
    clearTimeout(this._searchTimer);
    if (this._searchAbort) this._searchAbort.abort();

    if (q.length < 2) {
      dropdown.classList.remove('active');
      dropdown.innerHTML = '';
      return;
    }

    // wait for a short pause in typing before hitting the server
    this._searchTimer = setTimeout(() => this.fetchSuggestions(q, dropdown), 250);
  },

  async fetchSuggestions(q, dropdown) {
    this._searchAbort = new AbortController();

    try {
      const res = await fetch(`${window.SEARCH_SUGGEST_URL}?q=${encodeURIComponent(q)}`, {
        headers: { 'Accept': 'application/json' },
        signal: this._searchAbort.signal,
      });
      if (!res.ok) throw new Error('Search failed');

      const data = await res.json();
      this.renderSuggestions(q, data, dropdown);
    } catch (err) {
      if (err.name === 'AbortError') return;   // a newer keystroke replaced this request
      dropdown.innerHTML = '<div class="p-4 text-center text-xs text-slate-500">Search is unavailable right now.</div>';
      dropdown.classList.add('active');
    }
  },

  renderSuggestions(q, data, dropdown) {
    const e = s => this.esc(s);
    const list = data.products || [];
    const allUrl = `${window.SEARCH_SHOP_URL}?search=${encodeURIComponent(q)}`;

    if (!list.length) {
      dropdown.innerHTML = `
        <div class="p-4 text-center text-xs text-slate-500">
          No matching products found for "<strong class="text-slate-800">${e(q)}</strong>".
        </div>`;
    } else {
      dropdown.innerHTML = `
        <div class="p-2 border-b border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-500 uppercase px-3">
          <span>Products (${e(data.total)})</span>
          <span>Press Enter to View All</span>
        </div>
        <div class="divide-y divide-slate-100">
          ${list.map(p => `
            <a href="${e(p.url)}" class="flex items-center gap-3 p-3 hover:bg-slate-50 transition-colors group text-decoration-none">
              ${p.image
          ? `<img src="${e(p.image)}" alt="${e(p.name)}" loading="lazy" class="w-12 h-12 object-contain rounded-lg bg-slate-100 p-1 border border-slate-200 flex-shrink-0" />`
          : `<div class="w-12 h-12 rounded-lg bg-slate-100 border border-slate-200 flex-shrink-0"></div>`}
              <div class="flex-1 min-w-0">
                <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 truncate">${e(p.name)}</div>
                <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                  ${p.badge
          ? `<span class="badge ${p.badgeColor ? '' : 'badge-tested'} text-[9px] py-0 px-1.5"
                         ${p.badgeColor ? `style="background-color:${e(p.badgeColor)};color:#fff;"` : ''}>${e(p.badge)}</span>`
          : ''}
                  <span class="truncate">${e(p.brand || '')}</span>
                </div>
              </div>
              <div class="text-right flex-shrink-0">
                <div class="text-xs font-extrabold text-slate-900">${e(p.price)}</div>
                ${p.mrp ? `<div class="text-[10px] text-slate-400 line-through">${e(p.mrp)}</div>` : ''}
              </div>
            </a>`).join('')}
        </div>
        <div class="p-2.5 bg-slate-50 text-center border-t border-slate-100">
          <a href="${e(allUrl)}" class="text-xs font-bold text-blue-600 hover:underline">
            View all ${e(data.total)} results for "${e(q)}" →
          </a>
        </div>`;
    }

    dropdown.classList.add('active');
  },

  handleSearchSubmit(event, formEl) {
    event.preventDefault();
    const input = formEl.querySelector('input[name="search"]');
    const q = input ? input.value.trim() : '';
    if (q) {
      window.location.href = `${window.SEARCH_SHOP_URL}?search=${encodeURIComponent(q)}`;
    }
  },

  closeSearchOnClickOutside() {
    document.addEventListener('click', (e) => {
      const desktopSearchBox = document.getElementById('search-autocomplete-dropdown');
      const desktopSearchInput = document.getElementById('header-search-input');
      if (desktopSearchBox && !desktopSearchBox.contains(e.target) && e.target !== desktopSearchInput) {
        desktopSearchBox.classList.remove('active');
      }

      const mobileSearchBox = document.getElementById('mobile-search-autocomplete-dropdown');
      const mobileSearchInput = document.getElementById('mobile-header-search-input');
      if (mobileSearchBox && !mobileSearchBox.contains(e.target) && e.target !== mobileSearchInput) {
        mobileSearchBox.classList.remove('active');
      }
    });
  },

  // ==========================================
  // SCROLL BEHAVIOR & BACK TO TOP
  // ==========================================
  bindScrollEvents() {
    const mainHeader = document.getElementById('main-header');
    const backToTopBtn = document.getElementById('back-to-top-btn');

    window.addEventListener('scroll', () => {
      const scrollPos = window.scrollY || document.documentElement.scrollTop;

      if (mainHeader) {
        if (scrollPos > 40) {
          mainHeader.classList.add('header-scrolled');
        } else {
          mainHeader.classList.remove('header-scrolled');
        }
      }

      if (backToTopBtn) {
        if (scrollPos > 350) {
          backToTopBtn.classList.add('visible');
        } else {
          backToTopBtn.classList.remove('visible');
        }
      }
    }, { passive: true });
  },

  bindGlobalShortcuts() {
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        const openModals = document.querySelectorAll('.modal-wrapper.open');
        openModals.forEach(m => m.classList.remove('open'));
        App.closeMobileDrawer();
        ['search-autocomplete-dropdown', 'mobile-search-autocomplete-dropdown'].forEach(id => {
          const box = document.getElementById(id);
          if (box) box.classList.remove('active');
        });
        document.body.style.overflow = '';
      }
    });
  },

  // ==========================================
  // AUTH DEMO HANDLERS
  // ==========================================
  switchAuthTab(tab) {
    const loginForm = document.getElementById('form-login');
    const signupForm = document.getElementById('form-signup');
    const loginBtn = document.getElementById('tab-login-btn');
    const signupBtn = document.getElementById('tab-signup-btn');

    if (tab === 'login') {
      loginForm.classList.remove('hidden');
      signupForm.classList.add('hidden');
      loginBtn.className = 'py-2 rounded-lg bg-white shadow-sm text-blue-600';
      signupBtn.className = 'py-2 rounded-lg text-slate-600';
    } else {
      loginForm.classList.add('hidden');
      signupForm.classList.remove('hidden');
      signupBtn.className = 'py-2 rounded-lg bg-white shadow-sm text-blue-600';
      loginBtn.className = 'py-2 rounded-lg text-slate-600';
    }
  },

  handleAuthSubmit(event, type) {
    event.preventDefault();
    this.closeModal('auth-modal');
    this.showToast(type === 'login' ? 'Successfully logged in (Demo Mode)!' : 'Account registered successfully (Demo Mode)!', 'success');
  },

  handleNewsletter(event, formEl) {
    event.preventDefault();
    formEl.reset();
    this.showToast('Thank you for subscribing to VANSH IT & COMM updates!', 'success');
  },

  // ==========================================
  // URL QUERY HELPER
  // ==========================================
  getUrlParams() {
    const params = new URLSearchParams(window.location.search);
    const result = {};
    for (const [key, value] of params.entries()) {
      result[key] = value;
    }
    return result;
  },

  // ==========================================
  // ORDER ID GENERATOR & DEMO CHECKOUT
  // ==========================================
  generateOrderId() {
    const rand = Math.floor(1000 + Math.random() * 9000);
    return `VIC2026-${rand}`;
  }
};

// Global helper for toast
function showToast(message, type = 'info') {
  App.showToast(message, type);
}

document.addEventListener('DOMContentLoaded', () => {
  App.init();
});