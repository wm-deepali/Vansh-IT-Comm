{{-- resources/views/partials/mega-menu.blade.php
     Expects: $cols (array of [title, items]), $routeName, $promo (array) --}}
<div class="mega-menu">
    <div class="container-custom py-6 xl:py-8">
        <div class="grid grid-cols-6 gap-2.5 lg:gap-3.5 xl:gap-5 items-stretch">

            @foreach ($cols as [$title, $items])
                <div>
                    <h4 class="text-[11px] xl:text-xs font-bold text-slate-900 uppercase tracking-wider mb-2.5 pb-1 border-b border-slate-100 truncate">{{ $title }}</h4>
                    <ul class="space-y-1.5 text-[11px] xl:text-xs text-slate-600">
                        @foreach ($items as $item)
                            <li class="truncate">
                                <a href="#"
                                   class="hover:text-blue-600 transition-colors {{ $item[2] ?? '' }}">{{ $item[0] }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach

            <div class="bg-gradient-to-br {{ $promo['gradient'] }} p-3 xl:p-4 rounded-2xl text-white flex flex-col justify-between shadow-md border border-slate-700/60">
                <div>
                    <span class="badge {{ $promo['badgeClass'] }} text-white text-[9px] xl:text-[10px] mb-2 font-bold whitespace-nowrap">{{ $promo['badge'] }}</span>
                    <h4 class="font-extrabold text-xs xl:text-sm text-white leading-snug mb-1 truncate">{{ $promo['title'] }}</h4>
                    <p class="text-[10px] xl:text-[11px] text-slate-300 mb-2 leading-tight">{{ $promo['text'] }}</p>
                    <div class="text-[11px] xl:text-xs font-extrabold text-emerald-400">{{ $promo['price'] }}</div>
                </div>
                <a href="#" class="mt-2.5 btn-base btn-primary btn-sm text-[10px] xl:text-xs w-full py-1.5 justify-center font-bold">
                    {{ $promo['btn'] }} <i class="fa-solid fa-arrow-right text-[9px]"></i>
                </a>
            </div>
        </div>
    </div>
</div>