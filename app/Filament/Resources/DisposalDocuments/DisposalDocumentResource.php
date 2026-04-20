<?php

namespace App\Filament\Resources\DisposalDocuments;

use App\Enums\NavigationGroupEnum;
use App\Filament\Resources\DisposalDocuments\Pages\CreateDisposalDocument;
use App\Filament\Resources\DisposalDocuments\Pages\EditDisposalDocument;
use App\Filament\Resources\DisposalDocuments\Pages\ListDisposalDocuments;
use App\Filament\Resources\DisposalDocuments\Pages\ViewDisposalDocument;
use App\Filament\Resources\DisposalDocuments\Schemas\DisposalDocumentForm;
use App\Filament\Resources\DisposalDocuments\Schemas\DisposalDocumentInfolist;
use App\Filament\Resources\DisposalDocuments\Tables\DisposalDocumentsTable;
use App\Models\Document;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class DisposalDocumentResource extends Resource
{
    public static function getEloquentQuery(): Builder
        {
            return parent::getEloquentQuery()
                ->where('type', 'Baja')
                ->with(['items.product']);
        }
    protected static ?string $model = Document::class;
   //ASIGNAMOS AL GRUPO DE GESTION
    protected static ?string $modelLabel = 'Bajas';
    protected static ?string $pluralModelLabel = 'Bajas';
    protected static string | UnitEnum | null $navigationGroup = NavigationGroupEnum::Activos->value;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;
    protected static ?int $navigationSort = 13;
    protected static ?string $navigationLabel = 'Bajas';

    protected static ?string $recordTitleAttribute = 'Disposal';

    public static function form(Schema $schema): Schema
    {
        return DisposalDocumentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return DisposalDocumentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return DisposalDocumentsTable::configure($table);
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
            'index' => ListDisposalDocuments::route('/'),
            'create' => CreateDisposalDocument::route('/create'),
            'view' => ViewDisposalDocument::route('/{record}'),
            'edit' => EditDisposalDocument::route('/{record}/edit'),
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
