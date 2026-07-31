<?php

use App\Models\Service;
use Database\Seeders\ServiceSeeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;

it('switches the public site to Arabic and persists the choice', function () {
    $this->seed(ServiceSeeder::class);

    $this->get(route('home', ['lang' => 'ar']))
        ->assertSuccessful()
        ->assertSessionHas('locale', 'ar')
        ->assertSee('<html lang="ar" dir="rtl"', escape: false)
        ->assertSee('الرئيسية')
        ->assertSee('حلول دعم IT')
        ->assertSee('hreflang="en"', escape: false);

    $this->get(route('about'))
        ->assertSuccessful()
        ->assertSee('<html lang="ar" dir="rtl"', escape: false)
        ->assertSee('رؤيتنا');

    $this->get(route('home', ['lang' => 'en']))
        ->assertSuccessful()
        ->assertSessionHas('locale', 'en')
        ->assertSee('<html lang="en" dir="ltr"', escape: false)
        ->assertSee('Home');
});

it('renders every public page in Arabic while preserving technical names', function () {
    $this->seed(ServiceSeeder::class);

    $services = Service::query()->ordered()->get();
    $urls = [
        route('home'),
        route('about'),
        route('services.index'),
        route('contact'),
        ...$services->map(fn (Service $service): string => route('services.show', $service))->all(),
    ];

    foreach ($urls as $url) {
        $this->withSession(['locale' => 'ar'])
            ->get($url)
            ->assertSuccessful()
            ->assertSee('<html lang="ar" dir="rtl"', escape: false)
            ->assertSee('تواصل معنا');
    }

    $cybersecurity = $services->firstWhere('slug', 'cybersecurity');

    $this->withSession(['locale' => 'ar'])
        ->get(route('services.show', $cybersecurity))
        ->assertSuccessful()
        ->assertSee('المصادقة متعددة العوامل (MFA)')
        ->assertSee('Microsoft Defender')
        ->assertSee('Firewall');

    $microsoft365 = $services->firstWhere('slug', 'microsoft-365-services');

    $this->withSession(['locale' => 'ar'])
        ->get(route('services.show', $microsoft365))
        ->assertSuccessful()
        ->assertSee('Microsoft 365')
        ->assertSee('Exchange Online')
        ->assertSee('Microsoft Entra ID (Azure AD)');
});

it('uses Arabic validation messages on the public contact form', function () {
    $this->withSession(['locale' => 'ar'])
        ->from(route('contact'))
        ->post(route('contact.store'), [])
        ->assertRedirect(route('contact'))
        ->assertSessionHasErrors(['name', 'email', 'phone_local', 'subject', 'message']);

    $this->withSession(['locale' => 'ar'])
        ->get(route('contact'))
        ->assertSuccessful()
        ->assertSee('حقل الاسم مطلوب.')
        ->assertSee('راجع الحقول المحددة باللون الأحمر.');
});

it('keeps the admin interface on the default English locale', function () {
    $this->withSession(['locale' => 'ar'])
        ->get(route('admin.login'))
        ->assertSuccessful()
        ->assertSee('<html lang="en"', escape: false)
        ->assertDontSee('dir="rtl"', escape: false);
});

it('keeps the English and Arabic public translation catalogs in sync', function () {
    $englishKeys = array_keys(Arr::dot(Lang::get('public', [], 'en')));
    $arabicKeys = array_keys(Arr::dot(Lang::get('public', [], 'ar')));

    expect($arabicKeys)->toBe($englishKeys);
});

it('provides complete Arabic content for every seeded service', function () {
    $this->seed(ServiceSeeder::class);
    App::setLocale('ar');

    Service::query()->ordered()->get()->each(function (Service $service): void {
        expect($service->localizedName())->not->toBe($service->name)
            ->and($service->localizedExcerpt())->not->toBe($service->excerpt)
            ->and($service->localizedDescription())->not->toBe($service->description)
            ->and($service->localizedBenefitList())->toHaveCount(count($service->benefitList()))
            ->and($service->localizedServiceItems())->toHaveCount(count($service->serviceItems()))
            ->and($service->localizedReasons())->toHaveCount(count($service->reasons()))
            ->and($service->localizedStatement())->not->toBe($service->statement());
    });
});
