<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use App\Models\ContactReply;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ContactReply>
 */
class ContactReplyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'contact_message_id' => ContactMessage::factory(),
            'user_id' => User::factory(),
            'subject' => 'Re: '.fake()->sentence(6),
            'body' => fake()->paragraphs(2, true),
        ];
    }
}
