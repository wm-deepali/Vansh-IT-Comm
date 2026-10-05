{{-- resources/views/partials/quick-view.blade.php
Quick View modal + script. Include once per page, inside @section('content'):
@include('partials.quick-view')
Works with partials/product-card.blade.php, which exposes
.product-card[data-product-id] and data-quickview (JSON). --}}

<!-- Quick View Modal -->
<div id="qv-modal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-950/60 backdrop-blur-sm p-4" onclick="if(event.target===this) QuickView.close()">
  <div id="qv-content" class="bg-white rounded-2xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto"></div>
</div>

@push('scripts')
  <script>
    const QuickView = {
      esc(s) {
        return String(s ?? '').replace(/[&<>"']/g, c => ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' }[c]));
      },

      stars(rating) {
        const full = Math.floor(rating);
        const half = rating % 1 >= 0.5;
        let html = '<div class="flex items-center text-amber-400 text-[9px] sm:text-xs gap-0.5">';
        for (let i = 0; i < 5; i++) {
          if (i < full) html += '<i class="fa-solid fa-star"></i>';
          else if (i === full && half) html += '<i class="fa-solid fa-star-half-stroke"></i>';
          else html += '<i class="fa-regular fa-star text-slate-300"></i>';
        }
        html += `<span class="text-slate-500 font-bold ml-1 text-[9px] sm:text-xs">${Number(rating).toFixed(1)}</span></div>`;
        return html;
      },

      open(id) {
        const card = document.querySelector(`.product-card[data-product-id="${id}"]`);
        if (!card) return;
        const p = JSON.parse(card.dataset.quickview);
        const e = this.esc.bind(this);

        const specs = (p.specs || []).map(s => `
            <div class="p-2 rounded-xl bg-slate-50 border border-slate-200/80 truncate">
              <span class="text-[9px] font-bold text-slate-400 uppercase tracking-wider block">${e(s[0])}</span>
              <strong class="text-xs font-bold text-slate-800 truncate block">${e(s[1])}</strong>
            </div>`).join('');

        document.getElementById('qv-content').innerHTML = `
            <div class="p-6">
              <div class="flex items-center justify-between border-b border-slate-100 pb-4 mb-5">
                <div class="flex items-center gap-2">
                  <span class="badge ${e(p.badgeClass)}">${e(p.badge)}</span>
                  <span class="text-xs font-bold text-slate-500 uppercase tracking-wider bg-slate-100 px-2 py-0.5 rounded">${e(p.brand)}</span>
                </div>
                <button type="button" onclick="QuickView.close()" class="text-slate-400 hover:text-slate-700 w-8 h-8 rounded-full hover:bg-slate-100 flex items-center justify-center transition-colors text-lg" aria-label="Close">
                  <i class="fa-solid fa-xmark"></i>
                </button>
              </div>

              <div class="grid grid-cols-1 md:grid-cols-2 gap-6 items-center">
                <div class="bg-slate-50 rounded-2xl p-6 flex items-center justify-center border border-slate-100 min-h-[260px]">
                  <img src="${e(p.image)}" alt="${e(p.name)}" class="max-h-56 max-w-full object-contain"
                    onerror="this.onerror=null; this.src='${e(p.fallback)}';" />
                </div>

                <div class="flex flex-col justify-between">
                  <div>
                    <h2 class="font-extrabold text-slate-900 text-xl font-heading leading-snug mb-2">${e(p.name)}</h2>
                    <div class="mb-3">${this.stars(p.rating)}</div>

                    <div class="flex items-baseline gap-3 mb-4 flex-wrap">
                      <span class="text-2xl font-black text-slate-900 font-heading">${e(p.price)}</span>
                      ${p.mrp ? `<span class="text-sm text-slate-400 line-through">${e(p.mrp)}</span>` : ''}
                      ${p.discount ? `<span class="text-xs font-bold text-emerald-700 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded">${e(p.discount)}% OFF</span>` : ''}
                    </div>

                    <p class="text-xs text-slate-600 mb-4 line-clamp-3 leading-relaxed">${e(p.description)}</p>

                    <div class="grid grid-cols-2 gap-2 text-xs text-slate-700 mb-5">
                      ${specs}
                      <div class="col-span-2 p-2 rounded-xl bg-blue-50 border border-blue-100 text-blue-700 font-semibold text-xs flex items-center gap-1.5">
                        <i class="fa-solid fa-shield-halved"></i>${e(p.warranty)}
                      </div>
                    </div>
                  </div>

                  <div class="flex items-center gap-3">
                    <button type="button" data-add-to-cart="${e(p.id)}" onclick="QuickView.close()"
                      class="btn-base btn-primary flex-1 py-2.5 font-bold text-xs shadow-md shadow-blue-600/20">
                      <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                    </button>
                    <a href="${e(p.url)}" class="btn-base btn-secondary px-4 py-2.5 font-bold text-xs">
                      Full Specs <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </a>
                  </div>
                </div>
              </div>
            </div>
          `;

        const modal = document.getElementById('qv-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.style.overflow = 'hidden';
      },

      close() {
        const modal = document.getElementById('qv-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
      }
    };

    document.addEventListener('keydown', ev => { if (ev.key === 'Escape') QuickView.close(); });
  </script>
@endpush