<?php

namespace App\Models;

use App\Enums\ContactActivityType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactActivity extends Model
{
    protected $fillable = [
        'contact_message_id',
        'user_id',
        'type',
        'meta',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => ContactActivityType::class,
            'meta' => 'array',
        ];
    }

    /**
     * @return BelongsTo<ContactMessage, $this>
     */
    public function contactMessage(): BelongsTo
    {
        return $this->belongsTo(ContactMessage::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
