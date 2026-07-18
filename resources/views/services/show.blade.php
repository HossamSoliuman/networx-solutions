<x-layouts.public :site="$site" :navigation-services="$navigationServices" :title="$service->name" :description="$service->excerpt">
    <section class="relative isolate overflow-hidden bg-navy-950 text-white">
        <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }} equipment"
            class="absolute inset-0 -z-20 h-full w-full object-cover opacity-45">
        <div class="absolute inset-0 -z-10 bg-linear-to-r from-navy-950 via-navy-950/95 to-navy-950/25"></div>

        <div class="mx-auto flex min-h-[35rem] max-w-[90rem] items-end px-5 py-16 sm:px-8 lg:px-12 lg:py-20">
            <div class="max-w-4xl">
                <nav class="flex items-center gap-2 text-xs font-semibold text-slate-400" aria-label="Breadcrumb">
                    <a href="{{ route('services.index') }}" class="hover:text-white">Services</a>
                    <span>/</span>
                    <span class="text-brand-200">{{ $service->name }}</span>
                </nav>
                <div class="mt-8 flex size-12 items-center justify-center rounded-full bg-brand-500 text-white">
                    <x-icon :name="$service->icon" />
                </div>
                <h1 class="mt-6 font-display text-5xl font-bold leading-none tracking-[-0.05em] sm:text-6xl lg:text-7xl">
                    {{ $service->name }}
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">{{ $service->excerpt }}</p>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-28">
        <div class="mx-auto grid max-w-[90rem] gap-12 px-5 sm:px-8 lg:grid-cols-[1.25fr_0.75fr] lg:gap-24 lg:px-12">
            <div>
                <p class="section-kicker">Service overview</p>
                <p class="mt-6 text-xl leading-9 text-slate-700">{{ $service->description ?: $service->excerpt }}</p>

                @if ($service->benefitList())
                    <div class="mt-12 border-t border-slate-300 pt-10">
                        <h2 class="font-display text-2xl font-bold tracking-[-0.025em] text-navy-950">What this can include</h2>
                        <div class="mt-7 grid gap-4 sm:grid-cols-2">
                            @foreach ($service->benefitList() as $benefit)
                                <div class="flex gap-3 rounded-2xl bg-white p-5 ring-1 ring-slate-200">
                                    <span class="mt-0.5 flex size-6 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                                        <x-icon name="check" class="size-3.5" />
                                    </span>
                                    <p class="text-sm font-semibold leading-6 text-navy-950">{{ $benefit }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <aside class="lg:sticky lg:top-28 lg:self-start">
                <div class="rounded-[2rem] bg-navy-950 p-7 text-white sm:p-9">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-200">Talk through the requirement</p>
                    <h2 class="mt-4 font-display text-2xl font-bold">Need {{ $service->name }} expertise?</h2>
                    <p class="mt-4 text-sm leading-7 text-slate-300">Give us the context and we will respond with a practical next step.</p>
                    <a href="{{ route('contact', ['service' => $service->slug]) }}"
                        class="mt-7 inline-flex items-center justify-center gap-2 rounded-full bg-brand-500 px-5 py-3 text-sm font-bold text-white">
                        Discuss this service
                        <x-icon name="arrow-left" class="size-4 rotate-180" />
                    </a>
                </div>
            </aside>
        </div>
    </section>

    @if ($relatedServices->isNotEmpty())
        <section class="bg-white py-20 sm:py-24">
            <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
                <div class="flex items-end justify-between gap-8">
                    <div>
                        <p class="section-kicker">Related capabilities</p>
                        <h2 class="section-title mt-5">Keep exploring.</h2>
                    </div>
                    <a href="{{ route('services.index') }}" class="hidden text-sm font-bold text-brand-700 sm:block">All services</a>
                </div>
                <div class="mt-10 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                    @foreach ($relatedServices as $relatedService)
                        <x-site.service-card :service="$relatedService" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-site.cta :site="$site" />
</x-layouts.public>
