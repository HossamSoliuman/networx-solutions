<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreServiceRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:services,slug'],
            'icon' => ['required', 'string', 'max:50'],
            'excerpt' => ['required', 'string', 'max:255'],
            'excerpt_ar' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'description_ar' => ['nullable', 'string', 'max:5000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'benefits' => ['nullable', 'string', 'max:5000'],
            'benefits_ar' => ['nullable', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:1000'],
            'is_active' => ['boolean'],
            'pricing_enabled' => ['boolean'],
            'pricing_eyebrow' => ['nullable', 'string', 'max:255'],
            'pricing_eyebrow_ar' => ['nullable', 'string', 'max:255'],
            'pricing_title' => ['nullable', 'string', 'max:255'],
            'pricing_title_ar' => ['nullable', 'string', 'max:255'],
            'pricing_subtitle' => ['nullable', 'string', 'max:255'],
            'pricing_subtitle_ar' => ['nullable', 'string', 'max:255'],
            'pricing_yearly_note' => ['nullable', 'string', 'max:255'],
            'pricing_yearly_note_ar' => ['nullable', 'string', 'max:255'],
            'pricing_footnote' => ['nullable', 'string', 'max:1000'],
            'pricing_footnote_ar' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::slug($this->input('slug') ?: $this->input('name', '')),
            'is_active' => $this->boolean('is_active'),
            'pricing_enabled' => $this->boolean('pricing_enabled'),
        ]);
    }
}
