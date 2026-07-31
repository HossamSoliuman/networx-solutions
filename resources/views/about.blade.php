@extends('layouts.public')

@section('title', 'About')
@section('description', $site['about_intro'])

@section('content')
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
                @if ($site['linkedin_url'] || $site['facebook_url'] || $site['instagram_url'])
                    <div class="mt-4 flex items-center justify-between gap-4 border-t border-white/10 pt-4">
                        <p class="font-mono text-[0.65rem] font-semibold uppercase tracking-[0.16em] text-slate-400">
                            Follow us
                        </p>
                        <div class="flex items-center gap-2">
                            @if ($site['linkedin_url'])
                                <a href="{{ $site['linkedin_url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex size-10 items-center justify-center rounded-full bg-[#0a66c2] text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-[#004182] hover:shadow-md"
                                    aria-label="Visit LinkedIn (opens in a new tab)">
                                    <x-icon name="linkedin" solid class="size-4" />
                                </a>
                            @endif
                            @if ($site['facebook_url'])
                                <a href="{{ $site['facebook_url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex size-10 items-center justify-center rounded-full bg-[#1877f2] text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:bg-[#0866ff] hover:shadow-md"
                                    aria-label="Visit Facebook (opens in a new tab)">
                                    <x-icon name="facebook" solid class="size-4" />
                                </a>
                            @endif
                            @if ($site['instagram_url'])
                                <a href="{{ $site['instagram_url'] }}" target="_blank" rel="noopener noreferrer"
                                    class="inline-flex size-10 items-center justify-center rounded-full bg-[linear-gradient(135deg,#833ab4_0%,#e1306c_50%,#f77737_100%)] text-white shadow-sm transition duration-200 hover:-translate-y-0.5 hover:brightness-110 hover:shadow-md"
                                    aria-label="Visit Instagram (opens in a new tab)">
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
                <p class="section-kicker">Our vision</p>
                <div>
                    <h2 class="section-title">Empowering businesses through smarter technology.</h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">
                        We help businesses streamline operations, strengthen security, embrace cloud technologies, and build reliable IT environments that support sustainable growth.
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-4" data-reveal-group>
                @foreach ([
                    ['users', 'Empower Businesses', 'Deliver integrated IT services that improve productivity, simplify operations, and support business success.'],
                    ['optimize', 'Drive Innovation', 'Leverage modern technologies, including cloud solutions and Microsoft 365, to enhance collaboration and accelerate digital transformation.'],
                    ['shield', 'Strengthen Security', 'Protect your business with advanced cybersecurity, secure networks, and proactive monitoring that safeguard critical assets.'],
                    ['chart', 'Enable Growth', 'Scalable IT infrastructure and tailored technology solutions designed to grow with your business.'],
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
                        Deliver integrated IT services that create measurable business value.
                    </h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-300">
                        We combine technical expertise, strong security, innovation, and reliable partnerships to help businesses operate efficiently, securely, and confidently.
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-px overflow-hidden rounded-[1.5rem] bg-white/10 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
                @foreach ([
                    ['check', 'Deliver Excellence', 'Provide reliable, high-quality IT services that keep your business running smoothly and efficiently.'],
                    ['shield', 'Strengthen Security', 'Protect your business with advanced cybersecurity, secure networks, proactive monitoring, and resilient IT infrastructure.'],
                    ['optimize', 'Drive Innovation', 'Leverage cloud solutions, Microsoft 365, and modern technologies to accelerate digital transformation.'],
                    ['handshake', 'Build Lasting Partnerships', 'We work closely with our clients to deliver tailored technology solutions that support their long-term success.'],
                    ['stopwatch', 'Ensure Reliability', 'Deliver dependable IT services, rapid response, and proactive maintenance that businesses can trust.'],
                    ['chart', 'Support Business Growth', 'Provide scalable IT solutions that evolve with your business and support future expansion.'],
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
                    <h2 class="section-title">Your Trusted Technology Partner</h2>
                    <p class="mt-3 max-w-3xl text-base leading-7 text-slate-600">
                        We deliver integrated IT services that keep your business secure, connected, and ready to grow. From IT support and networking to cloud solutions, cybersecurity, CCTV & surveillance, and Microsoft 365, we're your trusted technology partner.
                    </p>
                </div>
            </div>

            <div class="mt-7 grid gap-4 sm:grid-cols-2 lg:grid-cols-3" data-reveal-group>
                @foreach ([
                    ['hardhat', 'Expertise & Experience', 'Certified IT professionals delivering reliable, practical, and results-driven technology solutions.'],
                    ['user', 'Customer-Centric Approach', 'Every solution is tailored to your business goals, operational needs, and future growth.'],
                    ['eye', 'Proactive Support', 'Proactive monitoring and rapid response help prevent issues before they impact your business.'],
                    ['grid', 'Comprehensive Services', 'Complete IT services including IT support, networking, cloud solutions, cybersecurity, CCTV & surveillance, and Microsoft 365.'],
                    ['chart', 'Scalable Solutions', 'Flexible IT solutions that scale with your business as it grows and evolves.'],
                    ['handshake', 'Reliable Partnership', 'A trusted technology partner committed to your long-term success, security, and business continuity.'],
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
@endsection
