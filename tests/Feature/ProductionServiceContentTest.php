<?php

use App\Models\Service;
use Database\Seeders\ServiceSeeder;

it('seeds every referenced service with its complete content', function () {
    $this->seed(ServiceSeeder::class);

    $services = Service::query()->ordered()->get();

    expect($services)->toHaveCount(6)
        ->and($services->pluck('slug')->all())->toBe([
            'it-support',
            'networking',
            'cloud-solutions',
            'cybersecurity',
            'cctv-systems',
            'microsoft-365-services',
        ]);

    $services->each(function (Service $service): void {
        expect($service->serviceItems())->toHaveCount(10)
            ->and($service->reasons())->toHaveCount(5)
            ->and($service->statement())->not->toBeEmpty()
            ->and(public_path($service->image_path))->toBeReadableFile();

        $this->get(route('services.show', $service))->assertSuccessful();
    });
});

it('renders referenced service items and reasons on the public service page', function () {
    $this->seed(ServiceSeeder::class);

    $service = Service::query()->where('slug', 'networking')->sole();

    $this->get(route('services.show', $service))
        ->assertSuccessful()
        ->assertSee('Network Design &amp; Implementation', escape: false)
        ->assertSee('VLAN Configuration')
        ->assertSee('High-Speed Connectivity')
        ->assertSee('Reliable Performance')
        ->assertSee('Strong networks power successful businesses.');
});

it('renders the six seeded services on the public catalogue', function () {
    $this->seed(ServiceSeeder::class);

    $this->get(route('services.index'))
        ->assertSuccessful()
        ->assertSee('IT Support Solutions')
        ->assertSee('Professional Networking Solutions')
        ->assertSee('Cloud Solutions')
        ->assertSee('Cybersecurity Services')
        ->assertSee('CCTV &amp; Surveillance Solutions', escape: false)
        ->assertSee('Microsoft 365 Services');
});
