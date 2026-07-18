<select
    {{ $attributes->merge(['class' => 'block w-full rounded-lg border-0 bg-white px-3 py-2 pr-8 text-sm text-slate-900 shadow-sm ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-inset focus:ring-brand-600']) }}>
    {{ $slot }}
</select>
