@extends('layouts.public')

@section('title', __('public.about.page_title'))
@section('description', $site['about_intro'])

@section('content')
    <x-site.page-hero :eyebrow="$site['about_eyebrow']" :title="$site['about_title']" :intro="$site['about_intro']" compact
        :image="$site['about_image_url']" :image-alt="__('public.about.image_alt')">
        <x-slot:aside>
            <div class="w-full rounded-[1.5rem] border border-white/15 bg-navy-950/70 p-5 backdrop-blur-md lg:w-96">
                <div class="flex items-center gap-3 text-brand-200">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-white/10">
                        <x-icon name="building" class="size-4" />
                    </span>
                    <p class="technical-label">{{ __('public.about.company_profile') }}</p>
                </div>
                <p class="mixed-direction mt-4 text-sm leading-7 text-slate-200">{{ $site['about_story'] }}</p>
                @if ($site['address'])
                    <p class="mt-4 border-t border-white/10 pt-4 font-mono text-xs font-semibold uppercase tracking-[0.12em] text-signal-300">
                        <bdi>{{ $site['address'] }}</bdi>
                    </p>
                @endif
                @if ($site['linkedin_url'] || $site['facebook_url'] || $site['instagram_url'])
                    <div class="mt-2 flex items-center justify-between gap-4 border-t border-white/10 pt-3 sm:mt-4 sm:pt-4">
                        <p class="font-mono text-[0.65rem] font-semibold uppercase tracking-[0.16em] text-slate-400">
                            {{ __('public.about.follow_us') }}
                        </p>
                        <div class="flex items-center gap-2">
                            @if ($site['linkedin_url'])
                                <a href="{{ $site['linkedin_url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex size-10 items-center justify-center rounded-full bg-[#0a66c2] text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-[#004182] hover:shadow-md"
                                    aria-label="{{ __('public.accessibility.opens_new_tab', ['network' => 'LinkedIn']) }}">
                                    <x-icon name="linkedin" solid class="size-4" />
                                </a>
                            @endif
                            @if ($site['facebook_url'])
                                <a href="{{ $site['facebook_url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex size-10 items-center justify-center rounded-full bg-[#1877f2] text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-[#0866ff] hover:shadow-md"
                                    aria-label="{{ __('public.accessibility.opens_new_tab', ['network' => 'Facebook']) }}">
                                    <x-icon name="facebook" solid class="size-4" />
                                </a>
                            @endif
                            @if ($site['instagram_url'])
                                <a href="{{ $site['instagram_url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex size-10 items-center justify-center rounded-full bg-[linear-gradient(135deg,#833ab4_0%,#e1306c_50%,#f77737_100%)] text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:brightness-110 hover:shadow-md"
                                    aria-label="{{ __('public.accessibility.opens_new_tab', ['network' => 'Instagram']) }}">
                                    <x-icon name="instagram" solid class="size-4" />
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </x-slot:aside>
    </x-site.page-hero>

    <section class="relative overflow-hidden border-b border-slate-200 bg-white py-12 sm:py-14">
        <div class="bg-public-grid absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-slate-200 pb-7 lg:grid-cols-[0.45fr_1.55fr] lg:items-end" data-reveal>
                <p class="section-kicker">{{ __('public.about.vision') }}</p>
                <div>
                    <h2 class="section-title">{{ __('public.about.vision_title') }}</h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">
                        {{ __('public.about.vision_intro') }}
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
                @foreach (__('public.about.vision_cards') as $card)
                    <article class="rounded-[1.5rem] bg-brand-50/70 p-6 ring-1 ring-brand-100" data-reveal>
                        <span class="flex size-10 items-center justify-center rounded-xl bg-white text-brand-700 ring-1 ring-brand-100">
                            <x-icon :name="$card['icon']" class="size-5" />
                        </span>
                        <h3 class="mt-5 font-display text-xl font-bold text-navy-950">{{ $card['title'] }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $card['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative isolate overflow-hidden border-b border-navy-900 bg-navy-950 py-14 text-white sm:py-20">
        <div class="bg-machine-grid absolute inset-0 -z-10 opacity-35"></div>
        <div class="bg-signal-glow absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-white/10 pb-8 lg:grid-cols-[0.85fr_1.15fr] lg:items-end lg:gap-14" data-reveal>
                <div>
                    <p class="section-kicker text-brand-200">{{ __('public.about.founder.eyebrow') }}</p>
                    <h2 class="mt-4 text-balance font-display text-4xl font-semibold leading-[1.03] tracking-[-0.035em] text-white sm:text-5xl">
                        {{ __('public.about.founder.title') }}
                    </h2>
                </div>
                <p class="text-base leading-7 text-slate-300 sm:text-lg">{{ __('public.about.founder.intro') }}</p>
            </div>

            <div class="founder-letter mt-12 grid gap-10 lg:mt-16 lg:grid-cols-[minmax(0,20rem)_minmax(0,1fr)] lg:gap-16" data-reveal>
                <figure class="founder-plate mx-auto w-full max-w-xs lg:mx-0 lg:max-w-none lg:self-start">
                    <div class="founder-frame relative">
                        <div class="founder-photo-clip relative overflow-hidden rounded-[1.35rem]">
                            <img src="{{ asset('images/site/founder.png') }}"
                                alt="{{ __('public.about.founder.photo_alt') }}" loading="lazy" decoding="async"
                                class="founder-photo aspect-[4/5] w-full object-cover object-top">
                            <span class="founder-photo-veil" aria-hidden="true"></span>
                        </div>

                        <figcaption class="founder-plaque">
                            <p class="font-display text-xl font-bold leading-tight tracking-[-0.02em] text-white">
                                <bdi>{{ __('public.about.founder.name') }}</bdi>
                            </p>
                            <p class="technical-label mt-1.5 text-brand-300">{{ __('public.about.founder.role') }}</p>
                        </figcaption>
                    </div>

                </figure>

                <div class="min-w-0">
                    <div class="founder-rail space-y-6 text-pretty text-base leading-8 text-slate-200 sm:text-lg sm:leading-9">
                        <p class="founder-line mixed-direction">
                            {{ __('public.about.founder.opening_before') }}
                            <strong class="font-semibold text-brand-300">{{ __('public.about.founder.opening_brand') }}</strong>{{ __('public.about.founder.opening_after') }}
                        </p>
                        <p class="founder-line mixed-direction text-lg font-semibold text-white sm:text-xl">{{ __('public.about.founder.commitment') }}</p>
                        <p class="founder-line mixed-direction">
                            {{ __('public.about.founder.mission_before') }}
                            <strong class="font-semibold text-brand-300">{{ __('public.about.founder.microsoft_365') }}</strong>{{ __('public.about.founder.mission_middle') }}
                            <strong class="font-semibold text-brand-300">{{ __('public.about.founder.network') }}</strong>{{ __('public.about.founder.mission_cloud') }}
                            <strong class="font-semibold text-brand-300">{{ __('public.about.founder.cloud') }}</strong>{{ __('public.about.founder.mission_support') }}
                            <strong class="font-semibold text-brand-300">{{ __('public.about.founder.support') }}</strong>{{ __('public.about.founder.mission_after') }}
                        </p>
                        <p class="founder-line mixed-direction">
                            {{ __('public.about.founder.partnership_before') }}
                            <strong class="font-semibold text-brand-300">{{ __('public.about.founder.partnership_brand') }}</strong>{{ __('public.about.founder.partnership_after') }}
                        </p>
                    </div>

                    <div class="founder-signoff mt-10 grid gap-6 border-t border-white/10 pt-7 sm:grid-cols-[1fr_auto] sm:items-end sm:gap-10">
                        <div class="flex items-center gap-4">
                            <span class="flex size-11 shrink-0 items-center justify-center rounded-full bg-brand-400/10 text-brand-300 ring-1 ring-brand-300/30">
                                <x-icon name="shield" class="size-6" />
                            </span>
                            <p class="mixed-direction text-base font-medium leading-8 text-slate-100 sm:text-lg">{{ __('public.about.founder.closing') }}</p>
                        </div>
                        <p class="founder-signature text-brand-300 sm:justify-self-end" aria-label="{{ __('public.about.founder.name') }}">
                            <bdi>{{ __('public.about.founder.signature') }}</bdi>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="relative isolate overflow-hidden bg-navy-950 py-12 text-white sm:py-14">
        <div class="bg-machine-grid absolute inset-0 -z-10 opacity-40"></div>
        <div class="bg-signal-glow absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-white/10 pb-7 lg:grid-cols-[0.45fr_1.55fr] lg:items-end" data-reveal>
                <p class="section-kicker text-brand-200">{{ __('public.about.mission') }}</p>
                <div>
                    <h2 class="text-balance font-display text-4xl font-semibold leading-[1.03] tracking-[-0.035em] sm:text-5xl">
                        {{ __('public.about.mission_title') }}
                    </h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-300">
                        {{ __('public.about.mission_intro') }}
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-px overflow-hidden rounded-[1.5rem] bg-white/10 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
                @foreach (__('public.about.mission_cards') as $card)
                    <article class="bg-navy-900/85 p-6" data-reveal>
                        <div class="flex items-center gap-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-white/8 text-signal-300 ring-1 ring-white/10">
                                <x-icon :name="$card['icon']" class="size-5" />
                            </span>
                            <h3 class="font-display text-xl font-semibold text-white">{{ $card['title'] }}</h3>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-slate-400">{{ $card['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 bg-canvas py-12 sm:py-14">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-slate-200 pb-7 lg:grid-cols-[0.45fr_1.55fr] lg:items-end" data-reveal>
                <p class="section-kicker">{{ __('public.about.why_choose_us') }}</p>
                <div>
                    <h2 class="section-title">{{ __('public.about.trusted_partner') }}</h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">
                        {{ __('public.about.trusted_partner_intro') }}
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
                @foreach (__('public.about.choice_cards') as $card)
                    <article class="group flex gap-4 rounded-[1.5rem] bg-white p-6 ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:ring-brand-200" data-reveal>
                        <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700 transition group-hover:bg-brand-600 group-hover:text-white">
                            <x-icon :name="$card['icon']" class="size-5" />
                        </span>
                        <div>
                            <h3 class="font-display text-lg font-bold text-navy-950">{{ $card['title'] }}</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $card['copy'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
