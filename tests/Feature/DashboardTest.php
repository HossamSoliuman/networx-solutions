<?php

use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\User;

it('renders the dashboard with message stats', function () {
    $user = User::factory()->create();
    $service = Service::factory()->create();
    $message = ContactMessage::factory()->for($service)->create();
    ContactMessage::factory()->replied()->count(2)->create();

    $this->actingAs($user)
        ->get(route('admin.dashboard'))
        ->assertSuccessful()
        ->assertSee('Dashboard')
        ->assertSee($message->name);
});

it('renders the dashboard when there is no data yet', function () {
    $this->actingAs(User::factory()->create())
        ->get(route('admin.dashboard'))
        ->assertSuccessful();
});
