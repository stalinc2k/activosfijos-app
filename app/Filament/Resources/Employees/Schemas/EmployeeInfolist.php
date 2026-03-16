<?php

namespace App\Filament\Resources\Employees\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EmployeeInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Empleado:'),
                TextEntry::make('mail')
                    ->label('Correo Empresarial:')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->label('Creado el:')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->label('Actualizado el:')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('creator.name')
                    ->label('Creado por:')
                    ->placeholder('-'),
                TextEntry::make('updater.name')
                    ->label('Actualizado por:')
                    ->placeholder('-'),
                TextEntry::make('department.name')
                    ->label('Departamento')
                    ->placeholder('-'),
                TextEntry::make('appointment.name')
                    ->label('Cargo')
                    ->placeholder('-'),
            ]);
    }
}
