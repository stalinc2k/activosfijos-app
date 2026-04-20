<?php

namespace App\Filament\Resources\DisposalDocuments\Schemas;

use App\Models\DocumentItem;
use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class DisposalDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            DatePicker::make('date')
                ->label('Fecha')
                ->default(now())
                ->required(),

            Textarea::make('Observation')
                ->label('Motivo de baja')
                ->dehydrateStateUsing(fn($state) => strtoupper($state))
                ->required()
                ->columnSpanFull(),

            Repeater::make('items')
                ->relationship()
                ->label('Activos a dar de baja')
                ->schema([
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


                    Hidden::make('quantity')->default(1),

                ])
                ->columns(2)
                ->defaultItems(1)
                ->addActionLabel('Agregar activo')
                ->reorderable(false)
                ->collapsible()
                ->columnSpanFull(),
        ]);
    }
}
