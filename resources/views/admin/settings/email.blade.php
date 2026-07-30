@extends('layouts.admin')

@section('title', 'Email testing')

@section('content')
    <x-admin.page-header title="Email testing"
        subtitle="Verify that application email can leave through your Hostinger mailbox." />

    <div class="max-w-5xl space-y-6">
        <x-card title="Hostinger SMTP">
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Server</p>
                    <p class="mt-1 break-all text-sm font-semibold text-slate-900">{{ $mailConfiguration['host'] }}</p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Connection</p>
                    <p class="mt-1 text-sm font-semibold text-slate-900">
                        Port {{ $mailConfiguration['port'] }} · {{ strtoupper($mailConfiguration['scheme'] ?: 'automatic') }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Mailbox</p>
                    <p class="mt-1 break-all text-sm font-semibold text-slate-900">
                        {{ $mailConfiguration['username'] ?: 'Not configured' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Status</p>
                    @if ($mailConfiguration['ready'])
                        <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-200">
                            <span class="size-1.5 rounded-full bg-emerald-500"></span>
                            Ready to test
                        </span>
                    @else
                        <span class="mt-1 inline-flex items-center gap-1.5 rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-700 ring-1 ring-inset ring-amber-200">
                            <span class="size-1.5 rounded-full bg-amber-500"></span>
                            Setup incomplete
                        </span>
                    @endif
                </div>
            </div>

            @unless ($mailConfiguration['password_configured'])
                <div class="mt-5 flex gap-3 rounded-lg bg-amber-50 p-4 text-sm text-amber-900 ring-1 ring-inset ring-amber-200">
                    <x-icon name="warning" class="mt-0.5 size-5 text-amber-600" />
                    <div>
                        <p class="font-semibold">Mailbox password required</p>
                        <p class="mt-1 text-amber-800">
                            Set <code class="rounded bg-amber-100 px-1.5 py-0.5 text-xs">MAIL_PASSWORD</code> in the production environment, then clear the configuration cache.
                        </p>
                    </div>
                </div>
            @endunless
        </x-card>

        <x-card title="Send a test email">
            <form method="POST" action="{{ route('admin.settings.email.test') }}" class="space-y-5">
                @csrf

                <div>
                    <x-form.label for="mail_test_recipient">Test recipient</x-form.label>
                    <x-form.input id="mail_test_recipient" name="mail_test_recipient" type="email"
                        :value="old('mail_test_recipient', $settings['mail_test_recipient'])"
                        placeholder="you@example.com" required autocomplete="email" class="mt-1.5" />
                    <x-form.error field="mail_test_recipient" />
                    <p class="mt-2 text-xs text-slate-500">
                        This address is saved when you send the test, so it will be ready next time.
                    </p>
                </div>

                <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-100 pt-5">
                    <p class="text-xs text-slate-500">
                        From {{ $mailConfiguration['from_address'] }} via {{ $mailConfiguration['host'] }}
                    </p>
                    <x-button type="submit" variant="primary" icon="send">Send test email</x-button>
                </div>
            </form>
        </x-card>
    </div>
@endsection
