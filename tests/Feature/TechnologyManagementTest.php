<?php

use App\Models\Technology;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('lists technologies', function () {
    $technology = Technology::factory()->create(['name' => 'Fortinet']);

    $this->actingAs($this->user)
        ->get(route('admin.technologies.index'))
        ->assertSuccessful()
        ->assertSee($technology->name);
});

it('creates a technology and generates the slug from the name when blank', function () {
    $this->actingAs($this->user)
        ->post(route('admin.technologies.store'), [
            'name' => 'Cisco Meraki',
            'slug' => '',
            'brand_color' => '#1BA0D7',
            'website_url' => 'https://meraki.cisco.com',
            'sort_order' => 4,
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.technologies.index'));

    $this->assertDatabaseHas('technologies', [
        'name' => 'Cisco Meraki',
        'slug' => 'cisco-meraki',
        'brand_color' => '#1BA0D7',
        'is_active' => true,
    ]);
});

it('stores an uploaded logo', function () {
    Storage::fake('public');

    $this->actingAs($this->user)
        ->post(route('admin.technologies.store'), [
            'name' => 'Sophos',
            'slug' => '',
            'logo' => UploadedFile::fake()->image('sophos.png', 400, 200),
            'brand_color' => '#0055A5',
            'sort_order' => 2,
            'is_active' => '1',
        ])
        ->assertRedirect(route('admin.technologies.index'));

    $technology = Technology::query()->where('slug', 'sophos')->sole();

    Storage::disk('public')->assertExists($technology->logo_path);
});

it('rejects an invalid brand colour', function () {
    $this->actingAs($this->user)
        ->post(route('admin.technologies.store'), [
            'name' => 'Aruba',
            'slug' => '',
            'brand_color' => 'orange',
            'sort_order' => 0,
        ])
        ->assertSessionHasErrors('brand_color');
});

it('rejects a duplicate slug', function () {
    Technology::factory()->create(['slug' => 'lenovo']);

    $this->actingAs($this->user)
        ->post(route('admin.technologies.store'), [
            'name' => 'Lenovo',
            'slug' => 'lenovo',
            'brand_color' => '#E2231A',
            'sort_order' => 1,
        ])
        ->assertSessionHasErrors('slug');
});

it('updates a technology and keeps its own slug available', function () {
    $technology = Technology::factory()->create(['slug' => 'vmware']);

    $this->actingAs($this->user)
        ->put(route('admin.technologies.update', $technology), [
            'name' => 'VMware by Broadcom',
            'slug' => 'vmware',
            'brand_color' => '#607078',
            'website_url' => '',
            'sort_order' => 9,
            'is_active' => '',
        ])
        ->assertRedirect(route('admin.technologies.index'));

    $technology->refresh();

    expect($technology->name)->toBe('VMware by Broadcom')
        ->and($technology->sort_order)->toBe(9)
        ->and($technology->is_active)->toBeFalse();
});

it('deletes a technology and its uploaded logo', function () {
    Storage::fake('public');

    $technology = Technology::factory()->create([
        'logo_path' => UploadedFile::fake()->image('logo.png')->store('technologies', 'public'),
    ]);

    $this->actingAs($this->user)
        ->delete(route('admin.technologies.destroy', $technology))
        ->assertRedirect(route('admin.technologies.index'));

    $this->assertDatabaseMissing('technologies', ['id' => $technology->id]);
    Storage::disk('public')->assertMissing($technology->logo_path);
});

it('keeps the shipped vendor logos when a technology is deleted', function () {
    Storage::fake('public');

    $technology = Technology::factory()->create(['logo_path' => 'images/technologies/microsoft.svg']);

    $this->actingAs($this->user)
        ->delete(route('admin.technologies.destroy', $technology))
        ->assertRedirect(route('admin.technologies.index'));

    expect(file_exists(public_path('images/technologies/microsoft.svg')))->toBeTrue();
});

it('requires authentication for the technologies admin', function () {
    $this->get(route('admin.technologies.index'))->assertRedirect(route('admin.login'));
});

it('shows active technologies on the home page and hides inactive ones', function () {
    Technology::factory()->create(['name' => 'Ubiquiti', 'slug' => 'ubiquiti']);
    Technology::factory()->inactive()->create(['name' => 'Retired Vendor', 'slug' => 'retired-vendor']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee(__('public.home.technologies.title'))
        ->assertSee('Ubiquiti')
        ->assertDontSee('Retired Vendor');
});

it('falls back to a wordmark when a technology has no logo', function () {
    Technology::factory()->withoutLogo()->create(['name' => 'Hikvision', 'slug' => 'hikvision']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('technology-wordmark', false)
        ->assertSee('Hikvision');
});
