// resources/views/emails/sendemail.blade.php
<!DOCTYPE html>
<html>
<head>
    <title>Registration Confirmation</title>
</head>
<body>
    <h2>Welcome to Our Website!</h2>
    <p>Hello {{ $data['name'] }},</p>

    <p>Thank you for registering. Here are your registration details:</p>

    <ul>
        <li>Name: {{ $data['name'] }}</li>
        <li>Email: {{ $data['email'] }}</li>
    </ul>

    <p>You can now login to your account using your email and password.</p>

    <p>Thank you!</p>
</body>
</html>
