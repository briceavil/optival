<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;

class OrderChart extends ChartWidget
{
    protected static ?string $heading = 'Ordenes';
    protected int | string | array $columnSpan = [
        'sm' => 1,
        'md' => 1,
        'xl' => 1,
    ];
    protected function getData(): array
    {

        $delivered = Order::where('delivered', true)->count();
        $nonDelivered = Order::where('delivered', false)->count();

        return [
            'datasets' => [
                [
                    'label' => 'Ordenes',
                    'data' => [$delivered, $nonDelivered],
                    'backgroundColor' => ['#4caf50', '#f44336'],
                    'borderColor' => '#FFFFFF',
                ],
            ],
            'labels' => ['Entregados', 'Por entregar']
        ];
    }

    protected function getType(): string
    {
        return 'pie';
    }
}
