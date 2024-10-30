<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TmakonCtegoryResource\Pages;
use App\Filament\Admin\Resources\TmakonCtegoryResource\RelationManagers;
use App\Models\TmakonCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TmakonCategoryResource extends Resource
{

    use Translatable;

    protected static ?string $model = TmakonCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListTmakonCtegories::route('/'),
            'create' => Pages\CreateTmakonCtegory::route('/create'),
            'edit' => Pages\EditTmakonCtegory::route('/{record}/edit'),
        ];
    }
}
