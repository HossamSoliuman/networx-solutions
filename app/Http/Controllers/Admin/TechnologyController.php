<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTechnologyRequest;
use App\Http\Requests\Admin\UpdateTechnologyRequest;
use App\Models\Technology;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TechnologyController extends Controller
{
    /**
     * List every technology shown in the "Technologies we work with" section.
     */
    public function index(): View
    {
        return view('admin.technologies.index', [
            'technologies' => Technology::query()->ordered()->get(),
        ]);
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('admin.technologies.create', ['technology' => new Technology]);
    }

    /**
     * Store a new technology.
     */
    public function store(StoreTechnologyRequest $request): RedirectResponse
    {
        $technologyData = $request->safe()->except('logo');

        if ($request->hasFile('logo')) {
            $technologyData['logo_path'] = $request->file('logo')->store('technologies', 'public');
        }

        $technology = Technology::query()->create($technologyData);

        return redirect()
            ->route('admin.technologies.index')
            ->with('success', "Technology “{$technology->name}” created.");
    }

    /**
     * Show the edit form.
     */
    public function edit(Technology $technology): View
    {
        return view('admin.technologies.edit', ['technology' => $technology]);
    }

    /**
     * Update a technology.
     */
    public function update(UpdateTechnologyRequest $request, Technology $technology): RedirectResponse
    {
        $technologyData = $request->safe()->except('logo');

        if ($request->hasFile('logo')) {
            $newLogoPath = $request->file('logo')->store('technologies', 'public');
            $this->deleteManagedLogo($technology->logo_path);
            $technologyData['logo_path'] = $newLogoPath;
        }

        $technology->update($technologyData);

        return redirect()
            ->route('admin.technologies.index')
            ->with('success', "Technology “{$technology->name}” updated.");
    }

    /**
     * Delete a technology and its uploaded logo.
     */
    public function destroy(Technology $technology): RedirectResponse
    {
        $this->deleteManagedLogo($technology->logo_path);
        $technology->delete();

        return redirect()
            ->route('admin.technologies.index')
            ->with('success', "Technology “{$technology->name}” deleted.");
    }

    private function deleteManagedLogo(?string $path): void
    {
        if ($path && ! Str::startsWith($path, 'images/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
