<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PlanRequest;
use App\Models\Service;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanRequestController extends Controller
{
    /**
     * The pricing plan leads captured from the website.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['status', 'service_id', 'q', 'sort']);

        return view('admin.plan-requests.index', [
            'planRequests' => PlanRequest::query()
                ->with('service')
                ->filter($filters)
                ->paginate(20)
                ->withQueryString(),
            'services' => Service::query()->ordered()->get(['id', 'name']),
            'filters' => $filters,
            'statusCounts' => PlanRequest::query()
                ->selectRaw('status, count(*) as total')
                ->groupBy('status')
                ->pluck('total', 'status'),
            'totalCount' => PlanRequest::query()->count(),
        ]);
    }

    /**
     * Show a single request and mark it as read.
     */
    public function show(PlanRequest $planRequest): View
    {
        $planRequest->markAsRead();

        return view('admin.plan-requests.show', [
            'planRequest' => $planRequest->load(['service', 'plan']),
        ]);
    }

    /**
     * Save the internal follow-up note.
     */
    public function update(Request $request, PlanRequest $planRequest): RedirectResponse
    {
        $validated = $request->validate([
            'admin_note' => ['nullable', 'string', 'max:5000'],
        ]);

        $planRequest->update($validated);

        return back()->with('success', 'Note saved.');
    }

    /**
     * Delete a request.
     */
    public function destroy(PlanRequest $planRequest): RedirectResponse
    {
        $planRequest->delete();

        return redirect()
            ->route('admin.plan-requests.index')
            ->with('success', "Request {$planRequest->reference} deleted.");
    }
}
