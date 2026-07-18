@props(['href', 'icon', 'active' => false, 'badge' => null])

<a href="{{ $href }}" @class([
    'group flex items-center gap-3 rounded-lg px-3 py-2 text-sm font-medium transition-colors',
    'bg-brand-600/20 text-white ring-1 ring-inset ring-brand-500/30' => $active,
    'text-slate-300 hover:bg-white/5 hover:text-white' => ! $active,
])>
    <x-icon :name="$icon" class="size-5 {{ $active ? 'text-brand-300' : 'text-slate-400 group-hover:text-brand-300' }}" />
    <span class="flex-1">{{ $slot }}</span>

    @if ($badge)
        <span class="rounded-full bg-brand-500 px-1.5 py-0.5 text-[0.65rem] font-semibold text-white">{{ $badge }}</span>
    @endif
</a>
