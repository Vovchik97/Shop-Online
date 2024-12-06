<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use App\Models\Order;
use App\MoonShine\Resources\CategoryResource;
use App\MoonShine\Resources\ProductResource;
use Illuminate\Support\Facades\DB;
use MoonShine\Metrics\ValueMetric;
use MoonShine\Pages\Page;
use MoonShine\Components\MoonShineComponent;
use MoonShine\Metrics\LineChartMetric;

class Dashboard extends Page
{
    /**
     * @return array<string, string>
     */
    public function breadcrumbs(): array
    {
        return [
            '#' => $this->title()
        ];
    }

    public function title(): string
    {
        return $this->title ?: 'Dashboard';
    }

    /**
     * @return list<MoonShineComponent>
     */
    public function components(): array
    {
        return [
            ValueMetric::make('Общее количество товаров')->value(fn() => $this->getProductsCount()),
            ValueMetric::make('Общее количество категорий')->value(fn() => $this->getCategoriesCount()),
            ValueMetric::make('Общее количество заказов')->value(fn() => $this->getOrdersCount()),
            ValueMetric::make('Общая выручка')->value(fn() => $this->getTotalEarnings() . ' ₽'),
            ValueMetric::make('Прогноз продаж (на день)')->value(fn() => $this->getSalesForecast() . ' ₽'),

            // График продаж
            LineChartMetric::make('Продажи и среднее значение заказа')
                ->line([
                    'Фактические продажи' => Order::query()
                        ->selectRaw('SUM(total_price) as total, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
                        ->groupBy('date')
                        ->pluck('total', 'date')
                        ->toArray(),
                    'Среднее значение заказа' => Order::query()
                        ->selectRaw('AVG(total_price) as avg, DATE_FORMAT(created_at, "%d.%m.%Y") as date')
                        ->groupBy('date')
                        ->pluck('avg', 'date')
                        ->toArray(),
                ], ['red', 'blue']) // Красный для фактических данных, синий для средней суммы заказа
                ->columnSpan(6) // Ширина блока для десктопной версии
                ->withoutSortKeys() // Отключаем сортировку по ключам
        ];
    }





    /**
     * Регистрируем ресурсы на панели администратора
     *
     * @return array
     */
    public function resources(): array
    {
        return [
            ProductResource::class,
            CategoryResource::class,
        ];
    }


    private function getOrdersCount(): int
    {
        return DB::table('orders')->count(); // Используем прямой SQL-запрос
    }

    private function getProductsCount(): int
    {
        return DB::table('products')->count(); // Прямой SQL-запрос для подсчёта товаров
    }

    private function getCategoriesCount(): int
    {
        return DB::table('categories')->count(); // Прямой SQL-запрос для подсчёта категорий
    }

    private function getTotalEarnings(): float
    {
        return (float) DB::table('orders')->sum('total_price'); // Суммируем значения в колонке `total`
    }

    private function getSalesForecast(): float
    {
        // Получаем данные о продажах за последние 3 дня (включая сегодня)
        $sales = DB::table('orders')
            ->selectRaw('SUM(total_price) as total_price, DATE(created_at) as day')
            ->groupBy('day')
            ->orderBy('day', 'desc')
            ->take(3)  // Берем только 3 дня
            ->pluck('total_price', 'day')
            ->reverse() // Переворачиваем данные, чтобы последние дни были в начале
            ->values()
            ->toArray();

        // Если данных нет, возвращаем 0
        if (empty($sales)) {
            return 0.0;
        }

        // Прогнозирование с использованием скользящего среднего
        $result = $this->calculateSimpleMovingAverage($sales, 3); // Используем 3-дневный период
        return $result['forecast']; // Возвращаем прогноз на завтра
    }


    public static function calculateSimpleMovingAverage(array $data, int $period): array
    {
        $forecast = []; // Массив для хранения прогнозных значений.
        $count = count($data); // Общее количество элементов в массиве данных.

        // Проходим по каждому элементу массива данных.
        for ($i = $period - 1; $i < $count; $i++) {
            // Извлекаем последние $period элементов массива, начиная с текущего индекса.
            $window = array_slice($data, $i - $period + 1, $period);

            // Считаем сумму элементов в окне и делим на период для получения среднего.
            $sum = array_sum($window);
            $forecast[] = $sum / $period; // Добавляем среднее значение в прогнозный массив.
        }

        $lastPrediction = end($forecast);

        $predicted = $lastPrediction + (1 / $period) * ($data[$count - 1] - $data[$count - 2]);

        return [
            'forecast' => round($predicted), // Прогнозируемое значение.
            'average_relative_error' => self::calculateAverageRelativeError($data, $forecast), // Средняя относительная ошибка.
        ];
    }

    private static function calculateAverageRelativeError(array $actual, array $predicted): float
    {
        $errors = self::calculateRelativeErrors($actual, $predicted);

        return array_sum($errors) / count($errors);
    }

    private static function calculateRelativeErrors(array $actual, array $predicted): array
    {
        $errors = [];
        foreach ($actual as $index => $value) {
            if (isset($predicted[$index])) {
                $errors[] = abs($value - $predicted[$index]) / $value * 100;
            }
        }

        return $errors;
    }
}
