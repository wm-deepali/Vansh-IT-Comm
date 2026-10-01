{{-- resources/views/partials/shop-filters.blade.php
     Used twice (desktop sidebar + mobile drawer) → pass a unique $formId each time.
     Inherits: $search, $sort, $categories, $conditions, $brands, $priceMin, $priceMax,
               $filterAttributes, $catSlugs, $conds, $brandIds, $maxPrice, $attrFilters --}}
@php
  $currency = config('shop.currency', '₹');
  $maxValue = $maxPrice !== null ? min($maxPrice, $priceMax) : $priceMax;
  $submit   = "this.form.submit()";
  $box      = 'rounded text-blue-600 focus:ring-0';
@endphp

<form id="{{ $formId }}" method="GET" action="{{ route('shop') }}" class="space-y-6">
  @if($search !== '') <input type="hidden" name="search" value="{{ $search }}"> @endif
  @if($sort !== 'featured') <input type="hidden" name="sort" value="{{ $sort }}"> @endif

  <div class="flex items-center justify-between pb-3 border-b border-slate-100">
    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-wider font-heading"><i class="fa-solid fa-filter text-blue-600 mr-1.5"></i> Filters</h3>
    <a href="{{ route('shop', array_filter(['search' => $search])) }}" class="text-xs text-blue-600 hover:underline font-semibold">Clear All</a>
  </div>

  {{-- Category --}}
  @if($categories->isNotEmpty())
    <div>
      <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5">Category</h4>
      <div class="space-y-1.5 text-xs text-slate-600">
        @foreach($categories as $cat)
          <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
            <input type="checkbox" name="category[]" value="{{ $cat->slug }}" onchange="{{ $submit }}" class="{{ $box }}"
              {{ in_array($cat->slug, $catSlugs, true) ? 'checked' : '' }}> {{ $cat->name }}
          </label>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Condition (values come from Product::CONDITIONS) --}}
  @if(count($conditions))
    <div class="pt-4 border-t border-slate-100">
      <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5">Condition</h4>
      <div class="space-y-1.5 text-xs text-slate-600">
        @foreach($conditions as $cond)
          <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
            <input type="checkbox" name="condition[]" value="{{ $cond }}" onchange="{{ $submit }}" class="{{ $box }}"
              {{ in_array($cond, $conds, true) ? 'checked' : '' }}> {{ $cond }}
          </label>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Brand --}}
  @if($brands->isNotEmpty())
    <div class="pt-4 border-t border-slate-100">
      <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5">Brand</h4>
      <div class="space-y-1.5 text-xs text-slate-600 max-h-48 overflow-y-auto pr-1">
        @foreach($brands as $brand)
          <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
            <input type="checkbox" name="brand[]" value="{{ $brand->id }}" onchange="{{ $submit }}" class="{{ $box }}"
              {{ in_array($brand->id, $brandIds, true) ? 'checked' : '' }}> {{ $brand->name }}
          </label>
        @endforeach
      </div>
    </div>
  @endif

  {{-- Attribute filters (attributes flagged "show in filter") --}}
  @foreach($filterAttributes as $row)
    @php $selected = $attrFilters->get($row['attribute']->id, []); @endphp
    <div class="pt-4 border-t border-slate-100">
      <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider mb-2.5">{{ $row['attribute']->name }}</h4>
      <div class="space-y-1.5 text-xs text-slate-600 max-h-48 overflow-y-auto pr-1">
        @foreach($row['values'] as $value)
          <label class="flex items-center gap-2 cursor-pointer hover:text-slate-900">
            <input type="checkbox" name="attr[{{ $row['attribute']->id }}][]" value="{{ $value->id }}" onchange="{{ $submit }}" class="{{ $box }}"
              {{ in_array($value->id, $selected, true) ? 'checked' : '' }}> {{ $value->value }}
          </label>
        @endforeach
      </div>
    </div>
  @endforeach

  {{-- Max price --}}
  @if($priceMax > $priceMin)
    <div class="pt-4 border-t border-slate-100">
      <div class="flex items-center justify-between mb-2">
        <h4 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Max Price</h4>
        <span data-price-label class="text-xs font-extrabold text-blue-600">{{ $currency }}{{ number_format($maxValue) }}</span>
      </div>
      <input type="range" name="maxPrice" min="{{ $priceMin }}" max="{{ $priceMax }}" step="1000" value="{{ $maxValue }}"
        oninput="this.closest('div').querySelector('[data-price-label]').textContent = '{{ $currency }}' + Number(this.value).toLocaleString('en-IN')"
        onchange="{{ $submit }}"
        class="w-full accent-blue-600 cursor-pointer" />
    </div>
  @endif
</form>