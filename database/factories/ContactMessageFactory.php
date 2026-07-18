<?php

namespace Database\Factories;

use App\Enums\ContactMessagePriority;
use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactMessage>
 */
class ContactMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->boolean(70) ? fake()->e164PhoneNumber() : null,
            'company' => fake()->boolean(60) ? fake()->company() : null,
            'subject' => fake()->sentence(6),
            'message' => fake()->paragraphs(fake()->numberBetween(1, 3), true),
            'status' => ContactMessageStatus::New,
            'priority' => ContactMessagePriority::Normal,
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->userAgent(),
        ];
    }

    public function read(): static
    {
        return $this->state(fn (array $attributes): array => [
            'read_at' => now(),
        ]);
    }

    public function inProgress(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ContactMessageStatus::InProgress,
            'read_at' => now(),
        ]);
    }

    public function replied(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ContactMessageStatus::Replied,
            'read_at' => now(),
            'replied_at' => now(),
        ]);
    }

    public function closed(): static
    {
        return $this->state(fn (array $attributes): array => [
            'status' => ContactMessageStatus::Closed,
            'read_at' => now(),
            'closed_at' => now(),
        ]);
    }

    public function starred(): static
    {
        return $this->state(fn (array $attributes): array => ['is_starred' => true]);
    }

    public function archived(): static
    {
        return $this->state(fn (array $attributes): array => ['archived_at' => now()]);
    }

    public function urgent(): static
    {
        return $this->state(fn (array $attributes): array => ['priority' => ContactMessagePriority::Urgent]);
    }
}
