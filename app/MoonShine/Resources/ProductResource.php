<?php

declare(strict_types=1);

namespace App\MoonShine\Resources;

use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Category;

use MoonShine\Fields\Field;
use MoonShine\Resources\ModelResource;
use MoonShine\Decorations\Block;
use MoonShine\Fields\ID;
use MoonShine\Fields\Text;
use MoonShine\Fields\Number;
use MoonShine\Fields\Select;
use MoonShine\Fields\Image;
use MoonShine\ActionButtons\ActionButtons; // Для работы с кнопками действий
use MoonShine\ActionButtons\ActionButton; // Для создания кнопок действий
use MoonShine\Components\MoonShineComponent;

/**
 * @extends ModelResource<Product>
 */
class ProductResource extends ModelResource
{
    protected string $model = Product::class;

    protected string $title = 'Продукты';

    /**
     * @return list<MoonShineComponent|Field>
     */
    public function fields(): array
    {
        return [
            Block::make([
                ID::make()->sortable(),
                Text::make('Название', 'name')
                    ->required(),
                Number::make('Цена', 'price')
                    ->required(),
                Text::make('Описание', 'description')
                    ->hideOnIndex(),
                Select::make('Категория', 'category_id')
                    ->options(Category::pluck('name', 'id')->toArray())
                    ->required(),
                Image::make('Изображение', 'image')
                    ->dir('products')
                    ->disk('public')
                    ->allowedExtensions(['jpg', 'jpeg', 'png', 'gif', 'webp'])
                    ->removable()
            ]),
        ];
    }

    public function label(): string
    {
        return 'Продукты'; // Заголовок для ресурса
    }

    public function singularLabel(): string
    {
        return 'Продукт'; // Заголовок для конкретного ресурса
    }

    /**
     * @param Product $item
     *
     * @return array<string, string[]|string>
     * @see https://laravel.com/docs/validation#available-validation-rules
     */
    public function rules(Model $item): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric'],
            'description' => ['nullable', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
        ];
    }

    /**
     * Метод для добавления действий в админку.
     * Добавляем действие для удаления.
     *
     * @return array
     */
    public function actions(): array
    {
        return [

        ];
    }
}
