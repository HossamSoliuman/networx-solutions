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
            'pages' => [
                'home_eyebrow' => ['nullable', 'string', 'max:255'],
                'home_title' => ['nullable', 'string', 'max:255'],
                'home_intro' => ['nullable', 'string', 'max:1000'],
                'home_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'services_title' => ['nullable', 'string', 'max:255'],
                'services_intro' => ['nullable', 'string', 'max:1000'],
                'about_eyebrow' => ['nullable', 'string', 'max:255'],
                'about_title' => ['nullable', 'string', 'max:255'],
                'about_intro' => ['nullable', 'string', 'max:1000'],
                'about_story' => ['nullable', 'string', 'max:5000'],
                'about_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'contact_eyebrow' => ['nullable', 'string', 'max:255'],
                'contact_title' => ['nullable', 'string', 'max:255'],
                'contact_intro' => ['nullable', 'string', 'max:1000'],
                'contact_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
                'cta_title' => ['nullable', 'string', 'max:255'],
                'cta_intro' => ['nullable', 'string', 'max:1000'],
            ],
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
            default => abort(404),
        };
    }
}
