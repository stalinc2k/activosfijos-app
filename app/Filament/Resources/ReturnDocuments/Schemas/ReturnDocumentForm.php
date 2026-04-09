<?php

namespace App\Filament\Resources\ReturnDocuments\Schemas;

use App\Models\DocumentItem;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class ReturnDocumentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                // 🔹 FECHA
                DatePicker::make('date')
                    ->label('Fecha')
                    ->default(now())
                    ->required(),

                // 🔹 EMPLEADO (QUIEN DEVUELVE)
                Select::make('returned_by')
                    ->label('Empleado')
                    ->relationship('returned', 'name')
                    ->searchable()
                    ->preload()
                    ->reactive()
                    ->live()
                    ->required()
                    ->afterStateUpdated(function ($set) {
                        $set('items', []); // 🔥 limpia repeater
                    }),

                // 🔹 OBSERVACIÓN
                Textarea::make('Observation')
                    ->label('Observaciones')
                    ->dehydrateStateUsing(fn($state) => strtoupper($state))
                    ->columnSpanFull(),

                // 🔥 DETALLE
                Repeater::make('items')
                    ->relationship()
                    ->label('Activos a devolver')
                    ->schema([

                        // 📦 PRODUCTO
                        Select::make('product_id')
                            ->label('Producto')
                            ->required()
                            ->reactive()
                            ->searchable()
                            ->options(function (Get $get) {

                                $employeeId = $get('../../returned_by');

                                if (!$employeeId) return [];

                                return DocumentItem::with('product')
                                    ->whereHas('document', function ($q) use ($employeeId) {
                                        $q->where('type', 'Entrega')
                                            ->where('delivered_to', $employeeId);
                                    })
                                    ->get()
                                    ->filter(function ($item) {

                                        return !DocumentItem::isSerieInStock(
                                            $item->product_id,
                                            $item->serie_number
                                        );
                                    })
                                    ->mapWithKeys(function ($item) {
                                        return [$item->product_id => $item->product->name];
                                    })
                                    ->unique();
                            }),
                        // 🔢 SERIE
                        Select::make('serie_number')
                            ->label('Serie')
                            ->required()
                            ->searchable()
                            ->options(function (Get $get, $record) {

                                $employeeId = $get('../../returned_by');
                                $productId = $get('product_id');

                                if (!$employeeId || !$productId) return [];

                                $query = DocumentItem::with('document')
                                    ->where('product_id', $productId)
                                    ->whereHas('document', function ($q) use ($employeeId) {
                                        $q->where('type', 'Entrega')
                                            ->where('delivered_to', $employeeId);
                                    });

                                $items = $query->get();

                                return $items
                                    ->filter(function ($item) use ($record) {

                                        // 🔥 permitir la serie actual aunque esté en stock
                                        if ($record && $record->serie_number === $item->serie_number) {
                                            return true;
                                        }

                                        return !DocumentItem::isSerieInStock(
                                            $item->product_id,
                                            $item->serie_number
                                        );
                                    })
                                    ->pluck('serie_number', 'serie_number');
                            }),

                        // 🔢 CANTIDAD
                        Hidden::make('quantity')->default(1),

                    ])
                    ->columns(2)
                    ->defaultItems(1)
                    ->addActionLabel('Devolver activo')
                    ->reorderable(false)
                    ->collapsible()
                    ->columnSpanFull(),

            ]);
    }
}
