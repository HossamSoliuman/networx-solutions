Plan request notification

Someone chose a pricing plan and asked to be contacted.

Reference: {{ $planRequest->reference }}
Service: {{ $planRequest->service_name ?? '—' }}
Plan: {{ $planRequest->plan_name }} ({{ $planRequest->billing_period->label() }})
Received at: {{ $planRequest->created_at->format('M j, Y g:i A T') }}

Sign in to the Networx Solutions admin panel to see the contact details:
{{ route('admin.plan-requests.show', $planRequest) }}
