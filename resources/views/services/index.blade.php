<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="Services" :description="$site['services_intro']">
    <x-site.page-hero eyebrow="Service catalogue" :title="$site['services_title']" :intro="$site['services_intro']"
        :image="$site['home_image_url']" image-alt="Connected enterprise technology infrastructure">
        <x-slot:aside>
            <div class="grid w-full grid-cols-2 gap-px overflow-hidden rounded-[1.75rem] bg-white/15 lg:w-80">
                <div class="bg-navy-950/75 p-6 backdrop-blur-md">
                    <p class="font-display text-4xl font-bold text-white">{{ str_pad((string) $services->count(), 2, '0', STR_PAD_LEFT) }}</p>
                    <p class="technical-label mt-2 text-slate-400">Capabilities</p>
                </div>
                <div class="bg-navy-950/75 p-6 backdrop-blur-md">
                    <p class="font-display text-4xl font-bold text-white">01</p>
                    <p class="technical-label mt-2 text-slate-400">Partner</p>
                </div>
                <div class="col-span-2 bg-navy-950/75 p-5 backdrop-blur-md">
                    <p class="technical-label text-brand-200">One connected lifecycle</p>
                    <p class="mt-2 text-sm font-semibold text-white">Assess → Design → Deliver → Support</p>
                </div>
            </div>
        </x-slot:aside>
    </x-site.page-hero>

    <section class="relative overflow-hidden py-20 sm:py-28">
        <div class="bg-public-grid absolute inset-0 -z-10"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-8 border-b border-slate-300 pb-10 lg:grid-cols-[0.7fr_1.3fr] lg:items-end" data-reveal>
                <div>
                    <p class="section-kicker">Choose the starting point</p>
                    <p class="mt-5 max-w-sm text-sm leading-7 text-slate-600">Every capability can stand alone or connect into a wider operating plan.</p>
                </div>
                <h2 class="section-title">Services designed to remove friction, risk, and uncertainty.</h2>
            </div>

            <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($services as $service)
                    <div data-reveal>
                        <x-site.service-card :service="$service" :index="$loop->iteration" />
                    </div>
                @empty
                    <div class="rounded-[2rem] border border-dashed border-slate-300 bg-white p-10 text-slate-600 md:col-span-2 xl:col-span-3">
                        <p class="font-display text-xl font-bold text-navy-950">Our service catalogue is being updated.</p>
                        <p class="mt-3 text-sm leading-7">Contact us and we will help identify the right path for your requirement.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="relative isolate overflow-hidden bg-navy-950 py-20 text-white sm:py-28">
        <div class="bg-machine-grid absolute inset-0 -z-10 opacity-45"></div>

        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-end" data-reveal>
                <div>
                    <p class="section-kicker text-brand-200">How services connect</p>
                    <h2 class="mt-6 text-balance font-display text-4xl font-bold leading-[1.03] tracking-[-0.05em] sm:text-5xl lg:text-6xl">
                        No isolated fixes. One operating picture.
                    </h2>
                </div>
                <p class="max-w-2xl text-lg leading-8 text-slate-300">
                    The right solution is rarely just a product. It is a sequence of decisions that protects continuity, reduces risk, and leaves the environment easier to run.
                </p>
            </div>

            <div class="mt-14 grid gap-px overflow-hidden rounded-[2rem] bg-white/10 md:grid-cols-2 xl:grid-cols-4" data-reveal>
                @foreach ([
                    ['01', 'Assess', 'Understand the environment, dependencies, risk, and desired business outcome.'],
                    ['02', 'Design', 'Choose the architecture, controls, equipment, and delivery sequence.'],
                    ['03', 'Deliver', 'Install, migrate, configure, test, document, and hand over clearly.'],
                    ['04', 'Support', 'Maintain, improve, and respond as the operation and its priorities change.'],
                ] as [$number, $title, $copy])
                    <article class="bg-navy-900/85 p-7 sm:p-8">
                        <span class="font-mono text-xs font-semibold text-signal-300">{{ $number }}</span>
                        <h3 class="mt-6 font-display text-2xl font-bold text-white">{{ $title }}</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-400">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-paper py-20 sm:py-28">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-10 lg:grid-cols-[0.72fr_1.28fr] lg:items-end" data-reveal>
                <div>
                    <p class="section-kicker">Designed around outcomes</p>
                    <h2 class="section-title mt-5">What the technology should make possible.</h2>
                </div>
                <p class="max-w-2xl text-lg leading-8 text-slate-600">
                    Tools matter, but the operating result matters more. We use these outcomes to keep scope and decisions grounded.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-3">
                @foreach ([
                    ['shield', 'Lower operational risk', 'Reduce avoidable exposure, single points of failure, and uncertainty during change.'],
                    ['cog', 'Simpler day-to-day operations', 'Give teams clearer ownership, better visibility, and systems that are easier to maintain.'],
                    ['grid', 'A stronger platform for growth', 'Build an environment that can absorb new users, locations, workflows, and requirements.'],
                ] as [$icon, $title, $copy])
                    <article class="site-panel p-8 sm:p-9" data-reveal>
                        <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-700">
                            <x-icon :name="$icon" class="size-5" />
                        </span>
                        <h3 class="mt-7 font-display text-2xl font-bold tracking-[-0.03em] text-navy-950">{{ $title }}</h3>
                        <p class="mt-4 text-sm leading-7 text-slate-600">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="border-t border-slate-200 py-20 sm:py-24">
        <div class="mx-auto grid max-w-[90rem] gap-12 px-5 sm:px-8 lg:grid-cols-[0.72fr_1.28fr] lg:gap-20 lg:px-12">
            <div data-reveal>
                <p class="section-kicker">Common questions</p>
                <h2 class="section-title mt-5">A clearer starting point.</h2>
                <p class="mt-5 max-w-md text-base leading-7 text-slate-600">
                    You do not need a finished technical brief before speaking with us. A business problem is enough to begin.
                </p>
            </div>

            <div class="border-t border-slate-300" data-reveal>
                @foreach ([
                    ['Can we engage Networx for one service?', 'Yes. A requirement can begin with one capability, while still accounting for the systems and teams it connects to.'],
                    ['Can you work with our existing environment?', 'The assessment starts with what is already in place. Recommendations are shaped around current constraints, risk, priorities, and the outcome you need.'],
                    ['What happens after implementation?', 'Testing, documentation, handover, ownership, and support expectations are included in the delivery conversation so the next step is clear.'],
                ] as [$question, $answer])
                    <details class="group border-b border-slate-300">
                        <summary class="flex cursor-pointer list-none items-center justify-between gap-6 py-6 font-display text-lg font-bold text-navy-950">
                            {{ $question }}
                            <span class="flex size-9 shrink-0 items-center justify-center rounded-full bg-white text-brand-700 ring-1 ring-slate-200">
                                <x-icon name="plus" class="size-4 transition-transform group-open:rotate-45" />
                            </span>
                        </summary>
                        <p class="max-w-2xl pb-7 pr-12 text-sm leading-7 text-slate-600">{{ $answer }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <x-site.cta :site="$site" />
</x-layouts.public>
