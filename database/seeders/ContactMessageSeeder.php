<?php

namespace Database\Seeders;

use App\Enums\ContactActivityType;
use App\Enums\ContactMessagePriority;
use App\Enums\ContactMessageStatus;
use App\Models\ContactMessage;
use App\Models\ContactReply;
use App\Models\Service;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

class ContactMessageSeeder extends Seeder
{
    /**
     * Seed a realistic inbox: a spread of message states over the last 60 days.
     */
    public function run(): void
    {
        $admins = User::all();
        $serviceIds = Service::query()->pluck('id');

        $plan = [
            ['count' => 8, 'state' => 'unread', 'daysBack' => 4],
            ['count' => 6, 'state' => 'read', 'daysBack' => 10],
            ['count' => 6, 'state' => 'in_progress', 'daysBack' => 21],
            ['count' => 15, 'state' => 'replied', 'daysBack' => 60],
            ['count' => 6, 'state' => 'closed', 'daysBack' => 60],
            ['count' => 4, 'state' => 'archived', 'daysBack' => 60],
        ];

        foreach ($plan as $group) {
            foreach (range(1, $group['count']) as $i) {
                $createdAt = Carbon::now()
                    ->subDays(fake()->numberBetween(0, $group['daysBack']))
                    ->subMinutes(fake()->numberBetween(0, 1200));

                $this->seedMessage($group['state'], $createdAt, $admins, $serviceIds);
            }
        }
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Collection<int, User>  $admins
     * @param  Collection<int, int>  $serviceIds
     */
    private function seedMessage(string $state, Carbon $createdAt, $admins, $serviceIds): void
    {
        $admin = $admins->random();

        $message = ContactMessage::factory()->create([
            'service_id' => fake()->boolean(80) ? $serviceIds->random() : null,
            'priority' => fake()->randomElement([
                ContactMessagePriority::Low,
                ContactMessagePriority::Normal,
                ContactMessagePriority::Normal,
                ContactMessagePriority::Normal,
                ContactMessagePriority::High,
                ContactMessagePriority::Urgent,
            ]),
            'is_starred' => fake()->boolean(15),
            'created_at' => $createdAt,
            'updated_at' => $createdAt,
        ]);

        if ($state === 'unread') {
            return;
        }

        $readAt = $createdAt->copy()->addMinutes(fake()->numberBetween(20, 600));
        $message->forceFill(['read_at' => $readAt])->saveQuietly();
        $message->activities()->forceCreate([
            'user_id' => $admin->id,
            'type' => ContactActivityType::Viewed,
            'created_at' => $readAt,
            'updated_at' => $readAt,
        ]);

        if ($state === 'read') {
            return;
        }

        if ($state === 'in_progress') {
            $this->changeStatus($message, ContactMessageStatus::InProgress, $admin, $readAt->copy()->addMinutes(30));
            $message->forceFill(['assigned_to_id' => $admin->id])->saveQuietly();

            return;
        }

        // replied, closed, and archived all start with a reply.
        $repliedAt = $readAt->copy()->addMinutes(fake()->numberBetween(30, 1500));

        ContactReply::factory()->create([
            'contact_message_id' => $message->id,
            'user_id' => $admin->id,
            'subject' => 'Re: '.$message->subject,
            'created_at' => $repliedAt,
            'updated_at' => $repliedAt,
        ]);

        $message->forceFill([
            'status' => ContactMessageStatus::Replied,
            'replied_at' => $repliedAt,
        ])->saveQuietly();

        $message->activities()->forceCreate([
            'user_id' => $admin->id,
            'type' => ContactActivityType::Replied,
            'created_at' => $repliedAt,
            'updated_at' => $repliedAt,
        ]);

        if ($state === 'replied') {
            return;
        }

        $closedAt = $repliedAt->copy()->addDays(fake()->numberBetween(1, 5));
        $this->changeStatus($message, ContactMessageStatus::Closed, $admin, $closedAt);
        $message->forceFill(['closed_at' => $closedAt])->saveQuietly();

        if ($state === 'archived') {
            $archivedAt = $closedAt->copy()->addDays(1);
            $message->forceFill(['archived_at' => $archivedAt])->saveQuietly();
            $message->activities()->forceCreate([
                'user_id' => $admin->id,
                'type' => ContactActivityType::Archived,
                'created_at' => $archivedAt,
                'updated_at' => $archivedAt,
            ]);
        }
    }

    private function changeStatus(ContactMessage $message, ContactMessageStatus $status, User $admin, Carbon $at): void
    {
        $previous = $message->status;
        $message->forceFill(['status' => $status])->saveQuietly();

        $message->activities()->forceCreate([
            'user_id' => $admin->id,
            'type' => ContactActivityType::StatusChanged,
            'meta' => ['from' => $previous->value, 'to' => $status->value],
            'created_at' => $at,
            'updated_at' => $at,
        ]);
    }
}
