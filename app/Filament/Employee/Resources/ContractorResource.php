<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\ContractorResource\Pages;
use App\Filament\Employee\Resources\ContractorResource\RelationManagers;
use App\Models\Contractor;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ContractorResource extends Resource
{
    protected static ?string $model = Contractor::class;

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->columns(2)
                    ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\Select::make('contractor_field_id')
                        ->relationship('contractor_field', 'name')
                        ->required(),
                    Forms\Components\Select::make('contractor_category_id')
                        ->relationship('contractor_category', 'name')
                        ->required(),
                    Forms\Components\TextInput::make('cr_number')
                        ->maxLength(255),
                ]),
                Forms\Components\Section::make('Contact Information')
                    ->columns(2)
                    ->schema([
                    Forms\Components\TextInput::make('address')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),
                Forms\Components\Section::make('Owner Information')
                    ->columns(2)
                    ->schema([
                    Forms\Components\TextInput::make('owner_fullname')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('owner_phone_number')
                        ->tel()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('owner_phone_email')
                        ->email()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('owner_civil_id')
                        ->maxLength(255),
                    Forms\Components\FileUpload::make('owner_civil_copy')
                        ->columnSpanFull(),
                ]),
                Forms\Components\Section::make('Documents')->schema([
                    Forms\Components\FileUpload::make('cr_document')
                        ->required(),
                    Forms\Components\FileUpload::make('chamber_ceritifcate_document')
                        ->required(),
                    Forms\Components\FileUpload::make('VAT_ceritifcate_document')
                        ->required(),
                    Forms\Components\FileUpload::make('readah_ceritifcate_document')
                        ->required(),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Basic Information')
                ->columns(2)
                ->schema([
                    TextEntry::make('name'),
                    TextEntry::make('contractor_field.name'),
                    TextEntry::make('contractor_category.name'),
                    TextEntry::make('cr_number'),
                ]),
            Section::make('Contact Information')
                ->columns(2)
                ->schema([
                    TextEntry::make('address'),
                    TextEntry::make('phone'),
                    TextEntry::make('email'),
                ]),
            Section::make('Owner Information')
                ->columns(2)
                ->schema([
                    TextEntry::make('owner_fullname'),
                    TextEntry::make('owner_phone_number'),
                    TextEntry::make('owner_phone_email'),
                    TextEntry::make('owner_civil_id'),
                    Actions::make([
                        Action::make('owner_civil_copy')
                            ->hidden(fn (Contractor $record) => !$record->owner_civil_copy)
                            ->label('Download Civil ID')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(function (Employee $record) {
                                return Storage::download($record->owner_civil_copy);
                            }),
                    ]),
                ]),
            Section::make('Documents')
                ->schema([
                    Actions::make([
                        Action::make('cr_document')
                            ->hidden(fn (Contractor $record) => !$record->cr_document)
                            ->label('Download CR')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(function (Employee $record) {
                                return Storage::download($record->cr_document);
                            }),
                        Action::make('chamber_ceritifcate_document')
                            ->hidden(fn (Contractor $record) => !$record->chamber_ceritifcate_document)
                            ->label('Download Chamber Certificate')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(function (Employee $record) {
                                return Storage::download($record->chamber_ceritifcate_document);
                            }),
                        Action::make('VAT_ceritifcate_document')
                            ->hidden(fn (Contractor $record) => !$record->VAT_ceritifcate_document)
                            ->label('Download VAT Certificate')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(function (Employee $record) {
                                return Storage::download($record->VAT_ceritifcate_document);
                            }),
                        Action::make('readah_ceritifcate_document')
                            ->hidden(fn (Contractor $record) => !$record->readah_ceritifcate_document)
                            ->label('Download Readah Certificate')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(function (Employee $record) {
                                return Storage::download($record->readah_ceritifcate_document);
                            }),
                    ])
                        ->columns(2)
                        ->fullWidth(),
            ])
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contractor_field.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contractor_category.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cr_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_fullname')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_phone_email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_civil_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('owner_civil_copy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cr_document')
                    ->searchable(),
                Tables\Columns\TextColumn::make('chamber_ceritifcate_document')
                    ->searchable(),
                Tables\Columns\TextColumn::make('VAT_ceritifcate_document')
                    ->searchable(),
                Tables\Columns\TextColumn::make('readah_ceritifcate_document')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListContractors::route('/'),
            'create' => Pages\CreateContractor::route('/create'),
            'edit' => Pages\EditContractor::route('/{record}/edit'),
            'view' => Pages\ViewContractor::route('/{record}'),
        ];
    }
}
