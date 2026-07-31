<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateArabicContentRequest;
use App\Models\Service;
use App\Support\ArabicContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArabicContentController extends Controller
{
    public function edit(ArabicContent $arabicContent): View
    {
        return view('admin.arabic-content.edit', [
            'sections' => $arabicContent->sections(),
            'services' => Service::query()->ordered()->get(['id', 'name', 'name_ar', 'slug']),
        ]);
    }

    public function update(UpdateArabicContentRequest $request, ArabicContent $arabicContent): RedirectResponse
    {
        $arabicContent->save($request->validated('translations'));

        return back()->with('success', 'Arabic content saved.');
    }
}
