<?php

use App\Mail\NewContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

/**
 * @return array<string, mixed>
 */
function validContactPayload(array $overrides = []): array
{
    return [
        'name' => 'Ahmed Mostafa',
        'email' => 'ahmed@company.com',
        'phone_country' => '+20',
        'phone_local' => '1066405570',
        'company' => 'Acme Trading',
        'subject' => 'Office network installation quote',
        'message' => 'We are opening a new branch and need structured cabling for 40 desks.',
        ...$overrides,
    ];
}

beforeEach(function (): void {
    config()->set('services.recaptcha.enabled', false);
    config()->set('services.recaptcha.site_key', null);
    config()->set('services.recaptcha.secret_key', null);
    config()->set('services.recaptcha.threshold', 0.5);
    config()->set('services.recaptcha.action', 'contact');
});

it('stores a contact form submission and flashes the reference', function () {
    Mail::fake();

    $service = Service::factory()->create();

    $this->from(route('home'))
        ->post(route('contact.store'), validContactPayload(['service_id' => $service->id]))
        ->assertRedirect(route('home'))
        ->assertSessionHas('contact_success');

    $message = ContactMessage::query()->sole();

    expect($message->reference)->toMatch('/^NX-\d{2}-\d{5}$/')
        ->and($message->service_id)->toBe($service->id)
        ->and($message->phone)->toBe('+20 1066405570')
        ->and($message->ip_address)->not->toBeNull();
});

it('accepts formatted international phone numbers', function () {
    Mail::fake();

    $this->post(route('contact.store'), validContactPayload([
        'phone_local' => '+1(888)105-3639',
    ]))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('contact_success');

    expect(ContactMessage::query()->sole()->phone)->toBe('+1(888)105-3639');
});

it('emails the notification address when one is configured', function () {
    Mail::fake();

    Setting::set('notification_email', 'inbox@networx-solutions.com');

    $this->post(route('contact.store'), validContactPayload());

    Mail::assertQueued(
        NewContactMessageMail::class,
        fn (NewContactMessageMail $mail) => $mail->hasTo('inbox@networx-solutions.com'),
    );
});

it('sends no notification when the setting is empty', function () {
    Mail::fake();

    $this->post(route('contact.store'), validContactPayload());

    Mail::assertNothingQueued();
});

it('rejects submissions that fill the honeypot field', function () {
    $this->post(route('contact.store'), validContactPayload(['company_fax' => '123456']))
        ->assertSessionHasErrors('company_fax');

    expect(ContactMessage::query()->count())->toBe(0);
});

it('verifies recaptcha when configured', function () {
    Mail::fake();
    Http::preventStrayRequests();
    Http::fake([
        'www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => true,
            'score' => 0.9,
            'action' => 'contact',
        ]),
    ]);

    config()->set('services.recaptcha.enabled', true);
    config()->set('services.recaptcha.secret_key', 'secret-key');
    config()->set('services.recaptcha.threshold', 0.5);
    config()->set('services.recaptcha.action', 'contact');

    $this->post(route('contact.store'), validContactPayload([
        'g-recaptcha-response' => 'valid-token',
    ]))
        ->assertSessionHasNoErrors()
        ->assertSessionHas('contact_success');

    Http::assertSent(function (Request $request): bool {
        return $request->url() === 'https://www.google.com/recaptcha/api/siteverify'
            && $request->data()['secret'] === 'secret-key'
            && $request->data()['response'] === 'valid-token';
    });

    expect(ContactMessage::query()->count())->toBe(1);
});

it('rejects submissions with a failing recaptcha score', function () {
    Mail::fake();
    Http::preventStrayRequests();
    Http::fake([
        'www.google.com/recaptcha/api/siteverify' => Http::response([
            'success' => true,
            'score' => 0.2,
            'action' => 'contact',
        ]),
    ]);

    config()->set('services.recaptcha.enabled', true);
    config()->set('services.recaptcha.secret_key', 'secret-key');
    config()->set('services.recaptcha.threshold', 0.5);
    config()->set('services.recaptcha.action', 'contact');

    $this->post(route('contact.store'), validContactPayload([
        'g-recaptcha-response' => 'low-score-token',
    ]))
        ->assertSessionHasErrors('g-recaptcha-response');

    Mail::assertNothingQueued();

    expect(ContactMessage::query()->count())->toBe(0);
});

it('validates required fields', function (string $field) {
    $this->post(route('contact.store'), validContactPayload([$field => null]))
        ->assertSessionHasErrors($field);
})->with(['name', 'email', 'phone_country', 'phone_local', 'subject', 'message']);

it('rejects unsupported country calling codes', function () {
    $this->post(route('contact.store'), validContactPayload(['phone_country' => '+999']))
        ->assertSessionHasErrors('phone_country');
});

it('explains honeypot rejections without claiming visible fields are invalid', function () {
    $this->followingRedirects()
        ->from(route('contact'))
        ->post(route('contact.store'), validContactPayload(['company_fax' => '123456']))
        ->assertSee("We couldn't send that enquiry.")
        ->assertDontSee('Check the fields outlined in red.');
});

it('explains recaptcha rejections without claiming visible fields are invalid', function () {
    config()->set('services.recaptcha.enabled', true);

    $this->followingRedirects()
        ->from(route('contact'))
        ->post(route('contact.store'), validContactPayload())
        ->assertSee("We couldn't send that enquiry.")
        ->assertDontSee('Check the fields outlined in red.');
});

it('renders recaptcha script and form attributes when configured', function () {
    config()->set('services.recaptcha.enabled', true);
    config()->set('services.recaptcha.site_key', 'site-key');
    config()->set('services.recaptcha.action', 'contact');

    $this->get(route('contact'))
        ->assertSuccessful()
        ->assertSee('https://www.google.com/recaptcha/api.js?render=site-key', escape: false)
        ->assertSee('data-recaptcha-site-key="site-key"', escape: false)
        ->assertSee('data-recaptcha-action="contact"', escape: false);
});

it('rejects a service that does not exist', function () {
    $this->post(route('contact.store'), validContactPayload(['service_id' => 999]))
        ->assertSessionHasErrors('service_id');
});

it('rate limits repeated submissions from one address', function () {
    foreach (range(1, 5) as $i) {
        $this->post(route('contact.store'), validContactPayload(['email' => "sender{$i}@company.com"]));
    }

    $this->post(route('contact.store'), validContactPayload())
        ->assertTooManyRequests();

    expect(ContactMessage::query()->count())->toBe(5);
});

it('renders the public home page with active services', function () {
    $active = Service::factory()->create(['name' => 'Cybersecurity']);
    $inactive = Service::factory()->inactive()->create(['name' => 'Hidden Service']);

    $this->get(route('home'))
        ->assertSuccessful()
        ->assertSee($active->name)
        ->assertDontSee($inactive->name);
});
