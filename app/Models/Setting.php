<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Setting extends Model
{
    /**
     * @var array<string, string>
     */
    public const SITE_DEFAULTS = [
        'site_name' => 'Networx Solutions',
        'tagline' => 'Connect • Secure • Empower',
        'contact_email' => 'info@networx-solutions.com',
        'contact_phone' => '+20 106 640 5570',
        'address' => 'Riyadh, Saudi Arabia',
        'website' => 'www.networx-solutions.com',
        'facebook_url' => '',
        'linkedin_url' => '',
        'instagram_url' => '',
        'home_eyebrow' => 'Infrastructure that works',
        'home_title' => 'Business technology, engineered to stay ready.',
        'home_intro' => 'Networx brings support, networks, cloud, security, and surveillance together under one accountable technology partner.',
        'home_image' => 'images/site/hero.jpg',
        'services_title' => 'One partner across your technology stack.',
        'services_intro' => 'Practical services designed around uptime, security, and the way your operation actually works.',
        'about_eyebrow' => 'Built for dependable operations',
        'about_title' => 'We make complex infrastructure feel straightforward.',
        'about_intro' => 'Networx Solutions plans, delivers, and supports the technology growing businesses rely on every day.',
        'about_story' => 'Our work starts with listening: how your teams operate, where risk is building, and what growth will demand next. From there, we design clear, maintainable systems and stay accountable after launch.',
        'about_image' => 'images/site/about.jpg',
        'contact_eyebrow' => 'Start a conversation',
        'contact_title' => 'Tell us what needs to work better.',
        'contact_intro' => 'Share the challenge, timeline, or service you have in mind. Our team will review it and respond with a practical next step.',
        'contact_image' => 'images/site/contact.jpg',
        'cta_title' => 'Ready for technology that keeps its promises?',
        'cta_intro' => 'Tell us where you are today. We will help map the clearest route forward.',
    ];

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        $settings = Cache::rememberForever('settings.all', function (): array {
            return self::query()->pluck('value', 'key')->all();
        });

        return $settings[$key] ?? $default;
    }

    public static function set(string $key, ?string $value): void
    {
        self::query()->updateOrCreate(['key' => $key], ['value' => $value]);

        Cache::forget('settings.all');
    }

    /**
     * @return array<string, string>
     */
    public static function siteValues(): array
    {
        $values = collect(self::SITE_DEFAULTS)
            ->mapWithKeys(fn (string $default, string $key): array => [
                $key => self::get($key, $default) ?? $default,
            ])
            ->all();

        foreach (['home_image', 'about_image', 'contact_image'] as $imageKey) {
            $values[$imageKey.'_url'] = self::publicImageUrl($values[$imageKey]);
        }

        return $values;
    }

    public static function publicImageUrl(string $path): string
    {
        return Str::startsWith($path, 'images/')
            ? asset($path)
            : Storage::disk('public')->url($path);
    }
}
