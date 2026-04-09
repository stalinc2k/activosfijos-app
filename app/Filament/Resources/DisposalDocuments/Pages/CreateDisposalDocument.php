<?php

namespace App\Filament\Resources\DisposalDocuments\Pages;

use App\Filament\Resources\DisposalDocuments\DisposalDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDisposalDocument extends CreateRecord
{
    protected static string $resource = DisposalDocumentResource::class;

    protected static ?string $title = 'Nueva Baja de Activo';
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'Baja';
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['type'] = 'Baja';
        return $data;
    }
}
