@props(['service', 'index' => null, 'compact' => false])

@php
    $benefits = $service->benefitList();
@endphp

<article
    class="group relative flex h-full flex-col overflow-hidden rounded-[1.75rem] bg-white ring-1 ring-slate-200 transition duration-300 hover:-translate-y-1 hover:ring-brand-200 hover:shadow-[0_26px_70px_-38px_rgba(5,26,53,0.5)]">
    <div class="relative overflow-hidden bg-navy-950">
        <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }}"
            class="h-52 w-full object-cover transition duration-700 group-hover:scale-[1.045] group-hover:opacity-85 sm:h-56"
            loading="lazy">
        <div class="absolute inset-0 bg-linear-to-t from-navy-950/65 via-transparent to-transparent"></div>

        @if ($index)
            <span
                class="technical-label absolute left-5 top-5 rounded-full border border-white/15 bg-navy-950/70 px-3 py-1.5 text-white backdrop-blur-sm">
                Capability {{ str_pad((string) $index, 2, '0', STR_PAD_LEFT) }}
            </span>
        @endif

        <span
            class="absolute bottom-5 right-5 flex size-11 items-center justify-center rounded-full border border-white/15 bg-white/10 text-white backdrop-blur-sm">
            <x-icon :name="$service->icon" class="size-5" />
        </span>
    </div>

    <div class="flex flex-1 flex-col p-6 sm:p-7">
        <h3 class="font-display text-2xl font-bold tracking-[-0.035em] text-navy-950">
            <a href="{{ route('services.show', $service) }}"
                class="after:absolute after:inset-0"
                aria-describedby="service-summary-{{ $service->getKey() }}">
                {{ $service->name }}
            </a>
        </h3>
        <p id="service-summary-{{ $service->getKey() }}" class="mt-3 text-sm leading-6 text-slate-600">
            {{ $service->excerpt }}
        </p>

        @if (! $compact && $benefits !== [])
            <ul class="mt-5 grid gap-2 border-t border-slate-200 pt-5">
                @foreach (array_slice($benefits, 0, 2) as $benefit)
                    <li class="flex items-start gap-2.5 text-xs font-semibold leading-5 text-slate-600">
                        <span class="mt-1 size-1.5 shrink-0 rounded-full bg-signal-500"></span>
                        {{ $benefit }}
                    </li>
                @endforeach
            </ul>
        @endif

        <span class="mt-auto inline-flex items-center gap-2 pt-6 text-sm font-bold text-brand-700">
            Explore service
            <x-icon name="arrow-left"
                class="size-4 rotate-180 transition-transform duration-200 group-hover:translate-x-1" />
        </span>
    </div>
</article>
