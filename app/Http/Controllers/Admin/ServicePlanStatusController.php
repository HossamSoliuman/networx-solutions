<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServicePlan;
use Illuminate\Http\RedirectResponse;

class ServicePlanStatusController extends Controller
{
    /**
     * Toggle whether the plan card is shown on the website.
     */
    public function update(Service $service, ServicePlan $plan): RedirectResponse
    {
        $plan->update(['is_active' => ! $plan->is_active]);

        return back()->with('success', $plan->is_active
            ? "Plan “{$plan->name}” is now visible on the website."
            : "Plan “{$plan->name}” is now hidden from the website.");
    }
}
