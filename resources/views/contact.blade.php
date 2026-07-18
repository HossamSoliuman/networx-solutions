<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="Contact" :description="$site['contact_intro']">
    <section class="bg-navy-950 py-20 text-white sm:py-24">
        <div class="mx-auto grid max-w-[90rem] gap-10 px-5 sm:px-8 lg:grid-cols-[0.65fr_1.35fr] lg:items-end lg:px-12">
            <p class="section-kicker text-brand-200">{{ $site['contact_eyebrow'] }}</p>
            <div>
                <h1 class="text-balance font-display text-5xl font-bold leading-[1] tracking-[-0.05em] sm:text-6xl">
                    {{ $site['contact_title'] }}
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-slate-300">{{ $site['contact_intro'] }}</p>
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-24">
        <div class="mx-auto grid max-w-[90rem] gap-10 px-5 sm:px-8 lg:grid-cols-[0.75fr_1.25fr] lg:gap-16 lg:px-12">
            <aside>
                <div class="overflow-hidden rounded-[2rem] bg-white ring-1 ring-slate-200">
                    <img src="{{ $site['contact_image_url'] }}" alt="High-performance network router"
                        class="h-72 w-full object-cover">
                    <div class="p-7 sm:p-8">
                        <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Direct contact</p>
                        <div class="mt-6 grid gap-5">
                            @if ($site['contact_email'])
                                <a href="mailto:{{ $site['contact_email'] }}" class="flex items-start gap-4">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                                        <x-icon name="envelope" class="size-4" />
                                    </span>
                                    <span>
                                        <span class="block text-xs font-semibold uppercase tracking-wide text-slate-400">Email</span>
                                        <span class="mt-1 block text-sm font-bold text-navy-950">{{ $site['contact_email'] }}</span>
                                    </span>
                                </a>
                            @endif
                            @if ($site['contact_phone'])
                                <a href="tel:{{ preg_replace('/[^+\d]/', '', $site['contact_phone']) }}" class="flex items-start gap-4">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                                        <x-icon name="phone" class="size-4" />
                                    </span>
                                    <span>
                                        <span class="block text-xs font-semibold uppercase tracking-wide text-slate-400">Phone</span>
                                        <span class="mt-1 block text-sm font-bold text-navy-950">{{ $site['contact_phone'] }}</span>
                                    </span>
                                </a>
                            @endif
                            @if ($site['address'])
                                <div class="flex items-start gap-4">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700">
                                        <x-icon name="building" class="size-4" />
                                    </span>
                                    <span>
                                        <span class="block text-xs font-semibold uppercase tracking-wide text-slate-400">Location</span>
                                        <span class="mt-1 block text-sm font-bold text-navy-950">{{ $site['address'] }}</span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </aside>

            <div class="rounded-[2rem] bg-white p-6 shadow-[0_24px_70px_-42px_rgba(6,27,57,0.38)] ring-1 ring-slate-200 sm:p-9 lg:p-11">
                @if (session('contact_success'))
                    <div class="mb-8 flex gap-3 rounded-2xl bg-emerald-50 p-5 text-emerald-800 ring-1 ring-emerald-200">
                        <x-icon name="check" class="mt-0.5 size-5" />
                        <p class="text-sm leading-6">{{ session('contact_success') }}</p>
                    </div>
                @endif

                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Project enquiry</p>
                    <h2 class="mt-3 font-display text-3xl font-bold tracking-[-0.03em] text-navy-950">How can we help?</h2>
                </div>

                <form method="POST" action="{{ route('contact.store') }}" class="mt-8 grid gap-5 sm:grid-cols-2">
                    @csrf

                    <div>
                        <x-form.label for="name">Name</x-form.label>
                        <x-form.input id="name" name="name" :value="old('name')" required autocomplete="name" class="mt-1.5" />
                        <x-form.error field="name" />
                    </div>
                    <div>
                        <x-form.label for="email">Work email</x-form.label>
                        <x-form.input id="email" name="email" type="email" :value="old('email')" required autocomplete="email" class="mt-1.5" />
                        <x-form.error field="email" />
                    </div>
                    <div>
                        <x-form.label for="phone">Phone</x-form.label>
                        <x-form.input id="phone" name="phone" :value="old('phone')" autocomplete="tel" class="mt-1.5" />
                        <x-form.error field="phone" />
                    </div>
                    <div>
                        <x-form.label for="company">Company</x-form.label>
                        <x-form.input id="company" name="company" :value="old('company')" autocomplete="organization" class="mt-1.5" />
                        <x-form.error field="company" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-form.label for="service_id">Service</x-form.label>
                        <x-form.select id="service_id" name="service_id" class="mt-1.5">
                            <option value="">Choose a service (optional)</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected((string) old('service_id', $selectedService?->id) === (string) $service->id)>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                        <x-form.error field="service_id" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-form.label for="subject">Subject</x-form.label>
                        <x-form.input id="subject" name="subject" :value="old('subject')" required class="mt-1.5" />
                        <x-form.error field="subject" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-form.label for="message">What do you need?</x-form.label>
                        <x-form.textarea id="message" name="message" rows="6" required class="mt-1.5">{{ old('message') }}</x-form.textarea>
                        <x-form.error field="message" />
                    </div>

                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="flex items-center justify-between gap-5 sm:col-span-2">
                        <p class="max-w-md text-xs leading-5 text-slate-500">Your enquiry is sent directly to the Networx team.</p>
                        <button type="submit"
                            class="inline-flex shrink-0 items-center justify-center gap-2 rounded-full bg-brand-600 px-6 py-3.5 text-sm font-bold text-white transition-all hover:-translate-y-0.5 hover:bg-brand-700">
                            Send enquiry
                            <x-icon name="send" class="size-4" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.public>
