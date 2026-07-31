<?php

use App\Models\Setting;
use App\Models\User;
use App\Support\ArabicContent;
use Illuminate\Support\Arr;

beforeEach(function () {
    $this->user = User::factory()->create();
});

it('requires authentication to manage Arabic content', function () {
    $this->get(route('admin.arabic-content.edit'))
        ->assertRedirect(route('admin.login'));
});

it('organizes Arabic content into website section tabs', function () {
    $this->actingAs($this->user)
        ->get(route('admin.arabic-content.edit'))
        ->assertSuccessful()
        ->assertSee('Arabic review workspace')
        ->assertSee('Home')
        ->assertSee('About')
        ->assertSee('Services')
        ->assertSee('Contact')
        ->assertSee('Shared content')
        ->assertSee('SEO &amp; AI', escape: false)
        ->assertSee('dir="rtl"', escape: false)
        ->assertSee('الرئيسية');
});

it('saves reviewed Arabic content and renders it on the Arabic site', function () {
    $arabicContent = app(ArabicContent::class);
    $translations = $arabicContent->values();

    Arr::set($translations, 'site.home_title', 'عنوان عربي راجعه العميل');
    Arr::set($translations, 'public.navigation.home', 'بداية الموقع');

    $this->actingAs($this->user)
        ->put(route('admin.arabic-content.update'), [
            'translations' => $translations,
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    $storedContent = json_decode((string) Setting::get(ArabicContent::STORAGE_KEY), true, flags: JSON_THROW_ON_ERROR);

    expect(data_get($storedContent, 'site.home_title'))->toBe('عنوان عربي راجعه العميل')
        ->and(data_get($storedContent, 'public.navigation.home'))->toBe('بداية الموقع');

    $this->withSession(['locale' => 'ar'])
        ->get(route('home'))
        ->assertSuccessful()
        ->assertSee('عنوان عربي راجعه العميل')
        ->assertSee('بداية الموقع');

    $this->withSession(['locale' => 'en'])
        ->get(route('home'))
        ->assertSuccessful()
        ->assertDontSee('عنوان عربي راجعه العميل')
        ->assertSee('Home');
});

it('validates every editable Arabic content field', function () {
    $translations = app(ArabicContent::class)->values();
    Arr::set($translations, 'public.contact.send', '');

    $this->actingAs($this->user)
        ->from(route('admin.arabic-content.edit'))
        ->put(route('admin.arabic-content.update'), [
            'translations' => $translations,
        ])
        ->assertRedirect(route('admin.arabic-content.edit'))
        ->assertSessionHasErrors('translations.public.contact.send');
});
