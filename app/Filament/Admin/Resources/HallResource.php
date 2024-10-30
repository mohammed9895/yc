<?php

namespace App\Filament\Admin\Resources;

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
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;

class HallResource extends Resource
{

    use Translatable;

    protected static ?string $model = Hall::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                Tables\Columns\TextColumn::make('name')->label(__('name')),
                Tables\Columns\TextColumn::make('description')->label(__('description')),
                Tables\Columns\TextColumn::make('conditions')->label(__('conditions')),
                Tables\Columns\TextColumn::make('capacity')->label(__('capacity')),
                ColorColumn::make('backgroundColor')->label(__('color')),
                IconColumn::make('status')
                    ->label(__('status'))
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
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
            'index' => Pages\ListHalls::route('/'),
            'create' => Pages\CreateHall::route('/create'),
            'edit' => Pages\EditHall::route('/{record}/edit'),
        ];
    }
}
