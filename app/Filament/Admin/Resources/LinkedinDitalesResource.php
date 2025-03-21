<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\LinkedinDitalesResource\Pages;
use App\Filament\Admin\Resources\LinkedinDitalesResource\RelationManagers;
use App\Models\LinkedinDitales;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LinkedinDitalesResource extends Resource
{
    protected static ?string $model = LinkedinDitales::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name'),
                TextInput::make('phone'),
                TextInput::make('email'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('fullname'),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('email'),
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
            'index' => Pages\ListLinkedinDitales::route('/'),
            'create' => Pages\CreateLinkedinDitales::route('/create'),
            'edit' => Pages\EditLinkedinDitales::route('/{record}/edit'),
        ];
    }
}
