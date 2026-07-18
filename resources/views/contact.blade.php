<x-layouts.public :site="$site" :navigation-services="$navigationServices" title="Contact" :description="$site['contact_intro']">
    <x-site.page-hero :eyebrow="$site['contact_eyebrow']" :title="$site['contact_title']" :intro="$site['contact_intro']"
        :image="$site['contact_image_url']" image-alt="Connected network equipment">
        <x-slot:aside>
            <div class="w-full rounded-[1.75rem] border border-white/15 bg-navy-950/70 p-6 backdrop-blur-md lg:w-80">
                <span class="flex size-11 items-center justify-center rounded-full bg-signal-300/15 text-signal-300">
                    <x-icon name="send" class="size-5" />
                </span>
                <p class="mt-5 font-display text-xl font-bold text-white">No finished technical brief required.</p>
                <p class="mt-3 text-sm leading-6 text-slate-300">Start with the pressure, problem, or outcome. We will help clarify the next step.</p>
            </div>
        </x-slot:aside>
    </x-site.page-hero>

    <section class="relative overflow-hidden py-16 sm:py-24">
        <div class="bg-public-grid absolute inset-0 -z-10"></div>

        <div class="mx-auto grid max-w-[90rem] gap-10 px-5 sm:px-8 lg:grid-cols-[0.72fr_1.28fr] lg:gap-16 lg:px-12">
            <aside class="lg:sticky lg:top-28 lg:self-start" data-reveal>
                <div class="overflow-hidden rounded-[2rem] bg-white ring-1 ring-slate-200">
                    <img src="{{ $site['contact_image_url'] }}" alt="High-performance network router"
                        class="h-64 w-full object-cover sm:h-72" loading="lazy">

                    <div class="p-7 sm:p-8">
                        <p class="technical-label text-brand-700">Direct contact</p>
                        <div class="mt-6 grid gap-5">
                            @if ($site['contact_email'])
                                <a href="mailto:{{ $site['contact_email'] }}" class="group flex items-start gap-4">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700 transition group-hover:bg-brand-100">
                                        <x-icon name="envelope" class="size-4" />
                                    </span>
                                    <span class="min-w-0">
                                        <span class="technical-label block text-slate-400">Email</span>
                                        <span class="mt-1 block break-all text-sm font-bold text-navy-950">{{ $site['contact_email'] }}</span>
                                    </span>
                                </a>
                            @endif
                            @if ($site['contact_phone'])
                                <a href="tel:{{ preg_replace('/[^+\d]/', '', $site['contact_phone']) }}" class="group flex items-start gap-4">
                                    <span class="flex size-10 shrink-0 items-center justify-center rounded-full bg-brand-50 text-brand-700 transition group-hover:bg-brand-100">
                                        <x-icon name="phone" class="size-4" />
                                    </span>
                                    <span>
                                        <span class="technical-label block text-slate-400">Phone</span>
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
                                        <span class="technical-label block text-slate-400">Location</span>
                                        <span class="mt-1 block text-sm font-bold text-navy-950">{{ $site['address'] }}</span>
                                    </span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="mt-5 rounded-[2rem] bg-navy-950 p-7 text-white sm:p-8">
                    <p class="technical-label text-brand-200">What happens next</p>
                    <ol class="mt-6 grid gap-5">
                        @foreach ([
                            ['01', 'We review the context you share.'],
                            ['02', 'We clarify the essentials and dependencies.'],
                            ['03', 'We recommend a practical next step.'],
                        ] as [$number, $step])
                            <li class="grid grid-cols-[auto_1fr] gap-4 border-t border-white/10 pt-4">
                                <span class="font-mono text-xs font-semibold text-signal-300">{{ $number }}</span>
                                <span class="text-sm leading-6 text-slate-300">{{ $step }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
            </aside>

            <div class="rounded-[2rem] bg-white p-6 shadow-[0_28px_80px_-48px_rgba(5,26,53,0.45)] ring-1 ring-slate-200 sm:p-9 lg:p-11"
                data-reveal>
                @if (session('contact_success'))
                    <div class="mb-8 flex gap-3 rounded-2xl bg-emerald-50 p-5 text-emerald-800 ring-1 ring-emerald-200" role="status">
                        <x-icon name="check" class="mt-0.5 size-5" />
                        <p class="text-sm leading-6">{{ session('contact_success') }}</p>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-8 rounded-2xl bg-red-50 p-5 text-red-800 ring-1 ring-red-200" role="alert">
                        <p class="font-display text-sm font-bold">Please review the highlighted fields.</p>
                        <p class="mt-1 text-xs leading-5">Your information is still here; correct the details below and send again.</p>
                    </div>
                @endif

                <div class="border-b border-slate-200 pb-7">
                    <p class="technical-label text-brand-700">Project enquiry</p>
                    <h2 class="mt-3 font-display text-3xl font-bold tracking-[-0.04em] text-navy-950 sm:text-4xl">How can we help?</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-600">Required fields are marked with an asterisk.</p>
                </div>

                <form method="POST" action="{{ route('contact.store') }}" class="mt-8 grid gap-5 sm:grid-cols-2" data-contact-form>
                    @csrf

                    <div>
                        <x-form.label for="name">Name <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <x-form.input id="name" name="name" :value="old('name')" required autocomplete="name"
                            placeholder="Your name" class="site-input mt-1.5"
                            aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                            aria-describedby="name-error" />
                        <x-form.error field="name" />
                    </div>
                    <div>
                        <x-form.label for="email">Work email <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <x-form.input id="email" name="email" type="email" :value="old('email')" required autocomplete="email"
                            placeholder="name@company.com" class="site-input mt-1.5"
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                            aria-describedby="email-error" />
                        <x-form.error field="email" />
                    </div>
                    <div>
                        <x-form.label for="phone">Phone</x-form.label>
                        <x-form.input id="phone" name="phone" type="tel" :value="old('phone')" autocomplete="tel"
                            placeholder="+20 ..." class="site-input mt-1.5"
                            aria-invalid="{{ $errors->has('phone') ? 'true' : 'false' }}"
                            aria-describedby="phone-error" />
                        <x-form.error field="phone" />
                    </div>
                    <div>
                        <x-form.label for="company">Company</x-form.label>
                        <x-form.input id="company" name="company" :value="old('company')" autocomplete="organization"
                            placeholder="Company name" class="site-input mt-1.5"
                            aria-invalid="{{ $errors->has('company') ? 'true' : 'false' }}"
                            aria-describedby="company-error" />
                        <x-form.error field="company" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-form.label for="service_id">Service</x-form.label>
                        <x-form.select id="service_id" name="service_id" class="site-input mt-1.5"
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
                    <div class="sm:col-span-2">
                        <x-form.label for="subject">Subject <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <x-form.input id="subject" name="subject" :value="old('subject')" required
                            placeholder="What needs attention?" class="site-input mt-1.5"
                            aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                            aria-describedby="subject-error" />
                        <x-form.error field="subject" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-form.label for="message">What do you need? <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
                        <x-form.textarea id="message" name="message" rows="6" required
                            placeholder="Share the current situation, impact, timing, or outcome you have in mind."
                            class="site-input mt-1.5"
                            aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}"
                            aria-describedby="message-error">{{ old('message') }}</x-form.textarea>
                        <x-form.error field="message" />
                    </div>

                    <div class="absolute -left-[9999px]" aria-hidden="true">
                        <label for="website">Website</label>
                        <input id="website" name="website" type="text" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="flex flex-col gap-5 border-t border-slate-200 pt-6 sm:col-span-2 sm:flex-row sm:items-center sm:justify-between">
                        <p class="max-w-md text-xs leading-5 text-slate-500">We use your details only to review and respond to this enquiry.</p>
                        <button type="submit" class="button-dark w-full shrink-0 disabled:pointer-events-none sm:w-auto"
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
