@props(['technology'])

@php
    $logoUrl = $technology->logoUrl();
    $websiteUrl = $technology->website_url;
    $tag = $websiteUrl ? 'a' : 'div';
@endphp

<{{ $tag }} @if ($websiteUrl) href="{{ $websiteUrl }}" target="_blank" rel="noopener noreferrer"
        aria-label="{{ __('public.accessibility.opens_new_tab', ['network' => $technology->name]) }}" @endif
    {{ $attributes->merge(['class' => 'technology-card']) }}
    style="--technology-color: {{ $technology->brand_color }}">
    @if ($logoUrl)
        <img src="{{ $logoUrl }}" alt="{{ $technology->name }}" class="technology-logo" loading="lazy">
    @else
        <span class="technology-wordmark">{{ $technology->name }}</span>
    @endif
</{{ $tag }}>
