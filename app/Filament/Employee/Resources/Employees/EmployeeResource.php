<?php

namespace App\Filament\Employee\Resources\Employees;

use LaraZeus\SpatieTranslatable\Resources\Concerns\Translatable;
use Filament\Schemas\Schema;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Flex;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Actions;
use Filament\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Actions\ViewAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Employee\Resources\Employees\Pages\ListEmployees;
use App\Filament\Employee\Resources\Employees\Pages\CreateEmployee;
use App\Filament\Employee\Resources\Employees\Pages\ViewEmployee;
use App\Filament\Employee\Resources\Employees\Pages\EditEmployee;
use App\Filament\Employee\Resources\EmployeeResource\Pages;
use App\Filament\Employee\Resources\EmployeeResource\RelationManagers;
use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Filament\Forms;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
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

    protected static string | \UnitEnum | null $navigationGroup = 'HR';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id')->toArray())
                    ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name)
                    ->options(User::where('email', 'like', '%@yc.om')->pluck('name', 'id'))
                    ->required(),
                TextInput::make('employee_number'),
                TextInput::make('first_name'),
                TextInput::make('second_name'),
                TextInput::make('third_name'),
                TextInput::make('family_name'),
                TextInput::make('position'),
                DatePicker::make('dob')->native(false),
                TextInput::make('email')
                    ->email()
                    ->maxLength(255),
                TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                TextInput::make('civil_id')
                    ->maxLength(255),
                TextInput::make('number_of_yearly_leave')
                    ->prefix('Days')
                    ->numeric(),
                TextInput::make('work_from_home_days')
                    ->prefix('Days')
                    ->numeric(),
                TextInput::make('salary')
                    ->prefix('OMR')
                    ->numeric(),
                FileUpload::make('personal_image')
                    ->avatar()
                    ->image(),
                Select::make('department_id')
                    ->options(Department::all()->pluck('name', 'id')),
                Select::make('direct_manager')
                    ->options(Employee::all()->pluck('first_name', 'id')),
                Select::make('employment_type_id')
                    ->relationship('employmentType', 'name'),
                DatePicker::make('joining_date')->native(false),
                DatePicker::make('contract_start_date')->native(false),
                DatePicker::make('contract_end_date')->native(false),
                FileUpload::make('civil_id_copy'),
                FileUpload::make('passport_copy'),
                FileUpload::make('contract_copy'),
                RichEditor::make('tasks')
                    ->columnSpanFull(),
                RichEditor::make('notes')
                    ->columnSpanFull(),
                Repeater::make('emergency_contacts')->schema([
                    TextInput::make('name'),
                    Select::make('relationship')->options([
                        'Father' => 'Father',
                        'Mother' => 'Mother',
                        'Spouse' => 'Spouse',
                        'Child' => 'Child',
                        'Sibling' => 'Sibling',
                        'Relative' => 'Relative',
                        'Other' => 'Other',
                    ]),
                    TextInput::make('phone'),
                ])->columnSpanFull(),
                Toggle::make('is_ceo')
                    ->default(1),
                Toggle::make('status')
                    ->default(1),
            ]);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Employee Information')
                ->schema([
                    Flex::make([
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
                TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('dob')
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('phone')
                    ->searchable(),
                TextColumn::make('civil_id')
                    ->searchable(),
                TextColumn::make('number_of_yearly_leave')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('salary')
                    ->numeric()
                    ->sortable(),
                ImageColumn::make('personal_image'),
                TextColumn::make('department.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('direct_manager')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('employmentType.name')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('contract_start_date')
                    ->searchable(),
                TextColumn::make('contract_end_date')
                    ->searchable(),
                TextColumn::make('civil_id_copy')
                    ->searchable(),
                TextColumn::make('passport_copy')
                    ->searchable(),
                TextColumn::make('contract_copy')
                    ->searchable(),
                TextColumn::make('status')
                    ->numeric()
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
            'index' => ListEmployees::route('/'),
            'create' => CreateEmployee::route('/create'),
            'view' => ViewEmployee::route('/{record}'),
            'edit' => EditEmployee::route('/{record}/edit'),
        ];
    }
}
