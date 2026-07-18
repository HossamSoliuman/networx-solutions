@props(['site', 'navigationServices', 'title' => null, 'description' => null])

@php
    $pageTitle = $title ? $title.' · '.$site['site_name'] : $site['site_name'];
    $metaDescription = $description ?: $site['home_intro'];
    $phoneHref = $site['contact_phone'] ? preg_replace('/[^+\d]/', '', $site['contact_phone']) : null;
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{ $metaDescription }}">
    <meta name="theme-color" content="#071a2f">
    <title>{{ $pageTitle }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=archivo:500,600,700,800|ibm-plex-sans:400,500,600,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-full bg-[#f7f8f5] font-sans text-slate-900 antialiased">
    <div class="bg-navy-950 text-slate-300">
        <div class="mx-auto flex min-h-10 max-w-[90rem] items-center justify-end gap-6 px-5 py-2 text-xs sm:justify-between sm:px-8 lg:px-12">
            <p class="hidden font-semibold uppercase tracking-[0.16em] text-brand-200 sm:block">{{ $site['tagline'] }}</p>

            <div class="flex items-center gap-5">
                @if ($site['contact_phone'])
                    <a href="tel:{{ $phoneHref }}" class="hidden items-center gap-2 transition-colors hover:text-white sm:inline-flex">
                        <x-icon name="phone" class="size-3.5" />
                        {{ $site['contact_phone'] }}
                    </a>
                @endif
                <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 font-bold text-white">
                    Start a project
                    <x-icon name="arrow-left" class="size-3.5 rotate-180" />
                </a>
            </div>
        </div>
    </div>

    <header data-site-header class="sticky top-0 z-40 border-b border-slate-200/80 bg-[#f7f8f5]/95 backdrop-blur-xl transition-shadow">
        <div class="mx-auto flex h-20 max-w-[90rem] items-center justify-between gap-8 px-5 sm:px-8 lg:px-12">
            <a href="{{ route('home') }}" aria-label="{{ $site['site_name'] }} home">
                <x-logo />
            </a>

            <nav class="hidden items-center gap-8 lg:flex" aria-label="Main navigation">
                <a href="{{ route('home') }}" @class([
                    'site-nav-link',
                    'text-navy-950' => request()->routeIs('home'),
                ])>Home</a>
                <a href="{{ route('services.index') }}" @class([
                    'site-nav-link',
                    'text-navy-950' => request()->routeIs('services.*'),
                ])>Services</a>
                <a href="{{ route('about') }}" @class([
                    'site-nav-link',
                    'text-navy-950' => request()->routeIs('about'),
                ])>About</a>
                <a href="{{ route('contact') }}" @class([
                    'site-nav-link',
                    'text-navy-950' => request()->routeIs('contact'),
                ])>Contact</a>
            </nav>

            <a href="{{ route('contact') }}"
                class="hidden items-center justify-center gap-2 rounded-full bg-navy-950 px-5 py-3 text-sm font-bold text-white transition-all hover:-translate-y-0.5 hover:bg-brand-700 lg:inline-flex">
                Get a quote
                <x-icon name="arrow-left" class="size-4 rotate-180" />
            </a>

            <button type="button" data-site-menu-toggle aria-expanded="false" aria-controls="site-menu"
                class="inline-flex size-11 items-center justify-center rounded-full border border-slate-300 text-navy-950 lg:hidden">
                <span class="sr-only">Open navigation</span>
                <x-icon name="menu" />
            </button>
        </div>

        <nav id="site-menu" data-site-menu class="hidden border-t border-slate-200 bg-[#f7f8f5] px-5 py-5 shadow-xl lg:hidden" aria-label="Mobile navigation">
            <div class="mx-auto grid max-w-[90rem] gap-1">
                <a href="{{ route('home') }}" class="site-mobile-link">Home</a>
                <a href="{{ route('services.index') }}" class="site-mobile-link">Services</a>
                <a href="{{ route('about') }}" class="site-mobile-link">About</a>
                <a href="{{ route('contact') }}" class="site-mobile-link">Contact</a>
            </div>
        </nav>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="bg-navy-950 text-slate-300">
        <div class="mx-auto max-w-[90rem] px-5 py-14 sm:px-8 lg:px-12 lg:py-20">
            <div class="grid gap-12 border-b border-white/10 pb-12 md:grid-cols-[1.3fr_0.7fr_1fr]">
                <div>
                    <x-logo light />
                    <p class="mt-5 max-w-md text-sm leading-7 text-slate-400">{{ $site['home_intro'] }}</p>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-white">Navigate</p>
                    <div class="mt-5 grid gap-3 text-sm">
                        <a href="{{ route('home') }}" class="footer-link">Home</a>
                        <a href="{{ route('about') }}" class="footer-link">About</a>
                        <a href="{{ route('services.index') }}" class="footer-link">Services</a>
                        <a href="{{ route('contact') }}" class="footer-link">Contact</a>
                    </div>
                </div>

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-white">Core services</p>
                    <div class="mt-5 grid gap-3 text-sm sm:grid-cols-2">
                        @foreach ($navigationServices as $navigationService)
                            <a href="{{ route('services.show', $navigationService) }}" class="footer-link">{{ $navigationService->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-4 pt-7 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                <p>© {{ now()->year }} {{ $site['site_name'] }}. All rights reserved.</p>
                <div class="flex flex-wrap gap-5">
                    @if ($site['contact_email'])
                        <a href="mailto:{{ $site['contact_email'] }}" class="hover:text-white">{{ $site['contact_email'] }}</a>
                    @endif
                    @if ($site['address'])
                        <span>{{ $site['address'] }}</span>
                    @endif
                </div>
            </div>
        </div>
    </footer>

    <x-flash />
</body>

</html>
