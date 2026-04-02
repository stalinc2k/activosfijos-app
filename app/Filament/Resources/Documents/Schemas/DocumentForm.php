<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\Employee;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('date')
                    ->label('Fecha')
                    ->default(now())
                    ->required(),
                Select::make('delivered_to')
                    ->label('Entragado a')
                    ->required()
                    ->searchable()
                    ->options(Employee::query()->pluck('name', 'id')),
                /* TextInput::make('returned.name')
                    ->label('Devuelto por:'), */
                Select::make('type')
                    ->label('Tipo documento')
                    ->options(['Entrada' => 'Entrada', 'Devolucion' => 'Devolucion'])
                    ->default('Entrada')
                    ->required(),
                Textarea::make('Observation')
                    ->label('Observaciones')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->columnSpanFull(),
            ])->columns(3);
    }
}
