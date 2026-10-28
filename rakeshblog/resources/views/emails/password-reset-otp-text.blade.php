Rakesh Rajbhat — Your sign-in code

Hello {{ $name }},

Use this code to finish resetting your password on {{ parse_url($siteUrl, PHP_URL_HOST) ?: 'rakeshrajbhat.com' }}:

{{ $otp }}

This code is valid for {{ $expiresMinutes }} minutes.

If you did not request this, you can ignore this email. Your password will stay the same.

{{ $siteUrl }}
