<?php

namespace App\Filament\Resources\DisposalDocuments\Tables;

use App\Models\Document;
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

class DisposalDocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('type')
                    ->label('Tipo')
                    ->searchable()
                    ->sortable()
                    ->badge()->color('danger'),
                TextColumn::make('id')
                    ->label('Doc')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('date')
                    ->label('Fecha')
                    ->date()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creator.name')
                    ->label('Creador por')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('items')
                    ->label('Activos')
                    ->formatStateUsing(function ($record) {
                        return $record->items
                            ->map(fn($item) => $item->product->name . ' - ' . $item->serie_number)
                            ->join(', ');
                    })
                    ->wrap()
                    ->weight('bold')
                    ->searchable(query: function ($query, $search) {
                        $query->whereHas('items', function ($q) use ($search) {
                            $q->where('serie_number', 'like', "%{$search}%")
                                ->orWhereHas('product', function ($q2) use ($search) {
                                    $q2->where('name', 'like', "%{$search}%");
                                });
                        });
                    }),
                TextColumn::make('delivered.name')
                    ->label('Entregado a')
                    ->description(fn(Document $record): string => $record->Observation)
                    ->limit(50, end: ' (more)')
                    ->size('sm')
                    ->wrap()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('Observation')
                    ->label('Motivo')
                    ->wrap()
                    ->searchable()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')
                    ->label('Actualizado por')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleted_at')
                    ->label('Eliminado el')
                    ->dateTime()
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleter.name')
                    ->label('Eliminado por')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),


            ])
            ->filters([
                TrashedFilter::make()
                    ->label('Registros Eliminados'),
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
