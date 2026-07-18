<x-layouts.guest title="Reliable IT Solutions for Growing Businesses">
    @php
        $phoneHref = $contactPhone ? preg_replace('/[^+\d]/', '', $contactPhone) : null;
    @endphp

    <div class="min-h-screen overflow-x-clip bg-white text-slate-700">
        <div class="bg-navy-950 text-slate-200">
            <div class="mx-auto flex min-h-9 max-w-7xl items-center justify-between gap-6 px-5 py-2 text-xs sm:px-6 lg:px-8">
                <div class="flex items-center gap-5">
                    @if ($contactPhone)
                        <a href="tel:{{ $phoneHref }}" class="inline-flex items-center gap-2 transition-colors hover:text-white">
                            <x-icon name="phone" class="size-3.5 text-brand-300" />
                            <span>{{ $contactPhone }}</span>
                        </a>
                    @endif

                    @if ($contactEmail)
                        <a href="mailto:{{ $contactEmail }}" class="hidden items-center gap-2 transition-colors hover:text-white sm:inline-flex">
                            <x-icon name="envelope" class="size-3.5 text-brand-300" />
                            <span>{{ $contactEmail }}</span>
                        </a>
                    @endif
                </div>

                <div class="hidden items-center gap-5 md:flex">
                    @if ($address)
                        <span class="inline-flex items-center gap-2">
                            <x-icon name="building" class="size-3.5 text-brand-300" />
                            {{ $address }}
                        </span>
                    @endif
                    <a href="#contact" class="inline-flex items-center gap-2 border-l border-white/20 pl-5 transition-colors hover:text-white">
                        <x-icon name="headset" class="size-3.5 text-brand-300" />
                        Talk to an expert
                    </a>
                </div>
            </div>
        </div>

        <header data-site-header class="sticky top-0 z-40 border-b border-slate-200/80 bg-white/95 backdrop-blur-md transition-shadow">
            <div class="mx-auto flex h-[4.75rem] max-w-7xl items-center justify-between gap-8 px-5 sm:px-6 lg:px-8">
                <a href="{{ route('home') }}" aria-label="Networx Solutions home">
                    <x-logo />
                </a>

                <nav class="hidden items-center gap-7 lg:flex" aria-label="Main navigation">
                    <a href="#services" class="text-sm font-semibold text-slate-600 transition-colors hover:text-brand-700">Services</a>
                    <a href="#solutions" class="text-sm font-semibold text-slate-600 transition-colors hover:text-brand-700">Solutions</a>
                    <a href="#industries" class="text-sm font-semibold text-slate-600 transition-colors hover:text-brand-700">Industries</a>
                    <a href="#about" class="text-sm font-semibold text-slate-600 transition-colors hover:text-brand-700">About</a>
                    <a href="#careers" class="text-sm font-semibold text-slate-600 transition-colors hover:text-brand-700">Careers</a>
                </nav>

                <div class="hidden items-center gap-3 lg:flex">
                    <a href="#contact"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm shadow-brand-700/20 transition-colors hover:bg-brand-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                        Get a quote
                        <x-icon name="send" class="size-4" />
                    </a>
                </div>

                <button type="button" data-site-menu-toggle aria-expanded="false" aria-controls="site-menu"
                    class="inline-flex size-10 items-center justify-center rounded-lg border border-slate-200 text-navy-950 transition-colors hover:border-brand-200 hover:bg-brand-50 lg:hidden">
                    <span class="sr-only">Open navigation</span>
                    <x-icon name="menu" class="size-5" />
                </button>
            </div>

            <nav id="site-menu" data-site-menu class="hidden border-t border-slate-200 bg-white px-5 py-4 shadow-lg lg:hidden" aria-label="Mobile navigation">
                <div class="mx-auto grid max-w-7xl gap-1">
                    <a href="#services" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">Services</a>
                    <a href="#solutions" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">Solutions</a>
                    <a href="#industries" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">Industries</a>
                    <a href="#about" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">About</a>
                    <a href="#careers" class="rounded-lg px-3 py-2.5 text-sm font-semibold text-slate-700 hover:bg-brand-50 hover:text-brand-700">Careers</a>
                    <a href="#contact" class="mt-2 inline-flex items-center justify-center rounded-lg bg-brand-600 px-4 py-3 text-sm font-bold text-white">
                        Get a quote
                    </a>
                </div>
            </nav>
        </header>

        <main>
            <section class="relative isolate overflow-hidden bg-[#f8fbff]">
                <div class="bg-public-grid pointer-events-none absolute inset-0 -z-10"></div>
                <div class="absolute -right-44 top-10 -z-10 size-[32rem] rounded-full bg-brand-100/70 blur-3xl"></div>

                <div class="mx-auto grid max-w-7xl gap-12 px-5 py-16 sm:px-6 sm:py-20 lg:grid-cols-[1.02fr_0.98fr] lg:items-center lg:gap-16 lg:px-8 lg:py-24">
                    <div>
                        <p class="site-reveal inline-flex items-center gap-2 rounded-full border border-brand-200 bg-white px-3 py-1.5 text-xs font-bold uppercase tracking-[0.16em] text-brand-700 shadow-sm">
                            <span class="size-1.5 rounded-full bg-brand-500"></span>
                            IT that keeps business moving
                        </p>

                        <h1 class="site-reveal site-reveal-delay-1 mt-6 max-w-3xl font-display text-4xl font-extrabold leading-[1.08] tracking-[-0.035em] text-navy-950 sm:text-5xl lg:text-[3.45rem]">
                            Smart IT solutions for a
                            <span class="text-brand-600">connected future.</span>
                        </h1>

                        <p class="site-reveal site-reveal-delay-2 mt-6 max-w-xl text-base leading-7 text-slate-600 sm:text-lg">
                            Reliable support, secure infrastructure, and practical technology guidance—built around the way your team actually works.
                        </p>

                        <div class="site-reveal site-reveal-delay-3 mt-8 flex flex-col gap-3 sm:flex-row">
                            <a href="#services"
                                class="inline-flex items-center justify-center gap-2 rounded-lg bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-lg shadow-brand-700/15 transition-all hover:-translate-y-0.5 hover:bg-brand-700 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                                Explore our services
                                <x-icon name="arrow-left" class="size-4 rotate-180" />
                            </a>
                            <a href="#contact"
                                class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-navy-950 transition-colors hover:border-brand-300 hover:bg-brand-50">
                                Speak with our team
                            </a>
                        </div>

                        <div class="site-reveal site-reveal-delay-3 mt-10 grid max-w-xl grid-cols-2 gap-x-6 gap-y-4 border-t border-slate-200 pt-6 sm:grid-cols-4">
                            @foreach ([
                                ['shield', 'Secure by design'],
                                ['headset', 'Responsive support'],
                                ['network', 'Built to scale'],
                                ['check', 'Clear guidance'],
                            ] as [$icon, $label])
                                <div class="flex items-center gap-2 text-xs font-semibold leading-5 text-slate-600">
                                    <x-icon :name="$icon" class="size-4 text-brand-600" />
                                    <span>{{ $label }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="site-reveal site-reveal-delay-2 relative mx-auto w-full max-w-[35rem]">
                        <div class="relative min-h-[28rem] overflow-hidden rounded-[1.75rem] border border-brand-100 bg-white p-5 shadow-[0_28px_80px_-35px_rgba(7,52,111,0.28)] sm:p-7">
                            <div class="absolute inset-x-0 top-0 h-1 bg-linear-to-r from-brand-800 via-brand-500 to-cyan-400"></div>
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-brand-700">Networx infrastructure</p>
                                    <p class="mt-1 font-display text-lg font-bold text-navy-950">One connected technology partner</p>
                                </div>
                                <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-bold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                    <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                    Protected
                                </span>
                            </div>

                            <div class="relative mt-6 min-h-[18rem] overflow-hidden rounded-2xl border border-brand-100 bg-brand-50/70">
                                <div class="bg-public-grid absolute inset-0 opacity-80"></div>
                                <div class="absolute left-1/2 top-1/2 h-px w-3/5 -translate-x-1/2 bg-brand-200"></div>
                                <div class="absolute left-1/2 top-1/2 h-3/5 w-px -translate-y-1/2 bg-brand-200"></div>

                                <div class="absolute left-1/2 top-1/2 z-10 flex size-24 -translate-x-1/2 -translate-y-1/2 flex-col items-center justify-center rounded-full bg-navy-950 text-center text-white shadow-xl shadow-brand-900/20 ring-8 ring-white">
                                    <x-logo :wordmark="false" class="scale-75" />
                                    <span class="-mt-1 text-[0.65rem] font-bold uppercase tracking-[0.16em] text-brand-200">Connected</span>
                                </div>

                                @foreach ([
                                    ['class' => 'left-4 top-6 sm:left-7', 'icon' => 'headset', 'label' => 'Support'],
                                    ['class' => 'right-4 top-8 sm:right-7', 'icon' => 'cloud', 'label' => 'Cloud'],
                                    ['class' => 'bottom-7 left-4 sm:left-7', 'icon' => 'network', 'label' => 'Network'],
                                    ['class' => 'bottom-5 right-4 sm:right-7', 'icon' => 'shield', 'label' => 'Security'],
                                ] as $node)
                                    <div class="absolute {{ $node['class'] }} z-10 flex min-w-28 items-center gap-2.5 rounded-xl border border-slate-200 bg-white px-3 py-2.5 shadow-sm">
                                        <span class="flex size-8 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                                            <x-icon :name="$node['icon']" class="size-4" />
                                        </span>
                                        <span class="text-xs font-bold text-navy-950">{{ $node['label'] }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <div class="mt-5 grid grid-cols-3 divide-x divide-slate-200 rounded-xl border border-slate-200 bg-white py-3">
                                <div class="px-3 text-center">
                                    <p class="font-display text-lg font-extrabold text-navy-950">24/7</p>
                                    <p class="text-[0.65rem] font-semibold uppercase tracking-wide text-slate-500">Monitoring</p>
                                </div>
                                <div class="px-3 text-center">
                                    <p class="font-display text-lg font-extrabold text-navy-950">6</p>
                                    <p class="text-[0.65rem] font-semibold uppercase tracking-wide text-slate-500">Core services</p>
                                </div>
                                <div class="px-3 text-center">
                                    <p class="font-display text-lg font-extrabold text-navy-950">1</p>
                                    <p class="text-[0.65rem] font-semibold uppercase tracking-wide text-slate-500">Trusted team</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="services" class="scroll-mt-24 bg-white py-20 sm:py-24">
                <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
                    <div class="flex flex-col justify-between gap-6 border-b border-slate-200 pb-8 md:flex-row md:items-end">
                        <div class="max-w-2xl">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">What we do</p>
                            <h2 class="mt-3 text-balance font-display text-3xl font-extrabold tracking-[-0.025em] text-navy-950 sm:text-4xl">
                                Essential IT services, without the complexity.
                            </h2>
                        </div>
                        <p class="max-w-md text-sm leading-6 text-slate-600 sm:text-base">
                            From day-to-day support to long-term infrastructure, we bring the right expertise together around your business.
                        </p>
                    </div>

                    <div class="mt-10 grid gap-4 md:grid-cols-2 lg:grid-cols-3">
                        @forelse ($services as $service)
                            <article class="group relative min-h-64 overflow-hidden rounded-2xl border border-slate-200 bg-white p-6 transition-all duration-300 hover:-translate-y-1 hover:border-brand-200 hover:shadow-[0_18px_45px_-28px_rgba(7,52,111,0.35)]">
                                <div class="flex items-start justify-between gap-4">
                                    <span class="flex size-11 items-center justify-center rounded-xl bg-brand-50 text-brand-700 ring-1 ring-inset ring-brand-100 transition-colors group-hover:bg-brand-600 group-hover:text-white">
                                        <x-icon :name="$service->icon" class="size-5" />
                                    </span>
                                    <span class="font-display text-xs font-bold tracking-[0.18em] text-slate-300">
                                        {{ str_pad((string) $loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </span>
                                </div>

                                <h3 class="mt-7 font-display text-xl font-bold text-navy-950">{{ $service->name }}</h3>
                                <p class="mt-3 text-sm leading-6 text-slate-600">{{ $service->excerpt }}</p>

                                <a href="#contact" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-brand-700">
                                    Ask about this service
                                    <x-icon name="arrow-left" class="size-3.5 rotate-180 transition-transform group-hover:translate-x-1" />
                                </a>
                            </article>
                        @empty
                            <div class="rounded-2xl border border-dashed border-slate-300 p-8 text-sm text-slate-500 md:col-span-2 lg:col-span-3">
                                Our service catalogue is being updated. Contact us and we will help you find the right solution.
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <section id="solutions" class="scroll-mt-24 bg-slate-50 py-20 sm:py-24">
                <div class="mx-auto grid max-w-7xl gap-12 px-5 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:gap-20 lg:px-8">
                    <div class="lg:sticky lg:top-28 lg:self-start">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">How we help</p>
                        <h2 class="mt-3 text-balance font-display text-3xl font-extrabold tracking-[-0.025em] text-navy-950 sm:text-4xl">
                            Technology decisions that make business sense.
                        </h2>
                        <p class="mt-5 max-w-md text-base leading-7 text-slate-600">
                            We start with your goals, then shape the support, infrastructure, and protection your team needs—nothing extra.
                        </p>
                        <a href="#contact" class="mt-7 inline-flex items-center gap-2 text-sm font-bold text-brand-700">
                            Plan your next project
                            <x-icon name="arrow-left" class="size-4 rotate-180" />
                        </a>
                    </div>

                    <div class="divide-y divide-slate-200 border-y border-slate-200">
                        @foreach ([
                            [
                                'number' => '01',
                                'title' => 'Keep everyday operations reliable',
                                'copy' => 'Responsive help desk support, proactive maintenance, and clear ownership reduce downtime and keep your team productive.',
                                'items' => ['On-site and remote support', 'Device and system maintenance', 'Vendor coordination'],
                            ],
                            [
                                'number' => '02',
                                'title' => 'Build a stronger digital workplace',
                                'copy' => 'Secure networking, cloud services, and Microsoft 365 give your people dependable access to the tools and information they need.',
                                'items' => ['Network design and deployment', 'Cloud migration and management', 'Microsoft 365 enablement'],
                            ],
                            [
                                'number' => '03',
                                'title' => 'Protect what matters most',
                                'copy' => 'Layered security and smart surveillance help protect your systems, data, sites, and reputation from modern risks.',
                                'items' => ['Endpoint and network security', 'Monitoring and continuity planning', 'CCTV design and installation'],
                            ],
                        ] as $solution)
                            <article class="grid gap-5 py-8 sm:grid-cols-[3rem_1fr] sm:py-10">
                                <span class="font-display text-sm font-extrabold text-brand-600">{{ $solution['number'] }}</span>
                                <div>
                                    <h3 class="font-display text-xl font-bold text-navy-950 sm:text-2xl">{{ $solution['title'] }}</h3>
                                    <p class="mt-3 max-w-2xl text-sm leading-6 text-slate-600 sm:text-base sm:leading-7">{{ $solution['copy'] }}</p>
                                    <ul class="mt-5 grid gap-2 sm:grid-cols-2">
                                        @foreach ($solution['items'] as $item)
                                            <li class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                                                <span class="flex size-5 items-center justify-center rounded-full bg-brand-100 text-brand-700">
                                                    <x-icon name="check" class="size-3" />
                                                </span>
                                                {{ $item }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </section>

            <section id="industries" class="scroll-mt-24 bg-white py-20 sm:py-24">
                <div class="mx-auto max-w-7xl px-5 sm:px-6 lg:px-8">
                    <div class="mx-auto max-w-2xl text-center">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Industries</p>
                        <h2 class="mt-3 text-balance font-display text-3xl font-extrabold tracking-[-0.025em] text-navy-950 sm:text-4xl">
                            Practical IT for the places where work happens.
                        </h2>
                        <p class="mt-4 text-base leading-7 text-slate-600">
                            Flexible services for growing teams, multi-site operations, and technology-critical environments.
                        </p>
                    </div>

                    <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                        @foreach ([
                            ['building', 'Professional offices', 'Reliable day-to-day technology for focused, productive teams.'],
                            ['grid', 'Retail & hospitality', 'Connected sites, secure systems, and responsive support.'],
                            ['network', 'Warehousing & logistics', 'Infrastructure that keeps operations visible and moving.'],
                            ['shield', 'Healthcare & education', 'Secure access and dependable systems for essential services.'],
                        ] as [$icon, $title, $copy])
                            <article class="rounded-2xl border border-slate-200 bg-white p-5">
                                <x-icon :name="$icon" class="size-5 text-brand-700" />
                                <h3 class="mt-8 font-display text-base font-bold text-navy-950">{{ $title }}</h3>
                                <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                            </article>
                        @endforeach
                    </div>

                    <div class="mt-16 grid overflow-hidden rounded-[1.75rem] border border-brand-100 bg-brand-50 lg:grid-cols-[0.95fr_1.05fr]">
                        <div class="p-7 sm:p-10 lg:p-12">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Our approach</p>
                            <h3 class="mt-3 text-balance font-display text-2xl font-extrabold text-navy-950 sm:text-3xl">
                                A clear path from issue to improvement.
                            </h3>
                            <p class="mt-4 max-w-lg text-sm leading-6 text-slate-600 sm:text-base sm:leading-7">
                                Good IT should feel calm. Our process keeps decisions visible, responsibilities clear, and progress easy to understand.
                            </p>
                        </div>

                        <ol class="grid border-t border-brand-100 bg-white sm:grid-cols-2 lg:border-l lg:border-t-0">
                            @foreach ([
                                ['01', 'Discover', 'Understand your people, systems, and priorities.'],
                                ['02', 'Design', 'Build a practical plan around the right technology.'],
                                ['03', 'Deliver', 'Implement carefully with minimal disruption.'],
                                ['04', 'Support', 'Monitor, maintain, and improve as you grow.'],
                            ] as [$number, $title, $copy])
                                <li class="border-brand-100 p-6 sm:border-b sm:odd:border-r [&:nth-child(n+3)]:border-b-0">
                                    <span class="font-display text-xs font-extrabold text-brand-600">{{ $number }}</span>
                                    <h4 class="mt-5 font-display text-base font-bold text-navy-950">{{ $title }}</h4>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                                </li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </section>

            <section id="about" class="scroll-mt-24 bg-brand-50 py-20 sm:py-24">
                <div class="mx-auto grid max-w-7xl gap-12 px-5 sm:px-6 lg:grid-cols-[1.1fr_0.9fr] lg:items-center lg:gap-20 lg:px-8">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Why Networx</p>
                        <h2 class="mt-3 max-w-2xl text-balance font-display text-3xl font-extrabold tracking-[-0.025em] text-navy-950 sm:text-4xl">
                            A technology partner that speaks your language.
                        </h2>
                        <p class="mt-5 max-w-2xl text-base leading-7 text-slate-600">
                            We combine hands-on technical experience with straightforward communication. You get practical answers, accountable support, and solutions designed to keep delivering value after launch day.
                        </p>

                        <div class="mt-8 grid gap-5 border-t border-brand-200 pt-8 sm:grid-cols-3">
                            @foreach ([
                                ['Reliable', 'Consistent support and clear ownership.'],
                                ['Experienced', 'Skilled people across your IT environment.'],
                                ['Responsive', 'Fast communication when it matters.'],
                            ] as [$title, $copy])
                                <div>
                                    <p class="font-display text-lg font-bold text-navy-950">{{ $title }}</p>
                                    <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-brand-100 bg-white p-7 text-navy-950 shadow-[0_24px_70px_-42px_rgba(7,52,111,0.35)] sm:p-9">
                        <div class="flex size-12 items-center justify-center rounded-xl bg-brand-50 text-brand-700">
                            <x-icon name="shield" class="size-6" />
                        </div>
                        <p class="mt-8 text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Our mission</p>
                        <blockquote class="mt-3 font-display text-2xl font-bold leading-snug tracking-[-0.02em] sm:text-3xl">
                            Help businesses stay connected, secure, and productive through smart technology and trusted support.
                        </blockquote>
                        <div class="mt-8 flex items-center gap-3 border-t border-slate-200 pt-6">
                            <span class="flex size-9 items-center justify-center rounded-full bg-navy-950 text-xs font-bold text-white">NX</span>
                            <div>
                                <p class="text-sm font-bold text-navy-950">Networx Solutions</p>
                                <p class="text-xs text-slate-500">Connect · Secure · Empower</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <section id="careers" class="scroll-mt-24 border-b border-slate-200 bg-white py-16">
                <div class="mx-auto flex max-w-7xl flex-col justify-between gap-7 px-5 sm:px-6 md:flex-row md:items-center lg:px-8">
                    <div class="max-w-2xl">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Careers</p>
                        <h2 class="mt-3 font-display text-2xl font-extrabold text-navy-950 sm:text-3xl">Do thoughtful work with people who care.</h2>
                        <p class="mt-3 text-sm leading-6 text-slate-600 sm:text-base">
                            We are always interested in meeting practical problem-solvers who value good service and clear communication.
                        </p>
                    </div>
                    @if ($contactEmail)
                        <a href="mailto:{{ $contactEmail }}?subject=Careers%20at%20Networx%20Solutions"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-lg border border-slate-300 bg-white px-5 py-3 text-sm font-bold text-navy-950 transition-colors hover:border-brand-300 hover:bg-brand-50">
                            Introduce yourself
                            <x-icon name="envelope" class="size-4 text-brand-700" />
                        </a>
                    @endif
                </div>
            </section>

            <section id="contact" class="scroll-mt-24 bg-[#f6f9fd] py-20 sm:py-24">
                <div class="mx-auto grid max-w-7xl gap-10 px-5 sm:px-6 lg:grid-cols-[0.8fr_1.2fr] lg:gap-16 lg:px-8">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Let's connect</p>
                        <h2 class="mt-3 text-balance font-display text-3xl font-extrabold tracking-[-0.025em] text-navy-950 sm:text-4xl">
                            Tell us what you need. We’ll help you find the next step.
                        </h2>
                        <p class="mt-5 max-w-lg text-base leading-7 text-slate-600">
                            Share a quick overview of your business or project. Our team usually replies within one business day.
                        </p>

                        <div class="mt-8 grid gap-3">
                            @if ($contactEmail)
                                <a href="mailto:{{ $contactEmail }}" class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 transition-colors hover:border-brand-200">
                                    <span class="flex size-10 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                                        <x-icon name="envelope" class="size-5" />
                                    </span>
                                    <span>
                                        <span class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Email</span>
                                        <span class="mt-0.5 block text-sm font-bold text-navy-950">{{ $contactEmail }}</span>
                                    </span>
                                </a>
                            @endif

                            @if ($contactPhone)
                                <a href="tel:{{ $phoneHref }}" class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4 transition-colors hover:border-brand-200">
                                    <span class="flex size-10 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                                        <x-icon name="phone" class="size-5" />
                                    </span>
                                    <span>
                                        <span class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Phone</span>
                                        <span class="mt-0.5 block text-sm font-bold text-navy-950">{{ $contactPhone }}</span>
                                    </span>
                                </a>
                            @endif

                            @if ($address)
                                <div class="flex items-center gap-4 rounded-xl border border-slate-200 bg-white p-4">
                                    <span class="flex size-10 items-center justify-center rounded-lg bg-brand-50 text-brand-700">
                                        <x-icon name="building" class="size-5" />
                                    </span>
                                    <span>
                                        <span class="block text-xs font-semibold uppercase tracking-wide text-slate-500">Location</span>
                                        <span class="mt-0.5 block text-sm font-bold text-navy-950">{{ $address }}</span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="rounded-[1.75rem] border border-slate-200 bg-white p-6 shadow-[0_24px_70px_-38px_rgba(7,52,111,0.3)] sm:p-8">
                        @if (session('contact_success'))
                            <div class="flex min-h-80 flex-col items-center justify-center text-center">
                                <span class="flex size-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-700 ring-1 ring-inset ring-emerald-200">
                                    <x-icon name="check" class="size-7" />
                                </span>
                                <h3 class="mt-5 font-display text-2xl font-bold text-navy-950">Message received</h3>
                                <p class="mt-2 max-w-md text-sm leading-6 text-slate-600">{{ session('contact_success') }}</p>
                                <a href="{{ route('home') }}" class="mt-6 text-sm font-bold text-brand-700">Back to the website</a>
                            </div>
                        @else
                            <div class="flex items-start justify-between gap-5 border-b border-slate-200 pb-5">
                                <div>
                                    <h3 class="font-display text-xl font-bold text-navy-950">Start a conversation</h3>
                                    <p class="mt-1 text-sm text-slate-500">A few details are enough to get started.</p>
                                </div>
                                <span class="hidden rounded-full bg-brand-50 px-3 py-1 text-xs font-bold text-brand-700 sm:inline-flex">1 business day</span>
                            </div>

                            <form method="POST" action="{{ route('contact.store') }}" class="mt-6 grid gap-5">
                                @csrf

                                <div class="hidden" aria-hidden="true">
                                    <label for="website-field">Website</label>
                                    <input id="website-field" type="text" name="website" tabindex="-1" autocomplete="off">
                                </div>

                                <div class="grid gap-5 sm:grid-cols-2">
                                    <div>
                                        <x-form.label for="contact-name">Name</x-form.label>
                                        <x-form.input id="contact-name" name="name" :value="old('name')" required autocomplete="name" class="mt-2" />
                                        <x-form.error field="name" />
                                    </div>
                                    <div>
                                        <x-form.label for="contact-email">Work email</x-form.label>
                                        <x-form.input id="contact-email" name="email" type="email" :value="old('email')" required autocomplete="email" class="mt-2" />
                                        <x-form.error field="email" />
                                    </div>
                                    <div>
                                        <x-form.label for="contact-phone">Phone <span class="font-normal text-slate-400">(optional)</span></x-form.label>
                                        <x-form.input id="contact-phone" name="phone" type="tel" :value="old('phone')" autocomplete="tel" class="mt-2" />
                                        <x-form.error field="phone" />
                                    </div>
                                    <div>
                                        <x-form.label for="contact-company">Company <span class="font-normal text-slate-400">(optional)</span></x-form.label>
                                        <x-form.input id="contact-company" name="company" :value="old('company')" autocomplete="organization" class="mt-2" />
                                        <x-form.error field="company" />
                                    </div>
                                </div>

                                <div class="grid gap-5 sm:grid-cols-2">
                                    <div>
                                        <x-form.label for="contact-service">Service</x-form.label>
                                        <x-form.select id="contact-service" name="service_id" class="mt-2">
                                            <option value="">General enquiry</option>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                                                    {{ $service->name }}
                                                </option>
                                            @endforeach
                                        </x-form.select>
                                        <x-form.error field="service_id" />
                                    </div>
                                    <div>
                                        <x-form.label for="contact-subject">Subject</x-form.label>
                                        <x-form.input id="contact-subject" name="subject" :value="old('subject')" required class="mt-2" />
                                        <x-form.error field="subject" />
                                    </div>
                                </div>

                                <div>
                                    <x-form.label for="contact-message">How can we help?</x-form.label>
                                    <x-form.textarea id="contact-message" name="message" rows="5" required class="mt-2">{{ old('message') }}</x-form.textarea>
                                    <x-form.error field="message" />
                                </div>

                                <div class="flex flex-col-reverse gap-3 sm:flex-row sm:items-center sm:justify-between">
                                    <p class="text-xs leading-5 text-slate-500">By submitting, you agree that we may contact you about your enquiry.</p>
                                    <x-button type="submit" variant="primary" size="lg" class="shrink-0" icon="send">
                                        Send message
                                    </x-button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </section>
        </main>

        <footer class="border-t border-slate-200 bg-white">
            <div class="mx-auto max-w-7xl px-5 py-10 sm:px-6 lg:px-8">
                <div class="grid gap-8 md:grid-cols-[1.3fr_0.7fr_0.7fr]">
                    <div>
                        <x-logo />
                        <p class="mt-4 max-w-sm text-sm leading-6 text-slate-600">
                            Reliable IT services that help your business stay connected, secure, and productive.
                        </p>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-navy-950">Company</p>
                        <div class="mt-4 grid gap-2 text-sm text-slate-600">
                            <a href="#about" class="hover:text-brand-700">About us</a>
                            <a href="#industries" class="hover:text-brand-700">Industries</a>
                            <a href="#careers" class="hover:text-brand-700">Careers</a>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.16em] text-navy-950">Explore</p>
                        <div class="mt-4 grid gap-2 text-sm text-slate-600">
                            <a href="#services" class="hover:text-brand-700">Services</a>
                            <a href="#solutions" class="hover:text-brand-700">Solutions</a>
                            <a href="#contact" class="hover:text-brand-700">Contact</a>
                        </div>
                    </div>
                </div>

                <div class="mt-10 flex flex-col gap-3 border-t border-slate-200 pt-6 text-xs text-slate-500 sm:flex-row sm:items-center sm:justify-between">
                    <p>© {{ now()->year }} Networx Solutions. All rights reserved.</p>
                    <p>Connect · Secure · Empower</p>
                </div>
            </div>
        </footer>
    </div>
</x-layouts.guest>
