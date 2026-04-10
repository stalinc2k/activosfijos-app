<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;

use App\Enums\NavigationGroupEnum;
use App\Models\Assignment;
use BackedEnum;
use Filament\Support\Enums\FontWeight;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use UnitEnum;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Concerns\InteractsWithTable;

class AssignmentReport extends Page implements HasTable
{
    protected string $view = 'filament.pages.assignment-report';

    use InteractsWithTable;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?string $title = 'Activos asignados';
    protected static ?string $navigationLabel = 'Activos asignados';
    protected static string | UnitEnum | null $navigationGroup = NavigationGroupEnum::ReportesAct->value;
    protected static ?int $navigationSort = 21;
    
    

    public function table(Table $table): Table
    {
        //dd(Assignment::query()->get());
        return $table
            ->query(Assignment::query())
            
            ->columns([
                TextColumn::make('Documento')
                    ->label('Documento'),
                TextColumn::make('Activo')
                    ->label('Descripción Activo')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('Marca')
                    ->label('Marca')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('Serial_number')
                    ->label('Serie')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('Asignado_at')
                    ->label('Empleado asignado')
                    ->searchable()
                    ->sortable()
                    ->weight(FontWeight::Bold)
            ]);
            
    }
}
