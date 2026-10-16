<script>
  (function () {
    const CART = {
      csrf: @json(csrf_token()),
      url: @json(route('cart.add')),
    };

    // A page (e.g. the product detail page) can define window.getCartExtraPayload()
    // to send extra fields such as the selected variant. Pages that don't define it
    // (listing, home) keep sending only product_id.
    async function postAddToCart(productId) {
      const extra = typeof window.getCartExtraPayload === 'function'
        ? (window.getCartExtraPayload() || {})
        : {};

      const res = await fetch(CART.url, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'X-CSRF-TOKEN': CART.csrf,
          'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({ ...extra, product_id: productId }),
      });

      const data = await res.json().catch(() => ({}));
      if (!res.ok || data.status === false) {
        throw new Error(data.message || 'Could not add this product to the cart.');
      }

      // fire here so both "Add to cart" and "Buy now" are tracked
      if (window.fireTrackingEvents) fireTrackingEvents(data.tracking_events);

      return data;
    }

    async function addToCart(btn, productId) {
      setBtnLoading(btn, true, 'Adding...');
      try {
        const data = await postAddToCart(productId);
        syncHeaderCart(data);
        // no fireTrackingEvents here anymore, otherwise it fires twice
        toast(data.message, 'success');
        if (data.coupon_removed && data.coupon_message) toast(data.coupon_message, 'info');
      } catch (err) {
        toast(err.message, 'error');
      } finally {
        setBtnLoading(btn, false);
      }
    }

    document.addEventListener('click', async (e) => {
      const btn = e.target.closest('[data-add-to-cart]');
      if (!btn) return;

      e.preventDefault();
      e.stopImmediatePropagation();

      const productId = btn.dataset.productId;
      if (!productId || btn.disabled) return;

      await addToCart(btn, productId);
    }, true);

    window.postAddToCart = postAddToCart; // used by Buy Now on the product page

  })();
</script>