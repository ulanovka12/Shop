<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;

class SalesReportService
{
    /**
     * Отчёт за последнюю неделю (7 дней).
     * Все вычисления выполняются на стороне БД (SQL).
     */
    public function getLastWeekReport(): array
    {
        $ordersCount = Order::query()->count();

        $from = Carbon::now()->subDays(6)->startOfDay();
        $to   = Carbon::now()->endOfDay();

        // 1. Общее количество заказов за период
        // Метод count() сразу вернет число (SELECT COUNT(*))
        $ordersCount = Order::query()
            ->whereBetween('created_at', [$from, $to])
            ->count();

        // Создаем базовый запрос для успешных продаж, чтобы не дублировать код
        $successfulOrdersQuery = Order::query()
            ->whereBetween('created_at', [$from, $to])
            ->whereIn('status', [
                Order::STATUS_PAID,
                Order::STATUS_SHIPPED,
                Order::STATUS_COMPLETED,
            ]);

        // 2. Количество успешных продаж
        // Используем clone, чтобы не изменить оригинальный $successfulOrdersQuery
        $salesCount = (clone $successfulOrdersQuery)->count();

        // 3. Выручка (сумма total)
        // Метод sum('total') выполняется в БД (SELECT SUM(total))
        $revenue = (float) (clone $successfulOrdersQuery)->sum('total');

        // 4. Количество отмененных заказов
        $canceledCount = Order::query()
            ->whereBetween('created_at', [$from, $to])
            ->where('status', Order::STATUS_CANCELED)
            ->count();

        $successfulOrdersQuery = Order::query()
            ->whereBetween('created_at', [$from, $to])
            ->whereIn('status', [
                Order::STATUS_PAID,
                Order::STATUS_SHIPPED,
                Order::STATUS_COMPLETED,
            ]);

        // 5. Продажи по дням (группировка на стороне БД)
        // Мы просим БД сразу сгруппировать данные по дате и сложить суммы
        $dailyStatsRaw = (clone $successfulOrdersQuery)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, SUM(total) as revenue')
            ->groupBy('date')
            ->get()
            ->keyBy('date'); // Делаю коллекцию с ключами в виде дат для быстрого поиска

        // Формирую полный массив дней (даже если в какой-то день продаж не было)
        $dailySales = [];
        $cursor = $from->copy();

        while ($cursor->lte($to)) {
            $dateString = $cursor->format('Y-m-d');
            $dayData = $dailyStatsRaw->get($dateString);

            // Если данные за этот день есть — берем их из БД, если нет — ставим нули
            $dailySales[] = [
                'date'    => $dateString,
                'count'   => $dayData ? (int) $dayData->count : 0,
                'revenue' => $dayData ? (float) $dayData->revenue : 0.0,
            ];

            $cursor->addDay();
        }

        return [
            'ordersCount'   => $ordersCount,
            'salesCount'    => $salesCount,
            'revenue'       => $revenue,
            'canceledCount' => $canceledCount,
            'dailySales'    => $dailySales,

        ];
    }
}
