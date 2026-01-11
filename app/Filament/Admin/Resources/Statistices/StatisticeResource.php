<?php

namespace App\Filament\Admin\Resources\Statistices;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Statistices\Pages\ListStatistices;
use App\Filament\Admin\Resources\Statistices\Pages\CreateStatistice;
use App\Filament\Admin\Resources\Statistices\Pages\EditStatistice;
use App\Filament\Admin\Resources\StatisticeResource\Pages;
use App\Filament\Admin\Resources\StatisticeResource\RelationManagers;
use App\Models\Statistice;
use Filament\Forms;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class StatisticeResource extends Resource
{
    use Translatable;

    protected static ?string $model = Statistice::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

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

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                    TextInput::make('title')
                        ->label(__('title'))
                        ->required(),
                    TextInput::make('number')
                        ->label(__('number'))
                        ->required(),
                    Textarea::make('icon')
                        ->label(__('icon'))
                        ->required(),
                    Toggle::make('status')
                        ->label(__('status'))
                        ->required(),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->label(__('title')),
                TextColumn::make('number')->label(__('number')),
                ToggleColumn::make('status')->label(__('status')),
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
            'index' => ListStatistices::route('/'),
            'create' => CreateStatistice::route('/create'),
            'edit' => EditStatistice::route('/{record}/edit'),
        ];
    }
}
