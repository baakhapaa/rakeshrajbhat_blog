<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your sign-in code</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1e1e1a; background-color: #f2efe8; padding: 24px; margin: 0;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 32px; border-radius: 12px;">
        <p style="margin: 0 0 8px; color: #735A12; font-size: 12px; letter-spacing: 0.14em; text-transform: uppercase;">Rakesh Rajbhat</p>
        <h1 style="margin: 0 0 16px; font-family: Georgia, 'Times New Roman', serif; font-size: 26px; font-weight: bold;">Your sign-in code</h1>
        <p style="margin: 0 0 20px; color: #3a3a34;">Hello {{ $name }},</p>
        <p style="margin: 0 0 24px; color: #3a3a34;">Use this code to finish resetting your password on {{ parse_url($siteUrl, PHP_URL_HOST) ?: 'rakeshrajbhat.com' }}:</p>
        <div style="background: #f8f6f0; padding: 24px; text-align: center; border-radius: 8px; margin: 0 0 24px;">
            <p style="margin: 0 0 8px; font-size: 13px; color: #6b6b63; letter-spacing: 0.06em; text-transform: uppercase;">Sign-in code</p>
            <p style="margin: 0; font-size: 32px; font-weight: bold; color: #735A12; letter-spacing: 6px; font-family: 'Courier New', Courier, monospace;">{{ $otp }}</p>
            <p style="margin: 12px 0 0; font-size: 13px; color: #8a8a82;">Valid for {{ $expiresMinutes }} minutes.</p>
        </div>
        <p style="margin: 0 0 16px; color: #3a3a34;">If you did not request this, you can ignore this email. Your password will stay the same.</p>
        <p style="margin: 0; font-size: 12px; color: #8a8a82; border-top: 1px solid #e7e1d6; padding-top: 16px;">
            Sent from <a href="{{ $siteUrl }}" style="color: #735A12;">{{ parse_url($siteUrl, PHP_URL_HOST) ?: 'rakeshrajbhat.com' }}</a>.
        </p>
    </div>
</body>
</html>
