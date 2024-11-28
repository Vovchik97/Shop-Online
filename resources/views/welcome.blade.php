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
            <ul class="navbar-nav me-2">
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('home') }}">Главная</a>
                </li>
            </ul>
            <form class="d-flex flex-grow-1 me-3" method="GET" action="#">
                <input class="form-control me-2" type="search" placeholder="Поиск товаров" aria-label="Поиск">
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
        <h1 class="display-4">Добро пожаловать в интернет-магазин ВелоМото!</h1>
        <p class="lead">Лучший выбор велосипедов и мотоциклов в одном месте</p>
        <a href="#" class="btn btn-light btn-lg">Посмотреть товары</a>
    </div>
</header>

<!-- Контент -->
<div class="container my-5">
    <h2 class="text-center">Популярные товары</h2>
    <div class="row mt-4">
        <!-- Пример карточек товаров -->
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Товар">
                <div class="card-body">
                    <h5 class="card-title">Название товара</h5>
                    <p class="card-text">Краткое описание товара. Цена: 10,000 руб.</p>
                    <a href="#" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Товар">
                <div class="card-body">
                    <h5 class="card-title">Название товара</h5>
                    <p class="card-text">Краткое описание товара. Цена: 20,000 руб.</p>
                    <a href="#" class="btn btn-primary">Подробнее</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <img src="https://via.placeholder.com/300x200" class="card-img-top" alt="Товар">
                <div class="card-body">
                    <h5 class="card-title">Название товара</h5>
                    <p class="card-text">Краткое описание товара. Цена: 30,000 руб.</p>
                    <a href="#" class="btn btn-primary">Подробнее</a>
                </div>
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
