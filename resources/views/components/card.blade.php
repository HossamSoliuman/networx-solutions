@props(['title' => null, 'padding' => true])

<div {{ $attributes->merge(['class' => 'rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5']) }}>
    @if ($title || isset($action))
        <div class="flex items-center justify-between gap-4 border-b border-slate-100 px-5 py-3.5">
            <h2 class="text-sm font-semibold text-slate-900">{{ $title }}</h2>
            @isset($action)<div>{{ $action }}</div>@endisset
        </div>
    @endif

    <div @class(['p-5' => $padding])>
        {{ $slot }}
    </div>
</div>
