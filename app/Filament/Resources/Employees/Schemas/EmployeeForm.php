<?php

namespace App\Filament\Resources\Employees\Schemas;

use App\Models\Appointment;
use App\Models\Department;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Collection;

class EmployeeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Apellidos - Nombres')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->required(),
                TextInput::make('mail')
                    ->label('Correo Empresarial')
                    ->email(),
                Select::make('department_id')
                    ->label('Departamento')
                    ->options(Department::query()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->afterStateUpdated(fn (Set $set) => $set('appointment_id', null))
                    ->required(),
                Select::make('appointment_id')
                    ->label('Cargo')
                    ->options(fn (Get $get): Collection => Appointment::query()
                        ->where('department_id', $get('department_id'))
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
            ]);
    }
}
