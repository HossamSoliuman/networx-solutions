<?php

use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('lists services with their message counts', function () {
    $service = Service::factory()->create();
    ContactMessage::factory()->for($service)->count(2)->create();

    $this->actingAs($this->user)
        ->get(route('admin.services.index'))
        ->assertSuccessful()
        ->assertSee($service->name);
});

it('creates a service and generates the slug from the name when blank', function () {
    $this->actingAs($this->user)
        ->post(route('admin.services.store'), [
            'name' => 'Managed Backups',
            'slug' => '',
            'icon' => 'cloud',
            'excerpt' => 'Automated off-site backups for critical business data.',
            'description' => 'Daily encrypted backups with quarterly restore drills.',
            'sort_order' => 7,
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.services.index'));

    $this->assertDatabaseHas('services', [
        'name' => 'Managed Backups',
        'slug' => 'managed-backups',
        'is_active' => true,
    ]);
});

it('rejects a duplicate slug', function () {
    Service::factory()->create(['slug' => 'cybersecurity']);

    $this->actingAs($this->user)
        ->post(route('admin.services.store'), [
            'name' => 'Cybersecurity',
            'slug' => 'cybersecurity',
            'icon' => 'shield',
            'excerpt' => 'Protecting your business.',
            'sort_order' => 1,
        ])
        ->assertSessionHasErrors('slug');
});

it('updates a service', function () {
    $service = Service::factory()->create();

    $this->actingAs($this->user)
        ->put(route('admin.services.update', $service), [
            'name' => 'Renamed Service',
            'slug' => $service->slug,
            'icon' => 'network',
            'excerpt' => 'A refreshed description of what we offer.',
            'sort_order' => 3,
            'is_active' => '',
        ])
        ->assertRedirect(route('admin.services.index'));

    $service->refresh();

    expect($service->name)->toBe('Renamed Service')
        ->and($service->is_active)->toBeFalse();
});

it('deletes a service and detaches its messages', function () {
    $service = Service::factory()->create();
    $message = ContactMessage::factory()->for($service)->create();

    $this->actingAs($this->user)
        ->delete(route('admin.services.destroy', $service))
        ->assertRedirect(route('admin.services.index'));

    $this->assertDatabaseMissing('services', ['id' => $service->id]);

    expect($message->refresh()->service_id)->toBeNull();
});
