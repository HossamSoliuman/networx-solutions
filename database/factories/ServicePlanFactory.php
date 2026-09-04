<?php

namespace Database\Factories;

use App\Models\Service;
use App\Models\ServicePlan;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<ServicePlan>
 */
class ServicePlanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $monthly = fake()->randomElement([499, 999, 1999, 3499, 6999]);

        return [
            'service_id' => Service::factory(),
            'name' => Str::title(fake()->unique()->words(2, true)),
            'icon' => fake()->randomElement(['star', 'desktop', 'users', 'building', 'server']),
            'accent_color' => '#0369a1',
            'capacity' => 'Up to '.fake()->numberBetween(5, 70).' Devices',
            'price_monthly' => $monthly,
            'price_yearly' => $monthly * 11,
            'currency' => 'EGP',
            'features' => "Remote Support\nWindows Support\nMonthly IT Report",
            'is_featured' => false,
            'sort_order' => fake()->numberBetween(0, 10),
            'is_active' => true,
        ];
    }

    public function featured(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_featured' => true,
            'badge' => 'Most Popular',
        ]);
    }

    public function customPrice(): static
    {
        return $this->state(fn (array $attributes): array => [
            'is_custom_price' => true,
            'price_monthly' => null,
            'price_yearly' => null,
            'custom_price_label' => 'Custom',
        ]);
    }

    public function inactive(): static
    {
        return $this->state(fn (array $attributes): array => ['is_active' => false]);
    }
}
