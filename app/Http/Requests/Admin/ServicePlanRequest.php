<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Shared validation for creating and updating a service pricing plan.
 */
class ServicePlanRequest extends FormRequest
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
        return [
            'name' => ['required', 'string', 'max:255'],
            'name_ar' => ['nullable', 'string', 'max:255'],
            'icon' => ['required', 'string', 'max:50'],
            'accent_color' => ['required', 'string', 'regex:/^#[0-9a-fA-F]{6}$/'],
            'badge' => ['nullable', 'string', 'max:60'],
            'badge_ar' => ['nullable', 'string', 'max:60'],
            'capacity' => ['nullable', 'string', 'max:120'],
            'capacity_ar' => ['nullable', 'string', 'max:120'],
            'price_monthly' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'price_yearly' => ['nullable', 'numeric', 'min:0', 'max:99999999'],
            'price_suffix' => ['nullable', 'string', 'max:8'],
            'currency' => ['required', 'string', 'max:8'],
            'is_custom_price' => ['boolean'],
            'custom_price_label' => ['nullable', 'string', 'max:60'],
            'custom_price_label_ar' => ['nullable', 'string', 'max:60'],
            'features' => ['nullable', 'string', 'max:5000'],
            'features_ar' => ['nullable', 'string', 'max:5000'],
            'cta_label' => ['nullable', 'string', 'max:60'],
            'cta_label_ar' => ['nullable', 'string', 'max:60'],
            'is_featured' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:1000'],
            'is_active' => ['boolean'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_custom_price' => $this->boolean('is_custom_price'),
            'is_featured' => $this->boolean('is_featured'),
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}
