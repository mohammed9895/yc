<?php

namespace App\Filament\Admin\Resources\TalentRequests;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\TalentRequests\Pages\ListTalentRequests;
use App\Filament\Admin\Resources\TalentRequests\Pages\CreateTalentRequest;
use App\Filament\Admin\Resources\TalentRequests\Pages\EditTalentRequest;
use App\Filament\Admin\Resources\TalentRequestResource\Pages;
use App\Filament\Admin\Resources\TalentRequestResource\RelationManagers;
use App\Models\TalentRequest;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use const _PHPStan_49641e245\__;

class TalentRequestResource extends Resource
{
    protected static ?string $model = TalentRequest::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static string | \UnitEnum | null $navigationGroup = 'Manjam';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('user_id')
                    ->required(),
                TextInput::make('talent_id')
                    ->required(),
                TextInput::make('reason')
                    ->required()
                    ->maxLength(255),
                Select::make('status')
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
                TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                TextColumn::make('talent.user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => TalentResource::getUrl('edit', $record->talent_id))
                    ->openUrlInNewTab(),
                TextColumn::make('reason'),
                TextColumn::make('status')->enum([
                    0 => 'Waiting',
                    1 => 'Approved',
                    2 => 'Rejected',
                ]),
                TextColumn::make('created_at')
                    ->dateTime(),
                TextColumn::make('updated_at')
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
            'index' => ListTalentRequests::route('/'),
            'create' => CreateTalentRequest::route('/create'),
            'edit' => EditTalentRequest::route('/{record}/edit'),
        ];
    }
}
