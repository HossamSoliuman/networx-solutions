<?php

use App\Models\Service;
use App\Models\Setting;

it('serves an llms.txt summary for ai crawlers', function () {
    $service = Service::factory()->create(['name' => 'Managed IT Support']);
    Setting::set('ai_summary', 'Networx Solutions provides managed IT services.');

    $this->get('/llms.txt')
        ->assertSuccessful()
        ->assertHeader('Content-Type', 'text/plain; charset=UTF-8')
        ->assertSee('Networx Solutions provides managed IT services.')
        ->assertSee('Managed IT Support')
        ->assertSee(route('services.show', $service));
});

it('serves a sitemap covering public pages and active services', function () {
    $active = Service::factory()->create();
    $inactive = Service::factory()->create(['is_active' => false]);

    $this->get('/sitemap.xml')
        ->assertSuccessful()
        ->assertSee(route('home'))
        ->assertSee(route('contact'))
        ->assertSee(route('services.show', $active))
        ->assertDontSee(route('services.show', $inactive));
});

it('welcomes ai crawlers in robots.txt by default', function () {
    $this->get('/robots.txt')
        ->assertSuccessful()
        ->assertSee('Disallow: /admin')
        ->assertSee('AI assistants and crawlers are welcome')
        ->assertSee('Sitemap: '.route('seo.sitemap'));
});

it('blocks ai crawlers in robots.txt when disabled', function () {
    Setting::set('ai_allow_crawlers', '0');

    $this->get('/robots.txt')
        ->assertSuccessful()
        ->assertSee('User-agent: GPTBot')
        ->assertSee('User-agent: ClaudeBot')
        ->assertDontSee('welcome');
});

it('embeds structured data and seo meta on public pages', function () {
    Setting::set('seo_meta_description', 'Managed IT support and networking in Riyadh.');
    Setting::set('seo_keywords', 'it support, networking');

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee('application/ld+json', escape: false)
        ->assertSee('"@type":"Organization"', escape: false)
        ->assertSee('Managed IT support and networking in Riyadh.')
        ->assertSee('name="keywords"', escape: false);
});
