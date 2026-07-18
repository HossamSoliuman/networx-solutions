<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="About" :description="$site['about_intro']">
    <section class="relative isolate overflow-hidden bg-navy-950 text-white">
        <img src="{{ $site['about_image_url'] }}" alt="Enterprise network switches and cabling"
            class="absolute inset-0 -z-20 h-full w-full object-cover opacity-45">
        <div class="absolute inset-0 -z-10 bg-linear-to-r from-navy-950 via-navy-950/90 to-navy-950/25"></div>

        <div class="mx-auto flex min-h-[34rem] max-w-[90rem] items-end px-5 py-16 sm:px-8 lg:px-12 lg:py-20">
            <div class="max-w-4xl">
                <p class="section-kicker text-brand-200">{{ $site['about_eyebrow'] }}</p>
                <h1 class="mt-6 text-balance font-display text-5xl font-bold leading-[1] tracking-[-0.05em] sm:text-6xl lg:text-7xl">
                    {{ $site['about_title'] }}
                </h1>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-28">
        <div class="mx-auto grid max-w-[90rem] gap-12 px-5 sm:px-8 lg:grid-cols-[0.65fr_1.35fr] lg:gap-24 lg:px-12">
            <div>
                <p class="section-kicker">Our point of view</p>
                <p class="mt-5 font-display text-2xl font-bold leading-9 tracking-[-0.025em] text-navy-950">{{ $site['about_intro'] }}</p>
            </div>
            <div class="max-w-3xl">
                <p class="text-xl leading-9 text-slate-600">{{ $site['about_story'] }}</p>
                <div class="mt-12 grid gap-8 border-t border-slate-300 pt-10 sm:grid-cols-3">
                    @foreach ([
                        ['01', 'Understand', 'We map the operation, the dependencies, and the real source of friction.'],
                        ['02', 'Engineer', 'We design a clear solution around resilience, security, and maintainability.'],
                        ['03', 'Stay accountable', 'We support the system after delivery and keep improving it with you.'],
                    ] as [$number, $title, $copy])
                        <div>
                            <p class="font-display text-sm font-bold text-brand-600">{{ $number }}</p>
                            <h2 class="mt-4 font-display text-lg font-bold text-navy-950">{{ $title }}</h2>
                            <p class="mt-3 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-white py-20 sm:py-28">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-8 lg:grid-cols-2 lg:items-end">
                <div>
                    <p class="section-kicker">What guides the work</p>
                    <h2 class="section-title mt-5">Practical values for critical systems.</h2>
                </div>
                <p class="max-w-xl text-base leading-7 text-slate-600">
                    Good infrastructure should be understandable, supportable, and ready for what the business asks of it next.
                </p>
            </div>

            <div class="mt-12 grid gap-px overflow-hidden rounded-[2rem] bg-slate-200 ring-1 ring-slate-200 md:grid-cols-3">
                @foreach ([
                    ['Clarity', 'Straight answers, visible scope, useful documentation, and no mystery around the next step.'],
                    ['Resilience', 'Systems are planned for change, failure, recovery, and the daily realities of business.'],
                    ['Ownership', 'We stay close to the outcome instead of disappearing when the installation is complete.'],
                ] as [$title, $copy])
                    <article class="bg-[#f7f8f5] p-8 sm:p-10">
                        <h3 class="font-display text-2xl font-bold text-navy-950">{{ $title }}</h3>
                        <p class="mt-5 text-sm leading-7 text-slate-600">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <x-site.cta :site="$site" />
</x-layouts.public>
