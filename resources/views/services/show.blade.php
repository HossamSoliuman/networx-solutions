@php
    $serviceItems = $service->serviceItems();
    $reasons = $service->reasons();
@endphp

<x-layouts.public :site="$site" :navigation-services="$navigationServices" :title="$service->name" :description="$service->excerpt">
    <section class="relative isolate overflow-hidden bg-navy-950 text-white">
        <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }}"
            class="absolute inset-0 -z-30 h-full w-full object-cover object-center">
        <div class="service-hero-shade absolute inset-0 -z-20"></div>
        <div class="bg-service-circuit absolute inset-0 -z-10 opacity-35"></div>

        <div class="mx-auto flex min-h-[31rem] max-w-[90rem] items-center px-5 py-12 sm:min-h-[34rem] sm:px-8 lg:min-h-[36rem] lg:px-12">
            <div class="w-full min-w-0 max-w-3xl">
                <nav class="site-reveal flex max-w-full items-center gap-2 overflow-hidden whitespace-nowrap text-xs font-bold uppercase tracking-[0.12em] text-blue-200/80"
                    aria-label="Breadcrumb">
                    <a href="{{ route('home') }}" class="transition-colors hover:text-white">Home</a>
                    <span aria-hidden="true">/</span>
                    <a href="{{ route('services.index') }}" class="transition-colors hover:text-white">Services</a>
                    <span aria-hidden="true">/</span>
                    <span class="hidden truncate text-white sm:inline" aria-current="page">{{ $service->name }}</span>
                </nav>

                <div class="site-reveal site-reveal-delay-1 mt-7 flex size-14 items-center justify-center rounded-full border-4 border-white bg-brand-600 text-white shadow-[0_14px_40px_rgba(0,44,132,0.45)]">
                    <x-icon :name="$service->icon" class="size-7" />
                </div>

                <h1 class="site-reveal site-reveal-delay-1 mt-6 max-w-full break-words font-display text-[clamp(2.7rem,12vw,6rem)] font-bold leading-[0.9] tracking-[-0.045em] text-white [overflow-wrap:anywhere]">
                    {{ $service->name }}
                </h1>
                <p class="site-reveal site-reveal-delay-2 mt-7 max-w-2xl text-pretty text-lg font-medium leading-8 text-blue-50 sm:text-xl sm:leading-9">
                    {{ $service->excerpt }}
                </p>
                <div class="site-reveal site-reveal-delay-3 mt-8 flex max-w-md flex-wrap gap-3">
                    <a href="#service-scope" class="button-light w-full sm:w-auto">
                        Explore the services
                        <x-icon name="arrow-left" class="size-4 -rotate-90" />
                    </a>
                    <a href="{{ route('contact', ['service' => $service->slug]) }}" class="button-ghost-light w-full sm:w-auto">
                        Request a consultation
                    </a>
                </div>
            </div>
        </div>
    </section>

    <section id="service-scope" class="relative overflow-hidden bg-canvas py-14 sm:py-18 lg:py-20">
        <div class="bg-reference-dots absolute right-0 top-0 h-80 w-80 opacity-60"></div>

        <div class="relative mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-8 xl:grid-cols-[minmax(0,1.28fr)_minmax(22rem,0.72fr)] xl:items-start">
                <div>
                    <div class="flex min-w-0 flex-col gap-4 border-b border-blue-200 pb-7 sm:flex-row sm:items-end sm:justify-between">
                        <div class="min-w-0">
                            <p class="section-kicker">Our {{ $service->name }} services</p>
                            <h2 class="mt-4 max-w-3xl break-words font-display text-3xl font-bold tracking-[-0.035em] text-navy-950 sm:text-4xl">
                                Everything needed to deliver and support the solution.
                            </h2>
                        </div>
                        <span class="font-display text-5xl font-bold text-brand-600/15">{{ str_pad((string) count($serviceItems), 2, '0', STR_PAD_LEFT) }}</span>
                    </div>

                    <div class="mt-6 grid gap-3 md:grid-cols-2" data-reveal-group>
                        @foreach ($serviceItems as $item)
                            <article class="group flex min-w-0 gap-4 rounded-2xl border border-blue-100 bg-white p-4 shadow-[0_12px_35px_-30px_rgba(0,39,114,0.7)] transition duration-200 hover:-translate-y-0.5 hover:border-brand-300 hover:shadow-[0_18px_45px_-28px_rgba(0,69,179,0.5)]"
                                data-reveal>
                                <span class="flex size-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-brand-700 ring-1 ring-blue-100 transition-colors group-hover:bg-brand-600 group-hover:text-white">
                                    <x-icon :name="$item['icon']" class="size-5" />
                                </span>
                                <div class="min-w-0">
                                    <h3 class="font-display text-base font-bold leading-5 text-navy-950">{{ $item['title'] }}</h3>
                                    <p class="mt-1.5 break-words text-sm leading-5 text-slate-600">{{ $item['description'] }}</p>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>

                <aside class="grid gap-5 xl:sticky xl:top-28" data-reveal>
                    <div class="overflow-hidden rounded-[1.75rem] bg-navy-950 text-white shadow-[0_24px_60px_-32px_rgba(0,30,91,0.8)]">
                        <div class="flex items-center gap-4 bg-linear-to-r from-brand-700 to-brand-500 px-6 py-5">
                            <span class="flex size-11 items-center justify-center rounded-full border-2 border-white/80">
                                <x-icon name="star" class="size-5" />
                            </span>
                            <h2 class="font-display text-2xl font-bold">Why choose us?</h2>
                        </div>

                        <ol class="relative grid gap-1 p-5 sm:p-6">
                            @foreach ($reasons as $reason)
                                <li class="group relative flex gap-4 py-3.5 first:pt-1 last:pb-1">
                                    @unless ($loop->last)
                                        <span class="absolute bottom-0 left-5 top-12 w-px bg-blue-700/60"></span>
                                    @endunless
                                    <span class="relative z-10 flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-600 text-white ring-4 ring-navy-950">
                                        <x-icon :name="$reason['icon']" class="size-[1.1rem]" />
                                    </span>
                                    <div>
                                        <h3 class="font-display text-base font-bold text-white">{{ $reason['title'] }}</h3>
                                        <p class="mt-1 text-sm leading-5 text-blue-100/75">{{ $reason['description'] }}</p>
                                    </div>
                                </li>
                            @endforeach
                        </ol>
                    </div>

                    <div class="rounded-[1.5rem] border border-blue-100 bg-white p-6">
                        <p class="font-display text-xl font-bold leading-7 text-navy-950">{{ $service->description }}</p>
                        <a href="{{ route('contact', ['service' => $service->slug]) }}" class="button-primary mt-5 w-full">
                            Talk to a specialist
                            <x-icon name="arrow-left" class="size-4 rotate-180" />
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    @if ($service->statement())
        <section class="bg-white py-8 sm:py-10">
            <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
                <div class="relative overflow-hidden rounded-[1.75rem] bg-linear-to-r from-navy-950 via-brand-800 to-brand-600 px-6 py-8 text-white sm:px-10 lg:flex lg:items-center lg:justify-between lg:gap-10 lg:px-12">
                    <div class="bg-reference-dots absolute right-0 top-0 h-full w-80 opacity-20"></div>
                    <div class="relative flex items-center gap-5">
                        <span class="flex size-14 shrink-0 items-center justify-center rounded-full border-2 border-white/80 bg-white/10">
                            <x-icon :name="$service->icon" class="size-7" />
                        </span>
                        <p class="max-w-3xl font-display text-2xl font-bold leading-tight sm:text-3xl">{{ $service->statement() }}</p>
                    </div>
                    <a href="{{ route('contact', ['service' => $service->slug]) }}" class="button-light relative mt-6 shrink-0 lg:mt-0">
                        Start a conversation
                        <x-icon name="phone" class="size-4" />
                    </a>
                </div>
            </div>
        </section>
    @endif

    @if ($relatedServices->isNotEmpty())
        <section class="border-t border-blue-100 bg-white py-14 sm:py-18">
            <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="section-kicker">More services</p>
                        <h2 class="mt-4 font-display text-3xl font-bold tracking-[-0.03em] text-navy-950 sm:text-4xl">Build a connected technology stack.</h2>
                    </div>
                    <a href="{{ route('services.index') }}" class="text-link">View all services <x-icon name="arrow-left" class="size-4 rotate-180" /></a>
                </div>
                <div class="mt-8 grid gap-5 md:grid-cols-3">
                    @foreach ($relatedServices as $relatedService)
                        <x-site.service-card :service="$relatedService" compact />
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.public>
