{{-- Certificate mark: the official logo when we have it, otherwise a drawn seal (no government emblems). --}}
@php $big = ($size ?? 'sm') === 'lg'; @endphp
@if ($c['logo'])
    <img src="{{ $c['logo'] }}" alt="{{ $c['title'] }}" loading="lazy"
         class="{{ $big ? 'max-h-64' : 'max-h-28' }} w-auto max-w-[80%] object-contain transition duration-500 group-hover:scale-105">
@else
    <span class="relative flex {{ $big ? 'h-56 w-56' : 'h-32 w-32' }} items-center justify-center rounded-full bg-gradient-to-br from-[#f1d48f] via-[#c8963e] to-[#8a5a17] p-1.5 shadow-lg shadow-amber-900/20 transition duration-700 group-hover:rotate-6">
        <span class="flex h-full w-full flex-col items-center justify-center rounded-full border-2 border-dashed border-[#f7e3b2]/70 bg-gradient-to-br from-gray-950 to-brand-900 text-white">
            <i data-lucide="{{ $c['icon'] }}" class="{{ $big ? 'h-12 w-12' : 'h-7 w-7' }} text-[#f1d48f]"></i>
            <span class="{{ $big ? 'mt-3 text-lg' : 'mt-1.5 text-[11px]' }} font-display font-bold uppercase tracking-[0.2em]">{{ $c['seal'] }}</span>
            <span class="{{ $big ? 'text-xs' : 'text-[8px]' }} uppercase tracking-[0.25em] text-[#f1d48f]">Certified</span>
        </span>
    </span>
@endif
