<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $booking->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; margin: 20px; font-size: 12px !important ;}
        .header, .footer { text-align: center; }
        .header h2 { margin: 0; color: #1f526b; }
        .company-info { margin-top: 10px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background: #1f526b; color: white; }
        .summary td { border: none; }
        .footer { margin-top: 30px; font-size: 13px; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <img src="{{ public_path($setting->site_logo) }}" width="100px" alt="">

        <h2>{{ $setting->site_name }}</h2>
        <div class="company-info">
            {{ $setting->site_address }}<br>
            Email: {{ $setting->site_email }} | Phone: {{ $setting->site_phone }}
        </div>
    </div>

    <h3 style="margin-top:30px;">Invoice #{{ $booking->id }}</h3>
    <p><strong>Customer:</strong> {{ $booking->name }}</p>
    <p><strong>Email:</strong> {{ $booking->email }}</p>
    <p><strong>Phone:</strong> {{ $booking->phone }}</p>

    <table>
        <thead>
            <tr>
                <th>Property</th>
                <th>Booked For</th>
                <th>Total Guests</th>
                <th>Price</th>
                
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $booking->property->name ?? 'N/A' }}</td>
                @php
                                            $start = \Carbon\Carbon::parse($booking->start_date);
                                            $end = \Carbon\Carbon::parse($booking->end_date);

                                            // Calculate differences
                                            $nights = $start->diffInDays($end);       // per night
                                            $weeks = $start->diffInWeeks($end);       // weekly
                                            $months = ceil($start->diffInMonths($end, false)); // monthly, round up
                                        @endphp
                <td>{{-- Duration based on booking type --}}
                                            @if($booking->booking_type === 'per-night')
                                                <span class="text-primary fw-bold">{{ $nights }} Night{{ $nights > 1 ? 's' : '' }}</span>
                                                <br>
                                            @elseif($booking->booking_type === 'weekly')
                                                <span class="text-success fw-bold">{{ $weeks }} Week{{ $weeks > 1 ? 's' : '' }}</span>
                                                <br>
                                            @elseif($booking->booking_type === 'monthly')
                                                <span class="text-info fw-bold">{{ $months }} Month{{ $months > 1 ? 's' : '' }}</span>
                                                <br>
                                            @endif
                                            
                                            {{ $start->format('M d, Y') }} - {{ $end->format('M d, Y') }}

                    <br>
                    (Check In: {{ \Carbon\Carbon::parse($booking->property->check_in)->format('g:i A') }} &  
                    Check Out: {{ \Carbon\Carbon::parse($booking->property->check_out)->format('g:i A') }})</td>
                <td>{{ $booking->total_guests }}</td>
                <td>{{ number_format($booking->total, 2) }}</td>
            </tr>
            <tr>
            	<td colspan ="2"></td>
                <td>Discount</td>
                <td>{{ number_format($booking->discount, 2) }} @if($booking->discount != 0) - ( Code : {{ $booking->coupon->code ?? '' }} ) @endif </td>
            </tr>
            <tr>
            	<td colspan ="2"></td>
                <td>Grand Total</td>
                <td>{{ number_format($booking->grand_total, 2) }}</td>
            </tr>
        </tbody>
    </table>

    <table class="summary" style="margin-top:20px;">
    	<tr>
            <td><strong>Payment Method:</strong> {{ $booking->payment->name }}</td>
        </tr>
        <tr>
            <td><strong>Payment Details:</strong>
                <br>
                @if ($booking->payment->payment_method_type == 'mobile_banking')
                    Transaction ID : {{ $booking->transaction_id }}
                @else
                    Your Account Number : {{ $booking->bank_account_number }}
                    <br>
                    Your Account Name : {{ $booking->bank_account_name }}
                @endif
            </td>
        </tr>
        <tr>
            <td>
                <strong>Payment Status:</strong>
                {{ $booking->payment_status == 1 ? 'Pending' : ($booking->payment_status == 2 ? 'Paid' : ($booking->payment_status == 3 ? 'Canceled' : 'Unknown')) }}
            </td>
        </tr>
        <tr>
            <td>
                <strong>Booking Status:</strong>
                {{ $booking->status == 1 ? 'Pending' : ($booking->status == 2 ? 'Confirmed' : ($booking->status == 3 ? 'Visited' : ($booking->status == 4 ? 'Canceled' : 'Unknown'))) }}
            </td>
        </tr>
        @if($booking->notes)
        <tr>
            <td><strong>Notes:</strong> {{ $booking->notes }}</td>
        </tr>
        @endif
    </table>

    <div class="footer">
        <p>For any queries, contact us at {{ $setting->site_email }} or call {{ $setting->site_phone }}.</p>
        <p>Thank you for choosing {{ $setting->site_name }}!</p>
    </div>
</body>
</html>
