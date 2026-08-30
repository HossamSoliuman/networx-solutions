<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ServicePlanRequest;
use App\Models\Service;
use App\Models\ServicePlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ServicePlanController extends Controller
{
    /**
     * List the pricing plans belonging to a service.
     */
    public function index(Service $service): View
    {
        return view('admin.services.plans.index', [
            'service' => $service,
            'plans' => $service->plans()->ordered()->withCount('planRequests')->get(),
        ]);
    }

    /**
     * Show the create form.
     */
    public function create(Service $service): View
    {
        return view('admin.services.plans.create', [
            'service' => $service,
            'plan' => new ServicePlan(['sort_order' => $service->plans()->count()]),
        ]);
    }

    /**
     * Store a new plan for the service.
     */
    public function store(ServicePlanRequest $request, Service $service): RedirectResponse
    {
        $plan = $service->plans()->create($request->validated());

        return redirect()
            ->route('admin.services.plans.index', $service)
            ->with('success', "Plan “{$plan->name}” created.");
    }

    /**
     * Show the edit form.
     */
    public function edit(Service $service, ServicePlan $plan): View
    {
        return view('admin.services.plans.edit', [
            'service' => $service,
            'plan' => $plan,
        ]);
    }

    /**
     * Update a plan.
     */
    public function update(ServicePlanRequest $request, Service $service, ServicePlan $plan): RedirectResponse
    {
        $plan->update($request->validated());

        return redirect()
            ->route('admin.services.plans.index', $service)
            ->with('success', "Plan “{$plan->name}” updated.");
    }

    /**
     * Delete a plan. Existing requests keep the plan name they were sent with.
     */
    public function destroy(Service $service, ServicePlan $plan): RedirectResponse
    {
        $plan->delete();

        return redirect()
            ->route('admin.services.plans.index', $service)
            ->with('success', "Plan “{$plan->name}” deleted.");
    }
}
