@props(['services'])

@php
    $hiddenErrorFields = config('services.recaptcha.version', 'v2') === 'v2'
        ? ['company_fax']
        : ['company_fax', 'g-recaptcha-response'];
@endphp

<dialog id="contact-modal" data-contact-modal @if ($errors->any()) data-open-on-load @endif
    aria-labelledby="contact-modal-title"
    class="m-auto max-h-[calc(100dvh-2rem)] w-[calc(100%-2rem)] max-w-4xl overflow-y-auto rounded-[1.75rem] bg-white p-0 text-slate-900 shadow-[0_32px_90px_-28px_rgba(5,26,53,0.7)] backdrop:bg-navy-950/75 backdrop:backdrop-blur-sm">
    <div class="relative overflow-hidden border-b border-slate-200 bg-navy-950 px-5 py-5 text-white sm:px-7">
        <img src="{{ asset('images/site/networx-logo-badge.jpeg') }}" alt="" aria-hidden="true"
            class="absolute -right-10 top-1/2 size-52 -translate-y-1/2 object-contain opacity-20 mix-blend-multiply">
        <div class="relative flex items-start justify-between gap-5">
            <div>
                <p class="technical-label text-brand-200">Start a conversation</p>
                <h2 id="contact-modal-title" class="mt-1.5 font-display text-2xl font-bold tracking-[-0.035em] sm:text-3xl">How can we help?</h2>
            </div>
            <button type="button" data-modal-close
                class="flex size-10 shrink-0 items-center justify-center rounded-full border border-white/20 text-white transition hover:border-white/40 hover:bg-white/10"
                aria-label="Close contact form">
                <x-icon name="x" class="size-4" />
            </button>
        </div>
    </div>

    <form method="POST" action="{{ route('contact.store') }}" class="grid gap-x-4 gap-y-3 p-5 sm:grid-cols-2 sm:p-7 lg:grid-cols-3"
        data-contact-form
        @if (config('services.recaptcha.enabled') && config('services.recaptcha.version', 'v2') === 'v3' && config('services.recaptcha.site_key'))
            data-recaptcha-site-key="{{ config('services.recaptcha.site_key') }}"
            data-recaptcha-action="{{ config('services.recaptcha.action') }}"
        @endif
        aria-labelledby="contact-modal-title">
        @csrf

        @if ($errors->any())
            <div class="rounded-xl bg-red-50 p-3 text-red-800 ring-1 ring-red-200 sm:col-span-2 lg:col-span-3" role="alert">
                @if ($errors->keys() !== [] && collect($errors->keys())->diff($hiddenErrorFields)->isEmpty())
                    <p class="font-display text-sm font-bold">We couldn&#039;t send that enquiry.</p>
                    <p class="mt-0.5 text-xs leading-5">Please wait a moment and try again.</p>
                @else
                    <p class="font-display text-sm font-bold">Check the fields outlined in red.</p>
                    <p class="mt-0.5 text-xs leading-5">Each highlighted field includes a note explaining what needs to change.</p>
                @endif
            </div>
        @endif

        <div class="min-w-0">
            <x-form.label for="modal_name">Name <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
            <x-form.input id="modal_name" name="name" :value="old('name')" required autocomplete="name"
                placeholder="Your name" class="mt-1 h-10 bg-white"
                aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                aria-describedby="name-error" />
            <x-form.error field="name" />
        </div>

        <div class="min-w-0">
            <x-form.label for="modal_email">Work email <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
            <x-form.input id="modal_email" name="email" type="email" :value="old('email')" required autocomplete="email"
                placeholder="name@company.com" class="mt-1 h-10 bg-white"
                aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                aria-describedby="email-error" />
            <x-form.error field="email" />
        </div>

        <div class="min-w-0">
            <x-form.label for="modal_company">Company</x-form.label>
            <x-form.input id="modal_company" name="company" :value="old('company')" autocomplete="organization"
                placeholder="Company name" class="mt-1 h-10 bg-white"
                aria-invalid="{{ $errors->has('company') ? 'true' : 'false' }}"
                aria-describedby="company-error" />
            <x-form.error field="company" />
        </div>

        <div class="min-w-0">
            <x-form.label for="modal_phone_local">Phone <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
            <input type="hidden" name="phone_country" value="{{ old('phone_country', '+20') }}">
            <x-form.input id="modal_phone_local" name="phone_local" type="tel" :value="old('phone_local')" required autocomplete="tel-national" inputmode="tel"
                placeholder="10 664 055 70" class="mt-1 h-10 bg-white"
                aria-invalid="{{ $errors->has('phone_local') ? 'true' : 'false' }}"
                aria-describedby="phone_local-error" />
            <x-form.error field="phone_country" />
            <x-form.error field="phone_local" />
        </div>

        <div class="min-w-0">
            <x-form.label for="modal_service_id">Service</x-form.label>
            <x-form.select id="modal_service_id" name="service_id" class="mt-1 h-10 bg-white py-1.5" data-contact-service-select
                aria-invalid="{{ $errors->has('service_id') ? 'true' : 'false' }}"
                aria-describedby="service_id-error">
                <option value="">Choose a service (optional)</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}" @selected((string) old('service_id') === (string) $service->id)>{{ $service->name }}</option>
                @endforeach
            </x-form.select>
            <x-form.error field="service_id" />
        </div>

        <div class="min-w-0">
            <x-form.label for="modal_subject">Subject <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
            <x-form.input id="modal_subject" name="subject" :value="old('subject')" required
                placeholder="What needs attention?" class="mt-1 h-10 bg-white"
                aria-invalid="{{ $errors->has('subject') ? 'true' : 'false' }}"
                aria-describedby="subject-error" />
            <x-form.error field="subject" />
        </div>

        <div class="min-w-0 sm:col-span-2 lg:col-span-3">
            <x-form.label for="modal_message">What do you need? <span class="text-brand-700" aria-hidden="true">*</span></x-form.label>
            <x-form.textarea id="modal_message" name="message" rows="6" required
                placeholder="Share the current situation, impact, timing, or outcome you have in mind."
                class="mt-1 min-h-40 resize-none bg-white"
                aria-invalid="{{ $errors->has('message') ? 'true' : 'false' }}"
                aria-describedby="message-error">{{ old('message') }}</x-form.textarea>
            <x-form.error field="message" />
        </div>

        <div class="absolute -left-[9999px]" aria-hidden="true">
            <label for="modal_company_fax">Fax</label>
            <input id="modal_company_fax" name="company_fax" type="text" tabindex="-1" autocomplete="off" readonly
                data-1p-ignore data-bwignore="true" data-lpignore="true">
        </div>

        <x-form.recaptcha class="min-w-0 sm:col-span-2 lg:col-span-3" />

        <div class="flex flex-col gap-3 border-t border-slate-200 pt-4 sm:col-span-2 sm:flex-row sm:items-center sm:justify-between lg:col-span-3">
            <p class="max-w-sm text-xs leading-5 text-slate-500">We use your details only to review and respond to this enquiry.</p>
            <button type="submit" class="button-dark min-h-10 w-full shrink-0 px-5 py-2 disabled:pointer-events-none sm:w-auto"
                data-contact-submit>
                <span data-contact-submit-label>Send enquiry</span>
                <x-icon name="send" class="size-4" />
            </button>
        </div>
    </form>
</dialog>
