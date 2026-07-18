@props(['label', 'value', 'icon', 'hint' => null, 'trend' => null, 'trendUp' => true])

<div {{ $attributes->merge(['class' => 'rounded-xl bg-white p-5 shadow-sm ring-1 ring-slate-900/5']) }}>
    <div class="flex items-center justify-between gap-3">
        <p class="text-sm font-medium text-slate-500">{{ $label }}</p>
        <span class="flex size-9 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
            <x-icon :name="$icon" class="size-5" />
        </span>
    </div>

    <p class="mt-2 font-display text-3xl font-bold tracking-tight text-navy-900">{{ $value }}</p>

    @if ($trend !== null || $hint)
        <p class="mt-1.5 flex items-center gap-1.5 text-xs text-slate-500">
            @if ($trend !== null)
                <span @class([
                    'font-semibold',
                    'text-emerald-600' => $trendUp,
                    'text-red-600' => ! $trendUp,
                ])>{{ $trend }}</span>
            @endif
            {{ $hint }}
        </p>
    @endif
</div>
