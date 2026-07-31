@extends('layouts.admin')

@section('title', 'Arabic content')

@section('content')
    @php
        $activeTab = array_key_first($sections);

        foreach ($sections as $sectionKey => $section) {
            $hasErrors = collect($section['groups'])
                ->flatMap(fn (array $group): array => $group['fields'])
                ->contains(fn (array $field): bool => $errors->has($field['validation_key']));

            if ($hasErrors) {
                $activeTab = $sectionKey;

                break;
            }
        }
    @endphp

    <x-admin.page-header title="Arabic content"
        subtitle="Review and update the Arabic website copy. Changes appear on the Arabic site immediately." />

    <form method="POST" action="{{ route('admin.arabic-content.update') }}" class="max-w-6xl space-y-6"
        data-page-content-tabs>
        @csrf
        @method('PUT')

        <div class="flex flex-col gap-4 rounded-2xl border border-blue-200 bg-gradient-to-r from-blue-50 to-white p-5 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-start gap-3">
                <span class="flex size-10 shrink-0 items-center justify-center rounded-xl bg-brand-600 text-white shadow-sm">
                    <x-icon name="globe" class="size-5" />
                </span>
                <div>
                    <p class="font-display text-sm font-bold text-navy-950">Arabic review workspace</p>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-600">Use the tabs to review one website section at a time. Technical names such as IT, Cloud, CCTV, and Microsoft 365 can remain in English.</p>
                </div>
            </div>
            <a href="{{ route('home', ['lang' => 'ar']) }}" target="_blank" rel="noopener"
                class="inline-flex min-h-10 shrink-0 items-center justify-center gap-2 rounded-lg bg-white px-4 py-2 text-sm font-semibold text-brand-700 shadow-sm ring-1 ring-inset ring-blue-200 transition hover:bg-blue-50">
                View Arabic site
                <x-icon name="external" class="size-4" />
            </a>
        </div>

        <nav aria-label="Arabic website sections" class="overflow-x-auto rounded-xl bg-white shadow-sm ring-1 ring-slate-900/5">
            <div class="flex min-w-max items-center gap-1 p-1.5 lg:min-w-0" role="tablist" data-page-content-tablist>
                @foreach ($sections as $sectionKey => $section)
                    <a id="arabic-content-tab-{{ $sectionKey }}" href="#arabic-content-panel-{{ $sectionKey }}"
                        @class([
                            'inline-flex min-h-11 items-center gap-2 whitespace-nowrap rounded-lg px-4 py-2.5 text-sm font-semibold transition-colors lg:flex-1 lg:justify-center',
                            'bg-navy-950 text-white shadow-sm' => $activeTab === $sectionKey,
                            'text-slate-500 hover:bg-slate-100 hover:text-navy-950' => $activeTab !== $sectionKey,
                        ])
                        role="tab" aria-controls="arabic-content-panel-{{ $sectionKey }}"
                        aria-selected="{{ $activeTab === $sectionKey ? 'true' : 'false' }}"
                        tabindex="{{ $activeTab === $sectionKey ? '0' : '-1' }}"
                        data-page-content-tab="{{ $sectionKey }}">
                        <x-icon :name="$section['icon']" class="size-4" />
                        <span>{{ $section['label'] }}</span>
                    </a>
                @endforeach
            </div>
        </nav>

        @foreach ($sections as $sectionKey => $section)
            <section id="arabic-content-panel-{{ $sectionKey }}" role="tabpanel"
                aria-labelledby="arabic-content-tab-{{ $sectionKey }}" data-page-content-panel="{{ $sectionKey }}"
                class="space-y-5" @if ($activeTab !== $sectionKey) hidden @endif>
                @foreach ($section['groups'] as $group)
                    <x-card>
                        <div class="border-b border-slate-100 pb-4">
                            <h2 class="font-display text-lg font-bold text-navy-950">{{ $group['title'] }}</h2>
                            <p class="mt-1 text-sm leading-6 text-slate-500">{{ $group['description'] }}</p>
                        </div>

                        <div class="mt-5 grid grid-cols-1 gap-5 lg:grid-cols-2" dir="rtl">
                            @foreach ($group['fields'] as $field)
                                <div @class(['lg:col-span-2' => $field['rows'] > 2])>
                                    <x-form.label :for="$field['id']" class="font-arabic text-right">{{ $field['label'] }}</x-form.label>
                                    <x-form.textarea :id="$field['id']" :name="$field['name']" :rows="$field['rows']"
                                        dir="rtl" @class([
                                            'mt-1.5 font-arabic text-right leading-7',
                                            'ring-red-400 focus:ring-red-600' => $errors->has($field['validation_key']),
                                        ])>{{ old($field['validation_key'], $field['value']) }}</x-form.textarea>
                                    <x-form.error :field="$field['validation_key']" />
                                </div>
                            @endforeach
                        </div>
                    </x-card>
                @endforeach

                @if ($sectionKey === 'services')
                    <x-card>
                        <div class="border-b border-slate-100 pb-4">
                            <h2 class="font-display text-lg font-bold text-navy-950">Individual services</h2>
                            <p class="mt-1 text-sm leading-6 text-slate-500">Service names, descriptions, inclusions, and detail-page content are managed with each service.</p>
                        </div>

                        <div class="mt-4 grid gap-3 sm:grid-cols-2">
                            @foreach ($services as $service)
                                <a href="{{ route('admin.services.edit', $service) }}"
                                    class="group flex items-center justify-between gap-4 rounded-xl border border-slate-200 bg-slate-50/70 px-4 py-3 transition hover:border-blue-300 hover:bg-blue-50">
                                    <div class="min-w-0">
                                        <p class="truncate text-sm font-semibold text-navy-950">{{ $service->name }}</p>
                                        <p class="mt-0.5 truncate font-arabic text-sm text-slate-500" dir="rtl">{{ $service->name_ar ?: 'Arabic content not added' }}</p>
                                    </div>
                                    <x-icon name="arrow-left" class="size-4 shrink-0 rotate-180 text-slate-400 transition group-hover:translate-x-0.5 group-hover:text-brand-700" />
                                </a>
                            @endforeach
                        </div>
                    </x-card>
                @endif
            </section>
        @endforeach

        <div class="sticky bottom-4 z-10 flex justify-end rounded-xl border border-slate-200 bg-white/90 p-3 shadow-lg backdrop-blur">
            <x-button type="submit" variant="primary" icon="check">Save Arabic content</x-button>
        </div>
    </form>
@endsection
