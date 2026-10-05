<script>
  window.setBtnLoading = window.setBtnLoading || function (btn, loading, text = 'Loading...') {
    if (!btn) return;
    if (loading) {
      btn.dataset.originalHtml = btn.innerHTML;
      btn.disabled = true;
      btn.classList.add('opacity-70', 'cursor-not-allowed');
      btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> ' + text;
    } else {
      btn.disabled = false;
      btn.classList.remove('opacity-70', 'cursor-not-allowed');
      if (btn.dataset.originalHtml !== undefined) btn.innerHTML = btn.dataset.originalHtml;
    }
  };

  window.toast = window.toast || function (message, type = 'success') {
    let box = document.getElementById('toast-box');
    if (!box) {
      box = document.createElement('div');
      box.id = 'toast-box';
      box.className = 'fixed top-4 right-4 z-[100] flex flex-col gap-2';
      document.body.appendChild(box);
    }
    const colors = { success: 'bg-emerald-600', error: 'bg-red-600', info: 'bg-blue-600' };
    const el = document.createElement('div');
    el.className = 'text-white text-xs font-semibold px-4 py-2.5 rounded-xl shadow-lg ' + (colors[type] || colors.info);
    el.textContent = message;
    box.appendChild(el);
    setTimeout(() => el.remove(), 3000);
  };

  window.syncHeaderCart = window.syncHeaderCart || function (data) {
  const count = data.cart_count ?? data.count ?? data.cart?.count;
  if (count === undefined) return;
  document.querySelectorAll('[data-cart-count]').forEach(el => {
    el.textContent = count > 99 ? '99+' : count;
    el.classList.toggle('hidden', !(count > 0));
  });
};
</script>