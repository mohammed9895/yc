<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\PlaceResource\Pages;
use App\Filament\Admin\Resources\PlaceResource\RelationManagers;
use App\Models\Place;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlaceResource extends Resource
{
    // use HasPageShield;
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_en')->label(__('name_en'))
                    ->required(),
                Forms\Components\TextInput::make('name_ar')->label(__('name_ar'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label(__('Name')),
                Tables\Columns\TextColumn::make('created_at')->label(__('created_at'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label(__('updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'edit' => Pages\EditPlace::route('/{record}/edit'),
        ];
    }
}
