<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm your subscription</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #1e1e1a; background-color: #f2efe8; padding: 24px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 32px; border-radius: 12px;">
        <p style="margin: 0 0 8px; color: #735A12; font-size: 12px; letter-spacing: 0.14em; text-transform: uppercase;">Rakesh Rajbhat</p>
        <h1 style="margin: 0 0 16px; font-family: Georgia, serif; font-size: 28px;">Confirm your subscription</h1>
        <p style="margin: 0 0 24px; color: #3a3a34;">After you confirm, you will get an email when a new article, research piece, or project is published.</p>
        <p style="margin: 0 0 28px;">
            <a href="{{ $confirmUrl }}" style="display: inline-block; background: #D4AF37; color: #0b0e12; text-decoration: none; font-weight: bold; padding: 12px 18px; border-radius: 6px;">Confirm subscription</a>
        </p>
        <p style="margin: 0; font-size: 12px; color: #6b6b63;">
            If you did not ask for this, you can ignore the email or
            <a href="{{ $unsubscribeUrl }}" style="color: #735A12;">unsubscribe</a>.
        </p>
    </div>
</body>
</html>
