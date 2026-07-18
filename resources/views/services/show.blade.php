@php
    $benefits = $service->benefitList();
@endphp

<x-layouts.public :site="$site" :navigation-services="$navigationServices" :title="$service->name" :description="$service->excerpt">
    <x-site.page-hero eyebrow="Connected capability" :title="$service->name" :intro="$service->excerpt"
        :image="$service->imageUrl()" :image-alt="$service->name">
        <x-slot:breadcrumb>
            <nav class="flex flex-wrap items-center gap-2 font-mono text-[0.68rem] font-semibold uppercase tracking-[0.12em] text-slate-400"
                aria-label="Breadcrumb">
                <a href="{{ route('home') }}" class="transition-colors hover:text-white">Home</a>
                <span aria-hidden="true">/</span>
                <a href="{{ route('services.index') }}" class="transition-colors hover:text-white">Services</a>
                <span aria-hidden="true">/</span>
                <span class="text-brand-200" aria-current="page">{{ $service->name }}</span>
            </nav>
        </x-slot:breadcrumb>

        <x-slot:aside>
            <div class="w-full rounded-[1.75rem] border border-white/15 bg-navy-950/70 p-6 backdrop-blur-md lg:w-80">
                <div class="flex items-center justify-between gap-4">
                    <span class="flex size-12 items-center justify-center rounded-2xl bg-brand-400/15 text-brand-200">
                        <x-icon :name="$service->icon" class="size-5" />
                    </span>
                    <span class="technical-label text-signal-300">Capability brief</span>
                </div>

                @if ($benefits !== [])
                    <ul class="mt-6 grid gap-3 border-t border-white/10 pt-5">
                        @foreach (array_slice($benefits, 0, 3) as $benefit)
                            <li class="flex gap-2.5 text-sm leading-6 text-slate-300">
                                <x-icon name="check" class="mt-1 size-3.5 text-signal-300" />
                                {{ $benefit }}
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </x-slot:aside>
    </x-site.page-hero>

    <section class="relative overflow-hidden py-20 sm:py-28">
        <div class="bg-public-grid absolute inset-0 -z-10"></div>

        <div class="mx-auto grid max-w-[90rem] gap-12 px-5 sm:px-8 lg:grid-cols-[1.2fr_0.8fr] lg:gap-20 lg:px-12">
            <div data-reveal>
                <p class="section-kicker">Service overview</p>
                <h2 class="mt-6 max-w-3xl font-display text-3xl font-bold leading-[1.15] tracking-[-0.04em] text-navy-950 sm:text-4xl">
                    A practical approach to {{ $service->name }}.
                </h2>
                <p class="mt-7 max-w-3xl text-pretty text-xl leading-9 text-slate-700">
                    {{ $service->description ?: $service->excerpt }}
                </p>

                @if ($benefits !== [])
                    <div class="mt-12 border-t border-slate-300 pt-10">
                        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                            <div>
                                <p class="technical-label text-brand-700">Typical scope</p>
                                <h2 class="mt-3 font-display text-2xl font-bold tracking-[-0.03em] text-navy-950">What this can include</h2>
                            </div>
                            <p class="max-w-sm text-xs leading-5 text-slate-500">Final scope is shaped around your environment and priorities.</p>
                        </div>

                        <div class="mt-7 grid gap-4 sm:grid-cols-2">
                            @foreach ($benefits as $benefit)
                                <div class="flex gap-3 rounded-2xl bg-white p-5 ring-1 ring-slate-200">
                                    <span class="mt-0.5 flex size-7 shrink-0 items-center justify-center rounded-full bg-signal-300/20 text-signal-500">
                                        <x-icon name="check" class="size-3.5" />
                                    </span>
                                    <p class="text-sm font-semibold leading-6 text-navy-950">{{ $benefit }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="lg:sticky lg:top-28 lg:self-start" data-reveal>
                <div class="relative overflow-hidden rounded-[2rem] bg-navy-950 p-7 text-white sm:p-9">
                    <div class="bg-technical-dots absolute -right-24 -top-20 size-72 opacity-60"></div>
                    <div class="relative">
                        <p class="technical-label text-brand-200">Talk through the requirement</p>
                        <h2 class="mt-5 font-display text-3xl font-bold leading-9 tracking-[-0.035em]">
                            Need {{ $service->name }} expertise?
                        </h2>
                        <p class="mt-4 text-sm leading-7 text-slate-300">
                            Give us the context, current pressure, and desired outcome. We will help define a practical next step.
                        </p>
                        <a href="{{ route('contact', ['service' => $service->slug]) }}" class="button-primary mt-7 w-full">
                            Discuss this service
                            <x-icon name="arrow-left" class="size-4 rotate-180" />
                        </a>
                    </div>
                </div>

                <div class="mt-5 rounded-[1.75rem] border border-slate-200 bg-white p-6">
                    <p class="technical-label text-slate-400">Every engagement considers</p>
                    <ul class="mt-5 grid gap-3">
                        @foreach (['Business continuity', 'Security and risk', 'Maintainability', 'Clear ownership'] as $consideration)
                            <li class="flex items-center gap-3 text-sm font-semibold text-slate-700">
                                <span class="size-1.5 rounded-full bg-brand-500"></span>
                                {{ $consideration }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            </aside>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-paper py-20 sm:py-24">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-10 lg:grid-cols-[0.75fr_1.25fr] lg:items-end" data-reveal>
                <div>
                    <p class="section-kicker">Delivery path</p>
                    <h2 class="section-title mt-5">From requirement to a system your team can run.</h2>
                </div>
                <p class="max-w-2xl text-lg leading-8 text-slate-600">
                    The exact work changes with the service. The discipline around decisions, continuity, testing, and handover does not.
                </p>
            </div>

            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-4">
                @foreach ([
                    ['01', 'Discover', 'Understand the environment, users, dependencies, and pressure points.'],
                    ['02', 'Plan', 'Define scope, architecture, controls, responsibilities, and sequence.'],
                    ['03', 'Implement', 'Configure, migrate, test, and manage change around the operation.'],
                    ['04', 'Handover', 'Document the result and make ownership and support expectations clear.'],
                ] as [$number, $title, $copy])
                    <article class="rounded-[1.75rem] bg-white p-7 ring-1 ring-slate-200" data-reveal>
                        <span class="font-mono text-xs font-semibold text-brand-600">{{ $number }}</span>
                        <h3 class="mt-5 font-display text-xl font-bold text-navy-950">{{ $title }}</h3>
                        <p class="mt-3 text-sm leading-7 text-slate-600">{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @if ($relatedServices->isNotEmpty())
        <section class="py-20 sm:py-24">
            <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
                <div class="flex flex-col gap-6 sm:flex-row sm:items-end sm:justify-between" data-reveal>
                    <div>
                        <p class="section-kicker">Related capabilities</p>
                        <h2 class="section-title mt-5">Keep exploring.</h2>
                    </div>
                    <a href="{{ route('services.index') }}" class="text-link">
                        All services
                        <x-icon name="arrow-left" class="size-4 rotate-180" />
                    </a>
                </div>

                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($relatedServices as $relatedService)
                        <div data-reveal>
                            <x-site.service-card :service="$relatedService" compact />
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-site.cta :site="$site" />
</x-layouts.public>
