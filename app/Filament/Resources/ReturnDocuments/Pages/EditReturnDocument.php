<?php

namespace App\Filament\Resources\ReturnDocuments\Pages;

use App\Filament\Resources\ReturnDocuments\ReturnDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditReturnDocument extends EditRecord
{
    protected static string $resource = ReturnDocumentResource::class;
    protected static ?string $title = 'Editar Devolucion';
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
