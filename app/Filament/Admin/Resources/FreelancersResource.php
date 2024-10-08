<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\FreelancersResource\Pages;
use App\Filament\Admin\Resources\FreelancersResource\RelationManagers;
use App\Models\Field;
use App\Models\Freelancers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class FreelancersResource extends Resource
{
    protected static ?string $model = Freelancers::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\FileUpload::make('civil_copy')
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
                Forms\Components\FileUpload::make('cr_copy')
                    ->enableDownload()
                    ->label(__('cr_copy')),
                Forms\Components\FileUpload::make('profile_file')
                    ->label(__('Work Files'))
                    ->enableDownload()
                    ->multiple(),
                Forms\Components\TextInput::make('profile_link')
                    ->label(__('Profile Link')),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')->label(__('User'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.phone')->label(__('filament::users.phone'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('user.province.name')->label(__('province'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('field.name')->label(__('Field'))->searchable()->sortable(),
                Tables\Columns\TextColumn::make('profile_link')->label(__('Profile Link')),
                Tables\Columns\TextColumn::make('created_at')->sortable()
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->sortable()
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('field_id')
                    ->multiple()
                    ->label(__('Field'))
                    ->options(Field::where('type', 'freelancer')
                        ->pluck('name', 'id')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListFreelancers::route('/'),
            'create' => Pages\CreateFreelancers::route('/create'),
            'edit' => Pages\EditFreelancers::route('/{record}/edit'),
        ];
    }
}
