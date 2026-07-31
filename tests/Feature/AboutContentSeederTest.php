<?php

use App\Models\Setting;
use Database\Seeders\AboutContentSeeder;

it('updates persisted about content and social links idempotently', function () {
    Setting::set('about_title', 'Outdated about title');
    Setting::set('facebook_url', 'https://example.com/old-facebook');

    $this->seed(AboutContentSeeder::class);
    $this->seed(AboutContentSeeder::class);

    expect(Setting::get('about_title'))
        ->toBe('Transforming businesses through integrated technology solutions.')
        ->and(Setting::get('about_intro'))
        ->toBe('Based in Cairo, Egypt, Networx Solutions delivers comprehensive IT services that help businesses improve performance, strengthen security, and accelerate digital transformation through reliable, scalable technology solutions.')
        ->and(Setting::get('facebook_url'))
        ->toBe('https://facebook.com/networxsolutions')
        ->and(Setting::get('linkedin_url'))
        ->toBe('https://www.linkedin.com/company/networx-solutions/')
        ->and(Setting::get('instagram_url'))
        ->toBe('https://instagram.com/networx_solutions')
        ->and(Setting::query()->whereIn('key', [
            'about_eyebrow',
            'about_title',
            'about_intro',
            'about_story',
            'facebook_url',
            'linkedin_url',
            'instagram_url',
        ])->count())->toBe(7);
});

it('renders the updated about page content and social links', function () {
    $this->seed(AboutContentSeeder::class);

    $this->get(route('about'))
        ->assertSuccessful()
        ->assertSee('Transforming businesses through integrated technology solutions.')
        ->assertSee('Empowering businesses through smarter technology.')
        ->assertSee('Deliver integrated IT services that create measurable business value.')
        ->assertSee('Your Trusted Technology Partner')
        ->assertSee('Reliable Partnership')
        ->assertSee('href="https://facebook.com/networxsolutions"', escape: false)
        ->assertSee('href="https://www.linkedin.com/company/networx-solutions/"', escape: false)
        ->assertSee('href="https://instagram.com/networx_solutions"', escape: false);
});
