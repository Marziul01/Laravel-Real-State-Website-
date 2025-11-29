<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Appointment</title>
    <style>
        body { font-family: Arial, sans-serif; color: #000; background-color: #fff; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; padding: 20px; border: 1px solid #ddd; }
        h2 { margin-bottom: 5px; font-size: 20px; }
        p { margin: 2px 0; font-size: 14px; color: #555; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { text-align: left; padding: 8px; border-bottom: 1px solid #ddd; }
        th { background-color: #f5f5f5; }
        .property-header { display: flex; align-items: center; margin-bottom: 20px; }
        .property-header img { width: 70px; height: 70px; object-fit: cover; margin-right: 10px; border-radius: 5px; }
        .footer { margin-top: 30px; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        {{-- Property info --}}
        <div class="property-header">
            <p>Appointment Request For: </p>
            <div>
                <h2>{{ $inquiry->team->name }}</h2>
                <p>{{ $inquiry->team->position }}</p>
            </div>
        </div>

        {{-- Inquiry details --}}
        <table>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
            <tr>
                <td>Name</td>
                <td>{{ $inquiry->name }}</td>
            </tr>
            <tr>
                <td>Phone</td>
                <td>{{ $inquiry->phone }}</td>
            </tr>
            <tr>
                <td>Email</td>
                <td>{{ $inquiry->email }}</td>
            </tr>
            <tr>
                <td>Country</td>
                <td>{{ $inquiry->country->name }}</td>
            </tr>
            <tr>
                <td>Schedule</td>
                <td>{{ $inquiry->schedule_date }} at {{ $inquiry->schedule_time }}</td>
            </tr>
            <tr>
                <td>Demands</td>
                <td>{{ $inquiry->demands }}</td>
            </tr>
            <tr>
                <td>Message</td>
                <td>{{ $inquiry->message }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
