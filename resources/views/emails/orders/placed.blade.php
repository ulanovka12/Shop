<!DOCTYPE html>
<html>
<head>
    <title>Новый заказ</title>
</head>
<body>
<h1>Поступил новый заказ №{{ $order->id }}!</h1>
<p>Сумма заказа: <strong>{{ $order->total }}</strong></p>
<p>Адрес доставки: {{ $order->address->full_address ?? 'Не указан' }}</p>

<p>Спасибо, что вы с нами!</p>
</body>
</html>
