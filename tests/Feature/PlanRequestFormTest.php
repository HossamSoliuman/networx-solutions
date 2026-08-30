<?php

use App\Enums\BillingPeriod;
use App\Enums\PlanRequestStatus;
use App\Mail\NewPlanRequestMail;
use App\Models\PlanRequest;
use App\Models\Service;
use App\Models\ServicePlan;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

/**
 * @return array<string, mixed>
 */
function validPlanRequestPayload(ServicePlan $plan, array $overrides = []): array
{
    return [
        'service_plan_id' => $plan->id,
        'billing_period' => BillingPeriod::Monthly->value,
        'name' => 'Ahmed Mostafa',
        'phone' => '+20 10 6640 5570',
        ...$overrides,
    ];
}

it('stores a plan request with a snapshot of the chosen plan', function () {
    Mail::fake();

    $service = Service::factory()->create(['name' => 'IT Support']);
    $plan = ServicePlan::factory()->for($service)->create([
        'name' => 'Essential Care',
        'price_monthly' => 1999,
        'price_yearly' => 20390,
        'currency' => 'EGP',
    ]);

    $this->from(route('services.show', $service))
        ->post(route('plan-requests.store'), validPlanRequestPayload($plan))
        ->assertRedirect(route('services.show', $service))
        ->assertSessionHas('plan_request_success');

    $planRequest = PlanRequest::query()->sole();

    expect($planRequest->service_id)->toBe($service->id)
        ->and($planRequest->service_plan_id)->toBe($plan->id)
        ->and($planRequest->service_name)->toBe('IT Support')
        ->and($planRequest->plan_name)->toBe('Essential Care')
        ->and($planRequest->billing_period)->toBe(BillingPeriod::Monthly)
        ->and((float) $planRequest->plan_price)->toBe(1999.0)
        ->and($planRequest->currency)->toBe('EGP')
        ->and($planRequest->phone)->toBe('+20 10 6640 5570')
        ->and($planRequest->reference)->toStartWith('NXP-');
});

it('stores the yearly price when the yearly period is chosen', function () {
    Mail::fake();

    $plan = ServicePlan::factory()->create(['price_monthly' => 1999, 'price_yearly' => 20390]);

    $this->post(route('plan-requests.store'), validPlanRequestPayload($plan, [
        'billing_period' => BillingPeriod::Yearly->value,
    ]))->assertSessionHasNoErrors();

    expect((float) PlanRequest::query()->sole()->plan_price)->toBe(20390.0);
});

it('accepts an email address without a phone number', function () {
    Mail::fake();

    $plan = ServicePlan::factory()->create();

    $this->post(route('plan-requests.store'), [
        'service_plan_id' => $plan->id,
        'billing_period' => BillingPeriod::Monthly->value,
        'email' => 'ahmed@company.com',
    ])->assertSessionHasNoErrors();

    $planRequest = PlanRequest::query()->sole();

    expect($planRequest->email)->toBe('ahmed@company.com')
        ->and($planRequest->phone)->toBeNull();
});

it('requires a phone number or an email address', function () {
    $plan = ServicePlan::factory()->create();

    $this->post(route('plan-requests.store'), [
        'service_plan_id' => $plan->id,
        'billing_period' => BillingPeriod::Monthly->value,
        'name' => 'Ahmed Mostafa',
    ])->assertSessionHasErrors(['phone', 'email'], null, 'planRequest');

    expect(PlanRequest::query()->count())->toBe(0);
});

it('rejects a submission that fills the honeypot', function () {
    $plan = ServicePlan::factory()->create();

    $this->post(route('plan-requests.store'), validPlanRequestPayload($plan, [
        'company_fax' => 'spam',
    ]))->assertSessionHasErrors('company_fax', null, 'planRequest');

    expect(PlanRequest::query()->count())->toBe(0);
});

it('notifies the configured address about a new plan request', function () {
    Mail::fake();

    Setting::set('notification_email', 'sales@networx-solutions.com');

    $plan = ServicePlan::factory()->create();

    $this->post(route('plan-requests.store'), validPlanRequestPayload($plan));

    Mail::assertSent(NewPlanRequestMail::class, function (NewPlanRequestMail $mail) {
        return $mail->hasTo('sales@networx-solutions.com');
    });
});

it('still confirms the request when the mail server is unreachable', function () {
    Setting::set('notification_email', 'sales@networx-solutions.com');

    Mail::shouldReceive('to')->andThrow(new RuntimeException('Connection could not be established.'));

    $plan = ServicePlan::factory()->create();

    $this->post(route('plan-requests.store'), validPlanRequestPayload($plan))
        ->assertSessionHas('plan_request_success');

    expect(PlanRequest::query()->count())->toBe(1);
});

it('confirms the plan that was actually requested', function () {
    Mail::fake();

    $service = Service::factory()->create(['pricing_enabled' => true]);
    ServicePlan::factory()->for($service)->create(['name' => 'Micro Care', 'sort_order' => 0]);
    $chosenPlan = ServicePlan::factory()->for($service)->create(['name' => 'Business Care', 'sort_order' => 3]);

    $this->followingRedirects()
        ->from(route('services.show', $service))
        ->post(route('plan-requests.store'), validPlanRequestPayload($chosenPlan))
        ->assertSee('Get started with Business Care')
        ->assertDontSee('Get started with Micro Care');
});

it('records the request as new and unread', function () {
    Mail::fake();

    $plan = ServicePlan::factory()->create();

    $this->post(route('plan-requests.store'), validPlanRequestPayload($plan));

    $planRequest = PlanRequest::query()->sole();

    expect($planRequest->status)->toBe(PlanRequestStatus::New)
        ->and($planRequest->isUnread())->toBeTrue();
});
