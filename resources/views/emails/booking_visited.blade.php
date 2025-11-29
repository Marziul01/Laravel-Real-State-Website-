<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Visited</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="background-color: #1f526b; color: white; padding: 20px; text-align: center;">
            <h2>Booking Marked as Visited!</h2>
        </div>
        <div style="padding: 20px;">
            <p>Hi {{ $booking->user->name }},</p>
            <p>Thank you for visiting your our property ( <strong>{{ $booking->property->name ?? 'the selected property' }}</strong> ). We hope you had a great time . You can leave a review for the property from you dashboard.</p>

            <p>Thank you for using our service. You can log in to your dashboard to view your booking history and invoice:</p>
            <p style="text-align: center; margin: 20px 0;">
                <a href="{{ route('user.dashboard') }}" style="background-color: #1f526b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Go to Dashboard</a>
            </p>

            <p style="margin-top: 30px; font-size: 12px; color: #888;">This is an automated message. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
