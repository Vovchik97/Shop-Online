<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Интернет-магазин</title>
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


<!-- Приветственный блок -->
<header class="bg-primary text-white text-center py-5">
    <div class="container">
        <h1 class="display-4">Добро пожаловать в интернет-магазин ВелоМото!</h1>
        <p class="lead">Лучший выбор велосипедов и мотоциклов в одном месте</p>
    </div>
</header>

<!-- Контент -->
<div class="container my-5">
    <div class="row">
        <!-- Секция категорий -->
        <div class="col-md-3">
            <h4>Категории</h4>
            <ul class="list-group">
                <li class="list-group-item">
                    <a href="{{ route('home') }}">Все товары</a>
                </li>
                @foreach ($categories as $category)
                    <li class="list-group-item">
                        <a href="{{ route('home', ['category' => $category->id]) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        <!-- Секция товаров -->
        <div class="col-md-9">
            <h2 class="text-center">Популярные товары</h2>
            <div class="row mt-4">
                @forelse ($products as $product)
                    <div class="col-md-4">
                        <div class="card mb-3">
                            <img src="{{ asset('storage/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text">{{ $product->price }} ₽</p>
                                <a href="{{ route('product.show', $product->id) }}" class="btn btn-primary">Подробнее</a>

                                @auth
                                    <form action="{{ route('cart.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1"> <!-- Количество всегда 1 -->
                                        <button type="submit" class="btn btn-primary">Добавить в корзину</button> <!-- Синяя кнопка -->
                                    </form>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-secondary">Войдите, чтобы добавить в корзину</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Нет доступных товаров.</p>
                @endforelse
            </div>
            <div class="mt-3">
                {{ $products->links() }}
            </div>
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
