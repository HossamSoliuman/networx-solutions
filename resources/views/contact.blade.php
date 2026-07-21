<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="Contact" :description="$site['contact_intro']" focused>
    <section class="relative isolate min-h-full overflow-hidden bg-navy-950 text-white">
        <img src="{{ asset('images/site/networx-logo-contact-transparent.png') }}" alt="" aria-hidden="true"
            class="absolute -left-28 top-1/2 -z-20 size-[34rem] -translate-y-1/2 object-contain opacity-30 sm:-left-20 sm:size-[42rem] lg:-left-24 lg:size-[48rem] lg:opacity-45">
        <div class="absolute inset-0 -z-10 bg-[linear-gradient(90deg,rgba(7,52,111,0.18)_0%,rgba(7,52,111,0.72)_42%,rgba(7,52,111,0.94)_100%)]"></div>

        <div class="mx-auto grid min-h-full w-full max-w-[90rem] items-center gap-8 px-5 py-8 sm:px-8 lg:grid-cols-[0.8fr_1.2fr] lg:px-12 lg:py-5 xl:grid-cols-[0.72fr_1.28fr] xl:gap-12">
            <div class="min-w-0 max-w-md rounded-[1.5rem] border border-white/15 bg-navy-950/35 p-5 shadow-[0_24px_70px_-42px_rgba(2,15,35,0.75)] backdrop-blur-md sm:p-6" data-reveal>
                <h1 class="sr-only">Contact {{ $site['site_name'] }}</h1>
                <p class="technical-label text-brand-200">Contact information</p>
                <div class="mt-5 min-w-0 divide-y divide-white/15 border-y border-white/15">
                        @if ($site['contact_email'])
                            <a href="mailto:{{ $site['contact_email'] }}" class="group flex min-w-0 items-center gap-4 py-5">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full border border-white/15 text-signal-300 transition group-hover:border-white/30 group-hover:bg-white/10">
                                    <x-icon name="envelope" class="size-4.5" />
                                </span>
                                <span class="min-w-0">
                                    <span class="technical-label block text-brand-100/85">Email</span>
                                    <span class="mt-1 block truncate text-base font-semibold text-white">{{ $site['contact_email'] }}</span>
                                </span>
                            </a>
                        @endif

                        @if ($site['contact_phone'])
                            <a href="tel:{{ preg_replace('/[^+\d]/', '', $site['contact_phone']) }}" class="group flex items-center gap-4 py-5">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full border border-white/15 text-signal-300 transition group-hover:border-white/30 group-hover:bg-white/10">
                                    <x-icon name="phone" class="size-4.5" />
                                </span>
                                <span>
                                    <span class="technical-label block text-brand-100/85">Phone</span>
                                    <span class="mt-1 block text-base font-semibold text-white">{{ $site['contact_phone'] }}</span>
                                </span>
                            </a>
                        @endif

                        @if ($site['address'])
                            <div class="flex items-center gap-4 py-5">
                                <span class="flex size-10 shrink-0 items-center justify-center rounded-full border border-white/15 text-signal-300">
                                    <x-icon name="building" class="size-4.5" />
                                </span>
                                <span>
                                    <span class="technical-label block text-brand-100/85">Location</span>
                                    <span class="mt-1 block text-base font-semibold text-white">{{ $site['address'] }}</span>
                                </span>
                            </div>
                        @endif
                </div>
            </div>

            <div class="min-w-0 rounded-[1.75rem] bg-white p-5 text-slate-900 shadow-[0_28px_80px_-48px_rgba(5,26,53,0.65)] ring-1 ring-white/30 sm:p-6 lg:p-5 xl:p-7"
                data-reveal>
                @if (session('contact_success'))
                    <div class="mb-4 flex gap-3 rounded-xl bg-emerald-50 p-3 text-emerald-800 ring-1 ring-emerald-200" role="status">
                        <x-icon name="check" class="mt-0.5 size-4 shrink-0" />
                        <p class="text-xs leading-5">{{ session('contact_success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-4 rounded-xl bg-red-50 p-3 text-red-800 ring-1 ring-red-200" role="alert">
                        @if ($errors->has('company_fax') && $errors->count() === 1)
                            <p class="font-display text-sm font-bold">We couldn&#039;t send that enquiry.</p>
                            <p class="mt-0.5 text-xs leading-5">Please wait a moment and try again.</p>
                        @else
                            <p class="font-display text-sm font-bold">Check the fields outlined in red.</p>
                            <p class="mt-0.5 text-xs leading-5">Each highlighted field includes a note explaining what needs to change.</p>
                        @endif
                    </div>
                @endif

                <div class="flex items-end justify-between gap-4 border-b border-slate-200 pb-4">
                    <div>
                        <p class="technical-label text-brand-700">Project enquiry</p>
                        <h2 class="mt-1.5 font-display text-2xl font-bold tracking-[-0.035em] text-navy-950 xl:text-3xl">How can we help?</h2>
                    </div>
                    <p class="hidden text-xs text-slate-500 sm:block">* Required fields</p>
                </div>

                <form method="POST" action="{{ route('contact.store') }}" class="mt-4 grid min-w-0 gap-x-3 gap-y-3 sm:grid-cols-2 xl:grid-cols-6" data-contact-form>
                    @csrf

                    <div class="min-w-0 xl:col-span-2">
                        <x-form.label for="name">Name <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <x-form.input id="name" name="name" :value="old('name')" required autocomplete="name"
                            placeholder="Your name" class="mt-1 h-10 bg-white"
                            aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                            aria-describedby="name-error" />
                        <x-form.error field="name" />
                    </div>
                    <div class="min-w-0 xl:col-span-2">
                        <x-form.label for="email">Work email <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <x-form.input id="email" name="email" type="email" :value="old('email')" required autocomplete="email"
                            placeholder="name@company.com" class="mt-1 h-10 bg-white"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            aria-describedby="email-error" />
                        <x-form.error field="email" />
                    </div>
                    <div class="min-w-0 xl:col-span-2">
                        <x-form.label for="company">Company</x-form.label>
                        <x-form.input id="company" name="company" :value="old('company')" autocomplete="organization"
                            placeholder="Company name" class="mt-1 h-10 bg-white"
                            aria-invalid="{{ $errors->has('company') ? 'true' : 'false' }}"
                            aria-describedby="company-error" />
                        <x-form.error field="company" />
                    </div>
                    <div class="min-w-0 xl:col-span-2">
                        <x-form.label for="phone_local">Phone <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <input type="hidden" name="phone_country" value="{{ old('phone_country', '+20') }}">
                        <x-form.input id="phone_local" name="phone_local" type="tel" :value="old('phone_local')" required autocomplete="tel-national" inputmode="numeric"
                            placeholder="10 664 055 70" class="mt-1 h-10 bg-white"
                            aria-invalid="{{ $errors->has('phone_local') ? 'true' : 'false' }}"
                            aria-describedby="phone_local-error" />
                        <x-form.error field="phone_country" />
                        <x-form.error field="phone_local" />
                    </div>
                    <div class="min-w-0 xl:col-span-2">
                        <x-form.label for="service_id">Service</x-form.label>
                        <x-form.select id="service_id" name="service_id" class="mt-1 h-10 bg-white py-1.5"
                            aria-invalid="{{ $errors->has('service_id') ? 'true' : 'false' }}"
                            aria-describedby="service_id-error">
                            <option value="">Choose a service (optional)</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected((string) old('service_id', $selectedService?->id) === (string) $service->id)>
                                    {{ $service->name }}
                                </option>
                            @endforeach
                        </x-form.select>
                        <x-form.error field="service_id" />
                    </div>
                    <div class="min-w-0 xl:col-span-2">
                        <x-form.label for="subject">Subject <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <x-form.input id="subject" name="subject" :value="old('subject')" required
                            placeholder="What needs attention?" class="mt-1 h-10 bg-white"
                            aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                            aria-describedby="subject-error" />
                        <x-form.error field="subject" />
                    </div>
                    <div class="min-w-0 sm:col-span-2 xl:col-span-6">
                        <x-form.label for="message">What do you need? <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <x-form.textarea id="message" name="message" rows="6" required
                            placeholder="Share the current situation, impact, timing, or outcome you have in mind."
                            class="mt-1 min-h-40 resize-none bg-white"
                            aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}"
                            aria-describedby="message-error">{{ old('message') }}</x-form.textarea>
                        <x-form.error field="message" />
                    </div>

                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label for="company_fax">Fax</label>
                        <input id="company_fax" name="company_fax" type="text" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="flex flex-col gap-3 border-t border-slate-200 pt-4 sm:col-span-2 sm:flex-row sm:items-center sm:justify-between xl:col-span-6">
                        <p class="max-w-sm text-xs leading-5 text-slate-500">We use your details only to review and respond to this enquiry.</p>
                        <button type="submit" class="button-dark min-h-10 w-full shrink-0 px-5 py-2 disabled:pointer-events-none sm:w-auto"
                            data-contact-submit>
                            <span data-contact-submit-label>Send enquiry</span>
                            <x-icon name="send" class="size-4" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.public>
