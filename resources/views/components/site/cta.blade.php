@props(['site'])

<section class="bg-brand-600">
    <div class="mx-auto grid max-w-[90rem] gap-8 px-5 py-14 sm:px-8 lg:grid-cols-[1fr_auto] lg:items-center lg:px-12 lg:py-16">
        <div>
            <p class="text-xs font-bold uppercase tracking-[0.2em] text-brand-100">Next step</p>
            <h2 class="mt-3 max-w-3xl font-display text-3xl font-bold tracking-[-0.035em] text-white sm:text-4xl">
                {{ $site['cta_title'] }}
            </h2>
            <p class="mt-4 max-w-2xl text-base leading-7 text-brand-100">{{ $site['cta_intro'] }}</p>
        </div>
        <a href="{{ route('contact') }}"
            class="inline-flex items-center justify-center gap-2 rounded-full bg-white px-6 py-3.5 text-sm font-bold text-navy-950 transition-transform hover:-translate-y-0.5">
            Talk to our team
            <x-icon name="arrow-left" class="size-4 rotate-180" />
        </a>
    </div>
</section>
