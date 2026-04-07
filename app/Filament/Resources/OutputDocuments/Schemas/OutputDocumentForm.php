<?php

namespace App\Filament\Resources\OutputDocuments\Schemas;

use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class OutputDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([

                // 📅 FECHA
                DatePicker::make('date')
                    ->label('Fecha')
                    ->default(now())
                    ->required(),

                // 👤 EMPLEADO
                Select::make('delivered_to')
                    ->label('Entregado a')
                    ->relationship('delivered', 'name')
                    ->preload()
                    ->searchable()
                    ->required(),

                // 📝 OBSERVACIÓN
                Textarea::make('Observation')
                    ->label('Observaciones')
                    ->dehydrateStateUsing(fn($state) => strtoupper($state))
                    ->columnSpanFull(),

                // 🔁 ITEMS
                Repeater::make('items')
                    ->relationship()
                    ->label('Activos entregados')
                    ->schema([

                        // 📦 PRODUCTO
                        Select::make('product_id')
                            ->label('Producto')
                            ->required()
                            ->searchable()
                            ->options(function () {
                                return Product::whereHas('category', function ($q) {
                                    $q->where('category_id', 1); // 👈 ajusta según tu BD
                                })->pluck('name', 'id');
                            })
                            ->reactive()
                            ->afterStateUpdated(fn($set) => $set('serie_number', null)),

                        // 🔢 SERIE
                        Select::make('serie_number')
                            ->label('Serie')
                            ->required()
                            ->options(function (Get $get) {

                                $productId = $get('product_id');
                                $currentSerie = $get('serie_number'); // 👈 clave

                                if (!$productId) return [];

                                return \App\Models\DocumentItem::query()
                                    ->where('product_id', $productId)
                                    ->whereNotNull('serie_number')
                                    ->get()
                                    ->filter(function ($item) use ($productId, $currentSerie) {

                                        // 🔥 permitir la serie actual aunque no esté en stock
                                        if ($item->serie_number === $currentSerie) {
                                            return true;
                                        }

                                        return \App\Models\DocumentItem::isSerieInStock(
                                            $productId,
                                            $item->serie_number
                                        );
                                    })
                                    ->pluck('serie_number', 'serie_number')
                                    ->toArray();
                            })
                            ->searchable()
                            ->reactive()
                            ->dehydrateStateUsing(fn($state) => strtoupper($state)),

                        // 🔒 quantity fijo
                        Hidden::make('quantity')->default(1),

                    ])
                    ->columns(2)
                    ->defaultItems(1)
                    ->addActionLabel('Agregar activo')
                    ->reorderable(false)
                    ->columnSpanFull(),

            ]);
    }
}
