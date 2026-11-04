<!DOCTYPE html>
<html>
<head>
    <title>Подтверждение Email</title>
</head>
<body>
<h1>Привет, {{ $user->name }}!</h1>
<p>Пожалуйста, подтвердите ваш email, нажав на кнопку ниже:</p>

<a href="{{ $verificationUrl }}" style="padding: 10px 20px; background: blue; color: white; text-decoration: none; border-radius: 5px;">
    Подтвердить Email
</a>

<p>Если вы не регистрировались на нашем сайте, просто проигнорируйте это письмо.</p>
</body>
</html>
