<?php

namespace App\Filament\Admin\Resources\Paths;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Paths\Pages\ListPaths;
use App\Filament\Admin\Resources\Paths\Pages\CreatePath;
use App\Filament\Admin\Resources\Paths\Pages\EditPath;
use App\Filament\Admin\Resources\PathResource\Pages;
use App\Filament\Admin\Resources\PathResource\RelationManagers;
use App\Models\Path;
use Filament\Forms;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PathResource extends Resource
{
    protected static ?string $model = Path::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('workshops');
    }

    public static function getModelLabel(): string
    {
        return   __('paths');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('paths');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name_en')
                    ->label(__('name_en'))
                    ->required(),
                TextInput::make('name_ar')
                    ->label(__('name_ar'))
                    ->required(),
                Textarea::make('description_en')->required()->label(__('description_en')),
                Textarea::make('description_ar')->required()->label(__('description_ar')),
                FileUpload::make('icon_en')
                    ->label(__('icon_en'))
                    ->directory('paths/en')
                    ->enableOpen()
                    ->enableDownload()
                    ->required(),
                FileUpload::make('icon_ar')
                    ->label(__('icon_ar'))
                    ->directory('paths/ar')
                    ->enableOpen()
                    ->enableDownload()
                    ->required(),
                Toggle::make('status')
                    ->label(__('status'))
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label(__('Name')),
                ImageColumn::make('icon')->label(__('icon')),
                TextColumn::make('status')->label(__('status')),
                TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime(),
                TextColumn::make('updated_at')
                    ->label(__('updated_at'))
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
            'index' => ListPaths::route('/'),
            'create' => CreatePath::route('/create'),
            'edit' => EditPath::route('/{record}/edit'),
        ];
    }
}
