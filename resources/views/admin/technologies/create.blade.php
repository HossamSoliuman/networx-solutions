@extends('layouts.admin')

@section('title', 'Add technology')

@section('content')
    <x-admin.page-header title="Add technology"
        subtitle="Add a vendor to the “Technologies we work with” section on the home page." />

    <x-card class="max-w-4xl">
        <form method="POST" action="{{ route('admin.technologies.store') }}" enctype="multipart/form-data" class="space-y-5">
            @csrf

            @include('admin.technologies.form')

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-5">
                <x-button :href="route('admin.technologies.index')" variant="secondary">Cancel</x-button>
                <x-button type="submit" variant="primary" icon="check">Create technology</x-button>
            </div>
        </form>
    </x-card>
@endsection
