<?php

namespace App\Filament\Admin\Resources\TmakonCategories;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\TmakonCtegoryResource\Pages\ListTmakonCtegories;
use App\Filament\Admin\Resources\TmakonCtegoryResource\Pages\CreateTmakonCtegory;
use App\Filament\Admin\Resources\TmakonCtegoryResource\Pages\EditTmakonCtegory;
use App\Filament\Admin\Resources\TmakonCtegoryResource\Pages;
use App\Filament\Admin\Resources\TmakonCtegoryResource\RelationManagers;
use App\Models\TmakonCategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TmakonCategoryResource extends Resource
{

    use Translatable;

    protected static ?string $model = TmakonCategory::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => ListTmakonCtegories::route('/'),
            'create' => CreateTmakonCtegory::route('/create'),
            'edit' => EditTmakonCtegory::route('/{record}/edit'),
        ];
    }
}
