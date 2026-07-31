<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules for the section being saved.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return match ($this->route('section')) {
            'company' => [
                'site_name' => ['required', 'string', 'max:255'],
                'tagline' => ['nullable', 'string', 'max:255'],
                'contact_email' => ['required', 'email', 'max:255'],
                'contact_phone' => ['nullable', 'string', 'max:50'],
                'address' => ['nullable', 'string', 'max:255'],
                'website' => ['nullable', 'string', 'max:255'],
                'facebook_url' => ['nullable', 'url', 'max:255'],
                'linkedin_url' => ['nullable', 'url', 'max:255'],
                'instagram_url' => ['nullable', 'url', 'max:255'],
            ],
            'seo' => [
                'seo_meta_title' => ['nullable', 'string', 'max:255'],
                'seo_meta_description' => ['nullable', 'string', 'max:500'],
                'seo_keywords' => ['nullable', 'string', 'max:500'],
                'ai_summary' => ['nullable', 'string', 'max:2000'],
                'ai_allow_crawlers' => ['required', 'boolean'],
            ],
            'messaging' => [
                'notification_email' => ['nullable', 'email', 'max:255'],
                'mail_signature' => ['nullable', 'string', 'max:1000'],
            ],
            'email' => [
                'mail_test_recipient' => ['required', 'email', 'max:255'],
            ],
            default => abort(404),
        };
    }
}
