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
                'image_path' => 'images/site/it-support.jpg',
                'benefits' => "Remote and on-site troubleshooting\nDevice health and patch management\nClear escalation and reporting",
            ],
            [
                'name' => 'Networking',
                'slug' => 'networking',
                'icon' => 'network',
                'excerpt' => 'Design, setup, and maintenance of secure and efficient networks.',
                'description' => 'From structured cabling to enterprise Wi-Fi, we design, implement, and maintain secure, high-performance networks tailored to your business needs.',
                'image_path' => 'images/site/networking.jpg',
                'benefits' => "Network design and site surveys\nStructured cabling and enterprise Wi-Fi\nMonitoring, optimization, and support",
            ],
            [
                'name' => 'Cloud Solutions',
                'slug' => 'cloud-solutions',
                'icon' => 'cloud',
                'excerpt' => 'Scalable cloud solutions to grow your business with confidence.',
                'description' => 'We handle cloud migration, infrastructure, and management so your business can scale with confidence while keeping costs under control.',
                'image_path' => 'images/site/cloud-solutions.jpg',
                'benefits' => "Cloud readiness and migration planning\nSecure backup and disaster recovery\nCost and performance management",
            ],
            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'icon' => 'shield',
                'excerpt' => 'Protecting your data and systems from modern threats.',
                'description' => 'We protect your data and systems with layered security: firewalls, endpoint protection, monitoring, and security awareness for your team.',
                'image_path' => 'images/site/cybersecurity.jpg',
                'benefits' => "Risk assessment and security hardening\nEndpoint, email, and network protection\nMonitoring and incident response planning",
            ],
            [
                'name' => 'CCTV Systems',
                'slug' => 'cctv-systems',
                'icon' => 'camera',
                'excerpt' => 'Smart surveillance solutions for your peace of mind.',
                'description' => 'Smart surveillance design and installation with remote viewing, recording, and maintenance for offices, warehouses, and retail locations.',
                'image_path' => 'images/site/cctv-systems.jpg',
                'benefits' => "Coverage planning and camera selection\nProfessional installation and configuration\nRemote access, recording, and maintenance",
            ],
            [
                'name' => 'Microsoft 365 Services',
                'slug' => 'microsoft-365-services',
                'icon' => 'grid',
                'excerpt' => 'Boost productivity and collaboration with Microsoft 365.',
                'description' => 'Licensing, migration, and administration of Microsoft 365 — Exchange, Teams, SharePoint, and OneDrive — to boost productivity and collaboration.',
                'image_path' => 'images/site/microsoft-365-services.jpg',
                'benefits' => "Tenant setup and license optimization\nEmail and file migration\nSecurity, governance, and ongoing administration",
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
