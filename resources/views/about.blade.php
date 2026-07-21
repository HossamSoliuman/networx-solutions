<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="About" :description="$site['about_intro']">
    <x-site.page-hero :eyebrow="$site['about_eyebrow']" :title="$site['about_title']" :intro="$site['about_intro']" compact
        :image="$site['about_image_url']" image-alt="Enterprise network switches and structured cabling">
        <x-slot:aside>
            <div class="w-full rounded-[1.5rem] border border-white/15 bg-navy-950/70 p-5 backdrop-blur-md lg:w-96">
                <div class="flex items-center gap-3 text-brand-200">
                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-white/10">
                        <x-icon name="building" class="size-4" />
                    </span>
                    <p class="technical-label">Company profile</p>
                </div>
                <p class="mt-4 text-sm leading-7 text-slate-200">{{ $site['about_story'] }}</p>
                @if ($site['address'])
                    <p class="mt-4 border-t border-white/10 pt-4 font-mono text-xs font-semibold uppercase tracking-[0.12em] text-signal-300">
                        {{ $site['address'] }}
                    </p>
                @endif
            </div>
        </x-slot:aside>
    </x-site.page-hero>

    <section class="relative overflow-hidden border-b border-slate-200 bg-white py-12 sm:py-14">
        <div class="bg-public-grid absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-slate-200 pb-7 lg:grid-cols-[0.45fr_1.55fr] lg:items-end" data-reveal>
                <p class="section-kicker">Our vision</p>
                <div>
                    <h2 class="section-title">Empower businesses to grow securely.</h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">
                        We help clients focus on their core operations, adopt new technology, protect digital assets, and adapt to changing market demands.
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
                @foreach ([
                    ['users', 'Empower businesses', 'Top-notch IT support keeps clients focused on operations and strategic goals.'],
                    ['optimize', 'Drive innovation', 'Current technology helps clients stay ahead in a changing digital landscape.'],
                    ['shield', 'Ensure security', 'Robust measures and proactive monitoring safeguard digital assets.'],
                    ['chart', 'Foster growth', 'Tailored IT support helps businesses scale, adapt, and remain resilient.'],
                ] as [$icon, $title, $copy])
                    <article class="rounded-[1.5rem] bg-brand-50/70 p-6 ring-1 ring-brand-100" data-reveal>
                        <span class="flex size-10 items-center justify-center rounded-xl bg-white text-brand-700 ring-1 ring-brand-100">
                            <x-icon :name="$icon" class="size-5" />
                        </span>
                        <h3 class="mt-5 font-display text-xl font-bold text-navy-950">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="relative isolate overflow-hidden bg-navy-950 py-12 text-white sm:py-14">
        <div class="bg-machine-grid absolute inset-0 -z-10 opacity-40"></div>
        <div class="bg-signal-glow absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-white/10 pb-7 lg:grid-cols-[0.45fr_1.55fr] lg:items-end" data-reveal>
                <p class="section-kicker text-brand-200">Our mission</p>
                <div>
                    <h2 class="text-balance font-display text-4xl font-semibold leading-[1.03] tracking-[-0.035em] sm:text-5xl">
                        Deliver reliable IT support with clear business value.
                    </h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-300">
                        We combine excellent service, strong security, innovation, and close collaboration to support long-term growth.
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-px overflow-hidden rounded-[1.5rem] bg-white/10 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
                @foreach ([
                    ['check', 'Deliver excellence', 'Top-tier support keeps business operations seamless and uninterrupted.'],
                    ['shield', 'Enhance security', 'Cybersecurity, proactive monitoring, and rapid response protect digital assets.'],
                    ['optimize', 'Promote innovation', 'The latest technology helps clients remain competitive.'],
                    ['handshake', 'Foster collaboration', 'Personalized support starts with understanding each client’s needs.'],
                    ['stopwatch', 'Ensure reliability', 'Consistent, dependable service builds lasting trust.'],
                    ['chart', 'Support growth', 'Flexible and scalable IT solutions adapt to changing demands.'],
                ] as [$icon, $title, $copy])
                    <article class="bg-navy-900/85 p-6" data-reveal>
                        <div class="flex items-center gap-4">
                            <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-white/8 text-signal-300 ring-1 ring-white/10">
                                <x-icon :name="$icon" class="size-5" />
                            </span>
                            <h3 class="font-display text-xl font-semibold text-white">{{ $title }}</h3>
                        </div>
                        <p class="mt-4 text-sm leading-6 text-slate-400">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-b border-slate-200 bg-canvas py-12 sm:py-14">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-slate-200 pb-7 lg:grid-cols-[0.45fr_1.55fr] lg:items-end" data-reveal>
                <p class="section-kicker">Why choose us</p>
                <div>
                    <h2 class="section-title">A dedicated team committed to your success.</h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">
                        Experienced professionals, personalized service, and proactive support keep your technology secure, efficient, and ready to grow.
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
                @foreach ([
                    ['hardhat', 'Expertise and experience', 'Skilled professionals bring practical knowledge and precision to every project.'],
                    ['user', 'Customer-centric approach', 'Solutions are tailored to your challenges, goals, and business objectives.'],
                    ['eye', 'Proactive support', 'Monitoring and maintenance identify issues early and minimize downtime.'],
                    ['grid', 'Comprehensive services', 'Support, maintenance, networks, and cybersecurity are covered under one roof.'],
                    ['chart', 'Scalable solutions', 'Your IT infrastructure grows with your business and expanding operations.'],
                    ['headset', '24/7 availability', 'Round-the-clock assistance is available whenever IT issues arise.'],
                ] as [$icon, $title, $copy])
                    <article class="group flex gap-4 rounded-[1.5rem] bg-white p-6 ring-1 ring-slate-200 transition hover:-translate-y-0.5 hover:ring-brand-200" data-reveal>
                        <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-brand-50 text-brand-700 transition group-hover:bg-brand-600 group-hover:text-white">
                            <x-icon :name="$icon" class="size-5" />
                        </span>
                        <div>
                            <h3 class="font-display text-lg font-bold text-navy-950">{{ $title }}</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
</x-layouts.public>
