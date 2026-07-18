<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Networx Admin',
            'email' => 'admin@networx-solutions.com',
        ]);

        User::factory()->create([
            'name' => 'Support Agent',
            'email' => 'agent@networx-solutions.com',
        ]);

        $defaults = [
            ...Setting::SITE_DEFAULTS,
            'notification_email' => 'info@networx-solutions.com',
            'mail_signature' => "Networx Solutions Support Team\nConnect • Secure • Empower",
        ];

        foreach ($defaults as $key => $value) {
            Setting::query()->firstOrCreate(['key' => $key], ['value' => $value]);
        }

        $this->call(ServiceSeeder::class);

        if (app()->environment('local')) {
            $this->call(ContactMessageSeeder::class);
        }
    }
}
