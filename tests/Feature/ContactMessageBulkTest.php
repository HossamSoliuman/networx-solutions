<?php

use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('bulk marks messages as read without touching already-read timestamps', function () {
    $unread = ContactMessage::factory()->count(2)->create();
    $alreadyRead = ContactMessage::factory()->read()->create(['read_at' => now()->subWeek()]);

    $this->actingAs($this->user)
        ->post(route('admin.messages.bulk'), [
            'action' => 'mark_read',
            'ids' => [...$unread->pluck('id'), $alreadyRead->id],
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(ContactMessage::query()->unread()->count())->toBe(0)
        ->and($alreadyRead->refresh()->read_at->lessThan(now()->subDay()))->toBeTrue()
        ->and(ContactMessage::query()->where('status', ContactMessageStatus::New)->count())->toBe(0);
});

it('bulk mark unread moves read messages back to new but keeps richer statuses', function () {
    $read = ContactMessage::factory()->read()->create();
    $replied = ContactMessage::factory()->replied()->create();

    $this->actingAs($this->user)
        ->post(route('admin.messages.bulk'), [
            'action' => 'mark_unread',
            'ids' => [$read->id, $replied->id],
        ])
        ->assertRedirect();

    expect($read->refresh()->status)->toBe(ContactMessageStatus::New)
        ->and($read->read_at)->toBeNull()
        ->and($replied->refresh()->status)->toBe(ContactMessageStatus::Replied)
        ->and($replied->read_at)->toBeNull();
});

it('bulk archives and bulk closes messages', function () {
    $messages = ContactMessage::factory()->count(3)->create();

    $this->actingAs($this->user)->post(route('admin.messages.bulk'), [
        'action' => 'archive',
        'ids' => $messages->pluck('id')->all(),
    ]);

    expect(ContactMessage::query()->archived()->count())->toBe(3);

    $this->actingAs($this->user)->post(route('admin.messages.bulk'), [
        'action' => 'close',
        'ids' => $messages->pluck('id')->all(),
    ]);

    expect(ContactMessage::query()->where('status', ContactMessageStatus::Closed)->count())->toBe(3);
});

it('bulk deletes messages', function () {
    $messages = ContactMessage::factory()->count(2)->create();
    $kept = ContactMessage::factory()->create();

    $this->actingAs($this->user)->post(route('admin.messages.bulk'), [
        'action' => 'delete',
        'ids' => $messages->pluck('id')->all(),
    ]);

    expect(ContactMessage::query()->count())->toBe(1)
        ->and(ContactMessage::query()->first()->id)->toBe($kept->id);
});

it('rejects an unknown bulk action or empty selection', function () {
    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)
        ->post(route('admin.messages.bulk'), ['action' => 'explode', 'ids' => [$message->id]])
        ->assertSessionHasErrors('action');

    $this->actingAs($this->user)
        ->post(route('admin.messages.bulk'), ['action' => 'archive', 'ids' => []])
        ->assertSessionHasErrors('ids');
});
