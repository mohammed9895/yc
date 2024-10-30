<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\StatisticeResource\Pages;
use App\Filament\Admin\Resources\StatisticeResource\RelationManagers;
use App\Models\Statistice;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Form;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StatisticeResource extends Resource
{
    use Translatable;

    protected static ?string $model = Statistice::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('settings');
    }

    public static function getModelLabel(): string
    {
        return   __('statistices');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('statistices');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                    Forms\Components\TextInput::make('title')
                        ->label(__('title'))
                        ->required(),
                    Forms\Components\TextInput::make('number')
                        ->label(__('number'))
                        ->required(),
                    Forms\Components\Textarea::make('icon')
                        ->label(__('icon'))
                        ->required(),
                    Forms\Components\Toggle::make('status')
                        ->label(__('status'))
                        ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->label(__('title')),
                Tables\Columns\TextColumn::make('number')->label(__('number')),
                Tables\Columns\ToggleColumn::make('status')->label(__('status')),
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
            'index' => Pages\ListStatistices::route('/'),
            'create' => Pages\CreateStatistice::route('/create'),
            'edit' => Pages\EditStatistice::route('/{record}/edit'),
        ];
    }
}
