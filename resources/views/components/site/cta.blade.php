@props(['site'])

<section class="relative isolate overflow-hidden bg-brand-600 text-white">
    <div class="bg-machine-grid absolute inset-0 -z-10 rotate-180 opacity-45"></div>
    <div class="absolute -right-20 -top-40 -z-10 size-[32rem] rounded-full bg-signal-300/15 blur-3xl"></div>

    <div class="mx-auto grid max-w-[90rem] gap-10 px-5 py-16 sm:px-8 sm:py-20 lg:grid-cols-[1fr_auto] lg:items-end lg:px-12">
        <div data-reveal>
            <p class="section-kicker text-brand-100">Start with the requirement</p>
            <h2 class="mt-5 max-w-4xl font-display text-4xl font-bold leading-[1.02] tracking-[-0.05em] text-white sm:text-5xl lg:text-6xl">
                {{ $site['cta_title'] }}
            </h2>
            <p class="mt-5 max-w-2xl text-base leading-7 text-brand-100 sm:text-lg">{{ $site['cta_intro'] }}</p>
        </div>

        <div class="flex flex-col gap-3 sm:flex-row lg:flex-col" data-reveal>
            <a href="{{ route('contact') }}" class="button-light">
                Talk to our team
                <x-icon name="arrow-left" class="size-4 rotate-180" />
            </a>
            <a href="{{ route('services.index') }}"
                class="inline-flex min-h-12 items-center justify-center gap-2 rounded-full border border-white/30 px-6 py-3 text-sm font-bold text-white transition hover:border-white/60 hover:bg-white/10">
                Explore services
            </a>
        </div>
    </div>
</section>
