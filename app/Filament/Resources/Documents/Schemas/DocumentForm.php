<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\DocumentItem;
use App\Models\Product;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 📅 FECHA
                DatePicker::make('date')
                    ->label('Fecha')
                    ->default(now())
                    ->required(),

                // 🏢 PROVEEDOR (GLOBAL)
                Select::make('provider_id')
                    ->label('Proveedor')
                    ->relationship('provider', 'name')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->required()
                    ->afterStateUpdated(fn($set) => $set('items', [])),

                TextInput::make('num_doc')
                    ->label('No. Factura')
                    ->required()
                    ->placeholder('Digite Factura'),

                // 📝 OBSERVACIÓN
                Textarea::make('Observation')
                    ->label('Observaciones')
                    ->dehydrateStateUsing(fn($state) => strtoupper($state))
                    ->columnSpanFull(),

                // 🔁 ITEMS (ACTIVOS)
                Repeater::make('items')
                    ->relationship()
                    ->label('Activos ingresados')
                    ->schema([

                        // 📦 PRODUCTO
                        Select::make('product_id')
                            ->label('Producto')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->reactive()
                            ->options(function (Get $get, $livewire) {

                                $providerId = $livewire->data['provider_id'] ?? null;

                                if (!$providerId) return [];

                                return Product::query()
                                    ->where('provider_id', $providerId)
                                    ->pluck('name', 'id');
                            })
                            ->disabled(fn($livewire) => empty($livewire->data['provider_id']))
                            ->afterStateUpdated(function ($state, callable $set) {

                                if (!$state) {
                                    $set('trademark_id', null);
                                    $set('trademark_name', null);
                                    return;
                                }

                                $product = Product::with('trademark')->find($state);

                                if ($product && $product->trademark) {
                                    $set('trademark_id', $product->trademark->id);
                                    $set('trademark_name', $product->trademark->name);
                                }
                            }),

                        // 🏷️ MARCA (OCULTA REAL)
                        Hidden::make('trademark_id'),

                        // 👁️ MARCA (VISIBLE)
                        TextInput::make('trademark_name')
                            ->label('Marca')
                            ->disabled()
                            ->dehydrated(false)
                            ->afterStateHydrated(function ($state, callable $set, callable $get) {

                                $productId = $get('product_id');

                                if (!$productId) return;

                                $product = Product::with('trademark')->find($productId);

                                if ($product && $product->trademark) {
                                    $set('trademark_name', $product->trademark->name);
                                }
                            }),

                        // 🔢 SERIE (OBLIGATORIA Y ÚNICA)
                        TextInput::make('serie_number')
                            ->label('Serie')
                            ->required()
                            ->distinct()
                            ->dehydrateStateUsing(fn($state) => strtoupper($state))
                            ->reactive()
                            ->rule(function (Get $get) {
                                return function ($attribute, $value, $fail) use ($get) {

                                    $productId = $get('product_id');
                                    $itemId = $get('id');

                                    if (!$productId || !$value) return;

                                    $existsInStock = DocumentItem::isSerieInStock(
                                        $productId,
                                        $value,
                                        $itemId // 👈 clave
                                    );

                                    if ($existsInStock) {
                                        $fail("La serie ya existe en inventario.");
                                    }
                                };
                            }),
                        Hidden::make('quantity')
                            ->default(1),

                        // 💲 COSTO
                        TextInput::make('unit_cost')
                            ->label('Costo')
                            ->numeric()
                            ->prefix('$'),

                    ])
                    ->columns(4)
                    ->defaultItems(1)
                    ->addActionLabel('Agregar activo')
                    ->reorderable(false)
                    ->collapsible()
                    ->columnSpanFull(),

            ]);
    }
}
