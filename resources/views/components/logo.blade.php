@props(['wordmark' => true, 'light' => false])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <svg class="size-9 shrink-0" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <defs>
            <linearGradient id="nx-mark-a" x1="8" y1="40" x2="26" y2="8" gradientUnits="userSpaceOnUse">
                <stop stop-color="#1e40af" />
                <stop offset="1" stop-color="#2563eb" />
            </linearGradient>
            <linearGradient id="nx-mark-b" x1="22" y1="42" x2="40" y2="6" gradientUnits="userSpaceOnUse">
                <stop stop-color="#2563eb" />
                <stop offset="1" stop-color="#5a8ffa" />
            </linearGradient>
        </defs>
        {{-- Stylized italic N: two angled strokes echoing the brand mark. --}}
        <path d="M10 40 24 8h7L17 40h-7Z" fill="url(#nx-mark-a)" />
        <path d="M17 40 31 8h7L24 40h-7Z" fill="url(#nx-mark-b)" fill-opacity="0.92" />
    </svg>

    @if ($wordmark)
        <span class="flex flex-col leading-none">
            <span class="font-display text-lg font-bold tracking-wide {{ $light ? 'text-white' : 'text-navy-900' }}">NETWORX</span>
            <span class="text-[0.65rem] font-medium tracking-[0.35em] {{ $light ? 'text-brand-300' : 'text-slate-500' }}">SOLUTIONS</span>
        </span>
    @endif
</span>
