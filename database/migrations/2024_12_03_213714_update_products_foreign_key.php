<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateProductsForeignKey extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Удаляем старый внешний ключ, если он есть
            $table->dropForeign(['category_id']);

            // Добавляем внешний ключ с каскадным удалением
            $table->foreign('category_id')
                ->references('id') // Ссылаемся на колонку id в таблице categories
                ->on('categories')
                ->onDelete('cascade'); // Настройка каскадного удаления
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Удаляем внешний ключ с каскадным удалением
            $table->dropForeign(['category_id']);

            // Восстанавливаем стандартное поведение
            $table->foreign('category_id')
                ->references('id')
                ->on('categories');
        });
    }
}
