<?php

namespace App\Filament\Resources\OutputDocuments\Pages;

use App\Filament\Resources\OutputDocuments\OutputDocumentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOutputDocument extends ViewRecord
{
    protected static string $resource = OutputDocumentResource::class;
    protected static ?string $title = 'Ver Asignacion';
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->label('Editar'),
        ];
    }
}
