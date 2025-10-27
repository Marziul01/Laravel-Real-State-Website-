<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Invoice</title>
    <style>
        body { font-family: 'Segoe UI', sans-serif; color: #333; margin: 0; padding: 0; background: #f6f8fa; }
        .container { background: #fff; max-width: 600px; margin: 40px auto; border-radius: 8px; overflow: hidden; box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
        .header { background: #1f526b; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        p { line-height: 1.6; }
        .btn { display: inline-block; padding: 10px 18px; background: #1f526b; color: white !important; border-radius: 5px; text-decoration: none; margin-top: 15px; }
        .footer { background: #f1f1f1; padding: 10px; text-align: center; color: #777; font-size: 13px; }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Thank You for Booking with {{ $setting->site_name }}</h2>
    </div>

    <div class="content">
        <p>Hi {{ $booking->name }},</p>
        <p>We’re excited to confirm your booking for <strong>{{ $booking->property->name ?? 'the selected property' }}</strong>.  
           You can find all the details in the attached invoice PDF.</p>

        <p>Your booking is currently <strong>Pending</strong>. Once we verify your payment or approve the booking, we’ll notify you right away.</p>

        <a href="{{ route('home') }}" class="btn">Visit Our Website</a>
    </div>

    <div class="footer">
        © {{ date('Y') }} {{ $setting->site_name }}. All rights reserved.
    </div>
</div>
</body>
</html>
