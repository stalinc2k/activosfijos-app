<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Document;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DocumentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('type')
                    ->label('Tipo Documento')
                    ->badge(),
                TextEntry::make('date')
                    ->label('Fecha')
                    ->dateTime(),
                 TextEntry::make('created_at')
                    ->label('Creado el')     
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('creator.name')
                    ->label('Creado por')
                    ->placeholder('-'),
                TextEntry::make('delivered.name')
                    ->label('Entregado a')
                    ->placeholder('-'),
                TextEntry::make('returned.name')
                    ->label('Devuelto por:')
                    ->placeholder('-'),
                TextEntry::make('Observation')
                    ->label('Observaciones')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('deleted_at')
                    ->label('Eliminado el')
                    ->dateTime()
                    ->visible(fn (Document $record): bool => $record->trashed()),
                TextEntry::make('deleter.name')
                    ->label('Eliminado por')
                    ->placeholder('-')
                    ->visible(fn (Document $record): bool => $record->trashed()),
                TextEntry::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updater.name')
                    ->label('Actualizado por')
                    ->placeholder('-'),
            ]);
    }
}
