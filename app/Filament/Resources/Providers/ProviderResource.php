<?php

namespace App\Filament\Resources\Providers;

use App\Enums\NavigationGroupEnum;
use App\Filament\Resources\Providers\Pages\ManageProviders;
use App\Models\Provider;
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

class ProviderResource extends Resource
{
    protected static ?string $model = Provider::class;
    //ASIGNAMOS AL GRUPO DE GESTION
    protected static string | UnitEnum | null $navigationGroup = NavigationGroupEnum::Productos->value;
    protected static ?int $navigationSort = 9;
    protected static ?string $navigationLabel = 'Proveedores'; //Permite cambiar el nombre en el panel de navegacion
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Providers';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('ruc')
                    ->label('Ruc')
                    ->minLength(10)
                    ->maxLength(13)
                    ->required(),
                TextInput::make('name')
                    ->label('Razon Social')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->required(),
                TextInput::make('address')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->label('Dirección'),
                TextInput::make('phone')
                    ->label('Teléfono')
                    ->tel(),
               /*  TextInput::make('created_by')
                    ->numeric(),
                TextInput::make('updated_by')
                    ->numeric(),
                TextInput::make('deleted_by')
                    ->numeric(), */
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('ruc')
                    ->label('RUC'),
                TextEntry::make('name')
                    ->label('Razón Social'),
                TextEntry::make('address')
                    ->label('Dirección')
                    ->placeholder('-'),
                TextEntry::make('phone')
                    ->label('Teléfono')
                    ->placeholder('-'),
                TextEntry::make('creator.name')
                    ->label('Creado por')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Creado el')
                    ->dateTime()
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
                    ->visible(fn (Provider $record): bool => $record->trashed()),
                TextEntry::make('deleted_by')
                    ->label('Eliminado por')
                    ->visible(fn (Provider $record): bool => $record->trashed()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Providers')
            ->columns([
                TextColumn::make('ruc')
                    ->label('RUC')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Razón Social')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('address')
                    ->label('Dirección')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('phone')
                    ->label('Teléfono')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),
                 TextColumn::make('creator.name')
                    ->label('Creado por')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('created_at')
                    ->label('Creado el')
                    ->searchable()
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->label('Eliminado el')
                    ->searchable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Actualizado el')
                    ->searchable()
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')
                    ->label('Actualizado por')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('deleter.name')
                    ->label('Eliminado por')
                    ->searchable()
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
            'index' => ManageProviders::route('/'),
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
