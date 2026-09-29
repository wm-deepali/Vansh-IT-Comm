/**
 * VANSH IT & COMM — MAIN APPLICATION CONTROLLER
 * Global search autocomplete, sticky headers, modals, toasts, form validation, and tracking simulator.
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
  // LIVE SEARCH & AUTOCOMPLETE
  // ==========================================
  handleLiveSearch(query, dropdownId = 'search-autocomplete-dropdown') {
    const dropdown = document.getElementById(dropdownId);
    if (!dropdown) return;

    const q = (query || '').trim().toLowerCase();
    if (q.length < 2) {
      dropdown.classList.remove('active');
      dropdown.innerHTML = '';
      return;
    }

    const matches = PRODUCTS_DATA.filter(p => {
      const name = (p.name || '').toLowerCase();
      const brand = (p.brand || '').toLowerCase();
      const proc = (p.processor || '').toLowerCase();
      const cat = (p.category || '').toLowerCase();
      const sub = (p.subcategory || '').toLowerCase();
      return name.includes(q) || brand.includes(q) || proc.includes(q) || cat.includes(q) || sub.includes(q);
    }).slice(0, 6);

    if (matches.length === 0) {
      dropdown.innerHTML = `
        <div class="p-4 text-center text-xs text-slate-500">
          No matching products found for "<strong class="text-slate-800">${query}</strong>".
        </div>
      `;
    } else {
      dropdown.innerHTML = `
        <div class="p-2 border-b border-slate-100 flex items-center justify-between text-[11px] font-bold text-slate-500 uppercase px-3">
          <span>Products (${matches.length})</span>
          <span>Press Enter to View All</span>
        </div>
        <div class="divide-y divide-slate-100">
          ${matches.map(p => `
            <a href="product.html?id=${p.id}" class="flex items-center gap-3 p-3 hover:bg-slate-50 transition-colors group text-decoration-none">
              <img src="${p.image}" alt="${p.name}" class="w-12 h-12 object-contain rounded-lg bg-slate-100 p-1 border border-slate-200 flex-shrink-0" />
              <div class="flex-1 min-w-0">
                <div class="text-xs font-bold text-slate-900 group-hover:text-blue-600 truncate">${p.name}</div>
                <div class="text-[11px] text-slate-500 flex items-center gap-2 mt-0.5">
                  <span class="badge ${ProductsEngine.getBadgeClass(p.badge || p.condition)} text-[9px] py-0 px-1.5">${p.condition}</span>
                  <span>${p.processor || p.storage || p.brand}</span>
                </div>
              </div>
              <div class="text-right flex-shrink-0">
                <div class="text-xs font-extrabold text-slate-900">${ProductsEngine.formatPrice(p.price)}</div>
                ${p.mrp ? `<div class="text-[10px] text-slate-400 line-through">${ProductsEngine.formatPrice(p.mrp)}</div>` : ''}
              </div>
            </a>
          `).join('')}
        </div>
        <div class="p-2.5 bg-slate-50 text-center border-t border-slate-100">
          <a href="shop.html?search=${encodeURIComponent(query)}" class="text-xs font-bold text-blue-600 hover:underline">
            View all results for "${query}" →
          </a>
        </div>
      `;
    }

    dropdown.classList.add('active');
  },

  handleSearchSubmit(event, formEl) {
    event.preventDefault();
    const input = formEl.querySelector('input[name="search"]');
    const q = input ? input.value.trim() : '';
    if (q) {
      window.location.href = `shop.html?search=${encodeURIComponent(q)}`;
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
        const searchBox = document.getElementById('search-autocomplete-dropdown');
        if (searchBox) searchBox.classList.remove('active');
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
