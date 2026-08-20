<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #D4AF37; border-bottom: 2px solid #D4AF37; padding-bottom: 10px;">New Contact Form Submission</h2>
        
        <p style="margin-bottom: 15px;"><strong style="color: #D4AF37;">Name:</strong> {{ $name }}</p>
        <p style="margin-bottom: 15px;"><strong style="color: #D4AF37;">Email:</strong> {{ $email }}</p>
        <p style="margin-bottom: 15px;"><strong style="color: #D4AF37;">Subject:</strong> {{ $subject }}</p>
        
        <h3 style="margin-top: 25px; color: #D4AF37;">Message:</h3>
        <div style="background: #f4f4f4; padding: 15px; border-left: 4px solid #D4AF37; border-radius: 4px; margin-bottom: 20px;">
            {{ $user_message }}
        </div>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">
        <p style="font-size: 12px; color: #888; text-align: center;">
            Sent via rakeshrajbhat.com contact form.
        </p>
    </div>
</body>
</html>