<?php

use App\Enums\PlanRequestStatus;
use App\Models\PlanRequest;
use App\Models\Service;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('lists plan requests in their own tab', function () {
    $planRequest = PlanRequest::factory()->create(['name' => 'Ahmed Mostafa']);

    $this->actingAs($this->user)
        ->get(route('admin.plan-requests.index'))
        ->assertSuccessful()
        ->assertSee('Plan requests')
        ->assertSee($planRequest->name)
        ->assertSee($planRequest->plan_name);
});

it('filters plan requests by status and search term', function () {
    PlanRequest::factory()->create(['name' => 'Ahmed Mostafa']);
    PlanRequest::factory()->contacted()->create(['name' => 'Sara Fouad']);

    $this->actingAs($this->user)
        ->get(route('admin.plan-requests.index', ['status' => PlanRequestStatus::Contacted->value]))
        ->assertSee('Sara Fouad')
        ->assertDontSee('Ahmed Mostafa');

    $this->actingAs($this->user)
        ->get(route('admin.plan-requests.index', ['q' => 'Ahmed']))
        ->assertSee('Ahmed Mostafa')
        ->assertDontSee('Sara Fouad');
});

it('filters plan requests by service', function () {
    $service = Service::factory()->create();
    PlanRequest::factory()->for($service)->create(['name' => 'Ahmed Mostafa']);
    PlanRequest::factory()->create(['name' => 'Sara Fouad']);

    $this->actingAs($this->user)
        ->get(route('admin.plan-requests.index', ['service_id' => $service->id]))
        ->assertSee('Ahmed Mostafa')
        ->assertDontSee('Sara Fouad');
});

it('marks a plan request as read when it is opened', function () {
    $planRequest = PlanRequest::factory()->create();

    expect($planRequest->isUnread())->toBeTrue();

    $this->actingAs($this->user)
        ->get(route('admin.plan-requests.show', $planRequest))
        ->assertSuccessful()
        ->assertSee($planRequest->reference);

    expect($planRequest->refresh()->isUnread())->toBeFalse();
});

it('moves a plan request through the follow-up statuses', function () {
    $planRequest = PlanRequest::factory()->create();

    $this->actingAs($this->user)
        ->patch(route('admin.plan-requests.status', $planRequest), ['status' => PlanRequestStatus::Contacted->value])
        ->assertRedirect();

    $planRequest->refresh();

    expect($planRequest->status)->toBe(PlanRequestStatus::Contacted)
        ->and($planRequest->contacted_at)->not->toBeNull();
});

it('rejects an unknown status', function () {
    $planRequest = PlanRequest::factory()->create();

    $this->actingAs($this->user)
        ->patch(route('admin.plan-requests.status', $planRequest), ['status' => 'archived'])
        ->assertSessionHasErrors('status');
});

it('saves an internal note', function () {
    $planRequest = PlanRequest::factory()->create();

    $this->actingAs($this->user)
        ->put(route('admin.plan-requests.update', $planRequest), ['admin_note' => 'Called back, wants 20 devices.'])
        ->assertRedirect();

    expect($planRequest->refresh()->admin_note)->toBe('Called back, wants 20 devices.');
});

it('deletes a plan request', function () {
    $planRequest = PlanRequest::factory()->create();

    $this->actingAs($this->user)
        ->delete(route('admin.plan-requests.destroy', $planRequest))
        ->assertRedirect(route('admin.plan-requests.index'));

    $this->assertDatabaseMissing('plan_requests', ['id' => $planRequest->id]);
});

it('shows the unread plan request count in the sidebar', function () {
    PlanRequest::factory()->count(3)->create();
    PlanRequest::factory()->read()->create();

    $this->actingAs($this->user)
        ->get(route('admin.dashboard'))
        ->assertSee('Plan requests')
        ->assertSee('>3<', false);
});

it('requires authentication', function () {
    $planRequest = PlanRequest::factory()->create();

    $this->get(route('admin.plan-requests.index'))->assertRedirect(route('admin.login'));
    $this->get(route('admin.plan-requests.show', $planRequest))->assertRedirect(route('admin.login'));
});
