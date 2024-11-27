<form action="{{ route('products.store') }}" method="POST">
@csrf
<label for="name">Название</label>
<input type="text" name="name" required>
<label for="description">Описание</label>
<textarea name="description" required></textarea>
<label for="price">Цена</label>
<input type="number" name="price" required>
<label for="category_id">Категория</label>
<select name="category_id" required>
    @foreach ($categories as $category)
        <option value="{{ $category->id }}">{{ $category->name }}</option>
    @endforeach
</select>
<button type="submit">Сохранить</button>
</form>
