<?php

namespace App\Filament\Resources\OutputDocuments;

use App\Enums\NavigationGroupEnum;
use App\Filament\Resources\OutputDocuments\Pages\CreateOutputDocument;
use App\Filament\Resources\OutputDocuments\Pages\EditOutputDocument;
use App\Filament\Resources\OutputDocuments\Pages\ListOutputDocuments;
use App\Filament\Resources\OutputDocuments\Pages\ViewOutputDocument;
use App\Filament\Resources\OutputDocuments\Schemas\OutputDocumentForm;
use App\Filament\Resources\OutputDocuments\Schemas\OutputDocumentInfolist;
use App\Filament\Resources\OutputDocuments\Tables\OutputDocumentsTable;
use App\Models\Document;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class OutputDocumentResource extends Resource
{
    //MUESTRA SOLO SALIDAS
    public static function getEloquentQuery(): Builder
        {
            return parent::getEloquentQuery()
                ->where('type', 'Entrega');
        }
    protected static ?string $model = Document::class;

    
     //ASIGNAMOS AL GRUPO DE GESTION
    protected static ?string $modelLabel = 'Asignaciones';
    protected static ?string $pluralModelLabel = 'Asignaciones';
    protected static string | UnitEnum | null $navigationGroup = NavigationGroupEnum::Activos->value;
    protected static ?int $navigationSort = 11;
    protected static ?string $navigationLabel = 'Asignaciones';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Document';

    public static function form(Schema $schema): Schema
    {
        return OutputDocumentForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return OutputDocumentInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return OutputDocumentsTable::configure($table);
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
            'index' => ListOutputDocuments::route('/'),
            'create' => CreateOutputDocument::route('/create'),
            'view' => ViewOutputDocument::route('/{record}'),
            'edit' => EditOutputDocument::route('/{record}/edit'),
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
