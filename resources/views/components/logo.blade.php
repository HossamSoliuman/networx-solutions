@props(['wordmark' => true, 'light' => false])

@php
    $logoPath = $wordmark
        ? 'images/site/networx-logo-horizontal.jpeg'
        : 'images/site/networx-logo-badge.jpeg';
@endphp

<span
    {{ $attributes->merge([
        'class' => $wordmark
            ? 'inline-flex h-12 w-48 shrink-0 overflow-hidden'.($light ? ' rounded-lg bg-white ring-1 ring-white/15' : '')
            : 'inline-flex size-12 shrink-0 overflow-hidden rounded-full bg-white'.($light ? ' ring-1 ring-white/15' : ''),
    ]) }}>
    <img src="{{ asset($logoPath) }}" alt="Networx Solutions"
        class="h-full w-full object-cover object-center {{ $wordmark ? '' : 'scale-125' }} {{ $light ? '' : 'mix-blend-multiply' }}">
</span>
