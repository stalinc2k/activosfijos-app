<?php

namespace App\Filament\Resources\DisposalDocuments\Pages;

use App\Filament\Resources\DisposalDocuments\DisposalDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDisposalDocuments extends ListRecords
{
    protected static string $resource = DisposalDocumentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nueva Baja'),
        ];
    }
}
