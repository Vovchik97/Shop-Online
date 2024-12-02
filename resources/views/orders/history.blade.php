<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>История заказов</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<!-- Навигационная панель -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('home') }}">ВелоМото</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">Главная</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                @auth
                    <li class="nav-item">
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-primary me-2">
                            <i class="bi bi-cart"></i> 🛒 Корзина
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-danger" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Выйти
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="btn btn-outline-primary me-2" href="{{ route('login') }}">Вход</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-outline-secondary" href="{{ route('register') }}">Регистрация</a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<!-- Содержимое страницы -->
<div class="container my-5">
    <h2>История заказов</h2>
    @if ($orders->isEmpty())
        <p>У вас пока нет заказов.</p>
    @else
        @foreach ($orders as $order)
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Заказ №{{ $order->id }} — {{ $order->created_at->format('d.m.Y H:i') }}</span>
                    <button class="btn btn-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#order-{{ $order->id }}" aria-expanded="false" aria-controls="order-{{ $order->id }}">
                        Подробнее
                    </button>
                </div>
                <div id="order-{{ $order->id }}" class="collapse">
                    <div class="card-body">
                        <h5>Продукты в заказе:</h5>
                        <ul>
                            @foreach ($order->products as $product)
                                <li>
                                    {{ $product->name }} — {{ $product->pivot->quantity }} шт. по цене {{ $product->pivot->price }} ₽
                                </li>
                            @endforeach
                        </ul>
                        <strong>Итоговая стоимость: {{ $order->total_price }} ₽</strong>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<!-- Footer -->
<footer class="bg-light text-center py-3">
    <p>&copy; 2024 ВелоМото. Все права защищены.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
