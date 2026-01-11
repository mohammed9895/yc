<?php

namespace App\Filament\Employee\Resources\BittyCashes;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\BittyCashes\Pages\ListBittyCashes;
use App\Filament\Employee\Resources\BittyCashes\Pages\CreateBittyCash;
use App\Filament\Employee\Resources\BittyCashes\Pages\EditBittyCash;
use App\Filament\Employee\Resources\BittyCashResource\Pages;
use App\Filament\Employee\Resources\BittyCashResource\RelationManagers;
use App\Models\BittyCash;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BittyCashResource extends Resource
{
    protected static ?string $model = BittyCash::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->maxLength(255),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Toggle::make('status')
                    ->default(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->sortable(),
                ToggleColumn::make('status')
                    ->sortable(),
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
            'index' => ListBittyCashes::route('/'),
            'create' => CreateBittyCash::route('/create'),
            'edit' => EditBittyCash::route('/{record}/edit'),
        ];
    }
}
