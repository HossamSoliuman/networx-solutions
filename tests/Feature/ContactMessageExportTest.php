<?php

use App\Models\ContactMessage;
use App\Models\User;

it('streams the filtered inbox as a CSV download', function () {
    $user = User::factory()->create();
    $message = ContactMessage::factory()->create();
    $archived = ContactMessage::factory()->archived()->create(['email' => 'archived@example.com']);

    $response = $this->actingAs($user)
        ->get(route('admin.messages.export'))
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'text/csv; charset=utf-8');

    $csv = $response->streamedContent();

    expect($csv)->toContain('Reference')
        ->toContain($message->fresh()->reference)
        ->toContain($message->email)
        ->not->toContain($archived->email);
});

it('requires authentication to export', function () {
    $this->get(route('admin.messages.export'))->assertRedirect(route('admin.login'));
});
