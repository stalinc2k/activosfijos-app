<?php

namespace App\Filament\Resources\Appointments;

use App\Filament\Resources\Appointments\Pages\ManageAppointments;
use App\Models\Appointment;
use App\Models\Department;
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
use Filament\Forms\Components\Select;

class AppointmentResource extends Resource
{
    protected static ?string $model = Appointment::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $navigationLabel = 'Cargos';
    protected static ?string $recordTitleAttribute = 'Cargos';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombre Cargo')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->required(),
                Select::make('department_id')
                    ->label('Departamento')
                    ->required()
                    ->placeholder('Seleccione Departamento')
                    ->searchable()
                    ->options(Department::query()->pluck('name','id')),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Cargo'),
                TextEntry::make('department.name')
                    ->label('Departamento'),
                TextEntry::make('created_at')
                    ->Label('Fecha Creación')
                    ->dateTime(),
                TextEntry::make('creator.name')
                    ->Label('Creado por:')
                    ->placeholder('-'),
                TextEntry::make('updater.name')
                    ->Label('Actualizado por:')
                    ->placeholder('-'),
                TextEntry::make('deleter.name')
                    ->Label('Eliminado por:')
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->Label('Fecha Actualización')
                    ->dateTime(),
                TextEntry::make('deleted_at')
                    ->dateTime()
                    ->visible(fn (Appointment $record): bool => $record->trashed()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('Cargos')
            ->columns([
                TextColumn::make('name')
                    ->Label('Cargo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('department.name')
                    ->label('Departamento'),
                TextColumn::make('deleted_at')
                    ->Label('Fecha Eliminación')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('created_at')
                    ->Label('Fecha Creación')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->Label('Fecha Actualización')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('creator.name')
                    ->Label('Creado por')
                    ->sortable(),
                TextColumn::make('updater.name')
                    ->Label('Actualizado por')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
                TextColumn::make('deleter.name')
                    ->Label('Eliminado por')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->sortable(),
            ])
            ->filters([
                TrashedFilter::make(),
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
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageAppointments::route('/'),
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
