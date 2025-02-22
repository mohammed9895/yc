<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\ExpenseResource\Pages;
use App\Filament\Employee\Resources\ExpenseResource\RelationManagers;
use App\Filament\Exports\ExpenseExporter;
use App\Models\Expense;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ExportAction;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('expenses_date')
                    ->required()
                    ->native(false),
                Forms\Components\TextInput::make('cr_civil_id')
                    ->label('CR Number / Civil ID')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('contractor_id')
                    ->label('Contractor')
                    ->searchable()
                    ->options(\App\Models\Contractor::all()->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->suffix('OMR')
                    ->numeric()
                    ->required(),
                Forms\Components\Select::make('contractor_category_id')
                    ->label('Contractor Category')
                    ->searchable()
                    ->required()
                    ->options(\App\Models\ContractorCategory::all()->pluck('name', 'id')),
                Forms\Components\Select::make('term_id')
                    ->label('Term')
                    ->options(\App\Models\Term::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->options(\App\Models\Department::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('source_id')
                    ->label('Source')
                    ->options(\App\Models\Source::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                Forms\Components\ToggleButtons::make('expense_status_id')
                    ->options(\App\Models\ExpenseStatus::all()->pluck('name', 'id'))
                    ->inline()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->headerActions([
                ExportAction::make()
                    ->exporter(ExpenseExporter::class)
            ])
            ->columns([
                Tables\Columns\TextColumn::make('expenses_id')
                    ->label('ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('expenses_date')
                    ->label('Date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cr_civil_id')
                    ->label('CR Number / Civil ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contractor.name')
                    ->label('Contractor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('OMR')
                    ->summarize(Sum::make()->money('OMR')),
                Tables\Columns\TextColumn::make('contractorCategory.name')
                    ->label('Contractor Category')
                    ->sortable(),
                Tables\Columns\TextColumn::make('term.name')
                    ->label('Term')
                    ->sortable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('source.name')
                    ->sortable(),
                Tables\Columns\TextColumn::make('expenseStatus.name')
                    ->badge()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('expense_status_id')
                    ->searchable()
                    ->options(\App\Models\ExpenseStatus::all()->pluck('name', 'id'))
                    ->sortable(),
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
            'index' => Pages\ListExpenses::route('/'),
            'create' => Pages\CreateExpense::route('/create'),
            'edit' => Pages\EditExpense::route('/{record}/edit'),
        ];
    }
}
