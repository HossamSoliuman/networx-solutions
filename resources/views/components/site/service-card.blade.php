@props(['service', 'index' => null, 'compact' => false])

@php
    $benefits = $service->benefitList();
@endphp

<article
    class="group relative flex h-full flex-col overflow-hidden rounded-[1.5rem] bg-white ring-1 ring-blue-100 transition duration-300 hover:-translate-y-1 hover:ring-brand-300 hover:shadow-[0_26px_70px_-38px_rgba(0,39,114,0.55)]">
    <div class="relative overflow-hidden bg-navy-950">
        <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }}"
            class="h-44 w-full object-cover transition duration-700 group-hover:scale-[1.045] sm:h-48"
            loading="lazy">
        <div class="absolute inset-0 bg-linear-to-t from-navy-950/80 via-navy-950/5 to-transparent"></div>

        @if ($index)
            <span
                class="absolute left-4 top-4 rounded-full border border-white/20 bg-navy-950/75 px-3 py-1.5 text-[0.65rem] font-bold uppercase tracking-[0.12em] text-white backdrop-blur-sm">
                Service {{ str_pad((string) $index, 2, '0', STR_PAD_LEFT) }}
            </span>
        @endif

        <span
            class="absolute bottom-4 right-4 flex size-11 items-center justify-center rounded-full border-2 border-white bg-brand-600 text-white shadow-lg">
            <x-icon :name="$service->icon" class="size-5" />
        </span>
    </div>

    <div class="flex flex-1 flex-col p-5">
        <h3 class="font-display text-[1.35rem] font-bold leading-6 tracking-[-0.025em] text-navy-950">
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
            <ul class="mt-4 grid gap-2 border-t border-blue-100 pt-4">
                @foreach (array_slice($benefits, 0, 2) as $benefit)
                    <li class="flex items-start gap-2.5 text-xs font-semibold leading-5 text-slate-600">
                        <span class="mt-1 size-1.5 shrink-0 rounded-full bg-brand-500"></span>
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
