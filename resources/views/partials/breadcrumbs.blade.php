@php
    // $crumbs = [['name' => 'Home', 'url' => route('home')], ..., ['name' => 'Current page', 'url' => optional]]
    $crumbs = $crumbs ?? [];

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => collect($crumbs)->values()->map(fn ($c, $i) => [
            '@type' => 'ListItem',
            'position' => $i + 1,
            'name' => $c['name'],
            'item' => $c['url'] ?? url()->current(),
        ])->all(),
    ];
@endphp

@if($visible ?? true)
  <nav class="flex items-center gap-2 text-xs text-slate-500 {{ $class ?? 'mb-6' }} flex-wrap" aria-label="Breadcrumb">
    @foreach($crumbs as $crumb)
      @if(!$loop->last)
        <a href="{{ $crumb['url'] }}" class="hover:text-blue-600">{{ $crumb['name'] }}</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
      @else
        <span class="text-slate-800 font-semibold truncate max-w-xs sm:max-w-md" aria-current="page">{{ $crumb['name'] }}</span>
      @endif
    @endforeach
  </nav>
@endif

@push('schema')
  @include('partials.json-ld', ['data' => $breadcrumbSchema])
@endpush