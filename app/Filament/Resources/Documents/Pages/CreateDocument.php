<?php

namespace App\Filament\Resources\Documents\Pages;

use App\Filament\Resources\Documents\DocumentResource;
use Filament\Resources\Pages\CreateRecord;

class CreateDocument extends CreateRecord
{
    protected static string $resource = DocumentResource::class;
    protected static ?string $title = 'Nueva Entrada';
    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['type'] = 'Entrada';
        $data['delivered_to'] = 1;
        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['type'] = 'Entrada';
        $data['delivered_to'] = 1;
        return $data;
    }
} 
