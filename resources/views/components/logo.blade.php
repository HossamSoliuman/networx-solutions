@props(['wordmark' => true, 'light' => false])

<span {{ $attributes->merge(['class' => 'inline-flex items-center gap-2.5']) }}>
    <svg class="size-10 shrink-0" viewBox="0 0 52 48" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <defs>
            <linearGradient id="nx-mark-a" x1="8" y1="42" x2="25" y2="6" gradientUnits="userSpaceOnUse">
                <stop stop-color="#0754c7" />
                <stop offset="1" stop-color="#1499f4" />
            </linearGradient>
            <linearGradient id="nx-mark-b" x1="22" y1="8" x2="39" y2="42" gradientUnits="userSpaceOnUse">
                <stop stop-color="#0d2f67" />
                <stop offset="1" stop-color="#0754c7" />
            </linearGradient>
            <linearGradient id="nx-mark-c" x1="34" y1="42" x2="48" y2="6" gradientUnits="userSpaceOnUse">
                <stop stop-color="#0866e5" />
                <stop offset="1" stop-color="#2db7f5" />
            </linearGradient>
        </defs>
        <path d="M4 41 18 7h11L15 41H4Z" fill="url(#nx-mark-a)" />
        <path d="M18 7h11l14 34H32L18 7Z" fill="url(#nx-mark-b)" />
        <path d="M32 41 46 7h6L38 41h-6Z" fill="url(#nx-mark-c)" />
    </svg>

    @if ($wordmark)
        <span class="flex flex-col leading-none">
            <span class="font-display text-[1.15rem] font-extrabold tracking-[0.04em] {{ $light ? 'text-white' : 'text-navy-950' }}">NETWORX</span>
            <span class="mt-1 text-[0.58rem] font-semibold tracking-[0.42em] {{ $light ? 'text-brand-200' : 'text-slate-500' }}">SOLUTIONS</span>
        </span>
    @endif
</span>
