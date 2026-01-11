<?php

namespace App\Filament\Employee\Resources\BittyCashRequests;

use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\ToggleButtons;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\BittyCashRequests\Pages\ListBittyCashRequests;
use App\Filament\Employee\Resources\BittyCashRequests\Pages\CreateBittyCashRequest;
use App\Filament\Employee\Resources\BittyCashRequests\Pages\EditBittyCashRequest;
use App\BittyCashStatus;
use App\Filament\Employee\Resources\BittyCashRequestResource\Pages;
use App\Filament\Employee\Resources\BittyCashRequestResource\RelationManagers;
use App\Filament\Employee\Resources\BittyCashRequests\Widgets\AvailableBittyCash;
use App\Models\BittyCashRequest;
use App\Models\Employee;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BittyCashRequestResource extends Resource
{
    protected static ?string $model = BittyCashRequest::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('employee_id')
                    ->required()
                    ->relationship('employee', 'first_name'),
                TextInput::make('amount')
                    ->required()
                    ->numeric(),
                TextInput::make('expense_date')
                    ->required()
                    ->maxLength(255),
                TextInput::make('reason')
                    ->required()
                    ->maxLength(255),
                FileUpload::make('proof')
                    ->multiple()
                    ->required(),
                ToggleButtons::make('status')
                    ->required()
                    ->options(BittyCashStatus::class),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('employee.first_name')
                    ->formatStateUsing(function (BittyCashRequest $record) {
                        return $record->employee->first_name . ' ' . $record->employee->second_name . ' ' . $record->employee->third_name  . ' ' . $record->employee->family_name;
                    })
                    ->sortable(),
                TextColumn::make('amount')
                    ->numeric()
                    ->money('OMR')
                    ->sortable(),
                TextColumn::make('expense_date')
                    ->date()
                    ->searchable(),
                SelectColumn::make('status')->options(BittyCashStatus::class),
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
                SelectFilter::make('employee_id')->relationship('employee', 'first_name',)->preload()->searchable()->label('Employee'),
                SelectFilter::make('status')->options(BittyCashStatus::class)->label('Status')->searchable(),
            ])
            ->recordActions([
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
            'index' => ListBittyCashRequests::route('/'),
            'create' => CreateBittyCashRequest::route('/create'),
            'edit' => EditBittyCashRequest::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            AvailableBittyCash::make(),
        ];
    }

}
