<?php

namespace App\Filament\Admin\Resources\Users;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Radio;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\Users\Pages\ListUsers;
use App\Filament\Admin\Resources\Users\Pages\CreateUser;
use App\Filament\Admin\Resources\Users\Pages\EditUser;
use App\Filament\Admin\Resources\Users\Pages\ViewUser;
use App\Filament\Admin\Resources\UserResource\Pages;
use App\Filament\Admin\Resources\UserResource\RelationManagers;
use App\Models\Country;
use App\Models\Disability;
use App\Models\EducationType;
use App\Models\EmployeeType;
use App\Models\Province;
use App\Models\State;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Eloquent\Builder;

class UserResource extends Resource
{
    // use HasPageShield;
    protected static ?string $model = User::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-users';

    public static function getPluralModelLabel(): string
    {
        return   __('filament::users.navigationLabel');
    }

    public static function getModelLabel(): string
    {
        return   __('filament::users.navigationLabelSingelr');
    }

    // protected static ?string $modelLabel = __('filament::users.navigationLabelSingelr');

    public static function getNavigationGroup(): ?string
    {
        return   __('users');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')->label(__('filament::users.name'))
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')->label(__('filament::users.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                TextInput::make('password')->label(__('filament::users.password'))
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->visibleOn('create'),
                TextInput::make('phone')->label(__('filament::users.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
                FileUpload::make('avatar_url')->label(__('filament::users.avatar')),
                Radio::make('citizen')->label(__('filament::users.citizin'))->options([
                    0 => __('filament::users.citizin'),
                    1 => __('filament::users.foreigner'),
                ])->required(),




                Select::make('roles')
                    ->label(__('Role'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),

                Radio::make('gender')->label(__('filament::users.sex'))
                    ->options([
                        0 => __('filament::users.male'),
                        1 => __('filament::users.female'),
                    ])->required(),

                TextInput::make('civil_no')->label(__('filament::users.id_number'))->maxLength(255)->required(),

                DatePicker::make('birth_date')
                    ->label(__('Birth Date'))
                    ->required(),

                Select::make('disability_id')->label(__('filament::users.disability'))->options(Disability::all()->pluck('name', 'id'))->searchable()->required(),
                Select::make('country_id')->label(__('filament::users.coutry'))
                    ->options(Country::all()->pluck('name', 'id'))->searchable()->required(),

                Select::make('province_id')
                    ->label(__('province'))
                    ->required()
                    ->options(Province::all()->pluck('name', 'id'))
                    ->searchable()
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),
                Select::make('state_id')
                    ->label(__('state'))
                    ->required()
                    ->options(function (callable $get) {
                        $province = Province::find($get('province_id'));
                        if (!$province) {
                            return State::all()->pluck('name', 'id');
                        }
                        return $province->state->pluck('name', 'id');
                    })
                    ->searchable(),
                Select::make('education_type_id')->label(__('filament::users.degree'))->options(EducationType::all()->pluck('name', 'id'))->searchable()->required(),
                Select::make('employee_type_id')->label(__('filament::users.work'))->options(EmployeeType::all()->pluck('name', 'id'))->searchable()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable()->sortable(),
                TextColumn::make('phone')->searchable()->sortable(),
                TextColumn::make('disability.name')->searchable()->sortable(),
                TextColumn::make('birth_date')->label(__('Age'))->formatStateUsing(fn (string $state): string => Carbon::parse($state)->age),
                TextColumn::make('gender')
                    ->badge()
                    ->formatStateUsing(function (string $state) {
                       if ($state == 0) {
                           return 'Male';
                       }
                       else {
                           return 'Female';
                       }
                    })
                    ->searchable()
                    ->sortable(),
                TextColumn::make('citizen')
                    ->badge()
                    ->formatStateUsing(function (string $state) {
                        if ($state == 0) {
                            return 'Omani';
                        }
                        else {
                            return 'Foreigner';
                        }
                    })->searchable()->sortable(),
                TextColumn::make('country.name')->searchable()->sortable(),
                TextColumn::make('province.name')->searchable()->sortable(),
                TextColumn::make('state.name')->searchable()->sortable(),
                TextColumn::make('educationType.name')->searchable()->sortable(),
                TextColumn::make('employeeType.name')->searchable()->sortable(),
                TextColumn::make('created_at')
                    ->since()->sortable(),
            ])
            ->filters([
                SelectFilter::make('citizen')
                    ->multiple()
                    ->options([
                        0 => 'Omani',
                        1 => 'Foreigner'
                    ]),
                SelectFilter::make('gender')
                    ->multiple()
                    ->options([
                        0 => 'Male',
                        1 => 'Female',
                    ]),
                SelectFilter::make('province_id')
                    ->multiple()
                    ->label('Province')
                    ->options(Province::all()->pluck('name', 'id')),

                SelectFilter::make('state_id')
                    ->multiple()
                    ->label('State')
                    ->options(State::all()->pluck('name', 'id')),

                SelectFilter::make('education_type_id')
                    ->multiple()
                    ->label('Education Type')
                    ->options(EducationType::all()->pluck('name', 'id')),

                SelectFilter::make('employee_type_id')
                    ->multiple()
                    ->label('Employee Type')
                    ->options(EmployeeType::all()->pluck('name', 'id')),
                Filter::make('date')
                    ->schema([
                        DatePicker::make('created_from')->label(__('filament::yc.created_from')),
                        DatePicker::make('created_until')->label(__('filament::yc.created_until')),
                    ])
                    ->label(__('filament::yc.date'))
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn(Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                ViewAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
                ExportBulkAction::make()
            ]);
    }

    protected function getTableRecordsPerPageSelectOptions(): array
    {
        return [10, 25, 50, 100];
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
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
            'view' => ViewUser::route('/{record}'),
        ];
    }
}
