<script>
  (function () {
    const WL = {
      csrf: @json(csrf_token()),
      url: @json(route('wishlist.toggle')),
    };

    function paint(productId, wishlisted) {
      document.querySelectorAll('[data-wishlist-btn="' + productId + '"]').forEach(btn => {
        const icon = btn.querySelector('i');
        btn.setAttribute('aria-pressed', wishlisted ? 'true' : 'false');
        btn.classList.toggle('text-red-500', wishlisted);
        btn.classList.toggle('text-slate-600', !wishlisted);
        if (icon) {
          icon.classList.toggle('fa-solid', wishlisted);
          icon.classList.toggle('fa-regular', !wishlisted);
        }
      });
    }

    function syncCount(count) {
      if (count === undefined) return;
      document.querySelectorAll('[data-wishlist-count]').forEach(el => {
        el.textContent = count;
        el.classList.toggle('hidden', Number(count) === 0);
      });
    }

    document.addEventListener('click', async (e) => {
      const btn = e.target.closest('[data-wishlist-btn]');
      if (!btn) return;

      e.preventDefault();
      e.stopImmediatePropagation();

      const productId = btn.dataset.wishlistBtn;
      if (!productId || btn.dataset.busy === '1') return;

      btn.dataset.busy = '1';
      btn.classList.add('opacity-60');

      try {
        const res = await fetch(WL.url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': WL.csrf,
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: JSON.stringify({ product_id: productId }),
        });

        const data = await res.json().catch(() => ({}));
        if (!res.ok || data.status === false) {
          throw new Error(data.message || 'Could not update wishlist.');
        }

        paint(productId, data.wishlisted);
        syncCount(data.wishlist_count);
        document.dispatchEvent(new CustomEvent('wishlist:changed', {
          detail: { productId: String(productId), wishlisted: data.wishlisted, count: data.wishlist_count }
        }));
        if (window.toast) toast(data.message, 'success');
      } catch (err) {
        if (window.toast) toast(err.message, 'error');
      } finally {
        btn.dataset.busy = '0';
        btn.classList.remove('opacity-60');
      }
    }, true);
  })();
</script>