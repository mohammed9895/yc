<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TalentTypeResource\Pages;
use App\Filament\Admin\Resources\TalentTypeResource\RelationManagers;
use App\Models\TalentType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;

class TalentTypeResource extends Resource
{
    protected static ?string $model = TalentType::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manjam';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name_en')->required(),
                Forms\Components\TextInput::make('name_ar')->required(),
                IconPicker::make('icon')
                    ->columns([
                        'default' => 1,
                        'lg' => 3,
                        '2xl' => 5,
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('created_at'),
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
            'index' => Pages\ListTalentTypes::route('/'),
            'create' => Pages\CreateTalentType::route('/create'),
            'edit' => Pages\EditTalentType::route('/{record}/edit'),
        ];
    }
}
