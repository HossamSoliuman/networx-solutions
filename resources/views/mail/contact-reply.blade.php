<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $reply->subject }}</title>
</head>

<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                    style="max-width:600px;width:100%;background-color:#ffffff;border-radius:12px;overflow:hidden;">
                    {{-- Header --}}
                    <tr>
                        <td style="background-color:#071429;padding:28px 32px;">
                            <p style="margin:0;font-size:20px;font-weight:bold;letter-spacing:2px;color:#ffffff;">
                                NETWORX <span style="color:#5a8ffa;font-weight:normal;">SOLUTIONS</span>
                            </p>
                            <p style="margin:6px 0 0;font-size:10px;letter-spacing:4px;color:#8ab4ff;">
                                CONNECT · SECURE · EMPOWER
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:32px;">
                            <p style="margin:0 0 4px;font-size:13px;color:#64748b;">
                                Hello {{ $contactMessage->name }},
                            </p>

                            <div style="margin:16px 0;font-size:14px;line-height:1.7;color:#334155;white-space:pre-line;">{{ $reply->body }}</div>

                            @if ($signature)
                                <div style="margin:24px 0 0;padding-top:16px;border-top:1px solid #e2e8f0;font-size:13px;line-height:1.6;color:#475569;white-space:pre-line;">{{ $signature }}</div>
                            @endif

                            {{-- Quoted original --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:28px;">
                                <tr>
                                    <td style="background-color:#f8fafc;border-left:3px solid #2563eb;border-radius:0 8px 8px 0;padding:16px 20px;">
                                        <p style="margin:0 0 6px;font-size:11px;font-weight:bold;letter-spacing:1px;color:#94a3b8;">
                                            YOUR ORIGINAL MESSAGE · {{ $contactMessage->reference }} · {{ $contactMessage->created_at->format('M j, Y') }}
                                        </p>
                                        <p style="margin:0 0 4px;font-size:13px;font-weight:bold;color:#334155;">{{ $contactMessage->subject }}</p>
                                        <div style="margin:0;font-size:13px;line-height:1.6;color:#64748b;white-space:pre-line;">{{ $contactMessage->message }}</div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color:#f8fafc;border-top:1px solid #e2e8f0;padding:20px 32px;">
                            <p style="margin:0;font-size:11px;line-height:1.6;color:#94a3b8;">
                                You are receiving this email because you contacted
                                {{ \App\Models\Setting::get('site_name', 'Networx Solutions') }}.
                                Reply directly to this email to continue the conversation — please keep the
                                reference {{ $contactMessage->reference }} in the subject.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
