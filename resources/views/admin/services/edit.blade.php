<x-layouts.admin title="Edit service">
    <x-admin.page-header :title="'Edit '.$service->name" subtitle="Changes appear on the website immediately." />

    <x-card class="max-w-3xl">
        <form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data" class="space-y-5">
            @csrf @method('PUT')

            @include('admin.services.form')

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-5">
                <x-button :href="route('admin.services.index')" variant="secondary">Cancel</x-button>
                <x-button type="submit" variant="primary" icon="check">Save changes</x-button>
            </div>
        </form>
    </x-card>
</x-layouts.admin>
