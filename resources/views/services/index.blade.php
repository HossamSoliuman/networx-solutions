<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="Services" :description="$site['services_intro']">
    <section class="bg-navy-950 py-20 text-white sm:py-24">
        <div class="mx-auto grid max-w-[90rem] gap-10 px-5 sm:px-8 lg:grid-cols-[0.65fr_1.35fr] lg:items-end lg:px-12">
            <p class="section-kicker text-brand-200">Service catalogue</p>
            <div>
                <h1 class="text-balance font-display text-5xl font-bold leading-[1] tracking-[-0.05em] sm:text-6xl">
                    {{ $site['services_title'] }}
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">{{ $site['services_intro'] }}</p>
            </div>
        </div>
    </section>

    <section class="py-20 sm:py-28">
        <div class="mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
            <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($services as $service)
                    <x-site.service-card :service="$service" :index="$loop->iteration" />
                @empty
                    <div class="rounded-[2rem] border border-dashed border-slate-300 p-10 text-slate-600 md:col-span-2 xl:col-span-3">
                        Our service catalogue is being updated. Contact us and we will help identify the right path.
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="border-y border-slate-200 bg-white py-20">
        <div class="mx-auto grid max-w-[90rem] gap-10 px-5 sm:px-8 lg:grid-cols-[1fr_1.4fr] lg:px-12">
            <div>
                <p class="section-kicker">How services connect</p>
                <h2 class="section-title mt-5">No isolated fixes. One operating picture.</h2>
            </div>
            <div class="grid gap-5 sm:grid-cols-2">
                @foreach ([
                    ['Assess', 'Understand the environment, risk, dependencies, and desired outcome.'],
                    ['Design', 'Choose the architecture, controls, equipment, and delivery sequence.'],
                    ['Deliver', 'Install, migrate, configure, test, document, and hand over clearly.'],
                    ['Support', 'Monitor, maintain, improve, and respond when the operation needs us.'],
                ] as [$title, $copy])
                    <div class="border-l-2 border-brand-500 pl-5">
                        <h3 class="font-display font-bold text-navy-950">{{ $title }}</h3>
                        <p class="mt-2 text-sm leading-6 text-slate-600">{{ $copy }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <x-site.cta :site="$site" />
</x-layouts.public>
