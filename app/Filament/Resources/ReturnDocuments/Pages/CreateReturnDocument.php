<?php

namespace App\Filament\Resources\ReturnDocuments\Pages;

use App\Filament\Resources\ReturnDocuments\ReturnDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateReturnDocument extends CreateRecord
{
    protected static string $resource = ReturnDocumentResource::class;
    
   protected static ?string $title = 'Nueva Devolucion';
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'Devolucion';
        $data['delivered_to'] = 1;
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['type'] = 'Devolucion';
        $data['delivered_to'] = 1;
        return $data;
    }
}
