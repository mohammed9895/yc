<?php

namespace App\Filament\Employee\Resources;

use App\Filament\Employee\Resources\EmployeeResource\Pages;
use App\Filament\Employee\Resources\EmployeeResource\RelationManagers;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\Split;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class EmployeeResource extends Resource
{
    use Translatable;

    protected static ?string $model = Employee::class;

    protected static ?string $navigationGroup = 'HR';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name)
                    ->options(User::where('email', 'like', '%@yc.om')->pluck('name', 'id'))
                    ->required(),
                Forms\Components\TextInput::make('employee_number'),
                Forms\Components\TextInput::make('first_name'),
                Forms\Components\TextInput::make('second_name'),
                Forms\Components\TextInput::make('third_name'),
                Forms\Components\TextInput::make('family_name'),
                Forms\Components\TextInput::make('position'),
                Forms\Components\DatePicker::make('dob')->native(false),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('civil_id')
                    ->maxLength(255),
                Forms\Components\TextInput::make('number_of_yearly_leave')
                    ->prefix('Days')
                    ->numeric(),
                Forms\Components\TextInput::make('work_from_home_days')
                    ->prefix('Days')
                    ->numeric(),
                Forms\Components\TextInput::make('salary')
                    ->prefix('OMR')
                    ->numeric(),
                Forms\Components\FileUpload::make('personal_image')
                    ->avatar()
                    ->image(),
                Forms\Components\Select::make('department_id')
                    ->options(Department::all()->pluck('name', 'id')),
                Forms\Components\Select::make('direct_manager')
                    ->options(Employee::all()->pluck('first_name', 'id')),
                Forms\Components\Select::make('employment_type_id')
                    ->relationship('employmentType', 'name'),
                Forms\Components\DatePicker::make('joining_date')->native(false),
                Forms\Components\DatePicker::make('contract_start_date')->native(false),
                Forms\Components\DatePicker::make('contract_end_date')->native(false),
                Forms\Components\FileUpload::make('civil_id_copy'),
                Forms\Components\FileUpload::make('passport_copy'),
                Forms\Components\FileUpload::make('contract_copy'),
                Forms\Components\RichEditor::make('tasks')
                    ->columnSpanFull(),
                Forms\Components\RichEditor::make('notes')
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('emergency_contacts')->schema([
                    Forms\Components\TextInput::make('name'),
                    Forms\Components\Select::make('relationship')->options([
                        'Father' => 'Father',
                        'Mother' => 'Mother',
                        'Spouse' => 'Spouse',
                        'Child' => 'Child',
                        'Sibling' => 'Sibling',
                        'Relative' => 'Relative',
                        'Other' => 'Other',
                    ]),
                    Forms\Components\TextInput::make('phone'),
                ])->columnSpanFull(),
                Forms\Components\Toggle::make('is_ceo')
                    ->default(1),
                Forms\Components\Toggle::make('status')
                    ->default(1),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Section::make('Employee Information')
                ->schema([
                    Split::make([
                        ImageEntry::make('personal_image')->hiddenLabel()->grow(false),
                        Grid::make(4)->schema([
                            TextEntry::make('employee_id')->badge(),
                            TextEntry::make('first_name'),
                            TextEntry::make('second_name'),
                            TextEntry::make('third_name'),
                            TextEntry::make('family_name'),
                            TextEntry::make('position'),
                            TextEntry::make('dob'),
                            TextEntry::make('civil_id')
                                ->badge(),
                            TextEntry::make('email')->icon('heroicon-m-envelope'),
                            TextEntry::make('phone')->icon('heroicon-m-phone'),
                            TextEntry::make('number_of_yearly_leave')->formatStateUsing(fn($state) => $state . ' days')->badge(),
                            TextEntry::make('salary')->formatStateUsing(fn($state) => $state . ' OMR'),
                            TextEntry::make('department.name')->badge(),
                            TextEntry::make('directManager.first_name')->badge(),
                            TextEntry::make('employmentType.name')->badge(),
                            TextEntry::make('joining_date')->date(),
                            TextEntry::make('contract_start_date')->date(),
                            TextEntry::make('contract_end_date')->date(),
                        ]),
                    ]),
                    Actions::make([
                        Action::make('civil_id_copy')
                            ->label('Download Civil ID')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(function (Employee $record) {
                                return Storage::download($record->civil_id_copy);
                            }),
                        Action::make('passport_copy')
                            ->label('Download Passport')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(function (Employee $record) {
                                return Storage::download($record->passport_copy);
                            }),
                        Action::make('contract_copy')
                            ->label('Download Contract')
                            ->icon('heroicon-m-arrow-down-tray')
                            ->action(function (Employee $record) {
                                return Storage::download($record->contract_copy);
                            }),
                    ])->fullWidth(),
                    TextEntry::make('tasks')->html(),
                    TextEntry::make('notes')->html(),
                    RepeatableEntry::make('emergency_contacts')
                        ->schema([
                            Grid::make(3)->schema([
                                TextEntry::make('name'),
                                TextEntry::make('relationship'),
                                TextEntry::make('phone'),
                            ])
                        ])->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('dob')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('civil_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('number_of_yearly_leave')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('salary')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('personal_image'),
                Tables\Columns\TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('direct_manager')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('employmentType.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('contract_start_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contract_end_date')
                    ->searchable(),
                Tables\Columns\TextColumn::make('civil_id_copy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('passport_copy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('contract_copy')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->numeric()
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
