@extends('layouts.admin')

@section('title', 'Technologies')

@section('content')
    <x-admin.page-header title="Technologies"
        subtitle="The vendor logos shown in the “Technologies we work with” section on the home page.">
        <x-button :href="route('admin.technologies.create')" variant="primary" icon="plus">Add technology</x-button>
    </x-admin.page-header>

    <x-card :padding="false">
        @if ($technologies->isEmpty())
            <x-empty-state icon="devices" title="No technologies yet">
                Add your first vendor to show the technologies section on the home page.
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                            <th class="px-5 py-3">Technology</th>
                            <th class="hidden px-3 py-3 md:table-cell">Website</th>
                            <th class="px-3 py-3">Order</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($technologies as $technology)
                            <tr class="transition-colors hover:bg-slate-50">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <span class="flex h-11 w-20 shrink-0 items-center justify-center rounded-lg bg-white px-2 ring-1 ring-slate-200">
                                            @if ($technology->logoUrl())
                                                <img src="{{ $technology->logoUrl() }}" alt="" class="max-h-7 w-auto max-w-full object-contain">
                                            @else
                                                <span class="truncate text-xs font-bold" style="color: {{ $technology->brand_color }}">
                                                    {{ $technology->name }}
                                                </span>
                                            @endif
                                        </span>
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $technology->name }}</p>
                                            <p class="text-xs text-slate-400">/{{ $technology->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden max-w-72 truncate px-3 py-3.5 text-slate-500 md:table-cell">
                                    {{ $technology->website_url ?: '—' }}
                                </td>
                                <td class="px-3 py-3.5 text-slate-600">{{ $technology->sort_order }}</td>
                                <td class="px-3 py-3.5">
                                    @if ($technology->is_active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Active</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500 ring-1 ring-inset ring-slate-500/20">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <x-button :href="route('admin.technologies.edit', $technology)" variant="ghost" size="sm">Edit</x-button>
                                        <x-button variant="ghost" size="sm" class="text-red-600 hover:bg-red-50"
                                            data-modal-open="delete-technology-{{ $technology->id }}">Delete</x-button>
                                    </div>

                                    <dialog id="delete-technology-{{ $technology->id }}"
                                        class="m-auto w-full max-w-md rounded-xl p-0 shadow-xl backdrop:bg-navy-950/50 backdrop:backdrop-blur-sm open:animate-in">
                                        <div class="p-6">
                                            <div class="flex items-start justify-between gap-4">
                                                <h2 class="text-base font-semibold text-slate-900">Delete “{{ $technology->name }}”?</h2>
                                                <button type="button" data-modal-close
                                                    class="rounded-md p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600"
                                                    aria-label="Close">
                                                    <x-icon name="x" class="size-4" />
                                                </button>
                                            </div>

                                            <p class="mt-3 text-sm text-slate-600">
                                                The logo will be removed from the home page. This cannot be undone.
                                            </p>

                                            <div class="mt-6 flex justify-end gap-2">
                                                <x-button variant="secondary" data-modal-close>Cancel</x-button>
                                                <form method="POST" action="{{ route('admin.technologies.destroy', $technology) }}">
                                                    @csrf @method('DELETE')
                                                    <x-button type="submit" variant="danger" icon="trash">Delete technology</x-button>
                                                </form>
                                            </div>
                                        </div>
                                    </dialog>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
@endsection
