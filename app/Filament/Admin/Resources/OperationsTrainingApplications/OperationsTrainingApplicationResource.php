<?php

namespace App\Filament\Admin\Resources\OperationsTrainingApplications;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\OperationsTrainingApplications\Pages\ListOperationsTrainingApplications;
use App\Filament\Admin\Resources\OperationsTrainingApplications\Pages\CreateOperationsTrainingApplication;
use App\Filament\Admin\Resources\OperationsTrainingApplications\Pages\EditOperationsTrainingApplication;
use App\Filament\Admin\Resources\OperationsTrainingApplicationResource\Pages;
use App\Filament\Admin\Resources\OperationsTrainingApplicationResource\RelationManagers;
use App\Models\OperationsTrainingApplication;
use App\Models\OperationsTrainingApplications;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class OperationsTrainingApplicationResource extends Resource
{
    protected static ?string $model = OperationsTrainingApplications::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                FileUpload::make('cv')->enableDownload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                TextColumn::make('user.email')->label('Email Address'),
                TextColumn::make('user.phone')->label('Phone Number'),
                IconColumn::make('do_you_have_experience')->boolean(),
                TextColumn::make('experience_description')->label('Experience'),
                TextColumn::make('goals')->label('Goals'),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                ExportBulkAction::make(),
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
            'index' => ListOperationsTrainingApplications::route('/'),
            'create' => CreateOperationsTrainingApplication::route('/create'),
            'edit' => EditOperationsTrainingApplication::route('/{record}/edit'),
        ];
    }
}
