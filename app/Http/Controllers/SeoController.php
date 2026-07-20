<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Response;

class SeoController extends Controller
{
    /**
     * Crawlers used by AI assistants (ChatGPT, Claude, Perplexity, Gemini, …).
     *
     * @var list<string>
     */
    private const AI_CRAWLERS = [
        'GPTBot',
        'ChatGPT-User',
        'OAI-SearchBot',
        'ClaudeBot',
        'Claude-User',
        'Claude-SearchBot',
        'anthropic-ai',
        'PerplexityBot',
        'Perplexity-User',
        'Google-Extended',
        'Amazonbot',
        'Applebot-Extended',
        'meta-externalagent',
        'CCBot',
    ];

    /**
     * Crawler rules; AI crawlers are blocked when the admin turns them off.
     */
    public function robots(): Response
    {
        $lines = [
            'User-agent: *',
            'Disallow: /admin',
            '',
        ];

        if (Setting::get('ai_allow_crawlers', '1') === '0') {
            foreach (self::AI_CRAWLERS as $crawler) {
                array_push($lines, "User-agent: {$crawler}", 'Disallow: /', '');
            }
        } else {
            $lines = ['# AI assistants and crawlers are welcome. See /llms.txt for a summary.', ...$lines];
        }

        $lines[] = 'Sitemap: '.route('seo.sitemap');

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }

    /**
     * Every public page, for search engines and AI crawlers alike.
     */
    public function sitemap(): Response
    {
        $entries = [
            [route('home'), null],
            [route('services.index'), null],
            [route('about'), null],
            [route('contact'), null],
        ];

        foreach (Service::query()->active()->ordered()->get(['slug', 'updated_at']) as $service) {
            $entries[] = [route('services.show', $service), $service->updated_at];
        }

        $urls = collect($entries)
            ->map(function (array $entry): string {
                [$location, $modifiedAt] = $entry;
                $lastmod = $modifiedAt ? '<lastmod>'.$modifiedAt->toDateString().'</lastmod>' : '';

                return "  <url><loc>{$location}</loc>{$lastmod}</url>";
            })
            ->implode("\n");

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n"
            .'<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n"
            .$urls."\n"
            .'</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml; charset=UTF-8']);
    }

    /**
     * The llms.txt summary AI crawlers read to describe the company
     * (https://llmstxt.org).
     */
    public function llms(): Response
    {
        $site = Setting::siteValues();
        $services = Service::query()->active()->ordered()->get(['name', 'slug', 'excerpt']);

        $lines = [
            "# {$site['site_name']}",
            '',
            "> {$site['tagline']}",
            '',
            $site['ai_summary'] ?: $site['about_intro'],
            '',
            '## Services',
            '',
            ...$services->map(fn (Service $service): string => sprintf(
                '- [%s](%s): %s',
                $service->name,
                route('services.show', $service),
                str($service->excerpt ?? '')->squish(),
            )),
            '',
            '## About',
            '',
            $site['about_story'],
            '',
            '## Contact',
            '',
            "- Website: {$site['website']}",
            "- Email: {$site['contact_email']}",
            "- Phone: {$site['contact_phone']}",
            "- Address: {$site['address']}",
            '- Contact form: '.route('contact'),
        ];

        return response(implode("\n", $lines), 200, ['Content-Type' => 'text/plain; charset=UTF-8']);
    }
}
