<x-layouts.admin title="Services">
    <x-admin.page-header title="Services"
        subtitle="The service catalogue shown on the public website and offered on the contact form.">
        <x-button :href="route('admin.services.create')" variant="primary" icon="plus">Add service</x-button>
    </x-admin.page-header>

    <x-card :padding="false">
        @if ($services->isEmpty())
            <x-empty-state icon="grid" title="No services yet">
                Add your first service to show it on the website and contact form.
            </x-empty-state>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead>
                        <tr class="text-left text-xs font-semibold uppercase tracking-wide text-slate-400">
                            <th class="px-5 py-3">Service</th>
                            <th class="hidden px-3 py-3 md:table-cell">Excerpt</th>
                            <th class="px-3 py-3">Enquiries</th>
                            <th class="px-3 py-3">Order</th>
                            <th class="px-3 py-3">Status</th>
                            <th class="px-5 py-3 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($services as $service)
                            <tr class="transition-colors hover:bg-slate-50">
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center gap-3">
                                        <span class="flex size-9 items-center justify-center rounded-lg bg-brand-50 text-brand-600">
                                            <x-icon :name="$service->icon" class="size-5" />
                                        </span>
                                        <div>
                                            <p class="font-medium text-slate-900">{{ $service->name }}</p>
                                            <p class="text-xs text-slate-400">/{{ $service->slug }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="hidden max-w-72 truncate px-3 py-3.5 text-slate-500 md:table-cell">
                                    {{ $service->excerpt }}
                                </td>
                                <td class="px-3 py-3.5 text-slate-600">{{ $service->contact_messages_count }}</td>
                                <td class="px-3 py-3.5 text-slate-600">{{ $service->sort_order }}</td>
                                <td class="px-3 py-3.5">
                                    @if ($service->is_active)
                                        <span class="inline-flex items-center rounded-full bg-emerald-50 px-2 py-0.5 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20">Active</span>
                                    @else
                                        <span class="inline-flex items-center rounded-full bg-slate-100 px-2 py-0.5 text-xs font-medium text-slate-500 ring-1 ring-inset ring-slate-500/20">Hidden</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3.5">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <x-button :href="route('admin.services.edit', $service)" variant="ghost" size="sm">Edit</x-button>
                                        <x-button variant="ghost" size="sm" class="text-red-600 hover:bg-red-50"
                                            data-modal-open="delete-service-{{ $service->id }}">Delete</x-button>
                                    </div>

                                    <x-modal id="delete-service-{{ $service->id }}" title="Delete “{{ $service->name }}”?">
                                        <p>
                                            Existing messages keep their content, but will no longer be linked to this service.
                                            This cannot be undone.
                                        </p>
                                        <x-slot:footer>
                                            <x-button variant="secondary" data-modal-close>Cancel</x-button>
                                            <form method="POST" action="{{ route('admin.services.destroy', $service) }}">
                                                @csrf @method('DELETE')
                                                <x-button type="submit" variant="danger" icon="trash">Delete service</x-button>
                                            </form>
                                        </x-slot:footer>
                                    </x-modal>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </x-card>
</x-layouts.admin>
