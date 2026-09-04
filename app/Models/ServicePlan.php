<?php

namespace App\Models;

use App\Enums\BillingPeriod;
use Database\Factories\ServicePlanFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Str;

class ServicePlan extends Model
{
    /** @use HasFactory<ServicePlanFactory> */
    use HasFactory;

    protected $fillable = [
        'service_id',
        'name',
        'name_ar',
        'icon',
        'accent_color',
        'badge',
        'badge_ar',
        'capacity',
        'capacity_ar',
        'price_monthly',
        'price_yearly',
        'price_suffix',
        'currency',
        'is_custom_price',
        'custom_price_label',
        'custom_price_label_ar',
        'features',
        'features_ar',
        'cta_label',
        'cta_label_ar',
        'is_featured',
        'sort_order',
        'is_active',
    ];

    protected $attributes = [
        'icon' => 'star',
        'accent_color' => '#0369a1',
        'currency' => 'EGP',
        'is_custom_price' => false,
        'is_featured' => false,
        'sort_order' => 0,
        'is_active' => true,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'price_monthly' => 'decimal:2',
            'price_yearly' => 'decimal:2',
            'is_custom_price' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    /**
     * @return BelongsTo<Service, $this>
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * @return HasMany<PlanRequest, $this>
     */
    public function planRequests(): HasMany
    {
        return $this->hasMany(PlanRequest::class);
    }

    /**
     * @param  Builder<ServicePlan>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<ServicePlan>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('id');
    }

    public function localizedName(): string
    {
        return $this->localizedString('name_ar', $this->name);
    }

    public function localizedBadge(): ?string
    {
        return $this->localizedNullableString('badge_ar', $this->badge);
    }

    public function localizedCapacity(): ?string
    {
        return $this->localizedNullableString('capacity_ar', $this->capacity);
    }

    public function localizedCtaLabel(): string
    {
        return $this->localizedNullableString('cta_label_ar', $this->cta_label)
            ?? __('public.pricing.get_started');
    }

    public function localizedCustomPriceLabel(): string
    {
        return $this->localizedNullableString('custom_price_label_ar', $this->custom_price_label)
            ?? __('public.pricing.custom_price');
    }

    /**
     * @return list<string>
     */
    public function featureList(): array
    {
        return $this->splitLines($this->features);
    }

    /**
     * @return list<string>
     */
    public function localizedFeatureList(): array
    {
        if (! App::isLocale('ar') || blank($this->features_ar)) {
            return $this->featureList();
        }

        return $this->splitLines($this->features_ar);
    }

    /**
     * The price charged for the given billing period, or null when the plan is
     * quoted individually or has no price for that period.
     */
    public function priceFor(BillingPeriod $period): ?float
    {
        if ($this->is_custom_price) {
            return null;
        }

        $price = $period === BillingPeriod::Yearly ? $this->price_yearly : $this->price_monthly;

        return $price === null ? null : (float) $price;
    }

    /**
     * Format a price without trailing zeros: 1999.00 becomes "1,999".
     */
    public function formattedPriceFor(BillingPeriod $period): ?string
    {
        $price = $this->priceFor($period);

        if ($price === null) {
            return null;
        }

        $decimals = fmod($price, 1.0) === 0.0 ? 0 : 2;

        return number_format($price, $decimals);
    }

    public function hasYearlyPrice(): bool
    {
        return ! $this->is_custom_price && $this->price_yearly !== null;
    }

    /**
     * Percentage saved by paying yearly instead of twelve monthly instalments.
     */
    public function yearlySavingsPercent(): ?int
    {
        $monthly = $this->priceFor(BillingPeriod::Monthly);
        $yearly = $this->priceFor(BillingPeriod::Yearly);

        if ($monthly === null || $yearly === null || $monthly <= 0.0) {
            return null;
        }

        $savings = (int) round((1 - ($yearly / ($monthly * 12))) * 100);

        return $savings > 0 ? $savings : null;
    }

    private function localizedString(string $arabicAttribute, string $fallback): string
    {
        return $this->localizedNullableString($arabicAttribute, $fallback) ?? $fallback;
    }

    private function localizedNullableString(string $arabicAttribute, ?string $fallback): ?string
    {
        $arabicValue = $this->getAttribute($arabicAttribute);

        if (App::isLocale('ar') && is_string($arabicValue) && filled($arabicValue)) {
            return $arabicValue;
        }

        return filled($fallback) ? $fallback : null;
    }

    /**
     * @return list<string>
     */
    private function splitLines(?string $value): array
    {
        return Str::of($value ?? '')
            ->replace("\r\n", "\n")
            ->explode("\n")
            ->map(fn (string $line): string => Str::squish($line))
            ->filter()
            ->values()
            ->all();
    }
}
