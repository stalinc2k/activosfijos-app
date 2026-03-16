<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Models\Category;
use App\Models\Trademark;
use App\Models\Type;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('code')
                    ->label('Código')
                    ->minLength(5)
                    ->maxLength(10)
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->required(),
                TextInput::make('name')
                    ->label('Nombre corto')
                    ->minLength(10)
                    ->maxLength(100)
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->required(),
                Textarea::make('description')
                    ->label('Descripción')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->columnSpanFull(),
                Textarea::make('model')
                    ->label('Modelo')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->columnSpanFull(),
                Textarea::make('serial_number')
                    ->label('Serie')
                    ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                    ->columnSpanFull(),
                TextInput::make('cost')
                    ->label('Precio')
                    ->numeric()
                    ->prefix('$'),
                Select::make('status')
                    ->label('Estado')
                    ->options(['enabled' => 'Enabled', 'disabled' => 'Disabled', 'low' => 'Low'])
                    ->default('enabled')
                    ->required(),
               /*  TextInput::make('created_by')
                    ->numeric(),
                TextInput::make('updated_by')
                    ->numeric(),
                TextInput::make('deleted_by')
                    ->numeric(), */
                Select::make('trademark_id')
                    ->label('Marca')
                    ->options(Trademark::query()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->required(),
                Select::make('category_id')
                    ->label('Categoría')
                    ->options(Category::query()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->required(),
                Select::make('type_id')
                    ->label('Tipo')
                    ->options(Type::query()->pluck('name', 'id'))
                    ->searchable()
                    ->live()
                    ->required(),
               
            ]);
    }
}
