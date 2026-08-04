@php
    $title = trim($__env->yieldContent('title')) ?: null;
    $description = trim($__env->yieldContent('description')) ?: null;
    $focused = trim($__env->yieldContent('focused')) === 'true';
    $pageTitle = $title ? $title.' · '.$site['site_name'] : ($site['seo_meta_title'] ?: $site['site_name']);
    $metaDescription = $description ?: ($site['seo_meta_description'] ?: $site['home_intro']);
    $phoneHref = $site['contact_phone'] ? preg_replace('/[^+\d]/', '', $site['contact_phone']) : null;
    $mapsUrl = $site['address']
        ? 'https://www.google.com/maps/search/?api=1&query='.rawurlencode($site['address'])
        : null;
    $isRtl = app()->isLocale('ar');
    $alternateLocale = $isRtl ? 'en' : 'ar';
    $alternateLocaleLabel = $isRtl
        ? __('public.locale.switch_to_english')
        : __('public.locale.switch_to_arabic');
    $localeSwitchUrl = request()->fullUrlWithQuery(['lang' => $alternateLocale]);

    // Structured data read by search engines and AI assistants alike.
    $structuredData = [
        '@context' => 'https://schema.org',
        '@graph' => [
            array_filter([
                '@type' => 'Organization',
                'name' => $site['site_name'],
                'url' => url('/'),
                'description' => $site['ai_summary'] ?: $site['seo_meta_description'],
                'slogan' => $site['tagline'] ?: null,
                'email' => $site['contact_email'] ?: null,
                'telephone' => $site['contact_phone'] ?: null,
                'address' => $site['address'] ?: null,
                'sameAs' => array_values(array_filter([
                    $site['linkedin_url'],
                    $site['facebook_url'],
                    $site['instagram_url'],
                ])) ?: null,
                'knowsAbout' => $navigationServices->map(fn ($service): string => $service->localizedName())->all() ?: null,
            ]),
            [
                '@type' => 'WebSite',
                'name' => $site['site_name'],
                'url' => url('/'),
            ],
        ],
    ];
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription }}">
    @if ($site['seo_keywords'])
        <meta name="keywords" content="{{ $site['seo_keywords'] }}">
    @endif
    <meta name="theme-color" content="#0080fc">
    <link rel="icon" href="{{ asset('favicon.png') }}" type="image/png">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $site['site_name'] }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $site['home_image_url'] }}">
    <meta property="og:locale" content="{{ $isRtl ? 'ar_AR' : 'en_US' }}">

    <link rel="canonical" href="{{ url()->current() }}">
    <title>{{ $pageTitle }}</title>

    <script type="application/ld+json">{!! json_encode($structuredData, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=barlow:400,500,600,700|barlow-semi-condensed:500,600,700|cairo:400,500,600,700|ibm-plex-mono:500,600"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body @class([
    'min-h-full bg-canvas font-sans text-slate-900 antialiased',
    'lg:h-dvh lg:overflow-hidden' => $focused,
])>
    <a href="#main-content"
        class="fixed start-4 top-4 z-[100] -translate-y-24 rounded-full bg-white px-5 py-3 text-sm font-bold text-navy-950 shadow-xl transition-transform focus:translate-y-0">
        {{ __('public.accessibility.skip_to_content') }}
    </a>

    @unless ($focused)
        <div class="hidden bg-navy-950 text-slate-300 sm:block">
            <div class="mx-auto flex min-h-10 max-w-[90rem] items-center justify-between gap-6 px-8 py-2 text-xs lg:px-12">
                <p class="flex items-center gap-2.5 font-mono font-semibold uppercase tracking-[0.14em] text-brand-200">
                    <span class="size-1.5 rounded-full bg-signal-400 shadow-[0_0_0_4px_rgba(53,212,170,0.12)]"></span>
                    <bdi>{{ $site['tagline'] }}</bdi>
                </p>

                <div class="flex items-center gap-6">
                    @if ($mapsUrl)
                        <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
                            aria-label="{{ __('public.accessibility.view_on_maps', ['address' => $site['address']]) }}"
                            class="hidden items-center gap-2 transition-colors hover:text-white md:inline-flex">
                            <x-icon name="map-pin" class="size-3.5" />
                            <bdi>{{ $site['address'] }}</bdi>
                        </a>
                    @endif
                    @if ($site['contact_phone'])
                        <a href="tel:{{ $phoneHref }}" class="inline-flex items-center gap-2 transition-colors hover:text-white">
                            <x-icon name="phone" class="size-3.5" />
                            <bdi dir="ltr">{{ $site['contact_phone'] }}</bdi>
                        </a>
                    @endif
                    <a href="{{ route('contact') }}" data-modal-open="contact-modal" class="inline-flex items-center gap-2 font-bold text-white">
                        {{ __('public.navigation.start_project') }}
                        <x-icon name="arrow-left" class="size-3.5 rotate-180 rtl:rotate-0" />
                    </a>
                </div>
            </div>
        </div>
    @endunless

    <header data-site-header
        class="site-header sticky top-0 z-50 border-b border-slate-200/80 bg-paper/95 backdrop-blur-xl transition-shadow">
        <div class="mx-auto flex h-16 max-w-[90rem] items-center justify-between gap-6 px-5 sm:px-8 lg:px-12">
            <a href="{{ route('home') }}" aria-label="{{ __('public.accessibility.home_label', ['site' => $site['site_name']]) }}">
                <x-logo />
            </a>

            <nav class="hidden items-center gap-8 lg:flex" aria-label="{{ __('public.accessibility.main_navigation') }}">
                <a href="{{ route('home') }}" class="site-nav-link"
                    @if (request()->routeIs('home')) aria-current="page" @endif>
                    {{ __('public.navigation.home') }}
                </a>

                <div class="group relative">
                    <a href="{{ route('services.index') }}" class="site-nav-link"
                        @if (request()->routeIs('services.*')) aria-current="page" @endif aria-haspopup="true">
                        {{ __('public.navigation.services') }}
                        <x-icon name="chevron-down" class="size-3.5 transition-transform group-hover:rotate-180" />
                    </a>

                    <div
                        class="invisible absolute left-1/2 top-[calc(100%-0.15rem)] w-[43rem] -translate-x-1/2 translate-y-2 pt-5 opacity-0 transition duration-200 group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-[0_28px_70px_-30px_rgba(5,26,53,0.45)]">
                            <div class="grid grid-cols-2 gap-px bg-slate-200">
                                @foreach ($navigationServices as $navigationService)
                                    <a href="{{ route('services.show', $navigationService) }}"
                                        class="group/service flex items-center justify-between gap-4 bg-white px-5 py-4 transition-colors hover:bg-brand-50">
                                        <bdi class="text-sm font-bold text-navy-950">{{ $navigationService->localizedName() }}</bdi>
                                        <x-icon name="arrow-left"
                                            class="size-4 rotate-180 text-brand-600 transition-transform group-hover/service:translate-x-1 rtl:rotate-0 rtl:group-hover/service:-translate-x-1" />
                                    </a>
                                @endforeach
                            </div>
                            <a href="{{ route('services.index') }}"
                                class="flex items-center justify-between gap-4 bg-navy-950 px-5 py-4 text-sm font-bold text-white">
                                <span>{{ __('public.navigation.service_catalogue') }}</span>
                                <x-icon name="arrow-left" class="size-4 rotate-180 rtl:rotate-0" />
                            </a>
                        </div>
                    </div>
                </div>

                <a href="{{ route('about') }}" class="site-nav-link"
                    @if (request()->routeIs('about')) aria-current="page" @endif>
                    {{ __('public.navigation.about') }}
                </a>
                <a href="{{ route('contact') }}" class="site-nav-link"
                    @if (request()->routeIs('contact')) aria-current="page" @endif>
                    {{ __('public.navigation.contact') }}
                </a>
            </nav>

            <div class="hidden items-center gap-3 lg:flex">
                <a href="{{ $localeSwitchUrl }}" hreflang="{{ $alternateLocale }}"
                    aria-label="{{ __('public.locale.change_language') }}"
                    class="inline-flex min-h-10 items-center gap-2 rounded-full border border-slate-300 px-4 py-2 text-sm font-bold text-navy-950 transition-colors hover:border-brand-400 hover:text-brand-700">
                    <x-icon name="globe" class="size-4" />
                    <bdi>{{ $alternateLocaleLabel }}</bdi>
                </a>
                <a href="{{ route('contact') }}" data-modal-open="contact-modal" class="button-dark min-h-10 px-5 py-2">
                    {{ __('public.navigation.get_quote') }}
                    <x-icon name="arrow-left" class="size-4 rotate-180 rtl:rotate-0" />
                </a>
            </div>

            <button type="button" data-site-menu-toggle aria-expanded="false" aria-controls="site-menu"
                aria-label="{{ __('public.accessibility.open_navigation') }}"
                data-open-label="{{ __('public.accessibility.open_navigation') }}"
                data-close-label="{{ __('public.accessibility.close_navigation') }}"
                class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 text-navy-950 transition-colors hover:border-brand-400 hover:text-brand-700 lg:hidden">
                <span data-site-menu-open-icon>
                    <x-icon name="menu" />
                </span>
                <span data-site-menu-close-icon class="hidden">
                    <x-icon name="x" />
                </span>
            </button>
        </div>

        <nav id="site-menu" data-site-menu
            class="absolute inset-x-0 top-full hidden max-h-[calc(100vh-4rem)] overflow-y-auto border-t border-slate-200 bg-paper px-5 pb-8 shadow-2xl lg:hidden"
            aria-label="{{ __('public.accessibility.mobile_navigation') }}">
            <div class="mx-auto max-w-[90rem]">
                <a href="{{ route('home') }}" class="site-mobile-link"
                    @if (request()->routeIs('home')) aria-current="page" @endif>
                    {{ __('public.navigation.home') }}
                    <span class="technical-label text-slate-400">01</span>
                </a>
                <a href="{{ route('services.index') }}" class="site-mobile-link"
                    @if (request()->routeIs('services.*')) aria-current="page" @endif>
                    {{ __('public.navigation.services') }}
                    <span class="technical-label text-slate-400">02</span>
                </a>

                @if ($navigationServices->isNotEmpty())
                    <div class="grid gap-1 border-b border-slate-200 py-3 sm:grid-cols-2">
                        @foreach ($navigationServices as $navigationService)
                            <a href="{{ route('services.show', $navigationService) }}"
                                class="rounded-xl px-3 py-2.5 text-sm font-semibold text-slate-600 transition-colors hover:bg-brand-50 hover:text-brand-700">
                                <bdi>{{ $navigationService->localizedName() }}</bdi>
                            </a>
                        @endforeach
                    </div>
                @endif

                <a href="{{ route('about') }}" class="site-mobile-link"
                    @if (request()->routeIs('about')) aria-current="page" @endif>
                    {{ __('public.navigation.about') }}
                    <span class="technical-label text-slate-400">03</span>
                </a>
                <a href="{{ route('contact') }}" class="site-mobile-link"
                    @if (request()->routeIs('contact')) aria-current="page" @endif>
                    {{ __('public.navigation.contact') }}
                    <span class="technical-label text-slate-400">04</span>
                </a>

                @if ($mapsUrl)
                    <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
                        aria-label="{{ __('public.accessibility.view_on_maps', ['address' => $site['address']]) }}"
                        class="mt-4 flex items-center gap-3 rounded-xl bg-canvas px-4 py-3 text-sm font-semibold text-navy-950 transition-colors hover:bg-brand-50">
                        <x-icon name="map-pin" class="size-4 text-brand-600" />
                        <bdi>{{ $site['address'] }}</bdi>
                    </a>
                @endif

                <div class="mt-6 grid grid-cols-2 gap-3">
                    <a href="{{ $localeSwitchUrl }}" hreflang="{{ $alternateLocale }}"
                        class="button-light border border-slate-300" aria-label="{{ __('public.locale.change_language') }}">
                        <x-icon name="globe" class="size-4" />
                        <bdi>{{ $alternateLocaleLabel }}</bdi>
                    </a>
                    <a href="{{ route('contact') }}" data-modal-open="contact-modal" class="button-primary">
                        {{ __('public.navigation.start_project') }}
                    </a>
                </div>
            </div>
        </nav>
    </header>

    <main id="main-content" @class(['lg:h-[calc(100dvh-4rem)] lg:overflow-y-auto' => $focused])>
        @yield('content')
    </main>

    @unless ($focused)
        <footer class="relative overflow-hidden bg-navy-950 text-slate-300">
        <div class="bg-technical-dots absolute -end-40 top-0 size-[32rem] opacity-40"></div>

        <div class="relative mx-auto max-w-[90rem] px-5 py-14 sm:px-8 lg:px-12 lg:py-20">
            <div class="grid gap-12 border-b border-white/10 pb-12 lg:grid-cols-[1.15fr_0.55fr_1fr_0.8fr] lg:gap-16">
                <div>
                    <x-logo light />
                    <p class="mixed-direction mt-5 max-w-sm text-sm leading-7 text-slate-400">{{ $site['home_intro'] }}</p>
                    <p class="mt-6 inline-flex items-center gap-2.5 rounded-full border border-white/10 bg-white/5 px-4 py-2 font-mono text-[0.65rem] uppercase tracking-[0.14em] text-slate-300">
                        <span class="size-1.5 rounded-full bg-signal-400"></span>
                        {{ __('public.footer.partner') }}
                    </p>
                </div>

                <div>
                    <p class="technical-label text-white">{{ __('public.footer.company') }}</p>
                    <div class="mt-5 grid gap-3 text-sm">
                        <a href="{{ route('home') }}" class="footer-link">{{ __('public.navigation.home') }}</a>
                        <a href="{{ route('about') }}" class="footer-link">{{ __('public.navigation.about') }}</a>
                        <a href="{{ route('services.index') }}" class="footer-link">{{ __('public.navigation.services') }}</a>
                        <a href="{{ route('contact') }}" data-modal-open="contact-modal" class="footer-link">{{ __('public.navigation.contact') }}</a>
                    </div>
                </div>

                <div>
                    <p class="technical-label text-white">{{ __('public.footer.capabilities') }}</p>
                    <div class="mt-5 grid gap-3 text-sm sm:grid-cols-2 lg:grid-cols-1">
                        @foreach ($navigationServices as $navigationService)
                            <a href="{{ route('services.show', $navigationService) }}" class="footer-link">
                                <bdi>{{ $navigationService->localizedName() }}</bdi>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div>
                    <p class="technical-label text-white">{{ __('public.footer.talk_to') }}</p>
                    <div class="mt-5 grid gap-4 text-sm">
                        @if ($site['contact_email'])
                            <a href="mailto:{{ $site['contact_email'] }}"
                                class="flex items-start gap-3 text-slate-400 transition-colors hover:text-white">
                                <x-icon name="envelope" class="mt-0.5 size-4 text-brand-300" />
                                <bdi dir="ltr" class="break-all">{{ $site['contact_email'] }}</bdi>
                            </a>
                        @endif
                        @if ($site['contact_phone'])
                            <a href="tel:{{ $phoneHref }}"
                                class="flex items-start gap-3 text-slate-400 transition-colors hover:text-white">
                                <x-icon name="phone" class="mt-0.5 size-4 text-brand-300" />
                                <bdi dir="ltr">{{ $site['contact_phone'] }}</bdi>
                            </a>
                        @endif
                        @if ($mapsUrl)
                            <a href="{{ $mapsUrl }}" target="_blank" rel="noopener noreferrer"
                                aria-label="{{ __('public.accessibility.view_on_maps', ['address' => $site['address']]) }}"
                                class="flex items-start gap-3 text-slate-400 transition-colors hover:text-white">
                                <x-icon name="map-pin" class="mt-0.5 size-4 text-brand-300" />
                                <bdi>{{ $site['address'] }}</bdi>
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-5 pt-7 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>{{ __('public.footer.rights', ['year' => now()->year, 'site' => $site['site_name']]) }}</p>

                <div class="flex flex-wrap items-center gap-5">
                    <div class="flex items-center gap-2">
                        @if ($site['linkedin_url'])
                            <a href="{{ $site['linkedin_url'] }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex size-10 items-center justify-center rounded-full border border-white/15 text-slate-400 transition duration-200 hover:-translate-y-0.5 hover:border-brand-300/60 hover:bg-brand-500/15 hover:text-white"
                                aria-label="{{ __('public.accessibility.opens_new_tab', ['network' => 'LinkedIn']) }}">
                                <x-icon name="linkedin" solid class="size-4" />
                            </a>
                        @endif
                        @if ($site['facebook_url'])
                            <a href="{{ $site['facebook_url'] }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex size-10 items-center justify-center rounded-full border border-white/15 text-slate-400 transition duration-200 hover:-translate-y-0.5 hover:border-brand-300/60 hover:bg-brand-500/15 hover:text-white"
                                aria-label="{{ __('public.accessibility.opens_new_tab', ['network' => 'Facebook']) }}">
                                <x-icon name="facebook" solid class="size-4" />
                            </a>
                        @endif
                        @if ($site['instagram_url'])
                            <a href="{{ $site['instagram_url'] }}" target="_blank" rel="noopener noreferrer"
                                class="inline-flex size-10 items-center justify-center rounded-full border border-white/15 text-slate-400 transition duration-200 hover:-translate-y-0.5 hover:border-brand-300/60 hover:bg-brand-500/15 hover:text-white"
                                aria-label="{{ __('public.accessibility.opens_new_tab', ['network' => 'Instagram']) }}">
                                <x-icon name="instagram" solid class="size-4" />
                            </a>
                        @endif
                    </div>
                    <span class="font-mono uppercase tracking-[0.12em]">{{ __('public.footer.promise') }}</span>
                </div>
            </div>
        </div>
        </footer>
    @endunless

    @unless ($focused)
        @include('partials.contact-modal', ['services' => $navigationServices])
    @endunless

    <x-flash />
</body>

</html>
