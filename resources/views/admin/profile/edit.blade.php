@extends('layouts.admin')

@section('title', 'Profile')

@section('content')
    <x-admin.page-header title="My profile" subtitle="Your account details and password." />

    <form method="POST" action="{{ route('admin.profile.update') }}" class="max-w-2xl space-y-6">
        @csrf @method('PUT')

        <x-card title="Account">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div>
                    <x-form.label for="name">Name</x-form.label>
                    <x-form.input id="name" name="name" :value="old('name', auth()->user()->name)" required class="mt-1.5" />
                    <x-form.error field="name" />
                </div>
                <div>
                    <x-form.label for="email">Email address</x-form.label>
                    <x-form.input id="email" name="email" type="email" :value="old('email', auth()->user()->email)" required class="mt-1.5" />
                    <x-form.error field="email" />
                </div>
            </div>
        </x-card>

        <x-card title="Change password">
            <p class="mb-4 text-sm text-slate-500">Leave these fields empty to keep your current password.</p>
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                <div>
                    <x-form.label for="current_password">Current password</x-form.label>
                    <x-form.input id="current_password" name="current_password" type="password" autocomplete="current-password" class="mt-1.5" />
                    <x-form.error field="current_password" />
                </div>
                <div>
                    <x-form.label for="password">New password</x-form.label>
                    <x-form.input id="password" name="password" type="password" autocomplete="new-password" class="mt-1.5" />
                    <x-form.error field="password" />
                </div>
                <div>
                    <x-form.label for="password_confirmation">Confirm new password</x-form.label>
                    <x-form.input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" class="mt-1.5" />
                </div>
            </div>
        </x-card>

        <div class="flex justify-end">
            <x-button type="submit" variant="primary" icon="check">Save profile</x-button>
        </div>
    </form>
@endsection
