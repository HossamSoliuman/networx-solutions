<x-layouts.public :site="$site" :navigation-services="$navigationServices" :title="$site['home_title']" :description="$site['home_intro']">
    <section class="relative isolate overflow-hidden bg-navy-950 text-white">
        <div class="absolute inset-0 -z-20">
            <img src="{{ $site['home_image_url'] }}" alt="Operational server infrastructure"
                class="h-full w-full object-cover opacity-45">
        </div>
        <div class="absolute inset-0 -z-10 bg-linear-to-r from-navy-950 via-navy-950/95 to-navy-950/35"></div>
        <div class="bg-machine-grid absolute inset-0 -z-10 opacity-30"></div>

        <div class="mx-auto grid min-h-[44rem] max-w-[90rem] items-end gap-12 px-5 py-16 sm:px-8 sm:py-20 lg:grid-cols-[1fr_0.55fr] lg:px-12 lg:py-24">
            <div class="max-w-4xl">
                <p class="site-reveal flex items-center gap-3 text-xs font-bold uppercase tracking-[0.24em] text-brand-200">
                    <span class="h-px w-10 bg-brand-400"></span>
                    {{ $site['home_eyebrow'] }}
                </p>
                <h1 class="site-reveal site-reveal-delay-1 mt-7 text-balance font-display text-5xl font-bold leading-[0.98] tracking-[-0.055em] text-white sm:text-6xl lg:text-[5.4rem]">
                    {{ $site['home_title'] }}
                </h1>
                <p class="site-reveal site-reveal-delay-2 mt-7 max-w-2xl text-lg leading-8 text-slate-300">
                    {{ $site['home_intro'] }}
                </p>
                <div class="site-reveal site-reveal-delay-3 mt-9 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('services.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-full bg-brand-500 px-6 py-3.5 text-sm font-bold text-white transition-all hover:-translate-y-0.5 hover:bg-brand-400">
                        Explore our services
                        <x-icon name="arrow-left" class="size-4 rotate-180" />
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center rounded-full border border-white/25 bg-white/5 px-6 py-3.5 text-sm font-bold text-white backdrop-blur transition-colors hover:bg-white/10">
                        Discuss a requirement
                    </a>
                </div>
            </div>

            <div class="grid gap-px overflow-hidden rounded-2xl bg-white/15 backdrop-blur-sm sm:grid-cols-3 lg:grid-cols-1">
                @foreach ([
                    ['06', 'connected disciplines'],
                    ['01', 'accountable partner'],
                    ['24/7', 'infrastructure mindset'],
                ] as [$value, $label])
                    <div class="bg-navy-950/65 p-6">
                        <p class="font-display text-3xl font-bold text-white">{{ $value }}</p>
                        <p class="mt-1 text-xs font-semibold uppercase tracking-[0.14em] text-slate-400">{{ $label }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-8 border-b border-slate-300 pb-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-end">
                <p class="section-kicker">What we operate</p>
                <div>
                    <h2 class="section-title">{{ $site['services_title'] }}</h2>
                    <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600">{{ $site['services_intro'] }}</p>
                </div>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @foreach ($services as $service)
                    <x-site.service-card :service="$service" :index="$loop->iteration" />
                @endforeach
            </div>

            <div class="mt-10 flex justify-end">
                <a href="{{ route('services.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-navy-950">
                    View the complete service catalogue
                    <x-icon name="arrow-left" class="size-4 rotate-180" />
                </a>
            </div>
        </div>
    </section>

    <section class="overflow-hidden bg-white">
        <div class="mx-auto grid max-w-[90rem] lg:grid-cols-2">
            <div class="relative min-h-[28rem] lg:min-h-[42rem]">
                <img src="{{ $site['about_image_url'] }}" alt="Enterprise network switching equipment"
                    class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-linear-to-t from-navy-950/55 to-transparent"></div>
                <div class="absolute bottom-7 left-7 rounded-full bg-white px-4 py-2 text-xs font-bold uppercase tracking-[0.14em] text-navy-950">
                    Real infrastructure. Real accountability.
                </div>
            </div>

            <div class="flex items-center px-5 py-16 sm:px-8 lg:px-14 lg:py-24 xl:px-20">
                <div class="max-w-xl">
                    <p class="section-kicker">{{ $site['about_eyebrow'] }}</p>
                    <h2 class="section-title mt-5">{{ $site['about_title'] }}</h2>
                    <p class="mt-6 text-lg leading-8 text-slate-600">{{ $site['about_intro'] }}</p>

                    <div class="mt-9 grid gap-5 sm:grid-cols-2">
                        @foreach ([
                            ['shield', 'Secure by default', 'Risk is addressed from the first decision, not added at the end.'],
                            ['network', 'Designed as one system', 'Support, network, cloud, and security work better when they work together.'],
                            ['headset', 'Clear ownership', 'You always know who is responsible and what happens next.'],
                            ['check', 'Built to be maintained', 'Documentation and support are part of the delivery, not an extra.'],
                        ] as [$icon, $title, $copy])
                            <div class="border-t border-slate-200 pt-4">
                                <x-icon :name="$icon" class="size-5 text-brand-600" />
                                <h3 class="mt-3 font-display font-bold text-navy-950">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('about') }}" class="mt-9 inline-flex items-center gap-2 text-sm font-bold text-brand-700">
                        More about Networx
                        <x-icon name="arrow-left" class="size-4 rotate-180" />
                    </a>
                </div>
            </div>
        </div>
    </section>

    <x-site.cta :site="$site" />
</x-layouts.public>
