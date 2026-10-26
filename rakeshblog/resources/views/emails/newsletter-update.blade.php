<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }}</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1e1e1a; background-color: #f2efe8; padding: 24px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 32px; border-radius: 12px;">
        <p style="margin: 0 0 8px; color: #735A12; font-size: 12px; letter-spacing: 0.14em; text-transform: uppercase;">Rakesh Rajbhat</p>
        <h1 style="margin: 0 0 16px; font-family: Georgia, serif; font-size: 28px; line-height: 1.3;">{{ $title }}</h1>
        @if($summary)
            <p style="margin: 0 0 24px; color: #3a3a34;">{{ $summary }}</p>
        @endif
        <p style="margin: 0 0 28px;">
            <a href="{{ $url }}" style="display: inline-block; background: #D4AF37; color: #0b0e12; text-decoration: none; font-weight: bold; padding: 12px 18px; border-radius: 6px;">Read it on the site</a>
        </p>
        <p style="margin: 0; font-size: 12px; color: #6b6b63;">
            You are receiving this because you subscribed on rakeshrajbhat.com.
            <a href="{{ $unsubscribeUrl }}" style="color: #735A12;">Unsubscribe</a>
        </p>
    </div>
</body>
</html>
