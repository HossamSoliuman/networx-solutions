<?php

namespace App\Models;

use App\Enums\ContactActivityType;
use App\Enums\ContactMessagePriority;
use App\Enums\ContactMessageStatus;
use Database\Factories\ContactMessageFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ContactMessage extends Model
{
    /** @use HasFactory<ContactMessageFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'subject',
        'message',
        'service_id',
        'status',
        'priority',
        'is_starred',
        'assigned_to_id',
        'read_at',
        'replied_at',
        'closed_at',
        'archived_at',
        'ip_address',
        'user_agent',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => ContactMessageStatus::class,
            'priority' => ContactMessagePriority::class,
            'is_starred' => 'boolean',
            'read_at' => 'datetime',
            'replied_at' => 'datetime',
            'closed_at' => 'datetime',
            'archived_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (ContactMessage $message) {
            $message->forceFill([
                'reference' => sprintf('NX-%s-%05d', $message->created_at->format('y'), $message->id),
            ])->saveQuietly();
        });
    }

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to_id');
    }

    /**
     * @return HasMany<ContactReply, $this>
     */
    public function replies(): HasMany
    {
        return $this->hasMany(ContactReply::class);
    }

    /**
     * @return HasMany<ContactNote, $this>
     */
    public function notes(): HasMany
    {
        return $this->hasMany(ContactNote::class);
    }

    /**
     * @return HasMany<ContactActivity, $this>
     */
    public function activities(): HasMany
    {
        return $this->hasMany(ContactActivity::class);
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    public function isArchived(): bool
    {
        return $this->archived_at !== null;
    }

    /**
     * Record an entry in the message's activity trail.
     *
     * @param  array<string, mixed>  $meta
     */
    public function recordActivity(ContactActivityType $type, ?User $user = null, array $meta = []): ContactActivity
    {
        return $this->activities()->create([
            'user_id' => $user?->id,
            'type' => $type,
            'meta' => $meta !== [] ? $meta : null,
        ]);
    }

    /**
     * Mark the message as read the first time it is opened.
     */
    public function markAsRead(User $user): void
    {
        if ($this->read_at !== null) {
            return;
        }

        $this->update(['read_at' => now()]);
        $this->recordActivity(ContactActivityType::Viewed, $user);
    }

    /**
     * Transition to a new status, stamping the related timestamp and activity.
     */
    public function transitionTo(ContactMessageStatus $status, ?User $user = null): void
    {
        if ($this->status === $status) {
            return;
        }

        $previous = $this->status;

        $this->update([
            'status' => $status,
            'closed_at' => $status === ContactMessageStatus::Closed ? now() : null,
        ]);

        $this->recordActivity(ContactActivityType::StatusChanged, $user, [
            'from' => $previous->value,
            'to' => $status->value,
        ]);
    }

    /**
     * Scope to messages that are not archived.
     *
     * @param  Builder<ContactMessage>  $query
     */
    public function scopeInbox(Builder $query): void
    {
        $query->whereNull('archived_at');
    }

    /**
     * @param  Builder<ContactMessage>  $query
     */
    public function scopeArchived(Builder $query): void
    {
        $query->whereNotNull('archived_at');
    }

    /**
     * @param  Builder<ContactMessage>  $query
     */
    public function scopeUnread(Builder $query): void
    {
        $query->whereNull('read_at');
    }

    /**
     * Apply the shared index/export filters.
     *
     * @param  Builder<ContactMessage>  $query
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter(Builder $query, array $filters, ?User $user = null): void
    {
        match ($filters['view'] ?? 'inbox') {
            'archived' => $query->archived(),
            'starred' => $query->inbox()->where('is_starred', true),
            default => $query->inbox(),
        };

        if ($status = ContactMessageStatus::tryFrom($filters['status'] ?? '')) {
            $query->where('status', $status);
        }

        if ($priority = ContactMessagePriority::tryFrom($filters['priority'] ?? '')) {
            $query->where('priority', $priority);
        }

        if (! empty($filters['q'])) {
            $query->search($filters['q']);
        }

        if (! empty($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }

        if (($filters['assigned'] ?? '') === 'me' && $user !== null) {
            $query->where('assigned_to_id', $user->id);
        } elseif (($filters['assigned'] ?? '') === 'unassigned') {
            $query->whereNull('assigned_to_id');
        }

        if (! empty($filters['from'])) {
            $query->whereDate('created_at', '>=', $filters['from']);
        }

        if (! empty($filters['to'])) {
            $query->whereDate('created_at', '<=', $filters['to']);
        }

        match ($filters['sort'] ?? 'newest') {
            'oldest' => $query->oldest(),
            'priority' => $query
                ->orderByRaw("case priority when 'urgent' then 0 when 'high' then 1 when 'normal' then 2 else 3 end")
                ->latest(),
            default => $query->latest(),
        };
    }

    /**
     * Free-text search across sender fields, subject, body, and reference.
     *
     * @param  Builder<ContactMessage>  $query
     */
    public function scopeSearch(Builder $query, string $term): void
    {
        $like = '%'.str_replace(['%', '_'], ['\\%', '\\_'], trim($term)).'%';

        $query->where(function (Builder $query) use ($like) {
            $query->where('name', 'like', $like)
                ->orWhere('email', 'like', $like)
                ->orWhere('company', 'like', $like)
                ->orWhere('subject', 'like', $like)
                ->orWhere('message', 'like', $like)
                ->orWhere('reference', 'like', $like);
        });
    }
}
