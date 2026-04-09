<?php

namespace App\Filament\Resources\DisposalDocuments\Pages;

use App\Filament\Resources\DisposalDocuments\DisposalDocumentResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditDisposalDocument extends EditRecord
{
    protected static string $resource = DisposalDocumentResource::class;
    protected static ?string $title = 'Editar Baja';

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
