<?php

namespace App\Filament\Admin\Resources\Halls;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Halls\Pages\ListHalls;
use App\Filament\Admin\Resources\Halls\Pages\CreateHall;
use App\Filament\Admin\Resources\Halls\Pages\EditHall;
use App\Filament\Admin\Resources\HallResource\Pages;
use App\Filament\Admin\Resources\HallResource\RelationManagers;
use App\Models\Hall;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class HallResource extends Resource
{

    use Translatable;

    protected static ?string $model = Hall::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public static function getModelLabel(): string
    {
        return   __('halls');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('halls');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('name')
                    ->label(__('name'))
                    ->required(),
                FileUpload::make('image')
                    ->image()
                    ->label(__('image')),
                Textarea::make('description')
                    ->label(__('description'))
                    ->required(),
                TagsInput::make('conditions')
                    ->label(__('conditions'))
                    ->placeholder('Conditions')
                    ->required(),
                TextInput::make('capacity')
                    ->label(__('capacity'))
                    ->required(),
                ColorPicker::make('backgroundColor')->label(__('hall')),
                Toggle::make('status')
                    ->label(__('status'))
                    ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('name')),
                TextColumn::make('description')->label(__('description')),
                TextColumn::make('conditions')->label(__('conditions')),
                TextColumn::make('capacity')->label(__('capacity')),
                ColorColumn::make('backgroundColor')->label(__('color')),
                IconColumn::make('status')
                    ->label(__('status'))
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label(__('created_at'))
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
            'index' => ListHalls::route('/'),
            'create' => CreateHall::route('/create'),
            'edit' => EditHall::route('/{record}/edit'),
        ];
    }
}
