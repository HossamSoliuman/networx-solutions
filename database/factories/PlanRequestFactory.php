<?php

namespace Database\Factories;

use App\Enums\BillingPeriod;
use App\Enums\PlanRequestStatus;
use App\Models\PlanRequest;
use App\Models\Service;
use App\Models\ServicePlan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PlanRequest>
 */
class PlanRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_id' => Service::factory(),
            'service_plan_id' => ServicePlan::factory(),
            'service_name' => 'IT Support',
            'plan_name' => 'Essential Care',
            'billing_period' => BillingPeriod::Monthly,
            'plan_price' => 1999,
            'currency' => 'EGP',
            'name' => fake()->name(),
            'phone' => '+20 10 6640 5570',
            'email' => fake()->safeEmail(),
            'note' => null,
            'status' => PlanRequestStatus::New,
            'locale' => 'en',
            'ip_address' => fake()->ipv4(),
        ];
    }

    public function read(): static
    {
        return $this->state(fn (array $attributes): array => ['read_at' => now()]);
    }

    public function contacted(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => PlanRequestStatus::Contacted,
            'read_at' => now(),
            'contacted_at' => now(),
        ]);
    }
}
