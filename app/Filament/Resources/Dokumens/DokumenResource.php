<?php

namespace App\Filament\Resources\Dokumens;

use App\Filament\Resources\Dokumens\Pages\CreateDokumen;
use App\Filament\Resources\Dokumens\Pages\EditDokumen;
use App\Filament\Resources\Dokumens\Pages\ListDokumens;
use App\Filament\Resources\Dokumens\Schemas\DokumenForm;
use App\Filament\Resources\Dokumens\Tables\DokumensTable;
use App\Models\Dokumen;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Filament\Navigation\NavigationItem;


class DokumenResource extends Resource
{
    protected static ?string $model = Dokumen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Dokumen';

    protected static ?string $navigationLabel = 'Dokumen';

    protected static ?string $modelLabel = 'Dokumen';

    protected static ?string $pluralModelLabel = 'Data Dokumen';

    public static function form(Schema $schema): Schema
    {
        return DokumenForm::configure($schema);
    }

    public static function getNavigationItems(): array
    {
        return [
            NavigationItem::make('Legal')
                ->group('Dokumen')
                // ->label('Jenis Kunjungan')
                ->icon('heroicon-o-scale')
                ->url(fn() => static::getUrl() . '?jenis=legal'),

            NavigationItem::make('Kontrak')
                ->group('Dokumen')
                ->icon('heroicon-o-document-text')
                ->url(fn() => static::getUrl() . '?jenis=kontrak'),

            NavigationItem::make('Risalah')
                ->group('Dokumen')
                ->icon('heroicon-o-clipboard-document')
                ->url(fn() => static::getUrl() . '?jenis=risalah'),
        ];
    }

    public static function table(Table $table): Table
    {
        return DokumensTable::configure($table);
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
            'index' => ListDokumens::route('/'),
            // 'create' => CreateDokumen::route('/create'),
            // 'edit' => EditDokumen::route('/{record}/edit'),
        ];
    }
}
