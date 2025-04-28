<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Filament\Resources\OrderResource\Widgets\OrderStatsOverview;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageOrders extends ManageRecords
{
    protected static string $resource = OrderResource::class;
    protected static ?string $title = 'Ordenes';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Nueva Orden'),
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            OrderStatsOverview::class,
        ];
    }
}
