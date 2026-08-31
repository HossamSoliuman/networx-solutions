@props(['class' => null])

@php
    $recaptchaEnabled = (bool) config('services.recaptcha.enabled');
    $recaptchaSiteKey = config('services.recaptcha.site_key');
@endphp

@if ($recaptchaEnabled && $recaptchaSiteKey)
    <div {{ $attributes->merge(['class' => $class]) }}>
        <div data-recaptcha-shell @class([
            'recaptcha-shell',
            'ring-2 ring-red-500' => $errors->has('g-recaptcha-response'),
        ])>
            <div data-recaptcha-widget data-sitekey="{{ $recaptchaSiteKey }}"></div>
        </div>
        <x-form.error field="g-recaptcha-response" />
    </div>
@endif
