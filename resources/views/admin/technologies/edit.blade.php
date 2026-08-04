@extends('layouts.admin')

@section('title', 'Edit technology')

@section('content')
    <x-admin.page-header :title="'Edit '.$technology->name" subtitle="Changes appear on the website immediately." />

    <x-card class="max-w-4xl">
        <form method="POST" action="{{ route('admin.technologies.update', $technology) }}" enctype="multipart/form-data"
            class="space-y-5">
            @csrf @method('PUT')

            @include('admin.technologies.form')

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-5">
                <x-button :href="route('admin.technologies.index')" variant="secondary">Cancel</x-button>
                <x-button type="submit" variant="primary" icon="check">Save changes</x-button>
            </div>
        </form>
    </x-card>
@endsection
