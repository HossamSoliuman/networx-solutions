@props([
    'eyebrow',
    'title',
    'intro',
    'image' => null,
    'imageAlt' => '',
])

<section {{ $attributes->class(['relative isolate overflow-hidden bg-navy-950 text-white']) }}>
    @if ($image)
        <img src="{{ $image }}" alt="{{ $imageAlt }}"
            class="absolute inset-0 -z-30 h-full w-full object-cover opacity-60 sm:opacity-70">
        <div class="page-hero-image-shade absolute inset-0 -z-20"></div>
    @endif

    <div class="bg-machine-grid absolute inset-0 -z-10 opacity-45"></div>
    <div class="bg-signal-glow absolute inset-0 -z-10"></div>
    <div class="absolute inset-y-0 right-[9%] -z-10 hidden w-px bg-white/10 lg:block"></div>
    <div class="absolute right-[9%] top-12 -z-10 hidden font-mono text-[0.6rem] uppercase tracking-[0.2em] text-white/35 lg:block">
        NX / OPERATIONS
    </div>

    <div class="mx-auto grid min-h-[28rem] max-w-[90rem] items-center gap-12 px-5 py-12 sm:min-h-[31rem] sm:px-8 sm:py-16 lg:min-h-[32rem] lg:grid-cols-[1.25fr_0.75fr] lg:px-12 lg:py-18">
        <div class="max-w-5xl">
            @isset($breadcrumb)
                <div class="mb-8">
                    {{ $breadcrumb }}
                </div>
            @endisset

            <p class="site-reveal section-kicker text-brand-200">{{ $eyebrow }}</p>
            <h1 class="site-reveal site-reveal-delay-1 site-page-title mt-6">{{ $title }}</h1>
            <p class="site-reveal site-reveal-delay-2 mt-7 max-w-3xl text-pretty text-lg leading-8 text-slate-300 sm:text-xl sm:leading-9">
                {{ $intro }}
            </p>
        </div>

        @isset($aside)
            <div class="site-reveal site-reveal-delay-3 lg:justify-self-end">
                {{ $aside }}
            </div>
        @endisset
    </div>
</section>
