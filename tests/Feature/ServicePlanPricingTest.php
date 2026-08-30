<?php

use App\Enums\BillingPeriod;
use App\Models\Service;
use App\Models\ServicePlan;

it('shows the pricing section with active plans on the service page', function () {
    $service = Service::factory()->create([
        'pricing_enabled' => true,
        'pricing_title' => 'IT Support Plans',
    ]);

    $plan = ServicePlan::factory()->for($service)->create([
        'name' => 'Essential Care',
        'price_monthly' => 1999,
        'capacity' => 'Up to 20 Devices',
        'features' => "Network Troubleshooting\nMonthly IT Report",
    ]);

    $this->get(route('services.show', $service))
        ->assertSuccessful()
        ->assertSee('IT Support Plans')
        ->assertSee($plan->name)
        ->assertSee('1,999')
        ->assertSee('Up to 20 Devices')
        ->assertSee('Network Troubleshooting');
});

it('hides inactive plans and the section when pricing is switched off', function () {
    $service = Service::factory()->create(['pricing_enabled' => true]);

    ServicePlan::factory()->for($service)->create(['name' => 'Visible Plan']);
    ServicePlan::factory()->for($service)->inactive()->create(['name' => 'Hidden Plan']);

    $this->get(route('services.show', $service))
        ->assertSee('Visible Plan')
        ->assertDontSee('Hidden Plan');

    $service->update(['pricing_enabled' => false]);

    $this->get(route('services.show', $service))
        ->assertDontSee('Visible Plan');
});

it('renders the plan in Arabic when the visitor picked Arabic', function () {
    $service = Service::factory()->create(['pricing_enabled' => true]);

    ServicePlan::factory()->for($service)->create([
        'name' => 'Essential Care',
        'name_ar' => 'الباقة الأساسية',
        'features' => 'Monthly IT Report',
        'features_ar' => 'تقرير شهري',
    ]);

    $this->withSession(['locale' => 'ar'])
        ->get(route('services.show', $service))
        ->assertSee('الباقة الأساسية', false)
        ->assertSee('تقرير شهري', false);
});

it('formats prices without trailing zeros and calculates the yearly saving', function () {
    $plan = ServicePlan::factory()->make([
        'price_monthly' => 1000,
        'price_yearly' => 10200,
    ]);

    expect($plan->formattedPriceFor(BillingPeriod::Monthly))->toBe('1,000')
        ->and($plan->formattedPriceFor(BillingPeriod::Yearly))->toBe('10,200')
        ->and($plan->yearlySavingsPercent())->toBe(15);
});

it('hides the price on a custom quoted plan', function () {
    $plan = ServicePlan::factory()->customPrice()->make();

    expect($plan->priceFor(BillingPeriod::Monthly))->toBeNull()
        ->and($plan->hasYearlyPrice())->toBeFalse()
        ->and($plan->yearlySavingsPercent())->toBeNull();
});
