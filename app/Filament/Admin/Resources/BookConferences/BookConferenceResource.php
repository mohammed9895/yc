<?php

namespace App\Filament\Admin\Resources\BookConferences;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\BookConferences\Pages\ListBookConferences;
use App\Filament\Admin\Resources\BookConferences\Pages\CreateBookConference;
use App\Filament\Admin\Resources\BookConferences\Pages\EditBookConference;
use App\Filament\Admin\Resources\BookConferenceResource\Pages;
use App\Filament\Admin\Resources\BookConferenceResource\RelationManagers;
use App\Models\BookConference;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookConferenceResource extends Resource
{
    protected static ?string $model = BookConference::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $slug = 'book-conference-resource';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('file')
                    ->required()
                    ->enableDownload(),
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
            'index' => ListBookConferences::route('/'),
            'create' => CreateBookConference::route('/create'),
            'edit' => EditBookConference::route('/{record}/edit'),
        ];
    }
}
