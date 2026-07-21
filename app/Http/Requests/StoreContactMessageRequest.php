<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StoreContactMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $phoneCountryCodes = array_keys((array) config('contact.phone_country_codes', []));

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone_country' => ['required', 'string', Rule::in($phoneCountryCodes)],
            'phone_local' => ['required', 'string', 'min:6', 'max:30', 'regex:/^\+?[0-9][0-9 .()-]*$/'],
            'company' => ['nullable', 'string', 'max:255'],
            'subject' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
            'service_id' => ['nullable', 'integer', 'exists:services,id'],
            'company_fax' => ['prohibited'],
            'g-recaptcha-response' => [Rule::requiredIf($this->recaptchaEnabled()), 'nullable', 'string'],
        ];
    }

    /**
     * Get the "after" validation callables for the request.
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                if (! $this->recaptchaEnabled() || $validator->errors()->isNotEmpty()) {
                    return;
                }

                if (! $this->recaptchaPasses()) {
                    $validator->errors()->add('g-recaptcha-response', 'Your submission could not be processed.');
                }
            },
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'company_fax.prohibited' => 'Your submission could not be processed.',
            'g-recaptcha-response.required' => 'Your submission could not be processed.',
        ];
    }

    /**
     * Get custom attribute names for validation messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'phone_country' => 'country code',
            'phone_local' => 'phone number',
        ];
    }

    private function recaptchaEnabled(): bool
    {
        return (bool) config('services.recaptcha.enabled');
    }

    private function recaptchaPasses(): bool
    {
        try {
            $response = Http::asForm()
                ->timeout(5)
                ->connectTimeout(2)
                ->post('https://www.google.com/recaptcha/api/siteverify', [
                    'secret' => config('services.recaptcha.secret_key'),
                    'response' => $this->input('g-recaptcha-response'),
                    'remoteip' => $this->ip(),
                ]);
        } catch (ConnectionException) {
            return false;
        }

        if (! $response->successful()) {
            return false;
        }

        $verification = $response->json();

        return (bool) data_get($verification, 'success')
            && data_get($verification, 'action') === config('services.recaptcha.action')
            && (float) data_get($verification, 'score', 0) >= (float) config('services.recaptcha.threshold', 0.5);
    }
}
