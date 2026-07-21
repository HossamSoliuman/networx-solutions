@extends('layouts.admin')

@section('title', 'Messaging')

@section('content')
    <x-admin.page-header title="Messaging"
        subtitle="Where enquiry alerts are sent and how your email replies are signed." />

    <form method="POST" action="{{ route('admin.settings.update', 'messaging') }}" class="max-w-5xl space-y-6">
        @csrf @method('PUT')

        <x-card title="Messaging">
            <div class="space-y-5">
                <div>
                    <x-form.label for="notification_email">New-message alerts go to</x-form.label>
                    <x-form.input id="notification_email" name="notification_email" type="email"
                        :value="old('notification_email', $settings['notification_email'])" class="mt-1.5" />
                    <x-form.error field="notification_email" />
                </div>
                <div>
                    <x-form.label for="mail_signature">Email reply signature</x-form.label>
                    <x-form.textarea id="mail_signature" name="mail_signature" rows="3" class="mt-1.5">{{ old('mail_signature', $settings['mail_signature']) }}</x-form.textarea>
                    <x-form.error field="mail_signature" />
                </div>
            </div>
        </x-card>

        <div class="flex justify-end">
            <x-button type="submit" variant="primary" icon="check">Save messaging</x-button>
        </div>
    </form>
@endsection
