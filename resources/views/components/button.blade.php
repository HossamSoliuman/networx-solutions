@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button', 'href' => null, 'icon' => null])

@php
    $base = 'inline-flex items-center justify-center gap-1.5 rounded-lg font-medium transition-colors focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600 disabled:opacity-50';

    $sizes = [
        'sm' => 'px-2.5 py-1.5 text-xs',
        'md' => 'px-3.5 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-sm',
    ];

    $variants = [
        'primary' => 'bg-brand-600 text-white hover:bg-brand-700 shadow-sm',
        'secondary' => 'bg-white text-slate-700 ring-1 ring-inset ring-slate-300 hover:bg-slate-50',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 shadow-sm',
        'danger-soft' => 'bg-red-50 text-red-700 ring-1 ring-inset ring-red-200 hover:bg-red-100',
        'ghost' => 'text-slate-600 hover:bg-slate-100 hover:text-slate-900',
    ];

    $classes = "{$base} {$sizes[$size]} {$variants[$variant]}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<x-icon :name="$icon" class="size-4" />@endif
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if ($icon)<x-icon :name="$icon" class="size-4" />@endif
        {{ $slot }}
    </button>
@endif
