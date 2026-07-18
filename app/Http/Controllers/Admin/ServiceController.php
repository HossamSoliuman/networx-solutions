<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreServiceRequest;
use App\Http\Requests\Admin\UpdateServiceRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
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
        $service = Service::query()->create($request->validated());

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
        $service->update($request->validated());

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Service “{$service->name}” updated.");
    }

    /**
     * Delete a service. Related messages keep their content; the link is nulled.
     */
    public function destroy(Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', "Service “{$service->name}” deleted.");
    }
}
