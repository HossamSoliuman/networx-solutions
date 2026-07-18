<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ServiceController extends Controller
{
    /**
     * List all services.
     */
    public function index(): View
    {
        return view('admin.services.index', [
            'services' => Service::query()
                ->ordered()
                ->withCount('contactMessages')
                ->get(),
        ]);
    }

    /**
     * Show the create form.
     */
    public function create(): View
    {
        return view('admin.services.create', ['service' => new Service]);
    }

    /**
     * Store a new service.
     */
    public function store(StoreServiceRequest $request): RedirectResponse
    {
        $serviceData = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $serviceData['image_path'] = $request->file('image')->store('services', 'public');
        }

        $service = Service::query()->create($serviceData);

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Service “{$service->name}” created.");
    }

    /**
     * Show the edit form.
     */
    public function edit(Service $service): View
    {
        return view('admin.services.edit', ['service' => $service]);
    }

    /**
     * Update a service.
     */
    public function update(UpdateServiceRequest $request, Service $service): RedirectResponse
    {
        $serviceData = $request->safe()->except('image');

        if ($request->hasFile('image')) {
            $newImagePath = $request->file('image')->store('services', 'public');
            $this->deleteManagedImage($service->image_path);
            $serviceData['image_path'] = $newImagePath;
        }

        $service->update($serviceData);

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Service “{$service->name}” updated.");
    }

    /**
     * Delete a service. Related messages keep their content; the link is nulled.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $this->deleteManagedImage($service->image_path);
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Service “{$service->name}” deleted.");
    }

    private function deleteManagedImage(?string $path): void
    {
        if ($path && ! Str::startsWith($path, 'images/')) {
            Storage::disk('public')->delete($path);
        }
    }
}
