@props(['id', 'title'])

<dialog id="{{ $id }}"
    {{ $attributes->merge(['class' => 'm-auto w-full max-w-md rounded-xl p-0 shadow-xl backdrop:bg-navy-950/50 backdrop:backdrop-blur-sm open:animate-in']) }}>
    <div class="p-6">
        <div class="flex items-start justify-between gap-4">
            <h2 class="text-base font-semibold text-slate-900">{{ $title }}</h2>
            <button type="button" data-modal-close class="rounded-md p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600" aria-label="Close">
                <x-icon name="x" class="size-4" />
            </button>
        </div>

        <div class="mt-3 text-sm text-slate-600">
            {{ $slot }}
        </div>

        @isset($footer)
            <div class="mt-6 flex justify-end gap-2">
                {{ $footer }}
            </div>
        @endisset
    </div>
</dialog>
