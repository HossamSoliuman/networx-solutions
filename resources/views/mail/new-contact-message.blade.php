<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>New contact message</title>
</head>

<body style="margin:0;padding:0;background-color:#f1f5f9;font-family:'Segoe UI',Arial,Helvetica,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f1f5f9;padding:32px 16px;">
        <tr>
            <td align="center">
                <table role="presentation" width="600" cellpadding="0" cellspacing="0"
                    style="max-width:600px;width:100%;background-color:#ffffff;border-radius:12px;overflow:hidden;">
                    <tr>
                        <td style="background-color:#071429;padding:24px 32px;">
                            <p style="margin:0;font-size:18px;font-weight:bold;letter-spacing:2px;color:#ffffff;">
                                NETWORX <span style="color:#5a8ffa;font-weight:normal;">SOLUTIONS</span>
                            </p>
                            <p style="margin:6px 0 0;font-size:12px;color:#8ab4ff;">New contact form message</p>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding:28px 32px;">
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="font-size:13px;color:#334155;">
                                @foreach ([
                                    'Reference' => $contactMessage->reference,
                                    'Name' => $contactMessage->name,
                                    'Email' => $contactMessage->email,
                                    'Phone' => $contactMessage->phone ?? '—',
                                    'Company' => $contactMessage->company ?? '—',
                                    'Service' => $contactMessage->service?->name ?? 'General enquiry',
                                    'Received' => $contactMessage->created_at->format('M j, Y g:i A'),
                                ] as $label => $value)
                                    <tr>
                                        <td style="padding:6px 12px 6px 0;font-weight:bold;color:#64748b;white-space:nowrap;vertical-align:top;">{{ $label }}</td>
                                        <td style="padding:6px 0;">{{ $value }}</td>
                                    </tr>
                                @endforeach
                            </table>

                            <p style="margin:20px 0 6px;font-size:11px;font-weight:bold;letter-spacing:1px;color:#94a3b8;">SUBJECT</p>
                            <p style="margin:0;font-size:14px;font-weight:bold;color:#0f172a;">{{ $contactMessage->subject }}</p>

                            <p style="margin:20px 0 6px;font-size:11px;font-weight:bold;letter-spacing:1px;color:#94a3b8;">MESSAGE</p>
                            <div style="background-color:#f8fafc;border-radius:8px;padding:16px 20px;font-size:13px;line-height:1.7;color:#334155;white-space:pre-line;">{{ $contactMessage->message }}</div>

                            <table role="presentation" cellpadding="0" cellspacing="0" style="margin-top:24px;">
                                <tr>
                                    <td style="background-color:#2563eb;border-radius:8px;">
                                        <a href="{{ route('admin.messages.show', $contactMessage) }}"
                                            style="display:inline-block;padding:11px 24px;font-size:13px;font-weight:bold;color:#ffffff;text-decoration:none;">
                                            Open in admin panel
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
