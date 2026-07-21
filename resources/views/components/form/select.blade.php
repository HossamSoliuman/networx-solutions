@php
    $selectClasses = $attributes->get('aria-invalid') === 'true'
        ? 'block w-full rounded-lg border-0 bg-white px-3 py-2 pr-8 text-sm text-slate-900 shadow-sm ring-1 ring-inset ring-red-400 focus:ring-2 focus:ring-inset focus:ring-red-600'
        : 'block w-full rounded-lg border-0 bg-white px-3 py-2 pr-8 text-sm text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-brand-600';
@endphp

<select
    {{ $attributes->merge(['class' => $selectClasses]) }}>
    {{ $slot }}
</select>
