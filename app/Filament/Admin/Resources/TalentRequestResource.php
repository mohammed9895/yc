<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\TalentRequestResource\Pages;
use App\Filament\Admin\Resources\TalentRequestResource\RelationManagers;
use App\Models\TalentRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use const _PHPStan_49641e245\__;

class TalentRequestResource extends Resource
{
    protected static ?string $model = TalentRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Manjam';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('user_id')
                    ->required(),
                Forms\Components\TextInput::make('talent_id')
                    ->required(),
                Forms\Components\TextInput::make('reason')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options([
                        0 => 'Waiting',
                        1 => 'Approved',
                        2 => 'Rejected',
                    ])
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('talent.user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => TalentResource::getUrl('edit', $record->talent_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('reason'),
                Tables\Columns\TextColumn::make('status')->enum([
                    0 => 'Waiting',
                    1 => 'Approved',
                    2 => 'Rejected',
                ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
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
            'index' => Pages\ListTalentRequests::route('/'),
            'create' => Pages\CreateTalentRequest::route('/create'),
            'edit' => Pages\EditTalentRequest::route('/{record}/edit'),
        ];
    }
}
