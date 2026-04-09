<?php

namespace App\Filament\Resources\OutputDocuments\Pages;

use App\Filament\Resources\OutputDocuments\OutputDocumentResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOutputDocuments extends ListRecords
{
    protected static string $resource = OutputDocumentResource::class;
   
    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Nueva Asignación'),
        ];
    }
}
