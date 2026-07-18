@props(['title', 'subtitle' => null])

<div class="flex flex-wrap items-center justify-between gap-4">
    <div>
        <h1 class="font-display text-2xl font-bold tracking-tight text-navy-900">{{ $title }}</h1>
        @if ($subtitle)
            <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
        @endif
    </div>

    @if (trim($slot))
        <div class="flex flex-wrap items-center gap-2">
            {{ $slot }}
        </div>
    @endif
</div>
