<?php

namespace Database\Seeders;

use App\Models\Technology;
use Illuminate\Database\Seeder;

class TechnologySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach ($this->technologies() as $index => $technology) {
            Technology::query()->updateOrCreate(
                ['slug' => $technology['slug']],
                [
                    ...$technology,
                    'sort_order' => $index,
                    'is_active' => true,
                ],
            );
        }
    }

    /**
     * Vendor logos ship with the application; the admin panel can replace any of them.
     *
     * @return list<array{name: string, slug: string, logo_path: string|null, brand_color: string, website_url: string}>
     */
    private function technologies(): array
    {
        return [
            [
                'name' => 'Microsoft',
                'slug' => 'microsoft',
                'logo_path' => 'images/technologies/microsoft.svg',
                'brand_color' => '#5E5E5E',
                'website_url' => 'https://www.microsoft.com',
            ],
            [
                'name' => 'Fortinet',
                'slug' => 'fortinet',
                'logo_path' => 'images/technologies/fortinet.svg',
                'brand_color' => '#EE3124',
                'website_url' => 'https://www.fortinet.com',
            ],
            [
                'name' => 'TP-Link',
                'slug' => 'tp-link',
                'logo_path' => 'images/technologies/tp-link.svg',
                'brand_color' => '#4ACBD6',
                'website_url' => 'https://www.tp-link.com',
            ],
            [
                'name' => 'Ubiquiti',
                'slug' => 'ubiquiti',
                'logo_path' => 'images/technologies/ubiquiti.svg',
                'brand_color' => '#0559C9',
                'website_url' => 'https://www.ui.com',
            ],
            [
                'name' => 'Hikvision',
                'slug' => 'hikvision',
                'logo_path' => null,
                'brand_color' => '#ED1C24',
                'website_url' => 'https://www.hikvision.com',
            ],
            [
                'name' => 'Logitech',
                'slug' => 'logitech',
                'logo_path' => 'images/technologies/logitech.svg',
                'brand_color' => '#1D1D1F',
                'website_url' => 'https://www.logitech.com',
            ],
            [
                'name' => 'Dell Technologies',
                'slug' => 'dell-technologies',
                'logo_path' => 'images/technologies/dell.svg',
                'brand_color' => '#007DB8',
                'website_url' => 'https://www.dell.com',
            ],
            [
                'name' => 'HP',
                'slug' => 'hp',
                'logo_path' => 'images/technologies/hp.svg',
                'brand_color' => '#0096D6',
                'website_url' => 'https://www.hp.com',
            ],
            [
                'name' => 'Lenovo',
                'slug' => 'lenovo',
                'logo_path' => 'images/technologies/lenovo.svg',
                'brand_color' => '#E2231A',
                'website_url' => 'https://www.lenovo.com',
            ],
            [
                'name' => 'VMware',
                'slug' => 'vmware',
                'logo_path' => 'images/technologies/vmware.svg',
                'brand_color' => '#607078',
                'website_url' => 'https://www.vmware.com',
            ],
        ];
    }
}
