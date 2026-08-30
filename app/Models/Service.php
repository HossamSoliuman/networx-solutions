<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'name_ar',
        'slug',
        'icon',
        'excerpt',
        'excerpt_ar',
        'description',
        'description_ar',
        'image_path',
        'benefits',
        'benefits_ar',
        'details',
        'details_ar',
        'sort_order',
        'is_active',
        'pricing_enabled',
        'pricing_eyebrow',
        'pricing_eyebrow_ar',
        'pricing_title',
        'pricing_title_ar',
        'pricing_subtitle',
        'pricing_subtitle_ar',
        'pricing_yearly_note',
        'pricing_yearly_note_ar',
        'pricing_footnote',
        'pricing_footnote_ar',
    ];

    protected $attributes = [
        'icon' => 'cog',
        'sort_order' => 0,
        'is_active' => true,
        'pricing_enabled' => true,
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'pricing_enabled' => 'boolean',
            'sort_order' => 'integer',
            'details' => 'array',
            'details_ar' => 'json:unicode',
        ];
    }

    /**
     * @return HasMany<ContactMessage, $this>
     */
    public function contactMessages(): HasMany
    {
        return $this->hasMany(ContactMessage::class);
    }

    /**
     * @return HasMany<ServicePlan, $this>
     */
    public function plans(): HasMany
    {
        return $this->hasMany(ServicePlan::class);
    }

    /**
     * @return HasMany<PlanRequest, $this>
     */
    public function planRequests(): HasMany
    {
        return $this->hasMany(PlanRequest::class);
    }

    /**
     * @param  Builder<Service>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    /**
     * @param  Builder<Service>  $query
     */
    public function scopeOrdered(Builder $query): void
    {
        $query->orderBy('sort_order')->orderBy('name');
    }

    public function imageUrl(): string
    {
        $path = $this->image_path ?: 'images/site/hero.jpg';

        return Str::startsWith($path, 'images/')
            ? asset($path)
            : Storage::disk('public')->url($path);
    }

    /**
     * @return list<string>
     */
    public function benefitList(): array
    {
        return $this->splitBenefits($this->benefits);
    }

    /**
     * @return list<array{title: string, description: string, icon: string}>
     */
    public function serviceItems(): array
    {
        return $this->details['service_items'] ?? [];
    }

    /**
     * @return list<array{title: string, description: string, icon: string}>
     */
    public function reasons(): array
    {
        return $this->details['reasons'] ?? [];
    }

    public function statement(): ?string
    {
        return $this->details['statement'] ?? null;
    }

    public function localizedName(): string
    {
        return $this->localizedString('name_ar', $this->name);
    }

    public function localizedExcerpt(): string
    {
        return $this->localizedString('excerpt_ar', $this->excerpt);
    }

    public function localizedDescription(): string
    {
        return $this->localizedString('description_ar', $this->description ?? '');
    }

    /**
     * @return list<string>
     */
    public function localizedBenefitList(): array
    {
        if (! App::isLocale('ar') || blank($this->benefits_ar)) {
            return $this->benefitList();
        }

        return $this->splitBenefits($this->benefits_ar);
    }

    /**
     * @return list<array{title: string, description: string, icon: string}>
     */
    public function localizedServiceItems(): array
    {
        return $this->localizedDetailItems('service_items', $this->serviceItems());
    }

    /**
     * @return list<array{title: string, description: string, icon: string}>
     */
    public function localizedReasons(): array
    {
        return $this->localizedDetailItems('reasons', $this->reasons());
    }

    /**
     * The plans shown on the public pricing section, in display order.
     *
     * @return Collection<int, ServicePlan>
     */
    public function activePlans(): Collection
    {
        return $this->relationLoaded('plans')
            ? $this->plans->where('is_active', true)->sortBy(['sort_order', 'id'])->values()
            : $this->plans()->active()->ordered()->get();
    }

    /**
     * The pricing section only renders when it is enabled and has plans to show.
     */
    public function showsPricing(): bool
    {
        return $this->pricing_enabled && $this->activePlans()->isNotEmpty();
    }

    public function localizedPricingEyebrow(): string
    {
        return $this->localizedNullableString('pricing_eyebrow_ar', $this->pricing_eyebrow)
            ?? __('public.pricing.eyebrow');
    }

    public function localizedPricingTitle(): string
    {
        return $this->localizedNullableString('pricing_title_ar', $this->pricing_title)
            ?? __('public.pricing.title', ['service' => $this->localizedName()]);
    }

    public function localizedPricingSubtitle(): string
    {
        return $this->localizedNullableString('pricing_subtitle_ar', $this->pricing_subtitle)
            ?? __('public.pricing.subtitle');
    }

    public function localizedPricingYearlyNote(): ?string
    {
        return $this->localizedNullableString('pricing_yearly_note_ar', $this->pricing_yearly_note);
    }

    public function localizedPricingFootnote(): ?string
    {
        return $this->localizedNullableString('pricing_footnote_ar', $this->pricing_footnote);
    }

    public function localizedStatement(): ?string
    {
        $statement = $this->statement();
        $localizedStatement = $this->arabicDetails()['statement'] ?? null;

        return App::isLocale('ar') && is_string($localizedStatement) && filled($localizedStatement)
            ? $localizedStatement
            : $statement;
    }

    private function localizedString(string $arabicAttribute, string $fallback): string
    {
        $arabicValue = $this->getAttribute($arabicAttribute);

        return App::isLocale('ar') && is_string($arabicValue) && filled($arabicValue)
            ? $arabicValue
            : $fallback;
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
     * @return array<string, mixed>
     */
    private function arabicDetails(): array
    {
        return is_array($this->details_ar) ? $this->details_ar : [];
    }

    /**
     * @param  list<array{title: string, description: string, icon: string}>  $items
     * @return list<array{title: string, description: string, icon: string}>
     */
    private function localizedDetailItems(string $key, array $items): array
    {
        $translations = $this->arabicDetails()[$key] ?? null;

        if (! App::isLocale('ar') || ! is_array($translations)) {
            return $items;
        }

        return collect($items)
            ->map(function (array $item, int $index) use ($translations): array {
                $translation = is_array($translations[$index] ?? null) ? $translations[$index] : [];

                return [
                    'title' => is_string($translation['title'] ?? null) ? $translation['title'] : $item['title'],
                    'description' => is_string($translation['description'] ?? null) ? $translation['description'] : $item['description'],
                    'icon' => $item['icon'],
                ];
            })
            ->all();
    }

    /**
     * @return list<string>
     */
    private function splitBenefits(?string $benefits): array
    {
        return Str::of($benefits ?? '')
            ->replace("\r\n", "\n")
            ->explode("\n")
            ->map(fn (string $benefit): string => Str::squish($benefit))
            ->filter()
            ->values()
            ->all();
    }
}
