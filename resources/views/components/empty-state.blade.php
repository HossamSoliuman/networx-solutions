@props(['icon' => 'inbox', 'title'])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center gap-3 px-6 py-14 text-center']) }}>
    <span class="flex size-12 items-center justify-center rounded-full bg-slate-100 text-slate-400">
        <x-icon :name="$icon" class="size-6" />
    </span>
    <p class="text-sm font-semibold text-slate-900">{{ $title }}</p>
    @if (trim($slot))
        <p class="max-w-sm text-sm text-slate-500">{{ $slot }}</p>
    @endif
</div>
