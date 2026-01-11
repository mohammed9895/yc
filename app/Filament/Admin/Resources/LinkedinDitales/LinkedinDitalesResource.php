<?php

namespace App\Filament\Admin\Resources\LinkedinDitales;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\LinkedinDitales\Pages\ListLinkedinDitales;
use App\Filament\Admin\Resources\LinkedinDitales\Pages\CreateLinkedinDitales;
use App\Filament\Admin\Resources\LinkedinDitales\Pages\EditLinkedinDitales;
use App\Filament\Admin\Resources\LinkedinDitalesResource\Pages;
use App\Filament\Admin\Resources\LinkedinDitalesResource\RelationManagers;
use App\Models\LinkedinDitales;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LinkedinDitalesResource extends Resource
{
    protected static ?string $model = LinkedinDitales::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name'),
                TextInput::make('phone'),
                TextInput::make('email'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('fullname'),
                TextColumn::make('phone'),
                TextColumn::make('email'),
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
            'index' => ListLinkedinDitales::route('/'),
            'create' => CreateLinkedinDitales::route('/create'),
            'edit' => EditLinkedinDitales::route('/{record}/edit'),
        ];
    }
}
