<?php

namespace App\Filament\Admin\Resources\Freelancers;

use Filament\Schemas\Schema;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\EditAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Freelancers\Pages\ListFreelancers;
use App\Filament\Admin\Resources\Freelancers\Pages\CreateFreelancers;
use App\Filament\Admin\Resources\Freelancers\Pages\EditFreelancers;
use App\Filament\Admin\Resources\FreelancersResource\Pages;
use App\Filament\Admin\Resources\FreelancersResource\RelationManagers;
use App\Models\Field;
use App\Models\Freelancers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class FreelancersResource extends Resource
{
    protected static ?string $model = Freelancers::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('companies');
    }

    public static function getModelLabel(): string
    {
        return   __('freelancers');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('freelancers');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                FileUpload::make('civil_copy')
                    ->label(__('Civil Copy'))
                    ->enableDownload()
                    ->required()
                    ->reactive(),
                Select::make('field_id')
                    ->label(__('Field'))
                    ->options(Field::where('type', 'freelancer')
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('others')->visible(function (callable $get) {
                    if ($get('field_id') == 24) {
                        return true;
                    }
                }),
                FileUpload::make('cr_copy')
                    ->enableDownload()
                    ->label(__('cr_copy')),
                FileUpload::make('profile_file')
                    ->label(__('Work Files'))
                    ->enableDownload()
                    ->multiple(),
                TextInput::make('profile_link')
                    ->label(__('Profile Link')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('User'))->searchable()->sortable(),
                TextColumn::make('user.phone')->label(__('filament::users.phone'))->searchable()->sortable(),
                TextColumn::make('user.province.name')->label(__('province'))->searchable()->sortable(),
                TextColumn::make('field.name')->label(__('Field'))->searchable()->sortable(),
                TextColumn::make('profile_link')->label(__('Profile Link')),
                TextColumn::make('created_at')->sortable()
                    ->dateTime(),
                TextColumn::make('updated_at')->sortable()
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('field_id')
                    ->multiple()
                    ->label(__('Field'))
                    ->options(Field::where('type', 'freelancer')
                        ->pluck('name', 'id')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
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

    public static function getPages(): array
    {
        return [
            'index' => ListFreelancers::route('/'),
            'create' => CreateFreelancers::route('/create'),
            'edit' => EditFreelancers::route('/{record}/edit'),
        ];
    }
}
