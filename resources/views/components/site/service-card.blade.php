@props(['service', 'index' => null])

<article class="group relative overflow-hidden rounded-[1.75rem] bg-white ring-1 ring-slate-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-[0_24px_70px_-36px_rgba(6,27,57,0.45)]">
    <a href="{{ route('services.show', $service) }}" class="block overflow-hidden">
        <img src="{{ $service->imageUrl() }}" alt="{{ $service->name }} equipment"
            class="h-56 w-full object-cover transition-transform duration-700 group-hover:scale-[1.04]" loading="lazy">
    </a>

    <div class="p-6 sm:p-7">
        <div class="flex items-center justify-between gap-4">
            <span class="flex size-11 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                <x-icon :name="$service->icon" class="size-5" />
            </span>
            @if ($index)
                <span class="font-display text-xs font-bold tracking-[0.2em] text-slate-300">
                    {{ str_pad((string) $index, 2, '0', STR_PAD_LEFT) }}
                </span>
            @endif
        </div>

        <h3 class="mt-6 font-display text-xl font-bold tracking-[-0.02em] text-navy-950">
            <a href="{{ route('services.show', $service) }}">{{ $service->name }}</a>
        </h3>
        <p class="mt-3 text-sm leading-6 text-slate-600">{{ $service->excerpt }}</p>

        <a href="{{ route('services.show', $service) }}" class="mt-6 inline-flex items-center gap-2 text-sm font-bold text-brand-700">
            Explore service
            <x-icon name="arrow-left" class="size-4 rotate-180 transition-transform group-hover:translate-x-1" />
        </a>
    </div>
</article>
