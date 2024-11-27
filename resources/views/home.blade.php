<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интернет магазин</title>
</head>
<body>
<h1>Добро пожаловать в наш интернет-магазин!</h1>

<h2>Продукты:</h2>
@foreach ($products as $product)
    <div>
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->description }}</p>
        <p>{{ $product->price }} руб.</p>
        <a href="{{ route('products.show', $product->id) }}">Подробнее</a>
    </div>
@endforeach
</body>
</html>

