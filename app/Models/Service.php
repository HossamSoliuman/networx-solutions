<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Service extends Model
{
    /** @use HasFactory<ServiceFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'icon',
        'excerpt',
        'description',
        'image_path',
        'benefits',
        'details',
        'sort_order',
        'is_active',
    ];

    protected $attributes = [
        'icon' => 'cog',
        'sort_order' => 0,
        'is_active' => true,
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
            'sort_order' => 'integer',
            'details' => 'array',
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
        return Str::of($this->benefits ?? '')
            ->replace("\r\n", "\n")
            ->explode("\n")
            ->map(fn (string $benefit): string => Str::squish($benefit))
            ->filter()
            ->values()
            ->all();
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
        return $this->translatedString('name', $this->name);
    }

    public function localizedExcerpt(): string
    {
        return $this->translatedString('excerpt', $this->excerpt);
    }

    public function localizedDescription(): string
    {
        return $this->translatedString('description', $this->description ?? '');
    }

    /**
     * @return list<string>
     */
    public function localizedBenefitList(): array
    {
        $benefits = $this->benefitList();
        $translations = $this->translatedArray('benefits');

        if ($translations === null) {
            return $benefits;
        }

        return collect($benefits)
            ->map(fn (string $benefit, int $index): string => is_string($translations[$index] ?? null)
                ? $translations[$index]
                : $benefit)
            ->all();
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

    public function localizedStatement(): ?string
    {
        $statement = $this->statement();

        return $statement === null ? null : $this->translatedString('statement', $statement);
    }

    private function translatedString(string $key, string $fallback): string
    {
        $translationKey = "services.catalog.{$this->slug}.{$key}";

        return Lang::has($translationKey) ? trans($translationKey) : $fallback;
    }

    /**
     * @return array<mixed>|null
     */
    private function translatedArray(string $key): ?array
    {
        $translationKey = "services.catalog.{$this->slug}.{$key}";
        $translation = Lang::has($translationKey) ? trans($translationKey) : null;

        return is_array($translation) ? $translation : null;
    }

    /**
     * @param  list<array{title: string, description: string, icon: string}>  $items
     * @return list<array{title: string, description: string, icon: string}>
     */
    private function localizedDetailItems(string $key, array $items): array
    {
        $translations = $this->translatedArray($key);

        if ($translations === null) {
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
}
