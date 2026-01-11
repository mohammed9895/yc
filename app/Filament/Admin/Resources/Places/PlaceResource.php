<?php

namespace App\Filament\Admin\Resources\Places;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Places\Pages\ListPlaces;
use App\Filament\Admin\Resources\Places\Pages\CreatePlace;
use App\Filament\Admin\Resources\Places\Pages\EditPlace;
use App\Filament\Admin\Resources\PlaceResource\Pages;
use App\Filament\Admin\Resources\PlaceResource\RelationManagers;
use App\Models\Place;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlaceResource extends Resource
{
    // use HasPageShield;
    protected static ?string $model = Place::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public static function getModelLabel(): string
    {
        return   __('places');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('places');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_en')->label(__('name_en'))
                    ->required(),
                TextInput::make('name_ar')->label(__('name_ar'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('Name')),
                TextColumn::make('created_at')->label(__('created_at'))
                    ->dateTime(),
                TextColumn::make('updated_at')->label(__('updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
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
            'index' => ListPlaces::route('/'),
            'create' => CreatePlace::route('/create'),
            'edit' => EditPlace::route('/{record}/edit'),
        ];
    }
}
