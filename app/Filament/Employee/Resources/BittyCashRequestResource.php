<?php

namespace App\Filament\Employee\Resources;

use App\BittyCashStatus;
use App\Filament\Employee\Resources\BittyCashRequestResource\Pages;
use App\Filament\Employee\Resources\BittyCashRequestResource\RelationManagers;
use App\Filament\Employee\Resources\BittyCashRequestResource\Widgets\AvailableBittyCash;
use App\Models\BittyCashRequest;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BittyCashRequestResource extends Resource
{
    protected static ?string $model = BittyCashRequest::class;

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('employee_id')
                    ->required()
                    ->relationship('employee', 'first_name'),
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('expense_date')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reason')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('proof')
                    ->multiple()
                    ->required(),
                Forms\Components\ToggleButtons::make('status')
                    ->required()
                    ->options(BittyCashStatus::class),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('employee.first_name')
                    ->formatStateUsing(function (BittyCashRequest $record) {
                        return $record->employee->first_name . ' ' . $record->employee->second_name . ' ' . $record->employee->third_name  . ' ' . $record->employee->family_name;
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->numeric()
                    ->money('OMR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expense_date')
                    ->date()
                    ->searchable(),
                Tables\Columns\SelectColumn::make('status')->options(BittyCashStatus::class),
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
                Tables\Filters\SelectFilter::make('employee_id')->relationship('employee', 'first_name',)->preload()->searchable()->label('Employee'),
                Tables\Filters\SelectFilter::make('status')->options(BittyCashStatus::class)->label('Status')->searchable(),
            ])
            ->actions([
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
            'index' => Pages\ListBittyCashRequests::route('/'),
            'create' => Pages\CreateBittyCashRequest::route('/create'),
            'edit' => Pages\EditBittyCashRequest::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            AvailableBittyCash::make(),
        ];
    }

}
