<?php

use App\Mail\NewContactMessageMail;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\Setting;
use Illuminate\Support\Facades\Mail;

/**
 * @return array<string, mixed>
 */
function validContactPayload(array $overrides = []): array
{
    return [
        'name' => 'Ahmed Mostafa',
        'email' => 'ahmed@company.com',
        'phone' => '+201066405570',
        'company' => 'Acme Trading',
        'subject' => 'Office network installation quote',
        'message' => 'We are opening a new branch and need structured cabling for 40 desks.',
        ...$overrides,
    ];
}

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
        ->and($message->ip_address)->not->toBeNull();
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
    $this->post(route('contact.store'), validContactPayload(['website' => 'https://spam.example']))
        ->assertSessionHasErrors('website');

    expect(ContactMessage::query()->count())->toBe(0);
});

it('validates required fields', function (string $field) {
    $this->post(route('contact.store'), validContactPayload([$field => null]))
        ->assertSessionHasErrors($field);
})->with(['name', 'email', 'subject', 'message']);

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
