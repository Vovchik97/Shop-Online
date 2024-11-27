<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
</head>
<body>
<h1>{{ $product->name }}</h1>
<p>{{ $product->description }}</p>
<p>Цена: {{ $product->price }} руб.</p>
<a href="{{ route('products.index') }}">Назад к списку продуктов</a>
</body>
</html>
npm install bootstrap @popperjs/core
