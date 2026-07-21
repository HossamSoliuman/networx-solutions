@extends('layouts.guest')

@section('title', 'Sign in')

@section('content')
    <div class="flex min-h-screen items-center justify-center p-6">
        <div class="w-full max-w-sm">
            <div class="mb-8 flex flex-col items-center gap-3 text-center">
                <x-logo light />
                <p class="text-xs font-medium tracking-[0.3em] text-brand-300">CONNECT · SECURE · EMPOWER</p>
            </div>

            <div class="rounded-2xl bg-white p-8 shadow-xl">
                <h1 class="font-display text-xl font-bold text-navy-900">Admin sign in</h1>
                <p class="mt-1 text-sm text-slate-500">Enter your credentials to manage Networx Solutions.</p>

                <form method="POST" action="{{ route('admin.login.store') }}" class="mt-6 space-y-4">
                    @csrf

                    <div>
                        <x-form.label for="email">Email address</x-form.label>
                        <x-form.input id="email" name="email" type="email" :value="old('email')" required autofocus
                            autocomplete="email" class="mt-1.5" />
                        <x-form.error field="email" />
                    </div>

                    <div>
                        <x-form.label for="password">Password</x-form.label>
                        <x-form.input id="password" name="password" type="password" required
                            autocomplete="current-password" class="mt-1.5" />
                        <x-form.error field="password" />
                    </div>

                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember"
                            class="size-4 rounded border-slate-300 text-brand-600 focus:ring-brand-600">
                        Keep me signed in
                    </label>

                    <x-button type="submit" variant="primary" size="lg" class="w-full">
                        Sign in
                    </x-button>
                </form>
            </div>

            <p class="mt-6 text-center text-xs text-slate-400">
                © {{ now()->year }} Networx Solutions — IT Solutions &amp; Services
            </p>
        </div>
    </div>
@endsection
