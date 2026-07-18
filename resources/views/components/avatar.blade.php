@props(['name'])

@php
    $initials = collect(explode(' ', trim($name)))
        ->filter()
        ->map(fn (string $part) => mb_strtoupper(mb_substr($part, 0, 1)))
        ->take(2)
        ->implode('');
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex size-8 shrink-0 items-center justify-center rounded-full bg-brand-100 text-xs font-semibold text-brand-800']) }}>
    {{ $initials ?: '?' }}
</span>
