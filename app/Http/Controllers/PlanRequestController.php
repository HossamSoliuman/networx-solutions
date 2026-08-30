<?php

namespace App\Http\Controllers;

use App\Enums\BillingPeriod;
use App\Http\Requests\StorePlanRequestRequest;
use App\Mail\NewPlanRequestMail;
use App\Models\PlanRequest;
use App\Models\ServicePlan;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Throwable;

class PlanRequestController extends Controller
{
    /**
     * Capture a visitor who picked a pricing plan so the team can call back.
     */
    public function store(StorePlanRequestRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        /** @var ServicePlan $plan */
        $plan = ServicePlan::query()->with('service')->findOrFail($validated['service_plan_id']);
        $billingPeriod = BillingPeriod::from($validated['billing_period']);

        $planRequest = PlanRequest::query()->create([
            'service_id' => $plan->service_id,
            'service_plan_id' => $plan->id,
            'service_name' => $plan->service?->name,
            'plan_name' => $plan->name,
            'billing_period' => $billingPeriod,
            'plan_price' => $plan->priceFor($billingPeriod),
            'currency' => $plan->currency,
            'name' => $validated['name'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'email' => $validated['email'] ?? null,
            'note' => $validated['note'] ?? null,
            'locale' => App::currentLocale(),
            'ip_address' => $request->ip(),
            'user_agent' => (string) str($request->userAgent() ?? '')->limit(255, ''),
        ]);

        $this->notifyTeam($planRequest);

        return back()->with('plan_request_success', [
            'reference' => $planRequest->reference,
            'plan' => $plan->localizedName(),
        ]);
    }

    /**
     * Email the team about the lead. The request is already stored, so a mail
     * server that is unreachable must not cost the visitor their confirmation.
     */
    private function notifyTeam(PlanRequest $planRequest): void
    {
        $notificationEmail = Setting::get('notification_email');

        if (! $notificationEmail) {
            return;
        }

        try {
            Mail::to($notificationEmail)->send(new NewPlanRequestMail($planRequest));
        } catch (Throwable $exception) {
            Log::error('Could not send the plan request notification.', [
                'plan_request_id' => $planRequest->id,
                'exception' => $exception->getMessage(),
            ]);
        }
    }
}
