<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\OperationsTrainingApplicationResource\Pages;
use App\Filament\Admin\Resources\OperationsTrainingApplicationResource\RelationManagers;
use App\Models\OperationsTrainingApplication;
use App\Models\OperationsTrainingApplications;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class OperationsTrainingApplicationResource extends Resource
{
    protected static ?string $model = OperationsTrainingApplications::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                FileUpload::make('cv')->enableDownload()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->url(fn($record) => UserResource::getUrl('view', $record->user_id))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('user.email')->label('Email Address'),
                Tables\Columns\TextColumn::make('user.phone')->label('Phone Number'),
                Tables\Columns\IconColumn::make('do_you_have_experience')->boolean(),
                Tables\Columns\TextColumn::make('experience_description')->label('Experience'),
                Tables\Columns\TextColumn::make('goals')->label('Goals'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                ExportBulkAction::make(),
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
            'index' => Pages\ListOperationsTrainingApplications::route('/'),
            'create' => Pages\CreateOperationsTrainingApplication::route('/create'),
            'edit' => Pages\EditOperationsTrainingApplication::route('/{record}/edit'),
        ];
    }
}
