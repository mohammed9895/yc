<?php

namespace App\Filament\Admin\Resources\Submissions;

use Filament\Schemas\Schema;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\SubmissionsResource\Pages\ListSubmissions;
use App\Filament\Admin\Resources\SubmissionsResource\Pages\CreateSubmissions;
use App\Filament\Admin\Resources\SubmissionsResource\Pages\EditSubmissions;
use App\Filament\Admin\Resources\SubmissionsResource\Pages;
use App\Filament\Admin\Resources\SubmissionsResource\RelationManagers;
use App\Models\Submission;
use App\Models\Submissions;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SubmissionResource extends Resource
{
    protected static ?string $model = Submission::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
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
            'index' => ListSubmissions::route('/'),
            'create' => CreateSubmissions::route('/create'),
            'edit' => EditSubmissions::route('/{record}/edit'),
        ];
    }
}
