<?php

namespace App\Filament\Resources\OutputDocuments\Pages;

use App\Filament\Resources\OutputDocuments\OutputDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOutputDocument extends EditRecord
{
    protected static string $resource = OutputDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make()->label('Ver'),
            DeleteAction::make()->label('Eliminar'),
            ForceDeleteAction::make()->label('Eliminar de BD'),
            RestoreAction::make()->label('Restaurar'),
        ];
    }
}
