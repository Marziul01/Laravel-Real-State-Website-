<!DOCTYPE html>
<html>
<head>
    <style>
        .container {
            font-family: Arial, sans-serif;
            padding: 20px;
            background: #f5f5f5;
        }
        .box {
            background: white;
            padding: 25px;
            border-radius: 8px;
            max-width: 550px;
            margin: auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .title {
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 15px;
        }
        .footer {
            margin-top: 20px;
            font-size: 13px;
            color: #888;
            text-align: center;
        }
    </style>
</head>

<body>
<div class="container">
    <div class="box">
        <p class="title">Your Appointment is Confirmed!</p>

        <p>Hello {{ $appointment->name }},</p>

        <p>Your appointment has been successfully confirmed.</p>

        <p><strong>Date:</strong> {{ $appointment->schedule_date }}</p>
        <p><strong>Time:</strong> {{ $appointment->schedule_time }}</p>

        <p>If you have any questions, feel free to reply to this email.</p>

        <p>Thank you!</p>

    </div>
</div>
</body>
</html>
