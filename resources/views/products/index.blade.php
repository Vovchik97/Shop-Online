@extends('layouts.app') <!-- Если у вас есть общий шаблон -->
@section('content')
    <h1>Список товаров</h1>

    @if($products->isEmpty())
        <p>Товары не найдены.</p>
    @else
        <ul>
            @foreach ($products as $product)
                <li>
                    <h2>{{ $product->name }}</h2>
                    <p>Цена: {{ $product->price }}</p>
                    <p>{{ $product->description }}</p>
                </li>
            @endforeach
        </ul>
    @endif
@endsection

