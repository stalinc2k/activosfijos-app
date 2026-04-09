<?php

namespace App\Filament\Resources\ReturnDocuments\Pages;

use App\Filament\Resources\ReturnDocuments\ReturnDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListReturnDocuments extends ListRecords
{
    protected static string $resource = ReturnDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nueva Devolución'),
        ];
    }
}
