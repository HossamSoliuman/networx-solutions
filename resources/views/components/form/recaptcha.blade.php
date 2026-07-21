@props(['class' => null])

@php
    $recaptchaEnabled = (bool) config('services.recaptcha.enabled');
    $recaptchaSiteKey = config('services.recaptcha.site_key');
    $recaptchaVersion = config('services.recaptcha.version', 'v2');
@endphp

@if ($recaptchaEnabled && $recaptchaSiteKey)
    @if ($recaptchaVersion === 'v2')
        <div {{ $attributes->merge(['class' => $class]) }}>
            <div @class([
                'inline-block max-w-full overflow-x-auto rounded-lg bg-white',
                'ring-2 ring-red-500' => $errors->has('g-recaptcha-response'),
            ])>
                <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
            </div>
            <x-form.error field="g-recaptcha-response" />
        </div>
    @else
        <input type="hidden" name="g-recaptcha-response" data-recaptcha-response>
    @endif
@endif
