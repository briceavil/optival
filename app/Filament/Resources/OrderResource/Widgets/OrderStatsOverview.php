<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStatsOverview extends BaseWidget
{
    protected static string $color = 'info';
    protected function getStats(): array
    {

        return [
            Stat::make('Ordenes totales', Order::all()->count())->icon('heroicon-m-clipboard-document-list'),
            Stat::make('Ordenes entregadas', Order::where('delivered', true)->count())->icon('heroicon-m-check-badge'),
            Stat::make('Ordenes pendientes', Order::where('delivered', false)->count())->icon('heroicon-m-x-circle'),
        ];
    }
}
