<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PlanRequestStatus;
use App\Http\Controllers\Controller;
use App\Models\PlanRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PlanRequestStatusController extends Controller
{
    /**
     * Move the plan request to a new follow-up status.
     */
    public function update(Request $request, PlanRequest $planRequest): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(PlanRequestStatus::class)],
        ]);

        $status = PlanRequestStatus::from($validated['status']);

        $planRequest->transitionTo($status);

        return back()->with('success', "Status changed to {$status->label()}.");
    }
}
