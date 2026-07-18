<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'IT Support',
                'slug' => 'it-support',
                'icon' => 'headset',
                'excerpt' => 'Reliable on-site and remote support for your business, whenever you need it.',
                'description' => 'Our IT support team keeps your business running with responsive on-site and remote assistance, proactive maintenance, and fast resolution of hardware and software issues.',
            ],
            [
                'name' => 'Networking',
                'slug' => 'networking',
                'icon' => 'network',
                'excerpt' => 'Design, setup, and maintenance of secure and efficient networks.',
                'description' => 'From structured cabling to enterprise Wi-Fi, we design, implement, and maintain secure, high-performance networks tailored to your business needs.',
            ],
            [
                'name' => 'Cloud Solutions',
                'slug' => 'cloud-solutions',
                'icon' => 'cloud',
                'excerpt' => 'Scalable cloud solutions to grow your business with confidence.',
                'description' => 'We handle cloud migration, infrastructure, and management so your business can scale with confidence while keeping costs under control.',
            ],
            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'icon' => 'shield',
                'excerpt' => 'Protecting your data and systems from modern threats.',
                'description' => 'We protect your data and systems with layered security: firewalls, endpoint protection, monitoring, and security awareness for your team.',
            ],
            [
                'name' => 'CCTV Systems',
                'slug' => 'cctv-systems',
                'icon' => 'camera',
                'excerpt' => 'Smart surveillance solutions for your peace of mind.',
                'description' => 'Smart surveillance design and installation with remote viewing, recording, and maintenance for offices, warehouses, and retail locations.',
            ],
            [
                'name' => 'Microsoft 365 Services',
                'slug' => 'microsoft-365-services',
                'icon' => 'grid',
                'excerpt' => 'Boost productivity and collaboration with Microsoft 365.',
                'description' => 'Licensing, migration, and administration of Microsoft 365 — Exchange, Teams, SharePoint, and OneDrive — to boost productivity and collaboration.',
            ],
        ];

        foreach ($services as $index => $service) {
            Service::query()->updateOrCreate(
                ['slug' => $service['slug']],
                [...$service, 'sort_order' => $index, 'is_active' => true],
            );
        }
    }
}
