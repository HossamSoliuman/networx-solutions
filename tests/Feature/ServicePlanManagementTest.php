<?php

use App\Models\Service;
use App\Models\ServicePlan;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
    $this->service = Service::factory()->create();
});

/**
 * @return array<string, mixed>
 */
function validPlanPayload(array $overrides = []): array
{
    return [
        'name' => 'Essential Care',
        'icon' => 'star',
        'accent_color' => '#0045B3',
        'capacity' => 'Up to 20 Devices',
        'price_monthly' => 1999,
        'price_yearly' => 20390,
        'currency' => 'EGP',
        'features' => "Network Troubleshooting\nMonthly IT Report",
        'sort_order' => 2,
        'is_active' => '1',
        ...$overrides,
    ];
}

it('lists the plans of a service', function () {
    $plan = ServicePlan::factory()->for($this->service)->create(['name' => 'Micro Care']);

    $this->actingAs($this->user)
        ->get(route('admin.services.plans.index', $this->service))
        ->assertSuccessful()
        ->assertSee($plan->name);
});

it('creates a plan for the service', function () {
    $this->actingAs($this->user)
        ->post(route('admin.services.plans.store', $this->service), validPlanPayload())
        ->assertRedirect(route('admin.services.plans.index', $this->service));

    $this->assertDatabaseHas('service_plans', [
        'service_id' => $this->service->id,
        'name' => 'Essential Care',
        'price_monthly' => 1999,
        'is_active' => true,
    ]);
});

it('creates a featured plan quoted individually', function () {
    $this->actingAs($this->user)
        ->post(route('admin.services.plans.store', $this->service), validPlanPayload([
            'name' => 'Enterprise Care',
            'price_monthly' => null,
            'price_yearly' => null,
            'is_custom_price' => '1',
            'custom_price_label' => 'Custom',
            'is_featured' => '1',
        ]))
        ->assertRedirect(route('admin.services.plans.index', $this->service));

    $plan = ServicePlan::query()->where('name', 'Enterprise Care')->sole();

    expect($plan->is_custom_price)->toBeTrue()
        ->and($plan->is_featured)->toBeTrue()
        ->and($plan->price_monthly)->toBeNull();
});

it('validates the plan fields', function () {
    $this->actingAs($this->user)
        ->post(route('admin.services.plans.store', $this->service), validPlanPayload([
            'name' => '',
            'accent_color' => 'blue',
            'price_monthly' => 'free',
        ]))
        ->assertSessionHasErrors(['name', 'accent_color', 'price_monthly']);
});

it('updates a plan', function () {
    $plan = ServicePlan::factory()->for($this->service)->create();

    $this->actingAs($this->user)
        ->put(route('admin.services.plans.update', [$this->service, $plan]), validPlanPayload([
            'name' => 'Renamed Plan',
            'is_active' => '0',
        ]))
        ->assertRedirect(route('admin.services.plans.index', $this->service));

    expect($plan->refresh()->name)->toBe('Renamed Plan')
        ->and($plan->is_active)->toBeFalse();
});

it('deactivates an active plan', function () {
    $plan = ServicePlan::factory()->for($this->service)->create(['is_active' => true]);

    $this->actingAs($this->user)
        ->from(route('admin.services.plans.index', $this->service))
        ->patch(route('admin.services.plans.status', [$this->service, $plan]))
        ->assertRedirect(route('admin.services.plans.index', $this->service));

    expect($plan->refresh()->is_active)->toBeFalse();
});

it('activates a hidden plan', function () {
    $plan = ServicePlan::factory()->for($this->service)->create(['is_active' => false]);

    $this->actingAs($this->user)
        ->from(route('admin.services.plans.index', $this->service))
        ->patch(route('admin.services.plans.status', [$this->service, $plan]))
        ->assertRedirect(route('admin.services.plans.index', $this->service));

    expect($plan->refresh()->is_active)->toBeTrue();
});

it('does not toggle a plan belonging to another service', function () {
    $otherPlan = ServicePlan::factory()->create(['is_active' => true]);

    $this->actingAs($this->user)
        ->patch(route('admin.services.plans.status', [$this->service, $otherPlan]))
        ->assertNotFound();

    expect($otherPlan->refresh()->is_active)->toBeTrue();
});

it('deletes a plan', function () {
    $plan = ServicePlan::factory()->for($this->service)->create();

    $this->actingAs($this->user)
        ->delete(route('admin.services.plans.destroy', [$this->service, $plan]))
        ->assertRedirect(route('admin.services.plans.index', $this->service));

    $this->assertDatabaseMissing('service_plans', ['id' => $plan->id]);
});

it('does not resolve a plan belonging to another service', function () {
    $otherPlan = ServicePlan::factory()->create();

    $this->actingAs($this->user)
        ->get(route('admin.services.plans.edit', [$this->service, $otherPlan]))
        ->assertNotFound();
});

it('requires authentication', function () {
    $this->get(route('admin.services.plans.index', $this->service))
        ->assertRedirect(route('admin.login'));
});

it('saves the pricing section text with the service', function () {
    $this->actingAs($this->user)
        ->put(route('admin.services.update', $this->service), [
            'name' => $this->service->name,
            'slug' => $this->service->slug,
            'icon' => 'headset',
            'excerpt' => 'Reliable support.',
            'sort_order' => 0,
            'is_active' => '1',
            'pricing_enabled' => '1',
            'pricing_title' => 'IT Support Plans',
            'pricing_title_ar' => 'خطط الدعم الفني',
            'pricing_yearly_note' => 'Save up to 15% with annual plans',
        ])
        ->assertRedirect(route('admin.services.index'));

    $service = $this->service->refresh();

    expect($service->pricing_enabled)->toBeTrue()
        ->and($service->pricing_title)->toBe('IT Support Plans')
        ->and($service->pricing_title_ar)->toBe('خطط الدعم الفني');
});
