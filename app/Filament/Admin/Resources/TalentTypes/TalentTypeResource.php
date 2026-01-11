<?php

namespace App\Filament\Admin\Resources\TalentTypes;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\TalentTypes\Pages\ListTalentTypes;
use App\Filament\Admin\Resources\TalentTypes\Pages\CreateTalentType;
use App\Filament\Admin\Resources\TalentTypes\Pages\EditTalentType;
use App\Filament\Admin\Resources\TalentTypeResource\Pages;
use App\Filament\Admin\Resources\TalentTypeResource\RelationManagers;
use App\Models\TalentType;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentIconPicker\Forms\IconPicker;

class TalentTypeResource extends Resource
{
    protected static ?string $model = TalentType::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string | \UnitEnum | null $navigationGroup = 'Manjam';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_en')->required(),
                TextInput::make('name_ar')->required(),
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
                TextColumn::make('name'),
                TextColumn::make('created_at'),
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
            'index' => ListTalentTypes::route('/'),
            'create' => CreateTalentType::route('/create'),
            'edit' => EditTalentType::route('/{record}/edit'),
        ];
    }
}
