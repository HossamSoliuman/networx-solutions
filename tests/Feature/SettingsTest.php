<?php

use App\Models\Setting;
use App\Models\User;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders the settings form', function () {
    Setting::set('site_name', 'Networx Solutions');

    $this->actingAs($this->user)
        ->get(route('admin.settings.edit'))
        ->assertSuccessful()
        ->assertSee('Networx Solutions');
});

it('saves settings and refreshes the cached values', function () {
    Setting::set('site_name', 'Old Name');

    $this->actingAs($this->user)
        ->put(route('admin.settings.update'), [
            'site_name' => 'Networx Solutions',
            'tagline' => 'Connect · Secure · Empower',
            'contact_email' => 'info@networx-solutions.com',
            'contact_phone' => '+201066405570',
            'address' => 'Riyadh, Saudi Arabia',
            'website' => 'www.networx-solutions.com',
            'notification_email' => 'inbox@networx-solutions.com',
            'mail_signature' => "Best regards,\nNetworx Solutions Support",
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Setting::get('site_name'))->toBe('Networx Solutions')
        ->and(Setting::get('notification_email'))->toBe('inbox@networx-solutions.com');
});

it('validates settings input', function () {
    $this->actingAs($this->user)
        ->put(route('admin.settings.update'), [
            'site_name' => 'Networx Solutions',
            'contact_email' => 'not-an-email',
            'facebook_url' => 'not-a-url',
        ])
        ->assertSessionHasErrors(['contact_email', 'facebook_url']);
});
