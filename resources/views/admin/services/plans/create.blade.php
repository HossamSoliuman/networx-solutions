@extends('layouts.admin')

@section('title', 'Add plan')

@section('content')
    <x-admin.page-header title="Add plan"
        :subtitle="'A new pricing card on the '.$service->name.' page.'" />

    <x-card class="max-w-4xl">
        <form method="POST" action="{{ route('admin.services.plans.store', $service) }}" class="space-y-5">
            @csrf

            @include('admin.services.plans.form')

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-5">
                <x-button :href="route('admin.services.plans.index', $service)" variant="secondary">Cancel</x-button>
                <x-button type="submit" variant="primary" icon="check">Create plan</x-button>
            </div>
        </form>
    </x-card>
@endsection
