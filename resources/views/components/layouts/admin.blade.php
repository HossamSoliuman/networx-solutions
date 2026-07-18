@props(['title' => 'Dashboard'])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} · Networx Solutions Admin</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|space-grotesk:500,700" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="h-full bg-slate-100 font-sans text-slate-900 antialiased">
    <div class="flex min-h-full">
        {{-- Mobile overlay --}}
        <div data-sidebar-overlay class="fixed inset-0 z-30 hidden bg-navy-950/60 backdrop-blur-sm lg:hidden"></div>

        {{-- Sidebar --}}
        <aside data-sidebar
            class="bg-network fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-navy-950 transition-transform duration-200 lg:translate-x-0">
            <div class="flex h-16 items-center justify-between px-5">
                <a href="{{ route('admin.dashboard') }}">
                    <x-logo light class="scale-90 origin-left" />
                </a>
                <button type="button" data-sidebar-toggle class="rounded-md p-1.5 text-slate-400 hover:text-white lg:hidden" aria-label="Close menu">
                    <x-icon name="x" />
                </button>
            </div>

            <nav class="mt-4 flex flex-1 flex-col gap-1 overflow-y-auto px-3">
                <x-admin.sidebar-link :href="route('admin.dashboard')" icon="home" :active="request()->routeIs('admin.dashboard')">
                    Dashboard
                </x-admin.sidebar-link>

                <x-admin.sidebar-link :href="route('admin.messages.index')" icon="inbox"
                    :active="request()->routeIs('admin.messages.*')" :badge="$unreadCount ?: null">
                    Messages
                </x-admin.sidebar-link>

                <x-admin.sidebar-link :href="route('admin.services.index')" icon="grid" :active="request()->routeIs('admin.services.*')">
                    Services
                </x-admin.sidebar-link>

                <x-admin.sidebar-link :href="route('admin.settings.edit')" icon="cog" :active="request()->routeIs('admin.settings.*')">
                    Settings
                </x-admin.sidebar-link>

                <div class="mt-auto mb-4 border-t border-white/10 pt-4">
                    <x-admin.sidebar-link :href="route('home')" icon="external">
                        View site
                    </x-admin.sidebar-link>
                </div>
            </nav>

            <div class="border-t border-white/10 p-4">
                <div class="flex items-center gap-3">
                    <x-avatar :name="auth()->user()->name" class="bg-brand-600/30 text-brand-200" />
                    <div class="min-w-0 flex-1">
                        <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-slate-400">{{ auth()->user()->email }}</p>
                    </div>
                </div>
                <div class="mt-3 flex gap-2">
                    <a href="{{ route('admin.profile.edit') }}"
                        class="flex-1 rounded-lg bg-white/5 px-3 py-1.5 text-center text-xs font-medium text-slate-300 hover:bg-white/10 hover:text-white">
                        Profile
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}" class="flex-1">
                        @csrf
                        <button type="submit"
                            class="w-full rounded-lg bg-white/5 px-3 py-1.5 text-xs font-medium text-slate-300 hover:bg-white/10 hover:text-white">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- Main column --}}
        <div class="flex min-w-0 flex-1 flex-col lg:pl-64">
            <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-slate-200 bg-white/80 px-4 backdrop-blur sm:px-6 lg:hidden">
                <button type="button" data-sidebar-toggle class="rounded-md p-1.5 text-slate-500 hover:bg-slate-100" aria-label="Open menu">
                    <x-icon name="menu" />
                </button>
                <x-logo class="scale-75 origin-left" />
            </header>

            <main class="flex-1 px-4 py-6 sm:px-6 lg:px-8 lg:py-8">
                <div class="mx-auto max-w-7xl space-y-6">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>

    <x-flash />
</body>

</html>
