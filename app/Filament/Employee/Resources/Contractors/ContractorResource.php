<?php

namespace App\Filament\Employee\Resources\Contractors;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Actions;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\Contractors\Pages\ListContractors;
use App\Filament\Employee\Resources\Contractors\Pages\CreateContractor;
use App\Filament\Employee\Resources\Contractors\Pages\EditContractor;
use App\Filament\Employee\Resources\Contractors\Pages\ViewContractor;
use App\Filament\Employee\Resources\ContractorResource\Pages;
use App\Filament\Employee\Resources\ContractorResource\RelationManagers;
use App\Models\Contractor;
use App\Models\Employee;
use Filament\Forms;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ContractorResource extends Resource
{
    protected static ?string $model = Contractor::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Basic Information')
                    ->columns(2)
                    ->schema([
                    TextInput::make('name')
                        ->required()
                        ->maxLength(255),
                    Select::make('contractor_field_id')
                        ->relationship('contractor_field', 'name')
                        ->required(),
                    Select::make('contractor_category_id')
                        ->relationship('contractor_category', 'name')
                        ->required(),
                    TextInput::make('cr_number')
                        ->maxLength(255),
                ]),
                Section::make('Contact Information')
                    ->columns(2)
                    ->schema([
                    TextInput::make('address')
                        ->maxLength(255),
                    TextInput::make('phone')
                        ->tel()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->email()
                        ->maxLength(255)
                        ->columnSpanFull(),
                ]),
                Section::make('Owner Information')
                    ->columns(2)
                    ->schema([
                    TextInput::make('owner_fullname')
                        ->maxLength(255),
                    TextInput::make('owner_phone_number')
                        ->tel()
                        ->maxLength(255),
                    TextInput::make('owner_phone_email')
                        ->email()
                        ->maxLength(255),
                    TextInput::make('owner_civil_id')
                        ->maxLength(255),
                    FileUpload::make('owner_civil_copy')
                        ->columnSpanFull(),
                ]),
                Section::make('Documents')->schema([
                    FileUpload::make('cr_document')
                        ->required(),
                    FileUpload::make('chamber_ceritifcate_document')
                        ->required(),
                    FileUpload::make('VAT_ceritifcate_document')
                        ->required(),
                    FileUpload::make('readah_ceritifcate_document')
                        ->required(),
                ]),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
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
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('contractor_field.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('contractor_category.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('address')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('cr_number')
                    ->searchable(),
                TextColumn::make('owner_fullname')
                    ->searchable(),
                TextColumn::make('owner_phone_number')
                    ->searchable(),
                TextColumn::make('owner_phone_email')
                    ->searchable(),
                TextColumn::make('owner_civil_id')
                    ->searchable(),
                TextColumn::make('owner_civil_copy')
                    ->searchable(),
                TextColumn::make('cr_document')
                    ->searchable(),
                TextColumn::make('chamber_ceritifcate_document')
                    ->searchable(),
                TextColumn::make('VAT_ceritifcate_document')
                    ->searchable(),
                TextColumn::make('readah_ceritifcate_document')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
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
            'index' => ListContractors::route('/'),
            'create' => CreateContractor::route('/create'),
            'edit' => EditContractor::route('/{record}/edit'),
            'view' => ViewContractor::route('/{record}'),
        ];
    }
}
