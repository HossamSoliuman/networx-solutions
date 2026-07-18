@props(['align' => 'right', 'width' => 'w-48'])

<div class="relative" data-dropdown>
    <div data-dropdown-trigger>
        {{ $trigger }}
    </div>

    <div data-dropdown-menu
        class="absolute z-30 mt-2 hidden {{ $width }} {{ $align === 'right' ? 'right-0' : 'left-0' }} origin-top rounded-lg bg-white py-1 shadow-lg ring-1 ring-slate-900/10">
        {{ $slot }}
    </div>
</div>
