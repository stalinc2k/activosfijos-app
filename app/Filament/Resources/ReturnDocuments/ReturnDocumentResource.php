<?php

namespace App\Filament\Resources\ReturnDocuments;

use App\Enums\NavigationGroupEnum;
use App\Filament\Resources\ReturnDocuments\Pages\CreateReturnDocument;
use App\Filament\Resources\ReturnDocuments\Pages\EditReturnDocument;
use App\Filament\Resources\ReturnDocuments\Pages\ListReturnDocuments;
use App\Filament\Resources\ReturnDocuments\Pages\ViewReturnDocument;
use App\Filament\Resources\ReturnDocuments\Schemas\ReturnDocumentForm;
use App\Filament\Resources\ReturnDocuments\Schemas\ReturnDocumentInfolist;
use App\Filament\Resources\ReturnDocuments\Tables\ReturnDocumentsTable;
use App\Models\Document;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class ReturnDocumentResource extends Resource
{

    public static function getEloquentQuery(): Builder
        {
            return parent::getEloquentQuery()
                ->where('type', 'Devolucion');
        }
        
    protected static ?string $model = Document::class;

    //ASIGNAMOS AL GRUPO DE GESTION
     protected static ?string $modelLabel = 'Devoluciones';
    protected static ?string $pluralModelLabel = 'Devoluciones';
    protected static string | UnitEnum | null $navigationGroup = NavigationGroupEnum::Activos->value;
    protected static ?int $navigationSort = 12;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ReturnAssets';

    public static function form(Schema $schema): Schema
    {
        return ReturnDocumentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return ReturnDocumentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ReturnDocumentsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListReturnDocuments::route('/'),
            'create' => CreateReturnDocument::route('/create'),
            'view' => ViewReturnDocument::route('/{record}'),
            'edit' => EditReturnDocument::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
