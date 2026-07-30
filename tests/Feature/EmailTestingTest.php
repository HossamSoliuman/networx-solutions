<?php

use App\Mail\HostingerTestMail;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->user = User::factory()->create();

    config([
        'mail.default' => 'smtp',
        'mail.mailers.smtp.host' => 'smtp.hostinger.com',
        'mail.mailers.smtp.port' => 465,
        'mail.mailers.smtp.scheme' => 'smtps',
        'mail.mailers.smtp.username' => 'm-abdellah@networx-solutions.com',
        'mail.mailers.smtp.password' => 'secret',
        'mail.from.address' => 'm-abdellah@networx-solutions.com',
    ]);
});

it('sends a Hostinger test email and saves the recipient', function () {
    Mail::fake();

    $this->actingAs($this->user)
        ->post(route('admin.settings.email.test'), [
            'mail_test_recipient' => 'mohamed@example.com',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Setting::get('mail_test_recipient'))->toBe('mohamed@example.com');

    Mail::assertSent(
        HostingerTestMail::class,
        fn (HostingerTestMail $mail): bool => $mail->hasTo('mohamed@example.com')
            && $mail->hasSubject('Networx Solutions email test'),
    );
});

it('validates the test recipient', function () {
    Mail::fake();

    $this->actingAs($this->user)
        ->post(route('admin.settings.email.test'), [
            'mail_test_recipient' => 'not-an-email',
        ])
        ->assertSessionHasErrors('mail_test_recipient');

    Mail::assertNothingSent();
});

it('does not report success when SMTP configuration is incomplete', function () {
    Mail::fake();
    config(['mail.mailers.smtp.password' => null]);

    $this->actingAs($this->user)
        ->post(route('admin.settings.email.test'), [
            'mail_test_recipient' => 'mohamed@example.com',
        ])
        ->assertRedirect()
        ->assertSessionHas('error');

    expect(Setting::get('mail_test_recipient'))->toBe('mohamed@example.com');
    Mail::assertNothingSent();
});

it('requires authentication to access email testing', function () {
    $this->get(route('admin.settings.edit', 'email'))
        ->assertRedirect(route('admin.login'));

    $this->post(route('admin.settings.email.test'), [
        'mail_test_recipient' => 'mohamed@example.com',
    ])->assertRedirect(route('admin.login'));
});

it('renders the test mailable content', function () {
    $mailable = new HostingerTestMail('Admin User');

    $mailable
        ->assertHasSubject('Networx Solutions email test')
        ->assertSeeInHtml('Your Hostinger email is working.')
        ->assertSeeInHtml('Admin User');
});
