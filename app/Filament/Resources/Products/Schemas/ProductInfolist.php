<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Product;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('code')
                    ->label('Código'),
                TextEntry::make('name')
                    ->label('Nombre corto'),
                TextEntry::make('description')
                    ->label('Descripción')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('model')
                    ->label('Modelo')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('serial_number')
                    ->label('Serie')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('cost')
                    ->label('Precio')
                    ->money()
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->label('Estado')
                    ->badge(),
                TextEntry::make('trademark.name')
                    ->label('Marca')
                    ->placeholder('-'),
                TextEntry::make('category.name')
                    ->label('Categoría')
                    ->placeholder('-'),
                TextEntry::make('type.name')
                    ->label('Tipo')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('creator.name')
                    ->label('Creado por')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updater.name')
                    ->label('Actualizado por')
                    ->placeholder('-'),
                TextEntry::make('deleted_at')
                    ->label('Eliminado el')
                    ->dateTime()
                    ->visible(fn (Product $record): bool => $record->trashed()),
                TextEntry::make('deleter.name')
                    ->label('Eliminado por')
                    ->visible(fn (Product $record): bool => $record->trashed()),

            ]);
    }
}
