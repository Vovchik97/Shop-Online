@extends('layouts.app')

@section('content')
    <h1>{{ $product->name }}</h1>
    <img src="{{ $product->image }}" class="img-fluid" alt="{{ $product->name }}">
    <p>{{ $product->description }}</p>
    <p>Цена: {{ $product->price }} руб.</p>
    <a href="{{ route('products.index') }}" class="btn btn-secondary">Назад</a>
@endsection
