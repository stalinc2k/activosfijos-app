<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nombres')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->required(),
                TextInput::make('email')
                    ->label('Correo')
                    ->email()
                    ->required(),
                Select::make('type')
                    ->label('Rol')
                    ->options(['user' => 'Usuario', 'admin' => 'Administrador'])
                    ->default('user')
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->hidden(),
                TextInput::make('password')
                    ->label('Contraseña')
                    ->password()
                    ->required(),
            ]);
    }
}
