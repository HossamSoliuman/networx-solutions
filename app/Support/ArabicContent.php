<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class ArabicContent
{
    public const STORAGE_KEY = 'arabic_content';

    /**
     * @var array<string, array{label: string, icon: string, groups: list<array{title: string, description: string, source: string, path: string}>}>
     */
    private const SECTION_DEFINITIONS = [
        'home' => [
            'label' => 'Home',
            'icon' => 'home',
            'groups' => [
                ['title' => 'Hero content', 'description' => 'The main Arabic heading and introduction at the top of the home page.', 'source' => 'site', 'path' => 'home'],
                ['title' => 'Home page sections', 'description' => 'Labels, cards, supporting copy, and calls to action throughout the home page.', 'source' => 'public', 'path' => 'home'],
            ],
        ],
        'about' => [
            'label' => 'About',
            'icon' => 'building',
            'groups' => [
                ['title' => 'Page introduction', 'description' => 'The Arabic page heading, introduction, and company story.', 'source' => 'site', 'path' => 'about'],
                ['title' => 'About page sections', 'description' => 'Vision, mission, values, and supporting Arabic content.', 'source' => 'public', 'path' => 'about'],
            ],
        ],
        'services' => [
            'label' => 'Services',
            'icon' => 'grid',
            'groups' => [
                ['title' => 'Services introduction', 'description' => 'The Arabic title and introduction shared by service sections.', 'source' => 'site', 'path' => 'services'],
                ['title' => 'Services catalogue', 'description' => 'The Arabic content on the main services page.', 'source' => 'public', 'path' => 'services'],
                ['title' => 'Service detail pages', 'description' => 'Shared buttons, headings, and calls to action on individual service pages.', 'source' => 'public', 'path' => 'service'],
            ],
        ],
        'contact' => [
            'label' => 'Contact',
            'icon' => 'envelope',
            'groups' => [
                ['title' => 'Page introduction', 'description' => 'The Arabic heading and introduction at the top of the contact page.', 'source' => 'site', 'path' => 'contact'],
                ['title' => 'Contact form and messages', 'description' => 'Arabic field labels, guidance, validation prompts, and success messages.', 'source' => 'public', 'path' => 'contact'],
            ],
        ],
        'shared' => [
            'label' => 'Shared content',
            'icon' => 'globe',
            'groups' => [
                ['title' => 'Company details', 'description' => 'Arabic company details displayed across the public site.', 'source' => 'site', 'path' => 'company'],
                ['title' => 'Calls to action', 'description' => 'Arabic call-to-action content reused across pages.', 'source' => 'site', 'path' => 'cta'],
                ['title' => 'Navigation', 'description' => 'Arabic labels for the website navigation.', 'source' => 'public', 'path' => 'navigation'],
                ['title' => 'Footer', 'description' => 'Arabic footer headings, descriptions, and legal copy.', 'source' => 'public', 'path' => 'footer'],
                ['title' => 'Language selector', 'description' => 'Labels used by the language switcher.', 'source' => 'public', 'path' => 'locale'],
                ['title' => 'Accessibility labels', 'description' => 'Arabic descriptions used by screen readers and assistive technology.', 'source' => 'public', 'path' => 'accessibility'],
            ],
        ],
        'seo' => [
            'label' => 'SEO & AI',
            'icon' => 'search',
            'groups' => [
                ['title' => 'Arabic search metadata', 'description' => 'Arabic page metadata, keywords, and the summary used by AI search tools.', 'source' => 'site', 'path' => 'seo'],
            ],
        ],
    ];

    /**
     * @return array<string, array{label: string, icon: string, groups: list<array{title: string, description: string, fields: list<array{path: string, validation_key: string, name: string, id: string, label: string, value: string, rows: int}>}>}>
     */
    public function sections(): array
    {
        $values = $this->values();
        $sections = [];

        foreach (self::SECTION_DEFINITIONS as $sectionKey => $definition) {
            $groups = [];

            foreach ($definition['groups'] as $group) {
                $groups[] = [
                    'title' => $group['title'],
                    'description' => $group['description'],
                    'fields' => $this->fieldsForGroup($values, $group['source'], $group['path']),
                ];
            }

            $sections[$sectionKey] = [
                'label' => $definition['label'],
                'icon' => $definition['icon'],
                'groups' => $groups,
            ];
        }

        return $sections;
    }

    /**
     * @return list<string>
     */
    public function editablePaths(): array
    {
        return collect($this->sections())
            ->flatMap(fn (array $section): array => $section['groups'])
            ->flatMap(fn (array $group): array => $group['fields'])
            ->pluck('path')
            ->values()
            ->all();
    }

    /**
     * @param  array<string, mixed>  $translations
     */
    public function save(array $translations): void
    {
        $content = [];

        foreach ($this->editablePaths() as $path) {
            $value = data_get($translations, $path);

            if (is_string($value)) {
                Arr::set($content, $path, trim($value));
            }
        }

        Setting::set(self::STORAGE_KEY, json_encode($content, JSON_THROW_ON_ERROR | JSON_UNESCAPED_UNICODE));
    }

    public function applyOverrides(): void
    {
        $defaults = $this->defaults();

        foreach (array_keys($defaults) as $group) {
            Lang::get($group, [], 'ar');
        }

        Lang::addLines(Arr::dot($defaults), 'ar');
        Lang::addLines(Arr::dot($this->overrides()), 'ar');
    }

    /**
     * @return array<string, mixed>
     */
    public function values(): array
    {
        return array_replace_recursive($this->defaults(), $this->overrides());
    }

    /**
     * @return array{site: array<string, mixed>, public: array<string, mixed>}
     */
    private function defaults(): array
    {
        return [
            'site' => require lang_path('ar/site.php'),
            'public' => require lang_path('ar/public.php'),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function overrides(): array
    {
        $content = Setting::get(self::STORAGE_KEY);

        if (! is_string($content) || $content === '') {
            return [];
        }

        $decoded = json_decode($content, true);

        return is_array($decoded) ? $decoded : [];
    }

    /**
     * @param  array<string, mixed>  $values
     * @return list<array{path: string, validation_key: string, name: string, id: string, label: string, value: string, rows: int}>
     */
    private function fieldsForGroup(array $values, string $source, string $groupPath): array
    {
        $sourceValues = $values[$source] ?? [];
        $matchingValues = [];

        foreach (Arr::dot(is_array($sourceValues) ? $sourceValues : []) as $path => $value) {
            if (! is_string($value) || ! $this->matchesGroup($path, $source, $groupPath)) {
                continue;
            }

            $segments = explode('.', $path);

            if (in_array(end($segments), ['icon', 'number'], true)) {
                continue;
            }

            $fullPath = "{$source}.{$path}";
            $matchingValues[] = [
                'path' => $fullPath,
                'validation_key' => "translations.{$fullPath}",
                'name' => $this->inputName($fullPath),
                'id' => 'arabic-'.str_replace(['.', '_'], '-', $fullPath),
                'label' => $this->fieldLabel($path, $groupPath),
                'value' => $value,
                'rows' => Str::length($value) > 100 ? 4 : 2,
            ];
        }

        return $matchingValues;
    }

    private function matchesGroup(string $path, string $source, string $groupPath): bool
    {
        if ($source === 'public') {
            return $path === $groupPath || Str::startsWith($path, "{$groupPath}.");
        }

        return match ($groupPath) {
            'home' => Str::startsWith($path, 'home_'),
            'about' => Str::startsWith($path, 'about_'),
            'services' => Str::startsWith($path, 'services_'),
            'contact' => Str::startsWith($path, 'contact_'),
            'cta' => Str::startsWith($path, 'cta_'),
            'seo' => in_array($path, ['seo_meta_title', 'seo_meta_description', 'seo_keywords', 'ai_summary'], true),
            'company' => in_array($path, ['tagline', 'address'], true),
            default => false,
        };
    }

    private function inputName(string $path): string
    {
        return 'translations['.str_replace('.', '][', $path).']';
    }

    private function fieldLabel(string $path, string $groupPath): string
    {
        $relativePath = Str::after($path, "{$groupPath}.");
        $segments = explode('.', $relativePath);
        $labels = [];

        foreach ($segments as $segment) {
            $labels[] = ctype_digit($segment)
                ? 'Item '.((int) $segment + 1)
                : Str::headline($segment);
        }

        return implode(' · ', $labels);
    }
}
