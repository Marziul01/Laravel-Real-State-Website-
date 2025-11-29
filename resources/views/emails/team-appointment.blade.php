<!DOCTYPE html>
<html>
<head>
    <style>
        .box {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
        }
    </style>
</head>

<body>
<div style="max-width:550px;margin:auto;background:#f5f5f5;padding:25px;">
    <div class="box">
        <h2>New Appointment Scheduled</h2>

        <p><strong>User:</strong> {{ $appointment->name }}</p>
        <p><strong>Phone:</strong> {{ $appointment->phone }}</p>
        <p><strong>Email:</strong> {{ $appointment->email }}</p>

        <p><strong>Date:</strong> {{ $appointment->schedule_date }}</p>
        <p><strong>Time:</strong> {{ $appointment->schedule_time }}</p>

        <p>Please be prepared for the session.</p>
    </div>
</div>
</body>
</html>
