<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Bootcamp Request</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; background-color: #f9f9f9; padding: 20px;">
    <div style="max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
        <h2 style="color: #D4AF37; border-bottom: 2px solid #D4AF37; padding-bottom: 10px;">New Bootcamp Request</h2>
        
        <p><strong style="color: #D4AF37;">Organization:</strong> {{ $org_name }}</p>
        <p><strong style="color: #D4AF37;">District:</strong> {{ $district }}</p>
        <p><strong style="color: #D4AF37;">Contact Person:</strong> {{ $contact_person }}</p>
        <p><strong style="color: #D4AF37;">Email:</strong> {{ $contact_email }}</p>
        <p><strong style="color: #D4AF37;">Phone:</strong> {{ $contact_phone }}</p>
        <p><strong style="color: #D4AF37;">Expected Participants:</strong> {{ $participants }}</p>
        <p><strong style="color: #D4AF37;">Preferred Date:</strong> {{ $preferred_date }}</p>
        <p><strong style="color: #D4AF37;">Target Audience:</strong> {{ $audience }}</p>
        
        <h3 style="margin-top: 25px; color: #D4AF37;">Requirements:</h3>
        <div style="background: #f4f4f4; padding: 15px; border-left: 4px solid #D4AF37; border-radius: 4px; margin-bottom: 20px;">
            {{ $requirements }}
        </div>
        
        <hr style="border: 0; border-top: 1px solid #eee; margin: 25px 0;">
        <p style="font-size: 12px; color: #888; text-align: center;">
            Sent via rakeshrajbhat.com bootcamp form.
        </p>
    </div>
</body>
</html>