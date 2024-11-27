@foreach ($products as $product)
    <div>
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->description }}</p>
        <p>{{ $product->price }} руб.</p>
        <p>{{ $product->category->name }}</p>
        <a href="{{ route('products.show', $product->id) }}">Подробнее</a>
    </div>
@endforeach
