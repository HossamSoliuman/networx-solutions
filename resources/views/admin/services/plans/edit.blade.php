@extends('layouts.admin')

@section('title', 'Edit plan')

@section('content')
    <x-admin.page-header :title="'Edit '.$plan->name" subtitle="Changes appear on the website immediately.">
        <form method="POST" action="{{ route('admin.services.plans.status', [$service, $plan]) }}">
            @csrf @method('PATCH')
            @if ($plan->is_active)
                <x-button type="submit" variant="secondary" icon="x">Deactivate plan</x-button>
            @else
                <x-button type="submit" variant="secondary" icon="check"
                    class="text-emerald-700 ring-emerald-300 hover:bg-emerald-50">Activate plan</x-button>
            @endif
        </form>
        <x-button :href="route('admin.services.plans.index', $service)" variant="secondary" icon="arrow-left">Back to plans</x-button>
    </x-admin.page-header>

    <x-card class="max-w-4xl">
        <form method="POST" action="{{ route('admin.services.plans.update', [$service, $plan]) }}" class="space-y-5">
            @csrf @method('PUT')

            @include('admin.services.plans.form')

            <div class="flex justify-end gap-2 border-t border-slate-100 pt-5">
                <x-button :href="route('admin.services.plans.index', $service)" variant="secondary">Cancel</x-button>
                <x-button type="submit" variant="primary" icon="check">Save changes</x-button>
            </div>
        </form>
    </x-card>
@endsection
