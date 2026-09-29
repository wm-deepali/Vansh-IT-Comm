/**
 * VANSH IT & COMM — PRODUCT RENDERING & FILTERING ENGINE
 * Handles card generation, responsive specifications, filtering, sorting, and Quick-View modal.
 */

const ProductsEngine = {
  formatPrice(num) {
    return '₹' + Number(num).toLocaleString('en-IN');
  },

  renderStars(rating) {
    const fullStars = Math.floor(rating);
    const hasHalf = rating % 1 >= 0.5;
    let html = '<div class="flex items-center text-amber-400 text-[9px] sm:text-xs gap-0.5" aria-label="' + rating + ' out of 5 stars">';
    for (let i = 0; i < 5; i++) {
      if (i < fullStars) {
        html += '<i class="fa-solid fa-star"></i>';
      } else if (i === fullStars && hasHalf) {
        html += '<i class="fa-solid fa-star-half-stroke"></i>';
      } else {
        html += '<i class="fa-regular fa-star text-slate-300"></i>';
      }
    }
    html += `<span class="text-slate-500 font-bold ml-1 text-[9px] sm:text-xs">${rating.toFixed(1)}</span></div>`;
    return html;
  },

  getBadgeClass(badge) {
    const b = (badge || '').toUpperCase();
    if (b.includes('REFURBISHED')) return 'badge-refurbished';
    if (b.includes('NEW')) return 'badge-new';
    if (b.includes('OPEN BOX')) return 'badge-openbox';
    if (b.includes('HOT') || b.includes('DEAL') || b.includes('FLAGSHIP')) return 'badge-deal';
    return 'badge-tested';
  },

  createProductCard(product) {
    const isWishlisted = Wishlist.hasItem(product.id);
    const badgeClass = this.getBadgeClass(product.badge || product.condition);

    // Build concise responsive specs list with fixed height container for alignment
    let specsHtml = '';
    if (product.category === 'laptops') {
      specsHtml = `
        <div class="text-[10px] sm:text-[11px] text-slate-600 space-y-0.5 sm:space-y-1 mb-2 sm:mb-2.5 bg-slate-50 p-1.5 sm:p-2.5 rounded-lg sm:rounded-xl border border-slate-100 min-h-[48px] sm:min-h-[62px] flex flex-col justify-center">
          <div class="font-medium text-slate-800 truncate text-[10px] sm:text-[11px] leading-tight"><i class="fa-solid fa-microchip text-blue-600 mr-1 sm:mr-1.5 w-3 text-[9px] sm:text-[10px]"></i>${product.processor || 'High-performance CPU'}</div>
          <div class="flex items-center gap-1 sm:gap-1.5 text-slate-600 truncate text-[10px] sm:text-[11px] leading-tight">
            <span class="truncate"><i class="fa-solid fa-memory text-blue-600 mr-1 text-[9px] sm:text-[10px]"></i>${product.ram || '8GB RAM'}</span>
            <span class="text-slate-300">•</span>
            <span class="truncate"><i class="fa-solid fa-hard-drive text-blue-600 mr-1 text-[9px] sm:text-[10px]"></i>${product.storage || 'SSD'}</span>
          </div>
        </div>
      `;
    } else if (product.category === 'mobile-phones') {
      specsHtml = `
        <div class="text-[10px] sm:text-[11px] text-slate-600 space-y-0.5 sm:space-y-1 mb-2 sm:mb-2.5 bg-slate-50 p-1.5 sm:p-2.5 rounded-lg sm:rounded-xl border border-slate-100 min-h-[48px] sm:min-h-[62px] flex flex-col justify-center">
          <div class="font-medium text-slate-800 truncate text-[10px] sm:text-[11px] leading-tight"><i class="fa-solid fa-mobile-screen-button text-blue-600 mr-1 sm:mr-1.5 w-3 text-[9px] sm:text-[10px]"></i>${product.display || 'FHD+ Display'}</div>
          <div class="flex items-center justify-between text-slate-600 text-[10px] sm:text-[11px] leading-tight">
            <span class="truncate"><i class="fa-solid fa-memory text-blue-600 mr-1 text-[9px] sm:text-[10px]"></i>${product.ram} • ${product.storage}</span>
            ${product.batteryHealth ? `<span class="text-emerald-700 font-bold ml-1 text-[8px] sm:text-[10px] flex-shrink-0 bg-emerald-50 px-1 py-0.5 rounded border border-emerald-100 leading-none">${product.batteryHealth.split(' ')[0]}</span>` : ''}
          </div>
        </div>
      `;
    } else {
      specsHtml = `
        <div class="text-[10px] sm:text-[11px] text-slate-600 space-y-0.5 sm:space-y-1 mb-2 sm:mb-2.5 bg-slate-50 p-1.5 sm:p-2.5 rounded-lg sm:rounded-xl border border-slate-100 min-h-[48px] sm:min-h-[62px] flex flex-col justify-center">
          <div class="font-medium text-slate-800 truncate text-[10px] sm:text-[11px] leading-tight"><i class="fa-solid fa-bolt text-blue-600 mr-1 sm:mr-1.5 w-3 text-[9px] sm:text-[10px]"></i>${product.compatibility || product.features || product.speed || 'Premium Quality Accessory'}</div>
          <div class="text-slate-500 text-[10px] sm:text-[11px] truncate flex items-center gap-1 leading-tight"><i class="fa-solid fa-shield-halved text-blue-600 text-[9px] sm:text-[10px]"></i>${product.warranty || 'Brand Warranty Included'}</div>
        </div>
      `;
    }

    return `
      <article class="product-card group" data-product-id="${product.id}">
        <!-- Image & Actions -->
        <div class="img-wrapper">
          <img 
            src="${product.image}" 
            alt="${product.name}" 
            loading="lazy" 
            onerror="this.onerror=null; this.src='img/product-1588872657578-7efd1f1555ed.jpg';"
          />
          
          <!-- Badge -->
          <div class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5 z-10">
            <span class="badge ${badgeClass} text-[9px] sm:text-[10px] px-1.5 py-0.5 sm:px-2 sm:py-0.5">${product.badge || product.condition}</span>
          </div>

          <!-- Wishlist Button -->
          <button 
            type="button" 
            data-wishlist-btn="${product.id}"
            class="heart-btn absolute top-2 right-2 sm:top-2.5 sm:right-2.5 z-10 w-6 h-6 sm:w-8 sm:h-8 rounded-full bg-white/90 backdrop-blur-sm border border-slate-200 text-slate-600 flex items-center justify-center hover:bg-white hover:text-red-500 shadow-sm transition-all ${isWishlisted ? 'active text-red-500' : ''}"
            onclick="ProductsEngine.handleWishlistToggle('${product.id}', event)"
            aria-label="${isWishlisted ? 'Remove from wishlist' : 'Add to wishlist'}"
          >
            <i class="fa-${isWishlisted ? 'solid' : 'regular'} fa-heart text-[11px] sm:text-sm"></i>
          </button>

          <!-- Quick View Overlay Button -->
          <button 
            type="button" 
            onclick="ProductsEngine.openQuickView('${product.id}')"
            class="absolute bottom-2.5 left-2.5 right-2.5 py-2 px-3 bg-slate-950/85 hover:bg-blue-600 text-white text-xs font-bold rounded-xl backdrop-blur-sm opacity-0 group-hover:opacity-100 transition-all duration-200 transform translate-y-2 group-hover:translate-y-0 flex items-center justify-center gap-1.5 shadow-lg hidden sm:flex"
          >
            <i class="fa-solid fa-eye text-xs"></i> Quick View
          </button>
        </div>

        <!-- Content -->
        <div class="p-2 sm:p-3.5 lg:p-4 flex flex-col flex-1 justify-between bg-white">
          <div>
            <!-- Ratings & Brand -->
            <div class="flex items-center justify-between gap-1 mb-1 sm:mb-1.5">
              ${this.renderStars(product.rating)}
              <span class="text-[8px] sm:text-[10px] font-bold text-slate-500 uppercase tracking-wider bg-slate-100 px-1 sm:px-1.5 py-0.5 rounded flex-shrink-0">${product.brand}</span>
            </div>

            <!-- Title (Enforce 2 lines with consistent min-height) -->
            <h3 class="font-bold text-slate-900 text-xs sm:text-sm leading-snug line-clamp-2 hover:text-blue-600 transition-colors mb-1.5 sm:mb-2 min-h-[2rem] sm:min-h-[2.4rem]">
              <a href="product.html?id=${product.id}">${product.name}</a>
            </h3>

            <!-- Specifications summary -->
            ${specsHtml}
          </div>

          <div>
            <!-- Price Block -->
            <div class="pt-1.5 sm:pt-2 border-t border-slate-100 mb-2 sm:mb-2.5">
              <div class="flex items-baseline gap-1 sm:gap-1.5 flex-wrap min-h-[22px] sm:min-h-[26px] items-center">
                <span class="product-price text-slate-900 font-black text-sm sm:text-base lg:text-lg leading-none">${this.formatPrice(product.price)}</span>
                ${product.mrp && product.mrp > product.price ? `
                  <span class="text-[9px] sm:text-xs text-slate-400 line-through">${this.formatPrice(product.mrp)}</span>
                  <span class="text-[8px] sm:text-[10px] font-black text-emerald-700 bg-emerald-50 border border-emerald-200 px-1 py-0.5 rounded whitespace-nowrap">${product.discount}% OFF</span>
                ` : ''}
              </div>
              <div class="flex items-center gap-1 text-[9px] sm:text-[11px] text-slate-500 mt-0.5 sm:mt-1">
                <i class="fa-solid fa-shield-halved text-blue-600 text-[9px] sm:text-[10px]"></i>
                <span class="truncate">${product.warranty || 'Warranty Included'}</span>
              </div>
            </div>

            <!-- Action Buttons -->
            <div class="grid grid-cols-2 gap-1 sm:gap-1.5">
              <button 
                type="button" 
                class="btn-base btn-secondary btn-sm text-[10px] sm:text-xs py-1.5 sm:py-2 px-1 w-full add-to-cart-btn font-bold flex items-center justify-center gap-1 rounded-lg sm:rounded-xl"
                onclick="ProductsEngine.handleAddToCart('${product.id}', this)"
              >
                <i class="fa-solid fa-cart-shopping text-[9px] sm:text-xs"></i> Add
              </button>
              <a 
                href="product.html?id=${product.id}" 
                class="btn-base btn-primary btn-sm text-[10px] sm:text-xs py-1.5 sm:py-2 px-1 w-full font-bold flex items-center justify-center gap-1 rounded-lg sm:rounded-xl"
              >
                View <i class="fa-solid fa-arrow-right text-[8px] sm:text-[10px]"></i>
              </a>
            </div>
          </div>
        </div>
      </article>
    `;
  },

  handleWishlistToggle(productId, event) {
    if (event) {
      event.preventDefault();
      event.stopPropagation();
    }
    const isNowInWishlist = Wishlist.toggleItem(productId);
    Wishlist.syncHeartIcons();
  },

  handleAddToCart(productId, buttonEl) {
    Cart.addItem(productId, 1);
    if (buttonEl) {
      const origHtml = buttonEl.innerHTML;
      buttonEl.innerHTML = '<i class="fa-solid fa-check text-emerald-600"></i> Added';
      buttonEl.classList.add('border-emerald-500', 'bg-emerald-50', 'text-emerald-700');
      setTimeout(() => {
        buttonEl.innerHTML = origHtml;
        buttonEl.classList.remove('border-emerald-500', 'bg-emerald-50', 'text-emerald-700');
      }, 1500);
    }
  },

  openQuickView(productId) {
    const product = PRODUCTS_DATA.find(p => p.id === productId);
    if (!product) return;

    const modalBox = document.getElementById('quick-view-modal-content');
    if (!modalBox) return;

    modalBox.innerHTML = `
      <div class="p-6">
        <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
          <div class="flex items-center gap-2">
            <span class="badge ${this.getBadgeClass(product.badge || product.condition)}">${product.badge || product.condition}</span>
            <span class="text-xs font-bold text-slate-500 uppercase tracking-wider bg-slate-100 px-2 py-0.5 rounded">${product.brand}</span>
          </div>
          <button type="button" onclick="App.closeModal('quick-view-modal')" class="text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center transition-colors text-lg" aria-label="Close">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
          <div class="bg-slate-50 rounded-2xl p-6 flex items-center justify-center border border-slate-100 min-h-[260px]">
            <img 
              src="${product.image}" 
              alt="${product.name}" 
              class="max-h-56 max-w-full object-contain"
              onerror="this.onerror=null; this.src='img/product-1588872657578-7efd1f1555ed.jpg';"
            />
          </div>

          <div class="flex flex-col justify-between">
            <div>
              <h2 class="font-extrabold text-slate-900 text-xl font-heading leading-snug mb-2">${product.name}</h2>
              <div class="mb-3">${this.renderStars(product.rating)}</div>

              <div class="flex items-baseline gap-3 mb-4 flex-wrap">
                <span class="text-2xl font-black text-slate-900 font-heading">${this.formatPrice(product.price)}</span>
                ${product.mrp ? `<span class="text-sm text-slate-400 line-through">${this.formatPrice(product.mrp)}</span>` : ''}
                ${product.discount ? `<span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded">${product.discount}% OFF</span>` : ''}
              </div>

              <p class="text-xs text-slate-600 mb-4 line-clamp-3 leading-relaxed">${product.description}</p>

              <div class="grid grid-cols-2 gap-2 text-xs text-slate-700 mb-5">
                ${product.processor ? `<div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 truncate"><span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">CPU</span><strong class="text-xs font-bold text-slate-800 truncate block">${product.processor}</strong></div>` : ''}
                ${product.ram ? `<div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 truncate"><span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">RAM</span><strong class="text-xs font-bold text-slate-800 truncate block">${product.ram}</strong></div>` : ''}
                ${product.storage ? `<div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 truncate"><span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Storage</span><strong class="text-xs font-bold text-slate-800 truncate block">${product.storage}</strong></div>` : ''}
                ${product.display ? `<div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 truncate"><span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">Display</span><strong class="text-xs font-bold text-slate-800 truncate block">${product.display}</strong></div>` : ''}
                ${product.warranty ? `<div class="col-span-2 p-2 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 font-semibold text-xs flex items-center gap-1.5"><i class="fa-solid fa-shield-halved"></i>${product.warranty}</div>` : ''}
              </div>
            </div>

            <div class="flex items-center gap-3">
              <button 
                type="button" 
                onclick="Cart.addItem('${product.id}', 1); App.closeModal('quick-view-modal');"
                class="btn-base btn-primary flex-1 py-2.5 font-bold text-xs shadow-md shadow-blue-600/20"
              >
                <i class="fa-solid fa-cart-shopping"></i> Add to Cart
              </button>
              <a 
                href="product.html?id=${product.id}" 
                class="btn-base btn-secondary px-4 py-2.5 font-bold text-xs"
              >
                Full Specs <i class="fa-solid fa-arrow-right text-[10px]"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    `;

    App.openModal('quick-view-modal');
  },

  renderProductsGrid(containerId, productsList) {
    const container = document.getElementById(containerId);
    if (!container) return;

    if (!productsList || productsList.length === 0) {
      container.innerHTML = `
        <div class="col-span-full text-center py-16 px-4 bg-white rounded-2xl border border-slate-200">
          <div class="w-16 h-16 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center mx-auto mb-4 text-2xl">
            <i class="fa-solid fa-box-open"></i>
          </div>
          <h3 class="text-lg font-bold text-slate-800 mb-1">No products found</h3>
          <p class="text-slate-500 text-sm max-w-sm mx-auto mb-6">Try adjusting your filters or search keywords to find what you're looking for.</p>
          <button type="button" onclick="location.reload()" class="btn-base btn-secondary btn-sm">Reset Filters</button>
        </div>
      `;
      return;
    }

    container.innerHTML = productsList.map(p => this.createProductCard(p)).join('');
    Wishlist.syncHeartIcons();
  }
};
