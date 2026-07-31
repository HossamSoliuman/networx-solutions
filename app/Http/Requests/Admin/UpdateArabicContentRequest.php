<?php

namespace App\Http\Requests\Admin;

use App\Support\ArabicContent;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateArabicContentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(ArabicContent $arabicContent): array
    {
        $rules = [
            'translations' => ['required', 'array'],
            'translations.site' => ['required', 'array'],
            'translations.public' => ['required', 'array'],
        ];

        foreach ($arabicContent->editablePaths() as $path) {
            $rules["translations.{$path}"] = ['required', 'string', 'max:5000'];
        }

        return $rules;
    }
}
