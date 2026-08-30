@php
    use App\Enums\BillingPeriod;

    /** @var \App\Models\Service $service */
    $plans = $service->activePlans();
    $showBillingToggle = $plans->contains(fn ($plan) => $plan->hasYearlyPrice());
    $yearlyNote = $service->localizedPricingYearlyNote();
    $footnote = $service->localizedPricingFootnote();

    $gridColumns = match ($plans->count()) {
        1 => 'mx-auto max-w-md grid-cols-1',
        2 => 'mx-auto max-w-3xl sm:grid-cols-2',
        3 => 'sm:grid-cols-2 lg:grid-cols-3',
        4 => 'sm:grid-cols-2 xl:grid-cols-4',
        5 => 'sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-5',
        default => 'sm:grid-cols-2 lg:grid-cols-3 2xl:grid-cols-6',
    };
@endphp

<section id="service-pricing" data-pricing data-billing="monthly"
    class="relative overflow-hidden border-t border-blue-100 bg-canvas py-14 sm:py-18 lg:py-20">
    <div class="bg-reference-dots absolute start-0 top-0 h-72 w-72 opacity-50"></div>

    <div class="relative mx-auto max-w-[90rem] px-5 sm:px-8 lg:px-12">
        <div class="mx-auto max-w-3xl text-center" data-reveal>
            <p class="section-kicker justify-center">{{ $service->localizedPricingEyebrow() }}</p>
            <h2 dir="auto"
                class="mt-4 text-balance font-display text-4xl font-bold leading-[1.02] tracking-[-0.04em] text-navy-950 sm:text-5xl lg:text-[3.4rem]">
                {{ $service->localizedPricingTitle() }}
            </h2>
            <p dir="auto" class="mt-5 text-pretty text-lg leading-8 text-slate-600">
                {{ $service->localizedPricingSubtitle() }}
            </p>
        </div>

        @if ($showBillingToggle)
            <div class="mt-8 flex flex-col items-center gap-4 sm:flex-row sm:justify-center" data-reveal>
                <div class="inline-flex rounded-full bg-white p-1 shadow-[0_12px_35px_-25px_rgba(0,39,114,0.8)] ring-1 ring-blue-100"
                    role="group" aria-label="{{ __('public.pricing.billing_period') }}">
                    @foreach (BillingPeriod::cases() as $period)
                        <button type="button" class="plan-billing-option" data-billing-option="{{ $period->value }}"
                            aria-pressed="{{ $period === BillingPeriod::Monthly ? 'true' : 'false' }}">
                            {{ $period->publicLabel() }}
                        </button>
                    @endforeach
                </div>

                @if ($yearlyNote)
                    <p dir="auto" class="max-w-xs text-center text-sm font-semibold leading-5 text-slate-500 sm:text-start">
                        {{ $yearlyNote }}
                    </p>
                @endif
            </div>
        @endif

        <div class="mt-10 grid gap-4 {{ $gridColumns }}" data-reveal-group>
            @foreach ($plans as $plan)
                @php
                    $badge = $plan->localizedBadge();
                    $capacity = $plan->localizedCapacity();
                    $features = $plan->localizedFeatureList();
                    $monthlyPrice = $plan->formattedPriceFor(BillingPeriod::Monthly);
                    $yearlyPrice = $plan->formattedPriceFor(BillingPeriod::Yearly);
                    $savings = $plan->yearlySavingsPercent();
                @endphp

                <article data-reveal style="--plan-accent: {{ $plan->accent_color ?: '#0045B3' }}"
                    @class(['plan-card', 'plan-card-featured mt-4 sm:mt-0' => $plan->is_featured])>
                    @if ($badge)
                        <span class="plan-badge"><bdi>{{ $badge }}</bdi></span>
                    @endif

                    <div class="flex flex-col items-center pt-3 text-center">
                        <span class="plan-icon">
                            <x-icon :name="$plan->icon" class="size-6" />
                        </span>

                        <h3 dir="auto" class="mt-4 font-display text-base font-bold uppercase tracking-[0.08em] text-navy-950">
                            <bdi>{{ $plan->localizedName() }}</bdi>
                        </h3>

                        @foreach (BillingPeriod::cases() as $period)
                            @php
                                $amount = $period === BillingPeriod::Yearly ? ($yearlyPrice ?? $monthlyPrice) : $monthlyPrice;
                                $periodSuffix = $period === BillingPeriod::Yearly && $yearlyPrice === null
                                    ? BillingPeriod::Monthly->publicSuffix()
                                    : $period->publicSuffix();
                            @endphp

                            <div class="mt-3 w-full" data-plan-price="{{ $period->value }}" hidden>
                                @if ($amount === null)
                                    <p class="plan-price font-display text-3xl font-bold leading-none">
                                        <bdi>{{ $plan->localizedCustomPriceLabel() }}</bdi>
                                    </p>
                                @else
                                    <p class="flex items-baseline justify-center gap-1.5" dir="ltr">
                                        <span class="plan-price font-display text-4xl font-bold leading-none tracking-[-0.03em]">
                                            {{ $amount }}{{ $plan->price_suffix }}
                                        </span>
                                        <span class="text-xs font-bold uppercase tracking-wide text-slate-400">{{ $plan->currency }}</span>
                                    </p>
                                    <p class="mt-1.5 text-xs font-semibold text-slate-500">{{ $periodSuffix }}</p>
                                @endif

                                @if ($period === BillingPeriod::Yearly && $savings !== null)
                                    <span class="mt-1.5 inline-flex items-center rounded-full bg-emerald-50 px-2.5 py-0.5 text-[0.65rem] font-bold text-emerald-700">
                                        {{ __('public.pricing.save_percent', ['percent' => $savings]) }}
                                    </span>
                                @endif
                            </div>
                        @endforeach

                        @if ($capacity)
                            <p dir="auto" class="mt-4 w-full border-y border-blue-100 py-2.5 text-sm font-semibold text-slate-600">
                                <bdi>{{ $capacity }}</bdi>
                            </p>
                        @endif
                    </div>

                    @if ($features !== [])
                        <ul class="mt-4 grid gap-2">
                            @foreach ($features as $feature)
                                <li class="flex items-start gap-2 text-[0.8rem] leading-5 text-slate-600">
                                    <x-icon name="check" class="plan-check mt-0.5 size-3.5 shrink-0" />
                                    <span class="mixed-direction">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif

                    <button type="button" class="plan-cta mt-auto" data-modal-open="plan-request-modal" data-plan-cta
                        data-plan-id="{{ $plan->id }}" data-plan-name="{{ $plan->localizedName() }}">
                        <span>{{ $plan->localizedCtaLabel() }}</span>
                        <x-icon name="arrow-left" class="size-4 rotate-180 rtl:rotate-0" />
                    </button>
                </article>
            @endforeach
        </div>

        @if ($footnote)
            <p dir="auto" class="mt-8 text-center text-xs leading-5 text-slate-500">{{ $footnote }}</p>
        @endif
    </div>
</section>

@include('partials.plan-request-modal', ['plans' => $plans])
