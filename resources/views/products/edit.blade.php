@extends('layouts.app')

@section('content')
    <h1>Редактировать товар: {{ $product->name }}</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Название товара</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $product->name) }}">
        </div>

        <div class="form-group">
            <label for="description">Описание товара</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        <div class="form-group">
            <label for="price">Цена</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ old('price', $product->price) }}">
        </div>

        <div class="form-group">
            <label for="category_id">Категория</label>
            <select name="category_id" id="category_id" class="form-control">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="image">Ссылка на изображение</label>
            <input type="url" name="image" id="image" class="form-control" value="{{ old('image', $product->image) }}">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Обновить товар</button>
    </form>
@endsection

