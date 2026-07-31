<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Setting extends Model
{
    /**
     * Public page copy and photography are fixed in code and cannot be overridden from settings.
     *
     * @var list<string>
     */
    private const PAGE_CONTENT_KEYS = [
        'home_eyebrow',
        'home_title',
        'home_intro',
        'home_image',
        'services_title',
        'services_intro',
        'about_eyebrow',
        'about_title',
        'about_intro',
        'about_story',
        'about_image',
        'contact_eyebrow',
        'contact_title',
        'contact_intro',
        'contact_image',
        'cta_title',
        'cta_intro',
    ];

    /**
     * @var array<string, string>
     */
    public const SITE_DEFAULTS = [
        'site_name' => 'Networx Solutions',
        'tagline' => 'Connect • Secure • Empower',
        'contact_email' => 'info@networx-solutions.com',
        'contact_phone' => '+20 106 640 5570',
        'address' => 'Cairo, Egypt',
        'website' => 'www.networx-solutions.com',
        'facebook_url' => 'https://facebook.com/networxsolutions',
        'linkedin_url' => 'https://www.linkedin.com/company/networx-solutions/',
        'instagram_url' => 'https://instagram.com/networx_solutions',
        'home_eyebrow' => 'Infrastructure that works',
        'home_title' => 'Connect. Secure. Empower.',
        'home_intro' => 'Networx Solutions brings support, networks, cloud, security, and surveillance together under one accountable technology partner.',
        'home_image' => 'images/site/hero.jpg',
        'services_title' => 'One partner across your technology stack.',
        'services_intro' => 'Practical services designed around uptime, security, and the way your operation actually works.',
        'about_eyebrow' => 'About us',
        'about_title' => 'Transforming businesses through integrated technology solutions.',
        'about_intro' => 'Based in Cairo, Egypt, Networx Solutions delivers comprehensive IT services that help businesses improve performance, strengthen security, and accelerate digital transformation through reliable, scalable technology solutions.',
        'about_story' => 'Networx Solutions is a Cairo-based IT company providing integrated IT services, including IT support, networking, cloud solutions, cybersecurity, CCTV & surveillance, and Microsoft 365. We help businesses build secure, reliable, and scalable IT environments that drive productivity, business continuity, and long-term growth.',
        'about_image' => 'images/site/about.jpg',
        'contact_eyebrow' => 'Start a conversation',
        'contact_title' => 'Tell us what needs to work better.',
        'contact_intro' => 'Share the challenge, timeline, or service you have in mind. Our team will review it and respond with a practical next step.',
        'contact_image' => 'images/site/contact.jpg',
        'cta_title' => 'Ready for technology that keeps its promises?',
        'cta_intro' => 'Tell us where you are today. We will help map the clearest route forward.',
        'seo_meta_title' => 'Networx Solutions · IT Support, Networks, Cloud, Security & Surveillance',
        'seo_meta_description' => 'Networx Solutions delivers managed IT support, networking, cloud, cybersecurity, and surveillance for growing businesses — one accountable technology partner.',
        'seo_keywords' => 'IT support, networking, cloud services, cybersecurity, CCTV surveillance, managed IT services',
        'ai_summary' => 'Networx Solutions is a business technology company providing managed IT support, network design and installation, cloud services, cybersecurity, and CCTV surveillance. It acts as a single accountable technology partner for growing businesses, planning, delivering, and supporting their infrastructure.',
        'ai_allow_crawlers' => '1',
    ];

    protected $fillable = [
        'key',
        'value',
    ];

    public static function get(string $key, ?string $default = null): ?string
    {
        $settings = self::cachedValues();

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
        $settings = self::cachedValues();

        $values = collect(self::SITE_DEFAULTS)
            ->mapWithKeys(function (string $default, string $key) use ($settings): array {
                $value = in_array($key, self::PAGE_CONTENT_KEYS, true)
                    ? $default
                    : ($settings[$key] ?? $default);

                return [$key => $value];
            })
            ->all();

        foreach (['home_image', 'about_image', 'contact_image'] as $imageKey) {
            $values[$imageKey.'_url'] = self::publicImageUrl($values[$imageKey]);
        }

        return $values;
    }

    /**
     * @return array<string, string>
     */
    public static function localizedSiteValues(): array
    {
        $values = self::siteValues();
        $translations = trans('site');

        if (! is_array($translations)) {
            return $values;
        }

        foreach ($translations as $key => $translation) {
            if (is_string($translation) && array_key_exists($key, $values)) {
                $values[$key] = $translation;
            }
        }

        return $values;
    }

    /**
     * @return array<string, string|null>
     */
    private static function cachedValues(): array
    {
        return Cache::rememberForever('settings.all', function (): array {
            return self::query()->pluck('value', 'key')->all();
        });
    }

    public static function publicImageUrl(string $path): string
    {
        return Str::startsWith($path, 'images/')
            ? asset($path)
            : Storage::disk('public')->url($path);
    }
}
