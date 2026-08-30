<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Plan request notification</title>
</head>

<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                    style="max-width:600px;width:100%;background-color:#ffffff;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="background-color:#071429;padding:28px 32px;">
                            <p style="margin:0;font-size:20px;font-weight:bold;letter-spacing:2px;color:#ffffff;">
                                NETWORX <span style="color:#5a8ffa;font-weight:normal;">SOLUTIONS</span>
                            </p>
                            <p style="margin:6px 0 0;font-size:12px;color:#8ab4ff;">Plan request notification</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <div style="display:inline-block;border-radius:999px;background-color:#eff6ff;padding:6px 12px;font-size:12px;font-weight:bold;color:#1d4ed8;">
                                Call back requested
                            </div>
                            <h1 style="margin:20px 0 8px;font-size:22px;color:#0f172a;">Someone chose a pricing plan.</h1>
                            <p style="margin:0;font-size:14px;line-height:1.7;color:#475569;">
                                Sign in to the Networx Solutions admin panel to see the contact details and call them back.
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0"
                                style="margin-top:24px;background-color:#f8fafc;border-radius:8px;padding:16px;font-size:13px;color:#475569;">
                                <tr>
                                    <td style="padding:4px 12px 4px 0;font-weight:bold;color:#64748b;">Reference</td>
                                    <td style="padding:4px 0;">{{ $planRequest->reference }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 12px 4px 0;font-weight:bold;color:#64748b;">Service</td>
                                    <td style="padding:4px 0;">{{ $planRequest->service_name ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 12px 4px 0;font-weight:bold;color:#64748b;">Plan</td>
                                    <td style="padding:4px 0;">{{ $planRequest->plan_name }} ({{ $planRequest->billing_period->label() }})</td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 12px 4px 0;font-weight:bold;color:#64748b;">Received at</td>
                                    <td style="padding:4px 0;">{{ $planRequest->created_at->format('M j, Y g:i A T') }}</td>
                                </tr>
                            </table>
                            <p style="margin:24px 0 0;">
                                <a href="{{ route('admin.plan-requests.show', $planRequest) }}"
                                    style="display:inline-block;border-radius:8px;background-color:#0045b3;padding:12px 20px;font-size:14px;font-weight:bold;color:#ffffff;text-decoration:none;">
                                    Open the request
                                </a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
