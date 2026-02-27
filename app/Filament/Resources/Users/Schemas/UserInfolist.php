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
                    ->label('Nombre Usuario'),
                TextEntry::make('email')
                    ->label('Dirección Correo'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->hidden(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->label('Fecha Creación'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-')
                    ->label('Fecha Modificación'),
            ]);
    }
}
