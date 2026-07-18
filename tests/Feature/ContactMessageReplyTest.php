<?php

use App\Enums\ContactActivityType;
use App\Enums\ContactMessageStatus;
use App\Mail\ContactReplyMail;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('sends a reply email and tracks the full state change', function () {
    Mail::fake();

    $message = ContactMessage::factory()->read()->create();

    $this->actingAs($this->user)
        ->post(route('admin.messages.reply', $message), [
            'subject' => "Re: {$message->subject}",
            'body' => 'Thanks for reaching out — an engineer will call you tomorrow morning.',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    Mail::assertQueued(ContactReplyMail::class, fn (ContactReplyMail $mail) => $mail->hasTo($message->email));

    $message->refresh();

    expect($message->status)->toBe(ContactMessageStatus::Replied)
        ->and($message->replied_at)->not->toBeNull()
        ->and($message->replies)->toHaveCount(1)
        ->and($message->replies->first()->user_id)->toBe($this->user->id)
        ->and($message->activities()->where('type', ContactActivityType::Replied)->count())->toBe(1)
        ->and($message->activities()->where('type', ContactActivityType::StatusChanged)->count())->toBe(1);
});

it('allows only a single reply per message', function () {
    Mail::fake();

    $message = ContactMessage::factory()->read()->create();

    $this->actingAs($this->user)->post(route('admin.messages.reply', $message), [
        'subject' => "Re: {$message->subject}",
        'body' => 'The first and only reply.',
    ]);

    $this->actingAs($this->user)
        ->post(route('admin.messages.reply', $message), [
            'subject' => 'Re: a second attempt',
            'body' => 'Trying to reply a second time.',
        ])
        ->assertRedirect()
        ->assertSessionHas('error');

    expect($message->refresh()->replies)->toHaveCount(1);
    Mail::assertQueued(ContactReplyMail::class, 1);
});

it('validates the reply form', function (array $payload, string $field) {
    Mail::fake();

    $message = ContactMessage::factory()->create();

    $this->actingAs($this->user)
        ->post(route('admin.messages.reply', $message), $payload)
        ->assertSessionHasErrors($field);

    Mail::assertNothingQueued();
})->with([
    'missing subject' => [['body' => 'A body without a subject.'], 'subject'],
    'missing body' => [['subject' => 'A subject without a body'], 'body'],
]);
