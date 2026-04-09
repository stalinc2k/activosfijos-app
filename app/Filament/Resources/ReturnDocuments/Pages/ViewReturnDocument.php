<?php

namespace App\Filament\Resources\ReturnDocuments\Pages;

use App\Filament\Resources\ReturnDocuments\ReturnDocumentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewReturnDocument extends ViewRecord
{
    protected static string $resource = ReturnDocumentResource::class;
    protected static ?string $title = 'Ver Devolución';
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->label('Editar'),
        ];
    }
}
