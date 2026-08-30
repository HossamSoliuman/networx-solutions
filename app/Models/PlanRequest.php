<?php

namespace App\Models;

use App\Enums\BillingPeriod;
use App\Enums\PlanRequestStatus;
use Database\Factories\PlanRequestFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PlanRequest extends Model
{
    /** @use HasFactory<PlanRequestFactory> */
    use HasFactory;

    protected $fillable = [
        'service_id',
        'service_plan_id',
        'service_name',
        'plan_name',
        'billing_period',
        'plan_price',
        'currency',
        'name',
        'phone',
        'email',
        'note',
        'status',
        'admin_note',
        'read_at',
        'contacted_at',
        'locale',
        'ip_address',
        'user_agent',
    ];

    protected $attributes = [
        'billing_period' => 'monthly',
        'status' => 'new',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'billing_period' => BillingPeriod::class,
            'status' => PlanRequestStatus::class,
            'plan_price' => 'decimal:2',
            'read_at' => 'datetime',
            'contacted_at' => 'datetime',
        ];
    }

    protected static function booted(): void
    {
        static::created(function (PlanRequest $planRequest): void {
            $planRequest->forceFill([
                'reference' => sprintf('NXP-%s-%05d', $planRequest->created_at->format('y'), $planRequest->id),
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
     * @return BelongsTo<ServicePlan, $this>
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(ServicePlan::class, 'service_plan_id');
    }

    public function isUnread(): bool
    {
        return $this->read_at === null;
    }

    /**
     * Mark the request as read the first time an admin opens it.
     */
    public function markAsRead(): void
    {
        if ($this->read_at !== null) {
            return;
        }

        $this->update(['read_at' => now()]);
    }

    /**
     * Move the request to a new status, stamping the contacted timestamp once
     * someone has actually reached out.
     */
    public function transitionTo(PlanRequestStatus $status): void
    {
        if ($this->status === $status) {
            return;
        }

        $this->update([
            'status' => $status,
            ...($status === PlanRequestStatus::New ? ['read_at' => null] : []),
            ...($status !== PlanRequestStatus::New && $this->read_at === null ? ['read_at' => now()] : []),
            ...($status === PlanRequestStatus::Contacted && $this->contacted_at === null ? ['contacted_at' => now()] : []),
        ]);
    }

    public function formattedPrice(): ?string
    {
        if ($this->plan_price === null) {
            return null;
        }

        $price = (float) $this->plan_price;
        $decimals = fmod($price, 1.0) === 0.0 ? 0 : 2;

        return trim(number_format($price, $decimals).' '.($this->currency ?? ''));
    }

    /**
     * @param  Builder<PlanRequest>  $query
     */
    public function scopeUnread(Builder $query): void
    {
        $query->whereNull('read_at');
    }

    /**
     * @param  Builder<PlanRequest>  $query
     */
    public function scopeOpen(Builder $query): void
    {
        $query->whereIn('status', [PlanRequestStatus::New, PlanRequestStatus::Contacted]);
    }

    /**
     * Apply the index filters.
     *
     * @param  Builder<PlanRequest>  $query
     * @param  array<string, mixed>  $filters
     */
    public function scopeFilter(Builder $query, array $filters): void
    {
        if ($status = PlanRequestStatus::tryFrom($filters['status'] ?? '')) {
            $query->where('status', $status);
        }

        if (! empty($filters['service_id'])) {
            $query->where('service_id', $filters['service_id']);
        }

        if (! empty($filters['q'])) {
            $query->search($filters['q']);
        }

        match ($filters['sort'] ?? 'newest') {
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };
    }

    /**
     * Free-text search across the contact details, plan, and reference.
     *
     * @param  Builder<PlanRequest>  $query
     */
    public function scopeSearch(Builder $query, string $term): void
    {
        $like = '%'.str_replace(['%', '_'], ['\\%', '\\_'], trim($term)).'%';

        $query->where(function (Builder $query) use ($like): void {
            $query->where('name', 'like', $like)
                ->orWhere('phone', 'like', $like)
                ->orWhere('email', 'like', $like)
                ->orWhere('plan_name', 'like', $like)
                ->orWhere('service_name', 'like', $like)
                ->orWhere('note', 'like', $like)
                ->orWhere('reference', 'like', $like);
        });
    }
}
