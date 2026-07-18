<?php

use App\Enums\ContactActivityType;
use App\Models\ContactMessage;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('shows a message and marks it as read on first view', function () {
    $message = ContactMessage::factory()->create();

    expect($message->read_at)->toBeNull();

    $this->actingAs($this->user)
        ->get(route('admin.messages.show', $message))
        ->assertSuccessful()
        ->assertSee($message->subject)
        ->assertSee($message->fresh()->reference);

    $message->refresh();

    expect($message->read_at)->not->toBeNull()
        ->and($message->activities()->where('type', ContactActivityType::Viewed)->count())->toBe(1);
});

it('does not record a second viewed activity on repeat visits', function () {
    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)->get(route('admin.messages.show', $message));
    $this->actingAs($this->user)->get(route('admin.messages.show', $message));

    expect($message->activities()->where('type', ContactActivityType::Viewed)->count())->toBe(1);
});

it('shows previous messages from the same sender', function () {
    $message = ContactMessage::factory()->create(['email' => 'repeat@client.com']);
    $earlier = ContactMessage::factory()->replied()->create([
        'email' => 'repeat@client.com',
        'subject' => 'An earlier enquiry from the same person',
    ]);

    $this->actingAs($this->user)
        ->get(route('admin.messages.show', $message))
        ->assertSuccessful()
        ->assertSee($earlier->subject);
});

it('deletes a message permanently', function () {
    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)
        ->delete(route('admin.messages.destroy', $message))
        ->assertRedirect(route('admin.messages.index'));

    $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
});
