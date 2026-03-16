<?php

namespace App\Filament\Resources\Types;

use App\Enums\NavigationGroupEnum;
use App\Filament\Resources\Types\Pages\ManageTypes;
use App\Models\Category;
use App\Models\Type;
use App\Models\Types;
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
use Filament\Forms\Components\Select;
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
use Illuminate\Support\Collection;
use Ramsey\Collection\Set;
use UnitEnum;

class TypesResource extends Resource
{
    protected static ?string $model = Type::class;

     //ASIGNAMOS AL GRUPO DE GESTION
    protected static string | UnitEnum | null $navigationGroup = NavigationGroupEnum::Productos->value;
    protected static ?int $navigationSort = 8;
    protected static ?string $navigationLabel = 'Tipos';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Types';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre Tipo:')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->required(),

            Select::make('category_id')
                    ->label('Categoría')
                    ->options(Category::query()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->required(),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Nombre Tipo'),
                TextEntry::make('category.name')
                    ->label('Categoría:')
                    ->placeholder('-'),
                
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
                    ->visible(fn(Type $record): bool => $record->trashed()),
                TextEntry::make('deleter.name')
                    ->label('Eliminado por:')
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Type')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre Tipo')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('category.name')
                    ->Label('Categoría')
                    ->sortable(),
                TextColumn::make('creator.name')
                    ->Label('Creado por')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->Label('Creado el')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->Label('Actualizado el')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updater.name')
                    ->Label('Actualizado por')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('deleted_at')
                    ->Label('Eliminado el')
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
            'index' => ManageTypes::route('/'),
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
