<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Account Created</title>
</head>
<body style="font-family: Arial; background:#f5f5f5; padding:30px;">

<div style="max-width:600px; margin:auto; background:white; padding:20px; border-radius:8px;">

    <h2 style="color:#0d6efd;">Welcome, {{ $name }}!</h2>

    <p>Your admin account has been created.</p>

    <p><strong>Login Email:</strong> {{ $email }}</p>
    <p><strong>Password:</strong> {{ $password }}</p>

    <br>

    <a href="{{ $loginUrl }}" 
       style="display:inline-block; padding:10px 20px; background:#0d6efd; color:white; text-decoration:none; border-radius:5px;">
        Login to Admin Panel
    </a>

    <br><br>

    <p style="color:gray; font-size:13px;">
        Please change your password after logging in for security purposes.
    </p>

</div>

</body>
</html>
