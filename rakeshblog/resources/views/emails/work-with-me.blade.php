<!DOCTYPE html>
<html>
<head>
    <title>New Work With Me Request</title>
</head>
<body style="font-family: sans-serif; padding: 20px; color: #1e1e1a;">
    <div style="max-width: 600px; margin: 0 auto; border: 1px solid #e0e0e0; border-radius: 8px; padding: 25px; background: #ffffff;">
        <h2 style="color: #D4AF37; margin-top: 0;">New Work With Me Request</h2>
        <p style="color: #3a3a34;"><strong>Type:</strong> <span style="background: #f2f2f2; padding: 4px 10px; border-radius: 4px; font-size: 13px;">{{ $type_label }}</span></p>
        <hr style="border: 0; border-top: 1px solid #f2f2f2; margin: 20px 0;">

        <h3 style="color: #D4AF37;">Contact Details</h3>
        <p><strong>Name:</strong> {{ $name }}</p>
        <p><strong>Email:</strong> {{ $email }}</p>
        <p><strong>Phone:</strong> {{ $phone }}</p>
        <hr style="border: 0; border-top: 1px solid #f2f2f2; margin: 20px 0;">

        <h3 style="color: #D4AF37;">Submission Details</h3>

        @if($type_label === 'Municipality')
            <p><strong>Organization:</strong> {{ $org_name }}</p>
            <p><strong>District:</strong> {{ $district }}</p>
            <p><strong>Interest:</strong> {{ $interest }}</p>
            <p><strong>Audience:</strong> {{ $audience }}</p>
            <p><strong>Participants:</strong> {{ $participants }}</p>
            <p><strong>Preferred Date:</strong> {{ $preferred_date }}</p>
            <p><strong>Requirements:</strong> {{ $requirements }}</p>

        @elseif($type_label === 'Education')
            <p><strong>School:</strong> {{ $org_name }}</p>
            <p><strong>Interest:</strong> {{ $interest }}</p>
            <p><strong>Target Audience:</strong> {{ $target_audience }}</p>
            <p><strong>Age / Grade:</strong> {{ $age_grade }}</p>
            <p><strong>Participants:</strong> {{ $participants }}</p>
            <p><strong>Preferred Date:</strong> {{ $preferred_date }}</p>
            <p><strong>Requirements:</strong> {{ $requirements }}</p>

        @elseif($type_label === 'Investor')
            <p><strong>Organization:</strong> {{ $organization }}</p>
            <p><strong>Interest:</strong> {{ $investor_type }}</p>
            <p><strong>What they'd like to explore:</strong> {{ $exploration }}</p>
            <p><strong>Website / LinkedIn:</strong> {{ $website }}</p>

        @elseif($type_label === 'Partner')
            <p><strong>Organization:</strong> {{ $org_name }}</p>
            <p><strong>Looking for:</strong> {{ $collaboration_type }}</p>
            <p><strong>Details:</strong> {{ $details }}</p>
            <p><strong>Website:</strong> {{ $website }}</p>

        @elseif($type_label === 'Future Builder')
            <p><strong>Location:</strong> {{ $location }}</p>
            <p><strong>Skills:</strong> {{ $skills }}</p>
            <p><strong>Portfolio:</strong> {{ $portfolio }}</p>
            <p><strong>Why they want to contribute:</strong> {{ $contribution_reason }}</p>
        @endif

        <hr style="border: 0; border-top: 1px solid #f2f2f2; margin: 20px 0;">
        <p style="font-size: 12px; color: #888; text-align: center;">Sent via rakeshrajbhat.com</p>
    </div>
</body>
</html>