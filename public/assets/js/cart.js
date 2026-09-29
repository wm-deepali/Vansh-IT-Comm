/**
 * VANSH IT & COMM — CART MODULE
 * Handles localStorage state ('vansh_cart'), item mutations, discounts, and real-time UI synchronization.
 */

const Cart = {
  KEY: 'vansh_cart',
  COUPON_KEY: 'vansh_applied_coupon',

  getItems() {
    try {
      const items = localStorage.getItem(this.KEY);
      return items ? JSON.parse(items) : [];
    } catch (e) {
      console.error('Error reading cart from localStorage', e);
      return [];
    }
  },

  saveItems(items) {
    try {
      localStorage.setItem(this.KEY, JSON.stringify(items));
      this.updateBadges();
      window.dispatchEvent(new CustomEvent('cartUpdated', { detail: items }));
    } catch (e) {
      console.error('Error saving cart to localStorage', e);
    }
  },

  addItem(productId, quantity = 1) {
    const product = PRODUCTS_DATA.find(p => p.id === productId);
    if (!product) {
      if (typeof showToast === 'function') showToast('Product not found', 'error');
      return;
    }

    const items = this.getItems();
    const existingIndex = items.findIndex(item => item.id === productId);

    if (existingIndex > -1) {
      items[existingIndex].quantity += quantity;
    } else {
      items.push({
        id: product.id,
        name: product.name,
        price: product.price,
        mrp: product.mrp,
        image: product.image,
        condition: product.condition,
        warranty: product.warranty,
        category: product.category,
        quantity: quantity
      });
    }

    this.saveItems(items);
    if (typeof showToast === 'function') {
      showToast(`"${product.name}" added to cart!`, 'success');
    }
  },

  removeItem(productId) {
    let items = this.getItems();
    const itemToRemove = items.find(i => i.id === productId);
    items = items.filter(item => item.id !== productId);
    this.saveItems(items);
    if (typeof showToast === 'function' && itemToRemove) {
      showToast(`Removed "${itemToRemove.name}" from cart`, 'info');
    }
  },

  updateQuantity(productId, delta) {
    const items = this.getItems();
    const item = items.find(i => i.id === productId);
    if (!item) return;

    item.quantity += delta;
    if (item.quantity <= 0) {
      this.removeItem(productId);
    } else {
      this.saveItems(items);
    }
  },

  setQuantity(productId, qty) {
    const items = this.getItems();
    const item = items.find(i => i.id === productId);
    if (!item) return;

    const parsedQty = parseInt(qty, 10);
    if (isNaN(parsedQty) || parsedQty <= 0) {
      this.removeItem(productId);
    } else {
      item.quantity = parsedQty;
      this.saveItems(items);
    }
  },

  clearCart() {
    localStorage.removeItem(this.KEY);
    localStorage.removeItem(this.COUPON_KEY);
    this.updateBadges();
    window.dispatchEvent(new CustomEvent('cartUpdated', { detail: [] }));
  },

  getCount() {
    const items = this.getItems();
    return items.reduce((total, item) => total + item.quantity, 0);
  },

  getAppliedCoupon() {
    try {
      const c = localStorage.getItem(this.COUPON_KEY);
      return c ? JSON.parse(c) : null;
    } catch (e) {
      return null;
    }
  },

  applyCoupon(code) {
    const cleanCode = (code || '').trim().toUpperCase();
    if (!COUPONS_DATA[cleanCode]) {
      return { success: false, message: 'Invalid or expired coupon code.' };
    }

    const coupon = COUPONS_DATA[cleanCode];
    const subtotal = this.getSubtotal();

    if (subtotal < coupon.minOrder) {
      return {
        success: false,
        message: `Minimum order amount for ${cleanCode} is ₹${coupon.minOrder.toLocaleString('en-IN')}.`
      };
    }

    localStorage.setItem(this.COUPON_KEY, JSON.stringify(coupon));
    return { success: true, message: `Coupon ${cleanCode} applied successfully!`, coupon };
  },

  removeCoupon() {
    localStorage.removeItem(this.COUPON_KEY);
  },

  getSubtotal() {
    const items = this.getItems();
    return items.reduce((sum, item) => sum + (item.price * item.quantity), 0);
  },

  getMrpTotal() {
    const items = this.getItems();
    return items.reduce((sum, item) => sum + ((item.mrp || item.price) * item.quantity), 0);
  },

  getSummary() {
    const subtotal = this.getSubtotal();
    const mrpTotal = this.getMrpTotal();
    const productSavings = Math.max(0, mrpTotal - subtotal);
    const coupon = this.getAppliedCoupon();

    let couponDiscount = 0;
    if (coupon) {
      if (coupon.type === 'percent') {
        couponDiscount = Math.round((subtotal * coupon.value) / 100);
      } else if (coupon.type === 'flat') {
        couponDiscount = coupon.value;
      }
    }

    const shipping = subtotal > 999 || subtotal === 0 ? 0 : 99; // Free shipping over ₹999
    const total = Math.max(0, subtotal - couponDiscount + shipping);

    return {
      subtotal,
      mrpTotal,
      productSavings,
      couponDiscount,
      coupon,
      shipping,
      total,
      itemCount: this.getCount()
    };
  },

  updateBadges() {
    const count = this.getCount();
    const badgeElements = document.querySelectorAll('.cart-count-badge');
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
  }
};

// Initialize Cart badges on load
document.addEventListener('DOMContentLoaded', () => {
  Cart.updateBadges();
});
