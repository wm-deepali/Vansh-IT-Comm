/**
 * VANSH IT & COMM — WISHLIST MODULE
 * Handles localStorage state ('vansh_wishlist'), toggles, and UI badge updates.
 */

const Wishlist = {
  KEY: 'vansh_wishlist',

  getItems() {
    try {
      const items = localStorage.getItem(this.KEY);
      return items ? JSON.parse(items) : [];
    } catch (e) {
      console.error('Error reading wishlist from localStorage', e);
      return [];
    }
  },

  saveItems(items) {
    try {
      localStorage.setItem(this.KEY, JSON.stringify(items));
      this.updateBadges();
      this.syncHeartIcons();
      window.dispatchEvent(new CustomEvent('wishlistUpdated', { detail: items }));
    } catch (e) {
      console.error('Error saving wishlist to localStorage', e);
    }
  },

  hasItem(productId) {
    const items = this.getItems();
    return items.includes(productId);
  },

  toggleItem(productId) {
    let items = this.getItems();
    const product = PRODUCTS_DATA.find(p => p.id === productId);
    const exists = items.includes(productId);

    if (exists) {
      items = items.filter(id => id !== productId);
      this.saveItems(items);
      if (typeof showToast === 'function') {
        showToast(`Removed "${product ? product.name : 'Item'}" from wishlist`, 'info');
      }
    } else {
      items.push(productId);
      this.saveItems(items);
      if (typeof showToast === 'function') {
        showToast(`Added "${product ? product.name : 'Item'}" to wishlist!`, 'success');
      }
    }
    return !exists;
  },

  removeItem(productId) {
    let items = this.getItems();
    items = items.filter(id => id !== productId);
    this.saveItems(items);
    if (typeof showToast === 'function') {
      showToast('Removed item from wishlist', 'info');
    }
  },

  getCount() {
    return this.getItems().length;
  },

  updateBadges() {
    const count = this.getCount();
    const badgeElements = document.querySelectorAll('.wishlist-count-badge');
    badgeElements.forEach(el => {
      el.textContent = count;
      if (count > 0) {
        el.classList.remove('hidden');
        el.classList.add('inline-flex');
      } else {
        el.classList.add('hidden');
        el.classList.remove('inline-flex');
      }
    });
  },

  syncHeartIcons() {
    const items = this.getItems();
    const buttons = document.querySelectorAll('[data-wishlist-btn]');
    buttons.forEach(btn => {
      const pid = btn.getAttribute('data-wishlist-btn');
      if (items.includes(pid)) {
        btn.classList.add('active');
        btn.setAttribute('aria-label', 'Remove from wishlist');
      } else {
        btn.classList.remove('active');
        btn.setAttribute('aria-label', 'Add to wishlist');
      }
    });
  }
};

// Initialize Wishlist on DOM ready
document.addEventListener('DOMContentLoaded', () => {
  Wishlist.updateBadges();
  Wishlist.syncHeartIcons();
});
