<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Email configuration test</title>
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
                            <p style="margin:6px 0 0;font-size:12px;color:#8ab4ff;">Email delivery test</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:32px;">
                            <div style="display:inline-block;border-radius:999px;background-color:#ecfdf5;padding:6px 12px;font-size:12px;font-weight:bold;color:#047857;">
                                SMTP connection successful
                            </div>
                            <h1 style="margin:20px 0 8px;font-size:22px;color:#0f172a;">Your Hostinger email is working.</h1>
                            <p style="margin:0;font-size:14px;line-height:1.7;color:#475569;">
                                {{ $siteName }} successfully sent this message through the configured application mailer.
                            </p>
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-top:24px;background-color:#f8fafc;border-radius:8px;padding:16px;font-size:13px;color:#475569;">
                                <tr>
                                    <td style="padding:4px 12px 4px 0;font-weight:bold;color:#64748b;">Requested by</td>
                                    <td style="padding:4px 0;">{{ $requestedBy }}</td>
                                </tr>
                                <tr>
                                    <td style="padding:4px 12px 4px 0;font-weight:bold;color:#64748b;">Sent at</td>
                                    <td style="padding:4px 0;">{{ $sentAt->format('M j, Y g:i A T') }}</td>
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
