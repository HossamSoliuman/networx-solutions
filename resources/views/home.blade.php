{{-- No title/description props: the home page head is controlled from the SEO settings tab. --}}
<x-layouts.public :site="$site" :navigation-services="$navigationServices">
    <section class="home-hero relative isolate overflow-hidden bg-navy-950 text-white">
        <img src="{{ $site['home_image_url'] }}" alt="Operational server infrastructure"
            class="hero-network-image absolute inset-0 -z-30 h-full w-full object-cover object-[58%_center] opacity-70 sm:opacity-80"
            fetchpriority="high">
        <div class="hero-image-shade absolute inset-0 -z-20"></div>
        <div class="bg-machine-grid absolute inset-0 -z-10 opacity-35"></div>
        <div class="bg-signal-glow absolute inset-0 -z-10"></div>
        <div class="hero-scan-beam absolute inset-0 -z-10" aria-hidden="true"></div>

        <div
            class="mx-auto grid max-w-[90rem] items-start gap-10 px-5 py-10 sm:px-8 sm:py-12 lg:min-h-[44rem] lg:grid-cols-[1.13fr_0.87fr] lg:gap-14 lg:px-12 lg:py-14 xl:gap-20">
            <div class="min-w-0 max-w-5xl">
                <p class="site-reveal section-kicker text-brand-200">{{ $site['home_eyebrow'] }}</p>
                @php
                    $heroSteps = collect(explode('.', (string) $site['home_title']))
                        ->map(fn (string $term): string => trim($term))
                        ->filter()
                        ->values();
                @endphp
                <h1 class="site-hero-title mt-4">
                    @if ($heroSteps->count() > 1)
                        <span class="hero-steps">
                            @foreach ($heroSteps as $index => $term)
                                <span class="hero-step site-reveal" style="--step: {{ $index }}; animation-delay: {{ 120 + $index * 130 }}ms">
                                    <span class="hero-step-dot" aria-hidden="true"></span>
                                    <span class="hero-step-term">{{ $term }}.</span>
                                </span>
                            @endforeach
                        </span>
                    @else
                        <span class="site-reveal site-reveal-delay-1">{{ $site['home_title'] }}</span>
                    @endif
                </h1>
                <p class="site-reveal site-reveal-delay-2 mt-5 max-w-2xl text-pretty text-lg leading-8 text-slate-200 sm:text-xl sm:leading-9">
                    {{ $site['home_intro'] }}
                </p>

                <div class="site-reveal site-reveal-delay-3 mt-7 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('contact') }}" data-modal-open="contact-modal" class="button-primary">
                        Discuss your requirements
                        <x-icon name="arrow-left" class="size-4 rotate-180" />
                    </a>
                    <a href="{{ route('services.index') }}" class="button-ghost-light">
                        Explore our services
                    </a>
                </div>

                <div class="site-reveal site-reveal-delay-3 mt-8 flex flex-wrap gap-x-6 gap-y-3 border-t border-white/10 pt-5">
                    @foreach (['Support', 'Networks', 'Cloud', 'Security', 'Surveillance', 'Microsoft 365'] as $capability)
                        <span class="flex items-center gap-2 text-xs font-semibold text-slate-400">
                            <span class="size-1 rounded-full bg-signal-400"></span>
                            {{ $capability }}
                        </span>
                    @endforeach
                </div>
            </div>

            <div class="site-reveal site-reveal-delay-2 relative min-w-0 lg:mt-6 lg:justify-self-end">
                <div
                    class="hero-operations-card relative min-w-0 w-full overflow-hidden rounded-[2rem] border border-white/15 bg-navy-950/90 p-5 shadow-[0_35px_100px_-35px_rgba(0,0,0,0.8)] backdrop-blur-md sm:p-7 lg:w-[31rem]">
                    <div class="flex items-center justify-between gap-4 border-b border-white/10 pb-5">
                        <div>
                            <p class="technical-label text-slate-500">Infrastructure view</p>
                            <p class="mt-1 font-display text-lg font-bold text-white">One operating picture</p>
                        </div>
                        <span
                            class="inline-flex items-center gap-2 rounded-full border border-signal-400/20 bg-signal-400/10 px-3 py-1.5 font-mono text-[0.62rem] font-semibold uppercase tracking-[0.12em] text-signal-200">
                            <span class="status-pulse size-1.5 rounded-full bg-signal-400"></span>
                            Connected
                        </span>
                    </div>

                    <div class="relative py-6">
                        <div class="bg-technical-dots absolute inset-0 opacity-70"></div>
                        <div class="relative grid grid-cols-2 gap-3">
                            @foreach ($services as $service)
                                <a href="{{ route('services.show', $service) }}"
                                    class="network-node group/node flex min-w-0 items-center gap-3 overflow-hidden rounded-2xl border border-white/10 bg-white/[0.06] p-3.5 transition hover:border-brand-300/35 hover:bg-brand-400/10">
                                    <span
                                        class="flex size-9 shrink-0 items-center justify-center rounded-xl bg-brand-400/10 text-brand-200">
                                        <x-icon :name="$service->icon" class="size-4" />
                                    </span>
                                    <span class="min-w-0 break-words text-xs font-bold leading-5 text-slate-200">{{ $service->name }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-px overflow-hidden rounded-2xl bg-white/10">
                        <div class="bg-navy-900/90 p-4">
                            <p class="font-display text-2xl font-bold text-white">{{ str_pad((string) $services->count(), 2, '0', STR_PAD_LEFT) }}</p>
                            <p class="technical-label mt-1 text-slate-500">Capabilities</p>
                        </div>
                        <div class="bg-navy-900/90 p-4">
                            <p class="font-display text-2xl font-bold text-white">01</p>
                            <p class="technical-label mt-1 text-slate-500">Partner</p>
                        </div>
                        <div class="bg-navy-900/90 p-4">
                            <p class="font-display text-2xl font-bold text-white">04</p>
                            <p class="technical-label mt-1 text-slate-500">Stages</p>
                        </div>
                    </div>
                </div>

                <div
                    class="hero-delivery-badge absolute -bottom-10 -left-5 hidden items-center gap-3 rounded-2xl border border-white/10 bg-white px-4 py-3 text-navy-950 shadow-xl sm:flex">
                    <span class="flex size-9 items-center justify-center rounded-full bg-signal-300/20 text-signal-500">
                        <x-icon name="check" class="size-4" />
                    </span>
                    <span>
                        <span class="technical-label block text-slate-400">Delivery principle</span>
                        <span class="mt-1 block text-sm font-bold">Clear ownership end to end</span>
                    </span>
                </div>
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 bg-slate-200">
        <div class="mx-auto grid max-w-[90rem] gap-px sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['network', 'One accountable team', 'Connected decisions across the stack.'],
                ['shield', 'Secure by design', 'Risk considered from the first decision.'],
                ['check', 'Documented delivery', 'Clear scope, handover, and next steps.'],
                ['cog', 'Built to be maintained', 'Practical systems your team can operate.'],
            ] as [$icon, $title, $copy])
                <div class="flex gap-4 bg-paper px-5 py-7 sm:px-8 lg:px-7">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                        <x-icon :name="$icon" class="size-4.5" />
                    </span>
                    <div>
                        <h2 class="font-display text-sm font-bold text-navy-950">{{ $title }}</h2>
                        <p class="mt-1 text-xs leading-5 text-slate-500">{{ $copy }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <section id="capabilities" class="relative overflow-hidden py-14 sm:py-16 lg:py-20">
        <div class="bg-public-grid absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-slate-300 pb-7 lg:grid-cols-[0.58fr_1.42fr] lg:items-start" data-reveal>
                <p class="section-kicker">Connected capabilities</p>
                <div>
                    <h2 class="section-title">{{ $site['services_title'] }}</h2>
                    <p class="mt-3 max-w-2xl text-base leading-7 text-slate-600 sm:text-lg sm:leading-8">
                        {{ $site['services_intro'] }}
                    </p>
                </div>
            </div>

            <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3" data-reveal-group>
                @foreach ($services as $service)
                    <div data-reveal>
                        <x-site.service-card :service="$service" :index="$loop->iteration" />
                    </div>
                @endforeach
            </div>

            <div class="mt-8 flex justify-end">
                <a href="{{ route('services.index') }}" class="text-link">
                    View the complete service catalogue
                    <x-icon name="arrow-left" class="size-4 rotate-180" />
                </a>
            </div>
        </div>
    </section>

    <section class="relative isolate overflow-hidden bg-navy-950 py-16 text-white sm:py-20">
        <div class="bg-machine-grid absolute inset-0 -z-10 opacity-45"></div>
        <div class="bg-signal-glow absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:gap-16">
                <div data-reveal>
                    <p class="section-kicker text-brand-200">Integrated by design</p>
                    <h2 class="mt-5 text-balance font-display text-4xl font-semibold leading-[1.03] tracking-[-0.035em] sm:text-5xl lg:text-6xl">
                        Better outcomes start with the whole system.
                    </h2>
                    <p class="mt-5 max-w-xl text-lg leading-8 text-slate-300">
                        Point solutions create new gaps when nobody owns the connections between them. Networx treats support, networks, cloud, and security as one operating environment.
                    </p>
                    <a href="{{ route('about') }}" class="mt-7 inline-flex items-center gap-2 text-sm font-bold text-brand-200">
                        See how we work
                        <x-icon name="arrow-left" class="size-4 rotate-180" />
                    </a>
                </div>

                <div class="grid gap-px overflow-hidden rounded-[2rem] bg-white/10 sm:grid-cols-2" data-reveal>
                    @foreach ([
                        ['eye', 'See the whole environment', 'Understand dependencies before choosing products or changing systems.'],
                        ['shield', 'Protect the weak points', 'Build security into identity, devices, networks, cloud, and operations.'],
                        ['cog', 'Make change without chaos', 'Sequence delivery around continuity, testing, and a clear handover.'],
                        ['users', 'Know who owns what', 'Keep responsibility visible from discovery through ongoing support.'],
                    ] as [$icon, $title, $copy])
                        <article class="bg-navy-900/80 p-6 sm:p-7">
                            <x-icon :name="$icon" class="size-5 text-signal-300" />
                            <h3 class="mt-4 font-display text-xl font-semibold text-white">{{ $title }}</h3>
                            <p class="mt-3 text-sm leading-7 text-slate-400">{{ $copy }}</p>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="mt-12 border-t border-white/10 pt-8" data-reveal>
                <p class="technical-label text-slate-500">The delivery path</p>
                <div class="mt-6 grid gap-7 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ([
                        ['01', 'Assess', 'Map the environment, business pressure, risk, and desired outcome.'],
                        ['02', 'Design', 'Define the architecture, scope, controls, and delivery sequence.'],
                        ['03', 'Deliver', 'Implement, test, document, and hand over without loose ends.'],
                        ['04', 'Support', 'Maintain, improve, and respond as the operation changes.'],
                    ] as [$number, $title, $copy])
                        <div class="relative border-l border-white/15 pl-5">
                            <span class="font-mono text-xs font-semibold text-brand-300">{{ $number }}</span>
                            <h3 class="mt-3 font-display text-lg font-semibold text-white">{{ $title }}</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-400">{{ $copy }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <div id="operational-handoff" class="section-handoff border-b border-slate-200 bg-paper">
        <div class="mx-auto flex min-h-16 max-w-[90rem] items-center gap-5 px-5 sm:px-8 lg:px-12">
            <span class="technical-label shrink-0 text-brand-700">Design to operations</span>
            <span class="handoff-track relative h-px flex-1 bg-slate-300" aria-hidden="true">
                <span class="absolute left-1/4 top-1/2 size-1.5 -translate-y-1/2 rounded-full bg-brand-500"></span>
                <span class="absolute left-1/2 top-1/2 size-1.5 -translate-y-1/2 rounded-full bg-brand-500"></span>
                <span class="absolute left-3/4 top-1/2 size-1.5 -translate-y-1/2 rounded-full bg-brand-500"></span>
                <span class="handoff-signal absolute left-0 top-1/2 size-2 -translate-y-1/2 rounded-full bg-signal-400"></span>
            </span>
            <span class="technical-label hidden shrink-0 text-slate-500 sm:inline">One accountable team</span>
        </div>
    </div>

    <section class="overflow-hidden bg-paper">
        <div class="mx-auto grid max-w-[90rem] lg:grid-cols-2">
            <div class="relative min-h-[28rem] lg:min-h-[40rem]" data-reveal>
                <img src="{{ $site['about_image_url'] }}" alt="Enterprise network switching equipment"
                    class="absolute inset-0 h-full w-full object-cover" loading="lazy">
                <div class="absolute inset-0 bg-linear-to-t from-navy-950/75 via-transparent to-transparent"></div>
                <div class="absolute inset-x-5 bottom-5 flex items-end justify-between gap-6 rounded-2xl border border-white/15 bg-navy-950/75 p-5 text-white backdrop-blur-md sm:inset-x-8 sm:bottom-8">
                    <div>
                        <p class="technical-label text-brand-200">Our standard</p>
                        <p class="mt-2 max-w-sm font-display text-xl font-bold">Real infrastructure. Clear accountability.</p>
                    </div>
                    <span class="hidden size-11 items-center justify-center rounded-full bg-signal-300/15 text-signal-300 sm:flex">
                        <x-icon name="check" class="size-5" />
                    </span>
                </div>
            </div>

            <div class="flex items-center px-5 py-14 sm:px-8 lg:px-14 lg:py-20 xl:px-20" data-reveal>
                <div class="max-w-xl">
                    <p class="section-kicker">{{ $site['about_eyebrow'] }}</p>
                    <h2 class="section-title mt-5">{{ $site['about_title'] }}</h2>
                    <p class="mt-6 text-lg leading-8 text-slate-600">{{ $site['about_intro'] }}</p>

                    <div class="mt-9 grid gap-5">
                        @foreach ([
                            ['Clarity before complexity', 'Straight answers, visible scope, and no mystery around the next step.'],
                            ['Operations before products', 'Technology choices begin with how your people and business need to work.'],
                            ['Accountability after launch', 'Documentation and support stay part of the delivery conversation.'],
                        ] as [$title, $copy])
                            <div class="flex gap-4 border-t border-slate-200 pt-5">
                                <span class="mt-1 size-2 shrink-0 rounded-full bg-brand-500"></span>
                                <div>
                                    <h3 class="font-display font-bold text-navy-950">{{ $title }}</h3>
                                    <p class="mt-1.5 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <a href="{{ route('about') }}" class="text-link mt-9">
                        More about Networx
                        <x-icon name="arrow-left" class="size-4 rotate-180" />
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-layouts.public>
