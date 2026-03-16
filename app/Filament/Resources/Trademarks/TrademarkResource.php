<?php

namespace App\Filament\Resources\Trademarks;

use App\Enums\NavigationGroupEnum;
use App\Filament\Resources\Trademarks\Pages\ManageTrademarks;
use App\Models\Trademark;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class TrademarkResource extends Resource
{
    protected static ?string $model = Trademark::class;

     //ASIGNAMOS AL GRUPO DE GESTION
    protected static string | UnitEnum | null $navigationGroup = NavigationGroupEnum::Productos->value;
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationLabel = 'Marcas';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Trademark';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre:')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->required(),
              
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre:'),
                
                TextEntry::make('created_at')
                    ->label('Creado el:')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('creator.name')
                    ->label('Creado por:')
                    ->placeholder('-'),
                
                TextEntry::make('updated_at')
                    ->label('Actualizado el:')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updater.name')
                    ->label('Actualizado por:')
                    ->placeholder('-'),

                TextEntry::make('deleted_at')
                    ->label('Eliminado el:')
                    ->dateTime()
                    ->visible(fn(Trademark $record): bool => $record->trashed()),
                TextEntry::make('deleter.name')
                    ->label('Eliminado por:')
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Trademark')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre Marca')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('creator.name')
                    ->Label('Creado por')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->Label('Fecha Creación')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->Label('Fecha Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')
                    ->Label('Actualizado por')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->Label('Fecha Eliminación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('deleter.name')
                    ->Label('Eliminado por')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                
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

    public static function getPages(): array
    {
        return [
            'index' => ManageTrademarks::route('/'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
