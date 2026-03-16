<?php

namespace App\Filament\Resources\Trademarks\Pages;

use App\Filament\Resources\Trademarks\TrademarkResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTrademarks extends ManageRecords
{
    protected static string $resource = TrademarkResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
            ->label('Nueva Marca'),
        ];
    }
}
