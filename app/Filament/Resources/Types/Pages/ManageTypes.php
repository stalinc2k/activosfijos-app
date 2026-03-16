<?php

namespace App\Filament\Resources\Types\Pages;

use App\Filament\Resources\Types\TypesResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageTypes extends ManageRecords
{
    protected static string $resource = TypesResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nuevo Tipo'),
        ];
    }
}
