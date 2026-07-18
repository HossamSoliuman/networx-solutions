<?php

use App\Enums\ContactActivityType;
use App\Enums\ContactMessagePriority;
use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('changes the status and stamps closed_at when closing', function () {
    $message = ContactMessage::factory()->read()->create();

    $this->actingAs($this->user)
        ->patch(route('admin.messages.status', $message), ['status' => 'closed'])
        ->assertRedirect()
        ->assertSessionHas('success');

    $message->refresh();

    expect($message->status)->toBe(ContactMessageStatus::Closed)
        ->and($message->closed_at)->not->toBeNull();

    $activity = $message->activities()->where('type', ContactActivityType::StatusChanged)->first();

    expect($activity->meta)->toBe(['from' => 'new', 'to' => 'closed']);
});

it('rejects an unknown status', function () {
    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)
        ->patch(route('admin.messages.status', $message), ['status' => 'bogus'])
        ->assertSessionHasErrors('status');
});

it('changes the priority and records the transition', function () {
    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)
        ->patch(route('admin.messages.priority', $message), ['priority' => 'urgent'])
        ->assertRedirect();

    expect($message->refresh()->priority)->toBe(ContactMessagePriority::Urgent);

    $activity = $message->activities()->where('type', ContactActivityType::PriorityChanged)->first();

    expect($activity->meta)->toBe(['from' => 'normal', 'to' => 'urgent']);
});

it('toggles the star flag', function () {
    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)->patch(route('admin.messages.star', $message));
    expect($message->refresh()->is_starred)->toBeTrue();

    $this->actingAs($this->user)->patch(route('admin.messages.star', $message));
    expect($message->refresh()->is_starred)->toBeFalse();
});

it('assigns and unassigns a team member', function () {
    $assignee = User::factory()->create();
    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)
        ->patch(route('admin.messages.assign', $message), ['assigned_to_id' => $assignee->id])
        ->assertRedirect();

    expect($message->refresh()->assigned_to_id)->toBe($assignee->id);

    $this->actingAs($this->user)
        ->patch(route('admin.messages.assign', $message), ['assigned_to_id' => null])
        ->assertRedirect();

    expect($message->refresh()->assigned_to_id)->toBeNull();
});

it('archives and restores a message', function () {
    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)->patch(route('admin.messages.archive', $message));
    expect($message->refresh()->isArchived())->toBeTrue();

    $this->actingAs($this->user)->patch(route('admin.messages.archive', $message));
    expect($message->refresh()->isArchived())->toBeFalse();

    expect($message->activities()->where('type', ContactActivityType::Archived)->count())->toBe(1)
        ->and($message->activities()->where('type', ContactActivityType::Restored)->count())->toBe(1);
});
