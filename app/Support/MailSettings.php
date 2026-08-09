<?php

namespace App\Support;

use App\Models\Setting;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

/**
 * Resolves the outgoing SMTP mailbox password, preferring the one saved by an
 * administrator over the MAIL_PASSWORD environment value.
 */
class MailSettings
{
    public const PASSWORD_KEY = 'mail_password';

    /**
     * The password the mailer should authenticate with, or null when none is available.
     */
    public static function password(): ?string
    {
        return self::storedPassword() ?? self::environmentPassword();
    }

    /**
     * Encrypt and persist the mailbox password entered in the admin panel.
     */
    public static function storePassword(string $password): void
    {
        Setting::set(self::PASSWORD_KEY, Crypt::encryptString($password));
    }

    /**
     * Drop the saved password so the environment value takes over again.
     */
    public static function forgetPassword(): void
    {
        Setting::set(self::PASSWORD_KEY, null);
    }

    /**
     * Push the resolved password onto the runtime mail configuration.
     */
    public static function applyToConfig(): void
    {
        $password = self::storedPassword();

        if ($password !== null) {
            config(['mail.mailers.smtp.password' => $password]);
        }
    }

    public static function isReady(): bool
    {
        return self::configuration()['ready'];
    }

    /**
     * @return array{mailer: string, host: string, port: int, scheme: string, username: ?string, from_address: string, password_configured: bool, password_source: ?string, ready: bool}
     */
    public static function configuration(): array
    {
        $mailer = (string) config('mail.default');
        $host = (string) config('mail.mailers.smtp.host');
        $username = config('mail.mailers.smtp.username');
        $fromAddress = (string) config('mail.from.address');

        $storedPassword = self::storedPassword();
        $password = $storedPassword ?? self::environmentPassword();

        return [
            'mailer' => $mailer,
            'host' => $host,
            'port' => (int) config('mail.mailers.smtp.port'),
            'scheme' => (string) config('mail.mailers.smtp.scheme'),
            'username' => is_string($username) ? $username : null,
            'from_address' => $fromAddress,
            'password_configured' => $password !== null,
            'password_source' => match (true) {
                $storedPassword !== null => 'settings',
                $password !== null => 'environment',
                default => null,
            },
            'ready' => $mailer === 'smtp'
                && filled($host)
                && filled($username)
                && $password !== null
                && filled($fromAddress),
        ];
    }

    /**
     * The decrypted password saved from the admin panel, if any.
     */
    private static function storedPassword(): ?string
    {
        $encrypted = Setting::get(self::PASSWORD_KEY);

        if (blank($encrypted)) {
            return null;
        }

        try {
            return Crypt::decryptString($encrypted);
        } catch (DecryptException $exception) {
            report($exception);

            return null;
        }
    }

    private static function environmentPassword(): ?string
    {
        $password = config('mail.mailers.smtp.password');

        return is_string($password) && $password !== '' ? $password : null;
    }
}
