<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                TextInput::make('age')
                ->inputMode('decimal')
                ->length(2),
                TextInput::make('address')
                    ->required(),
                DateTimePicker::make('email_verified_at')
                    ->hidden(),
                TextInput::make('password')
                    ->password()
                    ->required(),
            ]);
    }
}
