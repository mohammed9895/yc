<?php

namespace App\Filament\Employee\Resources\Expenses;

use Filament\Schemas\Schema;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use App\Models\Contractor;
use App\Models\ContractorCategory;
use App\Models\Term;
use App\Models\Department;
use App\Models\Source;
use Filament\Forms\Components\ToggleButtons;
use App\Models\ExpenseStatus;
use Filament\Actions\ExportAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\Expenses\Pages\ListExpenses;
use App\Filament\Employee\Resources\Expenses\Pages\CreateExpense;
use App\Filament\Employee\Resources\Expenses\Pages\EditExpense;
use App\Filament\Employee\Resources\ExpenseResource\Pages;
use App\Filament\Employee\Resources\ExpenseResource\RelationManagers;
use App\Filament\Exports\ExpenseExporter;
use App\Models\Expense;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ExpenseResource extends Resource
{
    protected static ?string $model = Expense::class;

    protected static string | \UnitEnum | null $navigationGroup = 'Finance';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                DatePicker::make('expenses_date')
                    ->required()
                    ->native(false),
                TextInput::make('cr_civil_id')
                    ->label('CR Number / Civil ID')
                    ->required()
                    ->maxLength(255),
                Select::make('contractor_id')
                    ->label('Contractor')
                    ->searchable()
                    ->options(Contractor::all()->pluck('name', 'id'))
                    ->required(),
                TextInput::make('amount')
                    ->suffix('OMR')
                    ->numeric()
                    ->required(),
                Select::make('contractor_category_id')
                    ->label('Contractor Category')
                    ->searchable()
                    ->required()
                    ->options(ContractorCategory::all()->pluck('name', 'id')),
                Select::make('term_id')
                    ->label('Term')
                    ->options(Term::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('department_id')
                    ->label('Department')
                    ->options(Department::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Select::make('source_id')
                    ->label('Source')
                    ->options(Source::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),

                ToggleButtons::make('expense_status_id')
                    ->options(ExpenseStatus::all()->pluck('name', 'id'))
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
                TextColumn::make('expenses_id')
                    ->label('ID')
                    ->searchable(),
                TextColumn::make('expenses_date')
                    ->label('Date')
                    ->searchable(),
                TextColumn::make('cr_civil_id')
                    ->label('CR Number / Civil ID')
                    ->searchable(),
                TextColumn::make('contractor.name')
                    ->label('Contractor')
                    ->sortable(),
                TextColumn::make('amount')
                    ->money('OMR')
                    ->summarize(Sum::make()->money('OMR')),
                TextColumn::make('contractorCategory.name')
                    ->label('Contractor Category')
                    ->sortable(),
                TextColumn::make('term.name')
                    ->label('Term')
                    ->sortable(),
                TextColumn::make('department.name')
                    ->sortable(),
                TextColumn::make('source.name')
                    ->sortable(),
                TextColumn::make('expenseStatus.name')
                    ->badge()
                    ->sortable(),
                SelectColumn::make('expense_status_id')
                    ->searchable()
                    ->options(ExpenseStatus::all()->pluck('name', 'id'))
                    ->sortable(),
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
            'index' => ListExpenses::route('/'),
            'create' => CreateExpense::route('/create'),
            'edit' => EditExpense::route('/{record}/edit'),
        ];
    }
}
