<?php

use App\Mail\HostingerTestMail;
use App\Models\Setting;
use App\Models\User;
use App\Support\MailSettings;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    $this->user = User::factory()->create();

    config([
        'mail.default' => 'smtp',
        'mail.mailers.smtp.host' => 'smtp.hostinger.com',
        'mail.mailers.smtp.port' => 465,
        'mail.mailers.smtp.scheme' => 'smtps',
        'mail.mailers.smtp.username' => 'm-abdellah@networx-solutions.com',
        'mail.mailers.smtp.password' => null,
        'mail.from.address' => 'm-abdellah@networx-solutions.com',
    ]);
});

it('saves the mailbox password from the admin panel and stores it encrypted', function () {
    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'email'), [
            'mail_password' => 'hostinger-secret',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Setting::get(MailSettings::PASSWORD_KEY))
        ->not->toBeNull()
        ->not->toContain('hostinger-secret')
        ->and(MailSettings::password())->toBe('hostinger-secret');
});

it('keeps the saved password when the field is submitted blank', function () {
    MailSettings::storePassword('hostinger-secret');

    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'email'), [
            'mail_password' => '',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(MailSettings::password())->toBe('hostinger-secret');
});

it('removes the saved password and falls back to the environment value', function () {
    MailSettings::storePassword('hostinger-secret');
    config(['mail.mailers.smtp.password' => 'env-secret']);

    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'email'), [
            'remove_mail_password' => '1',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    expect(Setting::get(MailSettings::PASSWORD_KEY))->toBeNull()
        ->and(MailSettings::password())->toBe('env-secret');
});

it('applies the saved password to the mailer configuration', function () {
    config(['mail.mailers.smtp.password' => 'env-secret']);
    MailSettings::storePassword('hostinger-secret');

    app()->forgetInstance('mail.manager');
    app('mail.manager');

    expect(config('mail.mailers.smtp.password'))->toBe('hostinger-secret');
});

it('sends the test email when only the admin password is configured', function () {
    Mail::fake();
    MailSettings::storePassword('hostinger-secret');

    $this->actingAs($this->user)
        ->post(route('admin.settings.email.test'), [
            'mail_test_recipient' => 'mohamed@example.com',
        ])
        ->assertRedirect()
        ->assertSessionHas('success');

    Mail::assertSent(HostingerTestMail::class);
});

it('reports the password source on the email settings page', function () {
    $this->actingAs($this->user)
        ->get(route('admin.settings.edit', 'email'))
        ->assertSuccessful()
        ->assertSee('Not configured');

    MailSettings::storePassword('hostinger-secret');

    $this->actingAs($this->user)
        ->get(route('admin.settings.edit', 'email'))
        ->assertSuccessful()
        ->assertSee('Saved here')
        ->assertSee('Remove the saved password')
        ->assertDontSee('hostinger-secret');
});

it('rejects an over-long mailbox password', function () {
    $this->actingAs($this->user)
        ->put(route('admin.settings.update', 'email'), [
            'mail_password' => str_repeat('a', 256),
        ])
        ->assertSessionHasErrors('mail_password');

    expect(Setting::get(MailSettings::PASSWORD_KEY))->toBeNull();
});
