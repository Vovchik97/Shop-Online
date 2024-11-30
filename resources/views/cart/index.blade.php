@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Корзина</h2>
        @if ($cartItems->isEmpty())
            <p>Ваша корзина пуста.</p>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>Товар</th>
                    <th>Количество</th>
                    <th>Цена</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>{{ $item->product->name }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->product->price * $item->quantity }} ₽</td>
                        <td>
                            <form method="POST" action="{{ route('cart.destroy', $item->id) }}">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm">Удалить</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection

