<x-layouts.guest title="Smart IT Solutions for a Connected Future">
    <div class="mx-auto flex min-h-screen max-w-5xl flex-col px-6 py-10">
        <header class="flex items-center justify-between">
            <x-logo light />
            <p class="hidden text-xs font-medium tracking-[0.3em] text-brand-300 sm:block">CONNECT · SECURE · EMPOWER</p>
        </header>

        <main class="flex flex-1 flex-col justify-center py-16">
            <div class="grid grid-cols-1 gap-12 lg:grid-cols-2 lg:items-center">
                <div>
                    <p class="text-sm font-semibold uppercase tracking-widest text-brand-400">Our full website is on its way</p>
                    <h1 class="mt-3 font-display text-4xl font-bold leading-tight text-white sm:text-5xl">
                        Smart IT Solutions<br>for a <span class="text-brand-400">Connected Future</span>
                    </h1>
                    <p class="mt-4 max-w-md text-slate-300">
                        Networx Solutions delivers reliable and innovative IT services that help your business
                        stay connected, secure, and productive.
                    </p>

                    @if ($services->isNotEmpty())
                        <ul class="mt-8 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            @foreach ($services as $service)
                                <li class="flex items-center gap-2 rounded-lg bg-white/5 px-3 py-2.5 text-sm text-slate-200 ring-1 ring-inset ring-white/10">
                                    <x-icon :name="$service->icon" class="size-4 text-brand-400" />
                                    {{ $service->name }}
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <div class="mt-10 space-y-2 text-sm text-slate-300">
                        @if ($contactEmail)
                            <p class="flex items-center gap-2.5">
                                <x-icon name="envelope" class="size-4 text-brand-400" />
                                <a href="mailto:{{ $contactEmail }}" class="hover:text-white">{{ $contactEmail }}</a>
                            </p>
                        @endif
                        @if ($contactPhone)
                            <p class="flex items-center gap-2.5">
                                <x-icon name="phone" class="size-4 text-brand-400" />
                                <a href="tel:{{ preg_replace('/[^+\d]/', '', $contactPhone) }}" class="hover:text-white">{{ $contactPhone }}</a>
                            </p>
                        @endif
                        @if ($website)
                            <p class="flex items-center gap-2.5">
                                <x-icon name="globe" class="size-4 text-brand-400" />
                                {{ $website }}
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Contact form --}}
                <div class="rounded-2xl bg-white p-8 shadow-xl">
                    <h2 class="font-display text-xl font-bold text-navy-900">Contact us today</h2>
                    <p class="mt-1 text-sm text-slate-500">Tell us what you need — we usually respond within one business day.</p>

                    @if (session('contact_success'))
                        <div class="mt-5 flex items-start gap-2.5 rounded-lg bg-emerald-50 p-4 text-sm text-emerald-800 ring-1 ring-inset ring-emerald-200">
                            <x-icon name="check" class="mt-0.5 size-4 shrink-0" />
                            {{ session('contact_success') }}
                        </div>
                    @else
                        <form method="POST" action="{{ route('contact.store') }}" class="mt-6 space-y-4">
                            @csrf

                            {{-- Honeypot: bots fill this, people never see it. --}}
                            <div class="hidden" aria-hidden="true">
                                <label for="website-field">Website</label>
                                <input id="website-field" type="text" name="website" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <x-form.label for="contact-name">Name</x-form.label>
                                    <x-form.input id="contact-name" name="name" :value="old('name')" required class="mt-1.5" />
                                    <x-form.error field="name" />
                                </div>
                                <div>
                                    <x-form.label for="contact-email">Email</x-form.label>
                                    <x-form.input id="contact-email" name="email" type="email" :value="old('email')" required class="mt-1.5" />
                                    <x-form.error field="email" />
                                </div>
                                <div>
                                    <x-form.label for="contact-phone">Phone <span class="font-normal text-slate-400">(optional)</span></x-form.label>
                                    <x-form.input id="contact-phone" name="phone" :value="old('phone')" class="mt-1.5" />
                                    <x-form.error field="phone" />
                                </div>
                                <div>
                                    <x-form.label for="contact-service">Service</x-form.label>
                                    <x-form.select id="contact-service" name="service_id" class="mt-1.5">
                                        <option value="">General enquiry</option>
                                        @foreach ($services as $service)
                                            <option value="{{ $service->id }}" @selected(old('service_id') == $service->id)>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </x-form.select>
                                    <x-form.error field="service_id" />
                                </div>
                            </div>

                            <div>
                                <x-form.label for="contact-subject">Subject</x-form.label>
                                <x-form.input id="contact-subject" name="subject" :value="old('subject')" required class="mt-1.5" />
                                <x-form.error field="subject" />
                            </div>

                            <div>
                                <x-form.label for="contact-message">Message</x-form.label>
                                <x-form.textarea id="contact-message" name="message" rows="4" required class="mt-1.5">{{ old('message') }}</x-form.textarea>
                                <x-form.error field="message" />
                            </div>

                            <x-button type="submit" variant="primary" size="lg" class="w-full" icon="send">
                                Send message
                            </x-button>
                        </form>
                    @endif
                </div>
            </div>
        </main>

        <footer class="flex flex-wrap items-center justify-between gap-3 border-t border-white/10 pt-6 text-xs text-slate-400">
            <p>© {{ now()->year }} Networx Solutions. All rights reserved.</p>
            <p>Your trusted partner for reliable IT solutions.</p>
        </footer>
    </div>
</x-layouts.guest>
