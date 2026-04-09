<?php

namespace App\Filament\Resources\DisposalDocuments\Schemas;

use App\Models\DocumentItem;
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

            // 📅 FECHA
            DatePicker::make('date')
                ->label('Fecha')
                ->default(now())
                ->required(),

            // 📝 OBSERVACIÓN
            Textarea::make('Observation')
                ->label('Motivo de baja')
                ->dehydrateStateUsing(fn($state) => strtoupper($state))
                ->required()
                ->columnSpanFull(),

            // 🔥 ITEMS
            Repeater::make('items')
                ->relationship()
                ->label('Activos a dar de baja')
                ->schema([

                    // 📦 PRODUCTO
                    Select::make('product_id')
                        ->label('Producto')
                        ->required()
                        ->reactive()
                        ->options(function ($record) {

                            $items = DocumentItem::with('product')->get();

                            return $items
                                ->filter(function ($item) use ($record) {

                                    // ✅ permitir producto actual en edición
                                    if ($record && $record->product_id === $item->product_id) {
                                        return true;
                                    }

                                    // ✅ solo en stock
                                    return DocumentItem::isSerieInStock(
                                        $item->product_id,
                                        $item->serie_number
                                    );
                                })
                                ->mapWithKeys(function ($item) {
                                    return [$item->product_id => $item->product->name];
                                })
                                ->unique();
                        })
                        ->afterStateUpdated(fn($set) => $set('serie_number', null)),

                    // 🔢 SERIE (CON FIX PARA EDITAR)
                    Select::make('serie_number')
                        ->label('Serie')
                        ->required()
                        ->searchable()
                        ->options(function (Get $get, $record) {

                            $productId = $get('product_id');

                            if (!$productId) return [];

                            $items = DocumentItem::where('product_id', $productId)->get();

                            return $items
                                ->filter(function ($item) use ($record) {

                                    // ✅ PERMITIR LA MISMA SERIE EN EDICIÓN
                                    if ($record && $record->serie_number === $item->serie_number) {
                                        return true;
                                    }

                                    // ✅ SOLO ACTIVOS EN STOCK
                                    return DocumentItem::isSerieInStock(
                                        $item->product_id,
                                        $item->serie_number
                                    );
                                })
                                ->pluck('serie_number', 'serie_number');
                        })

                        // 🔥 VALIDACIÓN PRO
                        ->rule(function (Get $get, $record) {
                            return function ($attribute, $value, $fail) use ($get, $record) {

                                $productId = $get('product_id');

                                if (!$productId || !$value) return;

                                // ✅ SI ES EDICIÓN Y MISMA SERIE → PERMITIR
                                if ($record && $record->serie_number === $value) {
                                    return;
                                }

                                $inStock = DocumentItem::isSerieInStock($productId, $value);

                                if (!$inStock) {
                                    $fail("El activo no está disponible en inventario.");
                                }
                            };
                        }),

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
