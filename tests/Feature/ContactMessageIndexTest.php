<?php

use App\Models\ContactMessage;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('lists inbox messages and hides archived ones', function () {
    $inbox = ContactMessage::factory()->create(['subject' => 'Server room network drop']);
    $archived = ContactMessage::factory()->archived()->create(['subject' => 'Old decommissioned request']);

    $this->actingAs($this->user)
        ->get(route('admin.messages.index'))
        ->assertSuccessful()
        ->assertSee($inbox->subject)
        ->assertDontSee($archived->subject);
});

it('shows archived messages in the archived view', function () {
    $archived = ContactMessage::factory()->archived()->create(['subject' => 'Old decommissioned request']);

    $this->actingAs($this->user)
        ->get(route('admin.messages.index', ['view' => 'archived']))
        ->assertSuccessful()
        ->assertSee($archived->subject);
});

it('shows only starred messages in the starred view', function () {
    $starred = ContactMessage::factory()->starred()->create(['subject' => 'Starred firewall enquiry']);
    $plain = ContactMessage::factory()->create(['subject' => 'Plain unstarred enquiry']);

    $this->actingAs($this->user)
        ->get(route('admin.messages.index', ['view' => 'starred']))
        ->assertSuccessful()
        ->assertSee($starred->subject)
        ->assertDontSee($plain->subject);
});

it('filters messages by status', function () {
    $new = ContactMessage::factory()->create(['subject' => 'Brand new CCTV request']);
    $replied = ContactMessage::factory()->replied()->create(['subject' => 'Replied cloud migration']);

    $this->actingAs($this->user)
        ->get(route('admin.messages.index', ['status' => 'replied']))
        ->assertSuccessful()
        ->assertSee($replied->subject)
        ->assertDontSee($new->subject);
});

it('searches messages across sender fields and reference', function () {
    $match = ContactMessage::factory()->create(['name' => 'Zainab Alharbi', 'subject' => 'Office 365 tenant help']);
    $other = ContactMessage::factory()->create(['name' => 'Someone Else', 'subject' => 'Unrelated topic entirely']);

    $this->actingAs($this->user)
        ->get(route('admin.messages.index', ['q' => 'Zainab']))
        ->assertSuccessful()
        ->assertSee($match->subject)
        ->assertDontSee($other->subject);

    $this->actingAs($this->user)
        ->get(route('admin.messages.index', ['q' => $match->fresh()->reference]))
        ->assertSuccessful()
        ->assertSee($match->subject);
});

it('filters messages assigned to the current user', function () {
    $mine = ContactMessage::factory()->create([
        'assigned_to_id' => $this->user->id,
        'subject' => 'Assigned to me directly',
    ]);
    $unassigned = ContactMessage::factory()->create(['subject' => 'Nobody owns this one']);

    $this->actingAs($this->user)
        ->get(route('admin.messages.index', ['assigned' => 'me']))
        ->assertSuccessful()
        ->assertSee($mine->subject)
        ->assertDontSee($unassigned->subject);

    $this->actingAs($this->user)
        ->get(route('admin.messages.index', ['assigned' => 'unassigned']))
        ->assertSuccessful()
        ->assertSee($unassigned->subject)
        ->assertDontSee($mine->subject);
});
