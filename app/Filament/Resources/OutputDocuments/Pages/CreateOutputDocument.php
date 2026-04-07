<?php

namespace App\Filament\Resources\OutputDocuments\Pages;

use App\Filament\Resources\OutputDocuments\OutputDocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateOutputDocument extends CreateRecord
{
    protected static string $resource = OutputDocumentResource::class;
    protected static ?string $title = 'Nueva Asignación';
    protected function mutateFormDataBeforeCreate(array $data): array
        {
            $data['type'] = 'Entrega';
            return $data;
        }

    protected function mutateFormDataBeforeSave(array $data): array
        {
            $data['type'] = 'Entrega';
            return $data;
        }
}
