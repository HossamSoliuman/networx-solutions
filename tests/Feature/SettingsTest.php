<?php

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('renders each settings section', function (string $section, string $expected) {
    $this->actingAs($this->user)
        ->get(route('admin.settings.edit', $section))
        ->assertSuccessful()
        ->assertSee($expected);
})->with([
    ['pages', 'Home page'],
    ['company', 'Company identity'],
    ['seo', 'AI search'],
    ['messaging', 'Email reply signature'],
]);

it('defaults to the page content section and rejects unknown sections', function () {
    $this->actingAs($this->user)
        ->get(route('admin.settings.edit'))
        ->assertSuccessful()
        ->assertSee('Page content');

    $this->actingAs($this->user)
        ->get('/admin/settings/bogus')
        ->assertNotFound();
});

it('saves company settings and refreshes the cached values', function () {
    Setting::set('site_name', 'Old Name');

    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'company'), [
            'site_name' => 'Networx Solutions',
            'tagline' => 'Connect · Secure · Empower',
            'contact_email' => 'info@networx-solutions.com',
            'contact_phone' => '+201066405570',
            'address' => 'Riyadh, Saudi Arabia',
            'website' => 'www.networx-solutions.com',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Setting::get('site_name'))->toBe('Networx Solutions');
});

it('saves messaging settings', function () {
    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'messaging'), [
            'notification_email' => 'inbox@networx-solutions.com',
            'mail_signature' => "Best regards,\nNetworx Solutions Support",
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Setting::get('notification_email'))->toBe('inbox@networx-solutions.com');
});

it('saves seo and ai settings', function () {
    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'seo'), [
            'seo_meta_title' => 'Networx Solutions · Managed IT',
            'seo_meta_description' => 'Managed IT support and networking.',
            'seo_keywords' => 'it support, networking',
            'ai_summary' => 'Networx Solutions provides managed IT services.',
            'ai_allow_crawlers' => '0',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Setting::get('seo_meta_title'))->toBe('Networx Solutions · Managed IT')
        ->and(Setting::get('ai_allow_crawlers'))->toBe('0');
});

it('validates settings input', function () {
    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'company'), [
            'site_name' => 'Networx Solutions',
            'contact_email' => 'not-an-email',
            'facebook_url' => 'not-a-url',
        ])
        ->assertSessionHasErrors(['contact_email', 'facebook_url']);
});

it('stores admin managed public page photography', function () {
    Storage::fake('public');

    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'pages'), [
            'home_image' => UploadedFile::fake()->image('server-room.jpg', 1600, 1000),
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $imagePath = Setting::get('home_image');

    expect($imagePath)->toStartWith('site/');
    Storage::disk('public')->assertExists($imagePath);
});
