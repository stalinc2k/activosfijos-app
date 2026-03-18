<?php

namespace App\Filament\Resources\Products\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label('Código')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nombre Corto')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('trademark.name')
                    ->label('Marca')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->label('Categoría')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('cost')
                    ->label('Precio')
                    ->money()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('type.name')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Estado')
                    ->searchable()
                    ->badge(),
                TextColumn::make('creator.name')
                    ->label('Creado por')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')
                    ->label('Actualizado por')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                 TextColumn::make('deleted_at')
                    ->label('Eliminado el')
                    ->dateTime()
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                 TextColumn::make('deleter.name')
                    ->label('Eliminado por')
                    ->sortable()
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()->label('Registros Eliminados'),
            ])
            ->recordActions([
                ViewAction::make()
                ->label('Ver'),
                EditAction::make()
                ->label('Editar'),
                DeleteAction::make()
                ->label('Eliminar'),
                ForceDeleteAction::make()
                ->label('Eliminar de BD'),
                RestoreAction::make()
                ->label('Restaurar'),
            ])
            ->toolbarActions([
              BulkActionGroup::make([
                    DeleteBulkAction::make()
                    ->label('Eliminar Todo'),
                    ForceDeleteBulkAction::make()
                    ->label('Eliminar de BD'),
                    RestoreBulkAction::make()
                    ->label('Restaurar Todo'),
                ])
                ->label('Acciones'),
            ]);
    }
}
