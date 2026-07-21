<?php

use App\Models\Service;
use App\Models\Setting;

it('renders the public site as separate pages', function () {
    $service = Service::factory()->create([
        'name' => 'Managed Infrastructure',
        'slug' => 'managed-infrastructure',
    ]);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee(route('services.index'))
        ->assertSee('id="contact-modal"', escape: false)
        ->assertSee('data-modal-open="contact-modal"', escape: false)
        ->assertSee('href="'.route('contact').'" class="site-nav-link"', escape: false)
        ->assertSee('href="'.route('contact').'" class="site-mobile-link"', escape: false)
        ->assertSee('Why choose Networx Solutions?');

    $this->get(route('about'))
        ->assertSuccessful()
        ->assertSee('About us')
        ->assertSee('Our mission')
        ->assertSee('Why choose us');

    $this->get(route('services.index'))
        ->assertSuccessful()
        ->assertSee($service->name)
        ->assertSee(route('services.show', $service));

    $this->get(route('services.show', $service))
        ->assertSuccessful()
        ->assertSee($service->name)
        ->assertSee('Explore the services')
        ->assertSee('data-contact-service-id="'.$service->id.'"', escape: false);

    $this->get(route('contact'))
        ->assertSuccessful()
        ->assertSee('Project enquiry');
});

it('uses page content managed through settings', function () {
    Setting::set('home_title', 'Infrastructure managed from the admin');
    Setting::set('about_story', 'A custom company story written in the admin area.');

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('Infrastructure managed from the admin');

    $this->get(route('about'))
        ->assertSuccessful()
        ->assertSee('A custom company story written in the admin area.');
});

it('does not publish inactive service detail pages', function () {
    $service = Service::factory()->inactive()->create();

    $this->get(route('services.show', $service))->assertNotFound();
});

it('preselects a requested service on the contact page', function () {
    $service = Service::factory()->create(['slug' => 'network-assessment']);

    $this->get(route('contact', ['service' => $service->slug]))
        ->assertSuccessful()
        ->assertSee('value="'.$service->id.'" selected', escape: false);
});

it('ships readable machine photography for every default public placement', function () {
    $imageFiles = [
        'hero.jpg',
        'about.jpg',
        'contact.jpg',
        'it-support.jpg',
        'networking.jpg',
        'cloud-solutions.jpg',
        'cybersecurity.jpg',
        'cctv-systems.jpg',
        'microsoft-365-services.jpg',
        'it-support-banner.webp',
        'networking-banner.webp',
        'cloud-solutions-banner.webp',
        'cybersecurity-banner.webp',
        'cctv-systems-banner.webp',
        'microsoft-365-services-banner.webp',
    ];

    foreach ($imageFiles as $imageFile) {
        expect(public_path('images/site/'.$imageFile))->toBeReadableFile();
    }
});
