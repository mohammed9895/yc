<?php

namespace App\Filament\Admin\Resources;

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
use Filament\Forms\Form;
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

    protected static ?string $navigationIcon = 'heroicon-o-users';

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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')->label(__('filament::users.name'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')->label(__('filament::users.email'))
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')->label(__('filament::users.password'))
                    ->password()
                    ->required()
                    ->maxLength(255)
                    ->visibleOn('create'),
                Forms\Components\TextInput::make('phone')->label(__('filament::users.phone'))
                    ->tel()
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('avatar_url')->label(__('filament::users.avatar')),
                Forms\Components\Radio::make('citizen')->label(__('filament::users.citizin'))->options([
                    0 => __('filament::users.citizin'),
                    1 => __('filament::users.foreigner'),
                ])->required(),




                Forms\Components\Select::make('roles')
                    ->label(__('Role'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable(),

                Forms\Components\Radio::make('gender')->label(__('filament::users.sex'))
                    ->options([
                        0 => __('filament::users.male'),
                        1 => __('filament::users.female'),
                    ])->required(),

                Forms\Components\TextInput::make('civil_no')->label(__('filament::users.id_number'))->maxLength(255)->required(),

                DatePicker::make('birth_date')
                    ->label(__('Birth Date'))
                    ->required(),

                Forms\Components\Select::make('disability_id')->label(__('filament::users.disability'))->options(Disability::all()->pluck('name', 'id'))->searchable()->required(),
                Forms\Components\Select::make('country_id')->label(__('filament::users.coutry'))
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
                Forms\Components\Select::make('education_type_id')->label(__('filament::users.degree'))->options(EducationType::all()->pluck('name', 'id'))->searchable()->required(),
                Forms\Components\Select::make('employee_type_id')->label(__('filament::users.work'))->options(EmployeeType::all()->pluck('name', 'id'))->searchable()->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('email')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('phone')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('disability.name')->searchable()->sortable(),
                TextColumn::make('birth_date')->label(__('Age'))->formatStateUsing(fn (string $state): string => Carbon::parse($state)->age),
                Tables\Columns\TextColumn::make('gender')
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
                Tables\Columns\TextColumn::make('citizen')
                    ->badge()
                    ->formatStateUsing(function (string $state) {
                        if ($state == 0) {
                            return 'Omani';
                        }
                        else {
                            return 'Foreigner';
                        }
                    })->searchable()->sortable(),
                Tables\Columns\TextColumn::make('country.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('province.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('state.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('educationType.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('employeeType.name')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('created_at')
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
                    ->form([
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
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
            'view' => Pages\ViewUser::route('/{record}'),
        ];
    }
}
