<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="min-h-screen bg-gray-100">
    <!-- Навигационная панель -->
    <nav class="bg-white border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Логотип -->
                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('home') }}">
                            <img class="h-8 w-auto" src="/images/logo.png" alt="Logo">
                        </a>
                    </div>

                    <!-- Ссылки -->
                    <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                        <a href="{{ route('home') }}" class="text-gray-900 hover:text-gray-700">Главная</a>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @auth
                        <!-- Корзина -->
                        <a href="{{ route('cart.index') }}" class="text-gray-900 hover:text-gray-700 mr-4">
                            🛒 Корзина
                        </a>
                        <!-- Выйти -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="text-gray-900 hover:text-gray-700">Выйти</button>
                        </form>
                    @else
                        <!-- Войти/Регистрация -->
                        <a href="{{ route('login') }}" class="text-gray-900 hover:text-gray-700 mr-4">Войти</a>
                        <a href="{{ route('register') }}" class="text-gray-900 hover:text-gray-700">Регистрация</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Заголовок страницы -->
    @isset($header)
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <!-- Контент страницы -->
    <main>
        @yield('content')
    </main>
</div>
</body>
</html>
