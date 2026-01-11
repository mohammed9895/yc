<?php

namespace App\Filament\Employee\Resources\ExpenseStatuses;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\ExpenseStatuses\Pages\ListExpenseStatuses;
use App\Filament\Employee\Resources\ExpenseStatuses\Pages\CreateExpenseStatus;
use App\Filament\Employee\Resources\ExpenseStatuses\Pages\EditExpenseStatus;
use App\Filament\Employee\Resources\ExpenseStatusResource\Pages;
use App\Filament\Employee\Resources\ExpenseStatusResource\RelationManagers;
use App\Models\ExpenseStatus;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseStatusResource extends Resource
{
    use Translatable;

    protected static ?string $model = ExpenseStatus::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('description'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
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
            'index' => ListExpenseStatuses::route('/'),
            'create' => CreateExpenseStatus::route('/create'),
            'edit' => EditExpenseStatus::route('/{record}/edit'),
        ];
    }
}
