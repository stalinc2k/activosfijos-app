<?php

namespace App\Filament\Resources\DisposalDocuments\Pages;

use App\Filament\Resources\DisposalDocuments\DisposalDocumentResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewDisposalDocument extends ViewRecord
{
    protected static string $resource = DisposalDocumentResource::class;
    protected static ?string $title = 'Ver Baja';

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make()->label('Editar'),
        ];
    }
}
