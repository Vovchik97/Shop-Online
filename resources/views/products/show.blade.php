<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
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
                    <a class="nav-link active" href="{{ route('home') }}">Главная</a>
                </li>
            </ul>
            <form class="d-flex flex-grow-1 me-3" method="GET" action="{{ route('home') }}">
                <input class="form-control me-2" type="search" name="search" placeholder="Поиск товаров" value="{{ request('search') }}">
                <button class="btn btn-outline-success" type="submit">Поиск</button>
            </form>
            <ul class="navbar-nav">
                @auth
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

<!-- Приветственный блок -->
<header class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="display-4">{{ $product->name }}</h1>
        <p class="lead">Цена: {{ $product->price }} ₽</p>
    </div>
</header>

<!-- Информация о продукте -->
<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('storage/' . $product->image) }}" class="img-fluid" alt="{{ $product->name }}">
        </div>
        <div class="col-md-6">
            <h3>Описание</h3>
            <p>{{ $product->description }}</p>
            <p class="lead">Цена: {{ $product->price }} ₽</p>
            <a href="#" class="btn btn-primary">Добавить в корзину</a>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="bg-light text-center py-3">
    <p>&copy; 2024 ВелоМото. Все права защищены.</p>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
