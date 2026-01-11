<?php

namespace App\Filament\Employee\Resources\EmploymentTypes;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\EmploymentTypes\Pages\ListEmploymentTypes;
use App\Filament\Employee\Resources\EmploymentTypes\Pages\CreateEmploymentType;
use App\Filament\Employee\Resources\EmploymentTypes\Pages\EditEmploymentType;
use App\Filament\Employee\Resources\EmploymentTypeResource\Pages;
use App\Filament\Employee\Resources\EmploymentTypeResource\RelationManagers;
use App\Models\EmploymentType;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmploymentTypeResource extends Resource
{

    use Translatable;

    protected static ?string $model = EmploymentType::class;

    protected static string | \UnitEnum | null $navigationGroup = 'HR';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('description')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
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
            'index' => ListEmploymentTypes::route('/'),
            'create' => CreateEmploymentType::route('/create'),
            'edit' => EditEmploymentType::route('/{record}/edit'),
        ];
    }
}
