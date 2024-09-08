<?php

namespace App\Filament\Cp\Pages\Auth;

use App\Models\Country;
use App\Models\Disability;
use App\Models\EducationType;
use App\Models\EmployeeType;
use App\Models\Province;
use App\Models\State;
use App\Models\User;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Pages\Page;
use Filament\Pages\Auth\Register as BaseRegister;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;

class Register extends BaseRegister
{

    protected static string $view = 'filament-panels::pages.auth.register';
    protected function getForms(): array
    {
        return [
            'form' => $this->form(
                $this->makeForm()
                    ->schema([
                        Wizard::make([
                            Wizard\Step::make(__('Step 1'))
                                ->schema([
                                    TextInput::make('first_name')
                                        ->label(__('First Name'))
                                        ->required()
                                        ->maxLength(50)->columnSpan(1),
                                    TextInput::make('middle_name')
                                        ->label(__('Middle Name'))
                                        ->required()
                                        ->maxLength(50)->columnSpan(1),
                                    TextInput::make('family_name')
                                        ->label(__('Family Name'))
                                        ->required()
                                        ->maxLength(50)
                                        ->columnSpan(1),
                                    TextInput::make('email')
                                        ->label(__('filament::users.email'))
                                        ->email()
                                        ->required()
                                        ->maxLength(50)
                                        ->unique(User::class),
                                    TextInput::make('password')
                                        ->label(__('filament::users.password'))
                                        ->password()
                                        ->required()
                                        ->maxLength(50)
                                        ->minLength(8)
                                        ->same('passwordConfirmation')
                                        ->dehydrateStateUsing(fn($state) => Hash::make($state)),
                                    TextInput::make('passwordConfirmation')
                                        ->label(__('passwordConfirmation'))
                                        ->password()
                                        ->required()
                                        ->maxLength(50)
                                        ->minLength(8)
                                        ->dehydrated(false),
                                    TextInput::make('phone')
                                        ->label(__('filament::users.phone'))
                                        ->maxLength(8)
                                        ->required()
                                        ->minLength(8),
                                    DatePicker::make('birth_date')
                                        ->label(__('Birth Date'))
                                        ->required(),
                                    Select::make('disability_id')
                                        ->label(__('disability'))
                                        ->required()
                                        ->options(Disability::all()->pluck('name', 'id'))
                                        ->searchable(),
                                    Radio::make('gender')
                                        ->label(__('sex'))
                                        ->options([
                                            0 => __('filament::users.male'),
                                            1 => __('filament::users.female'),
                                        ])->required(),
                                ])
                                ->columns([
                                    'sm' => '1',
                                    'lg' => 2,
                                ])
                                ->columnSpan([
                                    'sm' => 'full',
                                    'lg' => 2,
                                ]),
                            Wizard\Step::make(__('Step 2'))
                                ->schema([
                                    Radio::make('citizen')
                                        ->label(__('filament::users.citizin'))
                                        ->options([
                                            0 => __('filament::users.citizin'),
                                            1 => __('filament::users.foreigner'),
                                        ])->required(),
                                    TextInput::make('civil_no')->label(__('Civil Number'))->maxLength(10)->required(),
                                    Select::make('country_id')
                                        ->label(__('filament::users.coutry'))
                                        ->required()
                                        ->options(Country::all()->pluck('name', 'id'))
                                        ->searchable(),
                                    Select::make('province_id')
                                        ->label(__('province'))
                                        ->required()
                                        ->options(Province::all()->pluck('name', 'id'))
                                        ->searchable()
                                        ->reactive()
                                        ->afterStateUpdated(fn(callable $set) => $set('state_id', null)),
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
                                    Select::make('permanent_residence_state_id')
                                        ->label(__('permanent_residence_state'))
                                        ->required()
                                        ->options(State::all()->pluck('name', 'id'))
                                        ->searchable(),
                                ]),
                            Wizard\Step::make(__('Step 3'))
                                ->schema([
                                    Select::make('education_type_id')
                                        ->label(__('filament::users.degree'))
                                        ->required()
                                        ->searchable()
                                        ->options(EducationType::all()->pluck('name', 'id')),
                                    Select::make('employee_type_id')
                                        ->label(__('filament::users.work'))
                                        ->required()
                                        ->searchable()
                                        ->options(EmployeeType::all()->pluck('name', 'id')),
                                    Select::make('preferred_language')
                                        ->label(__('Preferred Communication Language'))
                                        ->searchable()
                                        ->options(
                                            [
                                                'en' => 'English',
                                                'ar' => 'Arabic'
                                            ]
                                        ),
                                    Checkbox::make('agreed_on_terms')->label(new HtmlString(''.__('I agree with the').' <a href="/termsandconditions" target="_blank" class="text-primary-600">'.__('terms and conditions').'</a>'))->inline()->required()
                                ])
                        ])
                            ->columns([
                                'sm' => 1,
                            ])
                            ->columnSpan([
                                'sm' => 1,
                            ])
                    ])
                    ->statePath('data'),
            ),
        ];
    }

    public function register(): ?RegistrationResponse
    {
        dd($this->form->getState());
    }
}
