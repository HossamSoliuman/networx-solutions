<?php

namespace App\Models;

use Database\Factories\ServiceFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
}
