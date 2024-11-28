<form action="{{ route('categories.store') }}" method="POST">
    @csrf
    <div class="form-group">
        <label for="name">Название категории</label>
        <input type="text" class="form-control" name="name" id="name" required>
    </div>
    <button type="submit" class="btn btn-primary">Добавить категорию</button>
</form>
