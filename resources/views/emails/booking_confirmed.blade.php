<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Booking Confirmed</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; padding: 20px;">
    <div style="max-width: 600px; margin: auto; background-color: #ffffff; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
        <div style="background-color: #1f526b; color: white; padding: 20px; text-align: center;">
            <h2>Booking Confirmed!</h2>
        </div>
        <div style="padding: 20px;">
            <p>Hi {{ $booking->user->name }},</p>
            <p>Your booking has been confirmed. Here are the details:</p>

            <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">Property</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ $booking->property->name }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">Booking Type</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ ucfirst($booking->booking_type) }}</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">Check-in</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($booking->start_date)->format('M d, Y') }} ( {{ \Carbon\Carbon::parse($booking->property->check_in)->format('g:i A') }} )</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">Check-out</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ \Carbon\Carbon::parse($booking->end_date)->format('M d, Y') }} ( {{ \Carbon\Carbon::parse($booking->property->check_out)->format('g:i A') }} )</td>
                </tr>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;">Total Price</td>
                    <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($booking->grand_total) }} BDT</td>
                </tr>
            </table>

            <p>To view your invoice or manage your booking, please log in to your dashboard:</p>
            <p style="text-align: center; margin: 20px 0;">
                <a href="{{ route('user.dashboard') }}" style="background-color: #1f526b; color: white; text-decoration: none; padding: 10px 20px; border-radius: 5px;">Go to Dashboard</a>
            </p>

            <p>Thank you for choosing our service!</p>
            <p style="margin-top: 30px; font-size: 12px; color: #888;">This is an automated message. Please do not reply.</p>
        </div>
    </div>
</body>
</html>
