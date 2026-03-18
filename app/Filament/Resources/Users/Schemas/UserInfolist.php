<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name')
                    ->label('Usuario'),
                TextEntry::make('email')
                    ->label('Correo'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->hidden(),
                TextEntry::make('type')
                    ->label('Tipo'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->label('Creado el'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->label('Modificado el'),
            ]);
    }
}
