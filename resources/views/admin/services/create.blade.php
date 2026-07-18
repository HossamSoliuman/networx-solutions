<x-layouts.admin title="Add service">
    <x-admin.page-header title="Add service" subtitle="Create a new entry in the service catalogue." />

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('admin.services.store') }}" class="space-y-5">
            @csrf

            @include('admin.services.form')

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-5">
                <x-button :href="route('admin.services.index')" variant="secondary">Cancel</x-button>
                <x-button type="submit" variant="primary" icon="check">Create service</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
