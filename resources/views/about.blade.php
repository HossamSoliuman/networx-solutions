<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="About" :description="$site['about_intro']">
    <x-site.page-hero :eyebrow="$site['about_eyebrow']" :title="$site['about_title']" :intro="$site['about_intro']"
        :image="$site['about_image_url']" image-alt="Enterprise network switches and structured cabling">
        <x-slot:aside>
            <div class="w-full rounded-[1.75rem] border border-white/15 bg-navy-950/65 p-6 backdrop-blur-md lg:w-80">
                <p class="technical-label text-brand-200">Our point of view</p>
                <p class="mt-4 font-display text-2xl font-bold leading-8 text-white">Technology should create confidence, not dependency.</p>
                @if ($site['address'])
                    <p class="mt-6 flex items-center gap-2 border-t border-white/10 pt-5 text-sm text-slate-300">
                        <x-icon name="building" class="size-4 text-signal-300" />
                        {{ $site['address'] }}
                    </p>
                @endif
            </div>
        </x-slot:aside>
    </x-site.page-hero>

    <section class="relative overflow-hidden py-20 sm:py-28">
        <div class="bg-public-grid absolute inset-0 -z-10"></div>

        <div class="mx-auto grid max-w-[90rem] gap-12 px-5 sm:px-8 lg:grid-cols-[0.7fr_1.3fr] lg:gap-24 lg:px-12">
            <div data-reveal>
                <p class="section-kicker">Our point of view</p>
                <p class="mt-6 max-w-md font-display text-3xl font-bold leading-[1.18] tracking-[-0.04em] text-navy-950">
                    Infrastructure is only successful when the business can rely on it, understand it, and grow with it.
                </p>
            </div>

            <div class="max-w-4xl" data-reveal>
                <p class="text-pretty text-xl leading-9 text-slate-700 sm:text-2xl sm:leading-10">{{ $site['about_story'] }}</p>
                <p class="mt-7 text-base leading-8 text-slate-600">
                    That is why the work is connected from the beginning. Support decisions affect security. Network decisions affect cloud performance. Documentation affects how quickly teams recover and change. We keep those dependencies visible and give the outcome one clear owner.
                </p>

                <div class="mt-12 grid gap-px overflow-hidden rounded-[2rem] bg-slate-200 ring-1 ring-slate-200 sm:grid-cols-3">
                    @foreach ([
                        ['01', 'Listen closely', 'Start with the operation, its constraints, and the people who depend on it.'],
                        ['02', 'Engineer clearly', 'Translate complexity into a practical architecture, scope, and sequence.'],
                        ['03', 'Stay accountable', 'Keep ownership visible through delivery, handover, and support.'],
                    ] as [$number, $title, $copy])
                        <article class="bg-white p-7 sm:p-8">
                            <span class="font-mono text-xs font-semibold text-brand-600">{{ $number }}</span>
                            <h2 class="mt-5 font-display text-xl font-bold text-navy-950">{{ $title }}</h2>
                            <p class="mt-3 text-sm leading-7 text-slate-600">{{ $copy }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="overflow-hidden border-y border-slate-200 bg-paper">
        <div class="mx-auto grid max-w-[90rem] lg:grid-cols-[0.9fr_1.1fr]">
            <div class="relative min-h-[28rem] lg:min-h-[46rem]" data-reveal>
                <img src="{{ $site['about_image_url'] }}" alt="Connected technology infrastructure"
                    class="absolute inset-0 h-full w-full object-cover object-bottom" loading="lazy">
                <div class="absolute inset-0 bg-navy-950/30"></div>
                <div class="absolute left-5 top-5 rounded-2xl border border-white/15 bg-navy-950/75 p-5 text-white backdrop-blur-md sm:left-8 sm:top-8">
                    <p class="technical-label text-brand-200">The Networx standard</p>
                    <p class="mt-2 max-w-xs font-display text-xl font-bold">Useful after the installation team leaves.</p>
                </div>
            </div>

            <div class="flex items-center px-5 py-16 sm:px-8 lg:px-14 lg:py-24 xl:px-20" data-reveal>
                <div class="max-w-2xl">
                    <p class="section-kicker">How we make the work dependable</p>
                    <h2 class="section-title mt-5">A delivery model built around the real operation.</h2>

                    <div class="mt-10 grid gap-7">
                        @foreach ([
                            ['01', 'Context before configuration', 'We map users, locations, workflows, existing systems, and business constraints before prescribing a solution.'],
                            ['02', 'Security throughout the design', 'Identity, devices, connectivity, cloud, and physical coverage are considered as connected risk surfaces.'],
                            ['03', 'Handover as part of delivery', 'Testing, documentation, ownership, and support expectations are defined before a project is considered complete.'],
                            ['04', 'Improvement after launch', 'The operating environment changes. The plan should make space for maintenance, learning, and the next stage of growth.'],
                        ] as [$number, $title, $copy])
                            <div class="grid grid-cols-[auto_1fr] gap-5 border-t border-slate-200 pt-6">
                                <span class="font-mono text-xs font-semibold text-brand-600">{{ $number }}</span>
                                <div>
                                    <h3 class="font-display text-lg font-bold text-navy-950">{{ $title }}</h3>
                                    <p class="mt-2 text-sm leading-7 text-slate-600">{{ $copy }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-10 lg:grid-cols-[0.8fr_1.2fr] lg:items-end" data-reveal>
                <div>
                    <p class="section-kicker">What guides the work</p>
                    <h2 class="section-title mt-5">Practical values for critical systems.</h2>
                </div>
                <p class="max-w-2xl text-lg leading-8 text-slate-600">
                    Good infrastructure should be understandable, supportable, and ready for what the business asks of it next.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['Clarity', 'Straight answers, visible scope, useful documentation, and no mystery around the next step.', 'Clarity turns complexity into action.'],
                    ['Resilience', 'Systems planned for change, failure, recovery, and the daily realities of a growing business.', 'Readiness is designed, not assumed.'],
                    ['Ownership', 'A team that stays close to the outcome instead of disappearing when installation is complete.', 'Responsibility remains visible.'],
                ] as [$title, $copy, $statement])
                    <article class="group relative overflow-hidden rounded-[2rem] bg-white p-8 ring-1 ring-slate-200 sm:p-9" data-reveal>
                        <div class="absolute inset-x-0 top-0 h-1 origin-left scale-x-0 bg-brand-500 transition-transform duration-300 group-hover:scale-x-100"></div>
                        <p class="technical-label text-brand-700">{{ $statement }}</p>
                        <h3 class="mt-8 font-display text-3xl font-bold tracking-[-0.04em] text-navy-950">{{ $title }}</h3>
                        <p class="mt-5 text-sm leading-7 text-slate-600">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <x-site.cta :site="$site" />
</x-layouts.public>
