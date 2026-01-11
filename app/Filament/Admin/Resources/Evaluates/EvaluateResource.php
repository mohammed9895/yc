<?php

namespace App\Filament\Admin\Resources\Evaluates;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Evaluates\Pages\ListEvaluates;
use App\Filament\Admin\Resources\EvaluateResource\Pages;
use App\Filament\Admin\Resources\EvaluateResource\RelationManagers;
use App\Models\Evaluate;
use App\Models\Workshop;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class EvaluateResource extends Resource
{
    protected static ?string $model = Evaluate::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('evaluates');
    }

    public static function getPluralModelLabel(): string
    {
        return __('evaluates');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->label(__('User'))
                    ->required(),
                TextInput::make('workshop_id')
                    ->label(__('Workshop'))
                    ->required(),
                TextInput::make('rating')
                    ->label(__('rating'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('instructor')
                    ->label(__('instructor'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('duration')
                    ->label(__('duration'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('sutsfing')
                    ->label(__('sutsfing'))
                    ->required()
                    ->maxLength(255),
                Textarea::make('devloped')
                    ->label(__('devloped'))
                    ->required()
                    ->maxLength(65535),
                Textarea::make('suggestions')
                    ->label(__('suggestions'))
                    ->required()
                    ->maxLength(65535),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->searchable()->label(__('User')),
                TextColumn::make('workshop.title')->searchable()->sortable()->label(__('Workshop')),
                ToggleColumn::make('public')->label(__('featured')),
                TextColumn::make('rating')->searchable()->sortable()->label(__('rating')),
                TextColumn::make('instructor')->searchable()->sortable()->label(__('instructor')),
                TextColumn::make('duration')->searchable()->sortable()->label(__('duration')),
                TextColumn::make('sutsfing')->searchable()->sortable()->label(__('sutsfing')),
                TextColumn::make('devloped')->searchable()->label(__('devloped')),
                TextColumn::make('suggestions')->searchable()->label(__('suggestions')),
                TextColumn::make('created_at')->searchable()->sortable()->label(__('created_at'))
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('workshop_id')
                    ->multiple()
                    ->label(__('Workshop'))
                    ->options(Workshop::all()->pluck('title', 'id')),
            ])
            ->recordActions([])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ExportBulkAction::make()
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvaluates::route('/'),
        ];
    }

    public static function getNavigationGroup(): ?string
    {
        return __('workshops');
    }
}
