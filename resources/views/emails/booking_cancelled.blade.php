<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Cancelled</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="background-color: #b00020; color: white; padding: 20px; text-align: center;">
            <h2>Booking Cancelled</h2>
        </div>
        <div style="padding: 20px;">
            <p>Hi {{ $booking->user->name }},</p>
            <p>We're sorry to inform you that your booking for <strong>{{ $booking->property->name ?? 'the selected property' }}</strong> has been cancelled.</p>

            <p>If you have any questions or concerns, please contact our support team. You can also log in to your dashboard to view your booking history and any invoices:</p>

            <p>Contact us at {{ $setting->site_email }} or call {{ $setting->site_phone }}.</p>

            <p style="margin-top: 30px; font-size: 12px; color: #888;">This is an automated message. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
