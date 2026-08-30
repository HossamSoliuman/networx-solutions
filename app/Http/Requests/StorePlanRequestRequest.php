<?php

namespace App\Http\Requests;

use App\Enums\BillingPeriod;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class StorePlanRequestRequest extends FormRequest
{
    /**
     * Validation errors stay in their own bag so they never reopen the
     * unrelated contact modal on the same page.
     */
    protected $errorBag = 'planRequest';

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
        return [
            'service_plan_id' => ['required', 'integer', 'exists:service_plans,id'],
            'billing_period' => ['required', Rule::enum(BillingPeriod::class)],
            'name' => ['nullable', 'string', 'max:255'],
            'phone' => [
                'nullable', 'required_without:email', 'string', 'min:6', 'max:30',
                'regex:/^\+?[0-9][0-9 .()-]*$/',
            ],
            'email' => ['nullable', 'required_without:phone', 'email', 'max:255'],
            'note' => ['nullable', 'string', 'max:2000'],
            'company_fax' => ['prohibited'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'company_fax.prohibited' => __('public.pricing.request.submission_failed'),
            'phone.required_without' => __('public.pricing.request.contact_required'),
            'email.required_without' => __('public.pricing.request.contact_required'),
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
            'phone' => __('public.pricing.request.phone'),
            'email' => __('public.pricing.request.email'),
            'note' => __('public.pricing.request.note'),
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('phone')) {
            $this->merge(['phone' => Str::squish((string) $this->input('phone')) ?: null]);
        }
    }
}
