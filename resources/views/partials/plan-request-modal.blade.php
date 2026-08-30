@php
    use App\Enums\BillingPeriod;

    /** @var \Illuminate\Support\Collection<int, \App\Models\ServicePlan> $plans */
    $planErrors = $errors->getBag('planRequest');
    $success = session('plan_request_success');
    $selectedPlan = $plans->firstWhere('id', (int) old('service_plan_id')) ?? $plans->first();

    // After a successful submission the redirect keeps no old input, so the
    // heading falls back to the plan name carried in the flash message.
    $headingPlan = $success['plan'] ?? $selectedPlan?->localizedName() ?? '';
@endphp

<dialog id="plan-request-modal" data-plan-modal
    data-plan-title-template="{{ __('public.pricing.request.title', ['plan' => ':plan']) }}"
    @if ($success || $planErrors->any()) data-open-on-load @endif
    aria-labelledby="plan-request-title"
    class="m-auto max-h-[calc(100dvh-2rem)] w-[calc(100%-2rem)] max-w-xl overflow-y-auto rounded-[1.5rem] bg-white p-0 text-slate-900 shadow-[0_32px_90px_-28px_rgba(5,26,53,0.7)] backdrop:bg-navy-950/70 backdrop:backdrop-blur-sm">
    <div class="relative overflow-hidden bg-navy-950 px-5 py-5 text-white sm:px-7">
        <img src="{{ asset('images/site/networx-logo-badge.jpeg') }}" alt="" aria-hidden="true"
            class="absolute -end-10 top-1/2 size-44 -translate-y-1/2 object-contain opacity-20 mix-blend-multiply">
        <div class="relative flex items-start justify-between gap-5">
            <div class="min-w-0">
                <p class="technical-label text-brand-200">{{ __('public.pricing.eyebrow') }}</p>
                <h2 id="plan-request-title" class="mt-1.5 font-display text-2xl font-bold tracking-[-0.035em]">
                    <bdi data-plan-request-title>
                        {{ __('public.pricing.request.title', ['plan' => $headingPlan]) }}
                    </bdi>
                </h2>
            </div>
            <button type="button" data-modal-close
                class="flex size-10 shrink-0 items-center justify-center rounded-full border border-white/20 text-white transition hover:border-white/40 hover:bg-white/10"
                aria-label="{{ __('public.pricing.request.close') }}">
                <x-icon name="x" class="size-4" />
            </button>
        </div>
    </div>

    @if ($success)
        <div class="p-6 text-center sm:p-8">
            <span class="mx-auto flex size-14 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                <x-icon name="check" class="size-7" />
            </span>
            <h3 class="mt-4 font-display text-xl font-bold text-navy-950">{{ __('public.pricing.request.success_title') }}</h3>
            <p dir="auto" class="mx-auto mt-2 max-w-md text-sm leading-6 text-slate-600">
                {{ __('public.pricing.request.success_copy', ['plan' => $success['plan'], 'reference' => $success['reference']]) }}
            </p>
            <button type="button" data-modal-close class="button-dark mt-6">
                {{ __('public.pricing.request.success_close') }}
            </button>
        </div>
    @else
        <form method="POST" action="{{ route('plan-requests.store') }}" class="grid gap-x-4 gap-y-3 p-5 sm:grid-cols-2 sm:p-7"
            data-plan-request-form aria-labelledby="plan-request-title">
            @csrf
            <input type="hidden" name="service_plan_id" value="{{ old('service_plan_id', $selectedPlan?->id) }}" data-plan-request-plan-id>
            <input type="hidden" name="billing_period" value="{{ old('billing_period', BillingPeriod::Monthly->value) }}" data-plan-request-billing-period>

            @if ($planErrors->any())
                <div class="rounded-xl bg-red-50 p-3 text-red-800 ring-1 ring-red-200 sm:col-span-2" role="alert">
                    <p class="font-display text-sm font-bold">{{ __('public.pricing.request.error_title') }}</p>
                    <p class="mt-0.5 text-xs leading-5">{{ $planErrors->first() }}</p>
                </div>
            @endif

            <div class="min-w-0 sm:col-span-2">
                <x-form.label for="plan_request_name">{{ __('public.pricing.request.name') }}</x-form.label>
                <x-form.input id="plan_request_name" name="name" :value="old('name')" autocomplete="name"
                    :placeholder="__('public.pricing.request.name_placeholder')" class="mt-1 h-10 bg-white"
                    aria-invalid="{{ $planErrors->has('name') ? 'true' : 'false' }}" />
                @if ($planErrors->has('name'))
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $planErrors->first('name') }}</p>
                @endif
            </div>

            <div class="min-w-0">
                <x-form.label for="plan_request_phone">{{ __('public.pricing.request.phone') }}</x-form.label>
                <x-form.input id="plan_request_phone" name="phone" type="tel" :value="old('phone')"
                    autocomplete="tel" inputmode="tel" :placeholder="__('public.pricing.request.phone_placeholder')"
                    dir="ltr" class="mt-1 h-10 bg-white text-left"
                    aria-invalid="{{ $planErrors->has('phone') ? 'true' : 'false' }}" />
                @if ($planErrors->has('phone'))
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $planErrors->first('phone') }}</p>
                @endif
            </div>

            <div class="min-w-0">
                <x-form.label for="plan_request_email">{{ __('public.pricing.request.email') }}</x-form.label>
                <x-form.input id="plan_request_email" name="email" type="email" :value="old('email')" autocomplete="email"
                    :placeholder="__('public.pricing.request.email_placeholder')" dir="ltr" class="mt-1 h-10 bg-white text-left"
                    aria-invalid="{{ $planErrors->has('email') ? 'true' : 'false' }}" />
                @if ($planErrors->has('email'))
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $planErrors->first('email') }}</p>
                @endif
            </div>

            <div class="min-w-0 sm:col-span-2">
                <x-form.label for="plan_request_note">{{ __('public.pricing.request.note') }}</x-form.label>
                <x-form.textarea id="plan_request_note" name="note" rows="3"
                    :placeholder="__('public.pricing.request.note_placeholder')" class="mt-1 resize-none bg-white"
                    aria-invalid="{{ $planErrors->has('note') ? 'true' : 'false' }}">{{ old('note') }}</x-form.textarea>
                @if ($planErrors->has('note'))
                    <p class="mt-1.5 text-xs font-medium text-red-600">{{ $planErrors->first('note') }}</p>
                @endif
            </div>

            <div class="absolute -start-[9999px]" aria-hidden="true">
                <label for="plan_request_company_fax">{{ __('public.contact.fax') }}</label>
                <input id="plan_request_company_fax" name="company_fax" type="text" tabindex="-1" autocomplete="off" readonly
                    data-1p-ignore data-bwignore="true" data-lpignore="true">
            </div>

            <div class="flex flex-col gap-3 border-t border-slate-200 pt-4 sm:col-span-2 sm:flex-row sm:items-center sm:justify-between">
                <p class="max-w-xs text-xs leading-5 text-slate-500">{{ __('public.pricing.request.privacy') }}</p>
                <button type="submit" class="button-dark min-h-10 w-full shrink-0 px-5 py-2 disabled:pointer-events-none sm:w-auto"
                    data-plan-request-submit>
                    <span data-plan-request-submit-label data-idle-label="{{ __('public.pricing.request.submit') }}"
                        data-busy-label="{{ __('public.pricing.request.submitting') }}">{{ __('public.pricing.request.submit') }}</span>
                    <x-icon name="phone" class="size-4" />
                </button>
            </div>
        </form>
    @endif
</dialog>
