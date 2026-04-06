<?php

namespace App\Filament\Resources\Documents\Schemas;

use App\Models\DocumentItem;
use App\Models\Employee;
use App\Models\Product;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class DocumentForm
{
    public static function configure(Schema $schema): Schema
    {
       return $schema
        ->components([
            DatePicker::make('date')
                ->label('Fecha')
                ->default(now())
                ->required(),

            Select::make('delivered_to')
                ->label('Entregado a')
                ->required()
                ->searchable()
                ->options(Employee::query()->pluck('name', 'id')),

            Select::make('type')
                ->label('Tipo documento')
                ->options([
                    'Entrada' => 'Entrada',
                    'Devolucion' => 'Devolucion'
                ])
                ->default('Entrada')
                ->required(),

            Textarea::make('Observation')
                ->label('Observaciones')
                ->dehydrateStateUsing(fn ($state) => strtoupper($state))
                ->columnSpanFull(),

            Repeater::make('items')
                ->relationship()
                ->label('Detalle del documento')
                ->schema([

                    // 🔹 PROVEEDOR
                    Select::make('provider_id')
                        ->label('Proveedor')
                        ->relationship('provider', 'name')
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->required()
                        ->afterStateUpdated(function ($set) {
                            $set('product_id', null);
                            $set('trademark_id', null);
                            $set('trademark_name', null);
                        })
                        ->placeholder('Seleccione')
                        ->columnSpan(1),

                    // 🔹 PRODUCTO
                    Select::make('product_id')
                        ->label('Producto')
                        ->required()
                        ->searchable()
                        ->preload()
                        ->reactive()
                        ->disabled(fn(Get $get) => !$get('provider_id'))
                        ->options(function (Get $get) {
                            $providerId = $get('provider_id');

                            if (!$providerId) {
                                return [];
                            }

                            return Product::query()
                                ->where('provider_id', $providerId)
                                ->pluck('name', 'id');
                        })
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
                            } else {
                                $set('trademark_id', null);
                                $set('trademark_name', null);
                            }
                        })
                        ->columnSpan(1),

                    // 🔹 ID REAL (SE GUARDA)
                    Hidden::make('trademark_id'),

                    // 🔹 MARCA (SOLO VISUAL)
                    TextInput::make('trademark_name')
                        ->label('Marca')
                        ->disabled()
                        ->dehydrated(false)
                        ->columnSpan(1)
                        ->afterStateHydrated(function ($state, callable $set, callable $get) {

                            $productId = $get('product_id');

                            if (!$productId) return;

                            $product = Product::with('trademark')->find($productId);

                            if ($product && $product->trademark) {
                                $set('trademark_name', $product->trademark->name);
                            }
                        }),

                    // 🔹 SERIE
                    TextInput::make('serie_number')
                        ->label('Serie')
                        ->required()
                        ->reactive()
                        ->distinct()
                        ->rule(function (Get $get, $livewire) {
                            return function ($attribute, $value, $fail) use ($get, $livewire) {

                                $productId = $get('product_id');
                                $type = $livewire->data['type'] ?? null;

                                if (!$productId || !$value) return;

                                $existsInStock = DocumentItem::isSerieInStock($productId, $value);

                                if ($type === 'Entrada' && $existsInStock) {
                                    $fail("La serie ya existe en inventario.");
                                }

                                if (in_array($type, ['Entrega', 'Baja']) && !$existsInStock) {
                                    $fail("La serie no existe en inventario.");
                                }
                            };
                        })
                        ->columnSpan(1),

                    // 🔹 CANTIDAD
                    TextInput::make('quantity')
                        ->label('Cantidad')
                        ->numeric()
                        ->default(1)
                        ->minValue(1)
                        ->required()
                        ->columnSpan(1),

                    // 🔹 COSTO
                    TextInput::make('unit_cost')
                        ->label('Costo Unitario')
                        ->numeric()
                        ->prefix('$')
                        ->columnSpan(1),

                ])
                ->columns(6)
                ->defaultItems(1)
                ->addActionLabel('Agregar producto')
                ->reorderable(false)
                ->collapsible()
                ->columnSpanFull()
        ]);
    }
}
