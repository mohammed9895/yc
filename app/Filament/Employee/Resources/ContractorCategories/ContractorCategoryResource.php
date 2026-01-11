<?php

namespace App\Filament\Employee\Resources\ContractorCategories;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\ContractorCategories\Pages\ListContractorCategories;
use App\Filament\Employee\Resources\ContractorCategories\Pages\CreateContractorCategory;
use App\Filament\Employee\Resources\ContractorCategories\Pages\EditContractorCategory;
use App\Filament\Employee\Resources\ContractorCategoryResource\Pages;
use App\Filament\Employee\Resources\ContractorCategoryResource\RelationManagers;
use App\Models\ContractorCategory;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractorCategoryResource extends Resource
{
    use Translatable;

    protected static ?string $model = ContractorCategory::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('name')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('description')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => ListContractorCategories::route('/'),
            'create' => CreateContractorCategory::route('/create'),
            'edit' => EditContractorCategory::route('/{record}/edit'),
        ];
    }
}
