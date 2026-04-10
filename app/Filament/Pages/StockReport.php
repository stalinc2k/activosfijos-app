<?php

namespace App\Filament\Pages;

use App\Enums\NavigationGroupEnum;
use App\Models\StockDisponible;
use BackedEnum;
use Filament\Pages\Page;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use UnitEnum;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;


class StockReport extends Page implements HasTable
{
    protected string $view = 'filament.pages.stock-report';
    use InteractsWithTable;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $title = 'Stock Activos';
    protected static ?string $navigationLabel = 'Stock Activos';
    protected static string | UnitEnum | null $navigationGroup = NavigationGroupEnum::ReportesAct->value;
    protected static ?int $navigationSort = 20;

    // 🔥 QUERY DIRECTO A SQL (ULTRA RÁPIDO)

    public function table(Table $table): Table
    {
        return $table
            ->query(StockDisponible::query())

            ->columns([

                Tables\Columns\TextColumn::make('id')
                    ->label('Producto')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('Activo')
                    ->label('Descripción Activo')
                    ->searchable()
                    ->sortable(),
                 Tables\Columns\TextColumn::make('Marca')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('Serial_number')
                    ->label('Serie')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('stock')
                    ->label('Stock')
                    ->badge()
                    ->color('success'),

            ])

            ->filters([

                Tables\Filters\SelectFilter::make('id')
                    ->label('Producto')
                    ->options(
                        fn() =>
                        StockDisponible::query()
                            ->pluck('id', 'Activo')
                    ),

            ])

            ->defaultSort('Activo');
    }
}
