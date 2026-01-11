<?php

namespace App\Filament\Employee\Resources\ContractorFields;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\ContractorFields\Pages\ListContractorFields;
use App\Filament\Employee\Resources\ContractorFields\Pages\CreateContractorField;
use App\Filament\Employee\Resources\ContractorFields\Pages\EditContractorField;
use App\Filament\Employee\Resources\ContractorFieldResource\Pages;
use App\Filament\Employee\Resources\ContractorFieldResource\RelationManagers;
use App\Models\ContractorField;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContractorFieldResource extends Resource
{
    use Translatable;

    protected static ?string $model = ContractorField::class;

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
            'index' => ListContractorFields::route('/'),
            'create' => CreateContractorField::route('/create'),
            'edit' => EditContractorField::route('/{record}/edit'),
        ];
    }
}
