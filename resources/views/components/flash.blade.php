@if (session('success') || session('error'))
    <div data-flash
        class="pointer-events-auto fixed right-4 top-4 z-50 flex max-w-sm items-start gap-3 rounded-xl bg-white p-4 shadow-lg ring-1 ring-slate-900/10 transition-all duration-300">
        @if (session('success'))
            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-emerald-100 text-emerald-600">
                <x-icon name="check" class="size-3.5" />
            </span>
            <p class="text-sm text-slate-700">{{ session('success') }}</p>
        @else
            <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                <x-icon name="warning" class="size-3.5" />
            </span>
            <p class="text-sm text-slate-700">{{ session('error') }}</p>
        @endif
    </div>
@endif
