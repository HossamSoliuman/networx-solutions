<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class AboutContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            'about_eyebrow' => 'About us',
            'about_title' => 'Transforming businesses through integrated technology solutions.',
            'about_intro' => 'Based in Cairo, Egypt, Networx Solutions delivers comprehensive IT services that help businesses improve performance, strengthen security, and accelerate digital transformation through reliable, scalable technology solutions.',
            'about_story' => 'Networx Solutions is a Cairo-based IT company providing integrated IT services, including IT support, networking, cloud solutions, cybersecurity, CCTV & surveillance, and Microsoft 365. We help businesses build secure, reliable, and scalable IT environments that drive productivity, business continuity, and long-term growth.',
            'facebook_url' => 'https://facebook.com/networxsolutions',
            'linkedin_url' => 'https://www.linkedin.com/company/networx-solutions/',
            'instagram_url' => 'https://instagram.com/networx_solutions',
        ];

        foreach ($settings as $key => $value) {
            Setting::set($key, $value);
        }
    }
}
