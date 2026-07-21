<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="Services" :description="$site['services_intro']">
    <section class="relative isolate overflow-hidden bg-navy-950 text-white">
        <img src="{{ asset('images/site/networking-banner.webp') }}" alt="Enterprise technology infrastructure"
            class="absolute inset-0 -z-30 h-full w-full object-cover">
        <div class="service-hero-shade absolute inset-0 -z-20"></div>
        <div class="bg-service-circuit absolute inset-0 -z-10 opacity-35"></div>

        <div class="mx-auto grid min-h-[31rem] max-w-[90rem] items-center gap-10 px-5 py-12 sm:px-8 lg:grid-cols-[1.1fr_0.9fr] lg:px-12">
            <div class="max-w-3xl">
                <p class="site-reveal section-kicker text-blue-200">Networx Solutions services</p>
                <h1 class="site-reveal site-reveal-delay-1 mt-6 font-display text-[clamp(3.4rem,7vw,6.4rem)] font-bold leading-[0.86] tracking-[-0.045em]">
                    Connected.<br><span class="text-brand-300">Secure.</span> Productive.
                </h1>
                <p class="site-reveal site-reveal-delay-2 mt-7 max-w-2xl text-lg font-medium leading-8 text-blue-50 sm:text-xl">
                    Six practical technology services, delivered as standalone solutions or one connected operating environment.
                </p>
            </div>

            <div class="site-reveal site-reveal-delay-3 hidden justify-self-end rounded-[1.75rem] border border-white/15 bg-navy-950/75 p-6 backdrop-blur-md sm:block lg:w-[22rem]">
                <div class="grid grid-cols-2 gap-3">
                    @foreach ($services as $service)
                        <a href="{{ route('services.show', $service) }}" class="group flex min-h-24 flex-col justify-between rounded-xl bg-white/7 p-4 ring-1 ring-white/10 transition hover:bg-brand-600/25 hover:ring-brand-300/50">
                            <x-icon :name="$service->icon" class="size-5 text-brand-200" />
                            <span class="mt-3 font-display text-sm font-bold leading-4 text-white">{{ $service->name }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="relative overflow-hidden bg-canvas py-14 sm:py-18 lg:py-20">
        <div class="bg-reference-dots absolute right-0 top-0 h-80 w-80 opacity-50"></div>
        <div class="relative mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-5 border-b border-blue-200 pb-8 lg:grid-cols-[0.8fr_1.2fr] lg:items-end">
                <div>
                    <p class="section-kicker">Choose your starting point</p>
                    <p class="mt-4 max-w-md text-sm leading-6 text-slate-600">Every page lists the exact services, support scope, and operational benefits available.</p>
                </div>
                <h2 class="font-display text-3xl font-bold leading-[1.02] tracking-[-0.035em] text-navy-950 sm:text-4xl lg:text-5xl">The right expertise for every layer of your business technology.</h2>
            </div>

            <div class="mt-8 grid gap-5 md:grid-cols-2 xl:grid-cols-3" data-reveal-group>
                @foreach ($services as $service)
                    <div data-reveal>
                        <x-site.service-card :service="$service" :index="$loop->iteration" />
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-10 sm:py-12">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="rounded-[1.75rem] bg-linear-to-r from-navy-950 via-brand-800 to-brand-600 px-6 py-8 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:gap-10 lg:px-12">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.16em] text-blue-200">One accountable technology partner</p>
                    <h2 class="mt-3 font-display text-3xl font-bold tracking-[-0.03em]">Tell us what needs to work better.</h2>
                </div>
                <a href="{{ route('contact') }}" class="button-light mt-6 shrink-0 lg:mt-0">Contact Networx <x-icon name="arrow-left" class="size-4 rotate-180" /></a>
            </div>
        </div>
    </section>
</x-layouts.public>
