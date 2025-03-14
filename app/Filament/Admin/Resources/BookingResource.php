<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\BookingResource\Pages;
use App\Filament\Admin\Resources\BookingResource\RelationManagers;
use App\Models\Booking;
use App\Models\Place;
use App\Models\Province;
use App\Models\Slot;
use App\Models\State;
use App\Models\User;
use App\Models\Workshop;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use function App\Filament\Resources\ray;

//use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class BookingResource extends Resource
{
    // use HasPageShield;
    protected static ?string $model = Booking::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    public $answer;
    protected $listeners = ['downloadAnswerFile' => 'download'];

    public static function getModelLabel(): string
    {
        return __('bookings');
    }

    public static function getPluralModelLabel(): string
    {
        return __('bookings');
    }

    public static function table(Table $table): Table
    {
        global $state;
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('workshop.title')->label(__('Workshop'))->searchable(),
                Tables\Columns\TextColumn::make('slot.name')->label(__('slot'))->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label(__('User'))
                    ->searchable()
                    ->url(fn($record) => UserResource::getUrl('view', [$record->user_id]))
                    ->openUrlInNewTab(),
                Tables\Columns\TextColumn::make('user.birth_date')->label(__('Age'))->formatStateUsing(fn(string $state
                ): string => Carbon::parse($state)->age),
                Tables\Columns\TextColumn::make('user.phone')
                    ->label(__('filament::users.phone'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.email')
                    ->label(__('filament::users.email'))
                    ->searchable(),
//                TextColumn::make('user.birth_date')->date(fn (Booking $record): string => $record->user->birth_date),
//                TextColumn::make('answers'),
                Tables\Columns\TextColumn::make('reasone')->label(__('reasone'))->searchable(),
                // Tables\Columns\TextColumn::make('answers')->label(__('answers'))->searchable(),
                Tables\Columns\TextColumn::make('rejection_message')->label(__('rejection_message')),
                Tables\Columns\TextColumn::make('status')->formatStateUsing(fn() => match ($state) {
                    0 => __('Waiting'),

                    1 => __('Rejected'),

                    2 => __('Approvied'),

                    3 => __('canceled'),

                    4 => __('Waiting List'),
                    default => __('Waiting'),
                })->badge()->colors([
                    'warning' => static fn($state): bool => $state === 0,
                    'success' => static fn($state): bool => $state === 2,
                    'danger' => static fn($state): bool => $state === 1,
                    'info' => static fn($state): bool => $state === 4,
                ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label(__('created_at'))
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('status'))
                    ->multiple()
                    ->options([
                        0 => __('Waiting'),
                        1 => __('Rejected'),
                        2 => __('Approvied'),
                        3 => __('canceled')
                    ]),
                Filter::make('state')
                    ->form([
                        Select::make('province_id')
                            ->options(Province::all()->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('state_id', null)),
                        Select::make('state_id')
                            ->label(__('State'))
                            ->options(function (callable $get) {
                                $province = Province::find($get('province_id'));
                                if (!$province) {
                                    return State::all()->pluck('name', 'id');
                                }
                                return $province->state->pluck('name', 'id');
                            })
                            ->searchable()
                            ->multiple(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['state_id'],
                                function (Builder $query, $state): Builder {
                                    return $query->whereHas('user', function ($query) use ($state) {
                                        $query->where('state_id', $state);
                                    });
                                }
                            );
                    }),
                Filter::make('workshop_id')
                    ->form([
                        Select::make('place_id')
                            ->label(__('Place'))
                            ->options(Place::all()->pluck('name', 'id'))
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('workshop_id', null)),
                        Select::make('workshop_id')
                            ->label(__('Workshop'))
                            ->options(function (callable $get) {
                                $place = Place::find($get('place_id'));
                                if (!$place) {
                                    return Workshop::all()->pluck('title', 'id');
                                }
                                return $place->workshop->pluck('title', 'id');
                            })
                            ->searchable()
                            ->reactive()
                            ->afterStateUpdated(fn(callable $set) => $set('slot_id', null)),
                        Select::make('slot_id')
                            ->label(__('slot'))
                            ->options(function (callable $get) {
                                $workshop = Workshop::find($get('workshop_id'));
                                if (!$workshop) {
                                    return Slot::all()->pluck('name', 'id');
                                }
                                return $workshop->slots->pluck('name', 'id');
                            })
                            ->searchable(),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['place_id'],
                                function (Builder $query, $placeId) {
                                    return $query->whereHas('workshop', function ($query) use ($placeId) {
                                        $query->where('place_id', $placeId);
                                    });
                                }
                            )
                            ->when(
                                $data['workshop_id'],
                                fn(Builder $query, $date): Builder => $query->where('workshop_id', '=', $date),
                            )
                            ->when(
                                $data['slot_id'],
                                fn(Builder $query, $date): Builder => $query->where('slot_id', '=', $date),
                            );
                    })
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Action::make('approve')
                    ->label(__('approve'))
                    ->action(function (Booking $record, array $data) {
                        $user = User::where('id', $record->user_id)->first();
                        $slot = Slot::where('id', '=', $record->slot_id)->first();
                        $workshop = Workshop::where('id', '=', $record->workshop_id)->first();
                        $sms = new SmsMessage;
                        if ($user->preferred_language == 'ar') {
                            if ($data['type'] == 'default') {
                                $sms->to($user->phone)
                                    ->message('أهلا بصديق المركز ' . $user->name . ' يسرنا إعلامك بقبولك في برنامج (' . $workshop->getTranslation('title',
                                            'ar') . '). نحن بانتظارك في (' . $slot['start_date'] . ') تبدأ الورشة (' . $slot['start_time'] . ')')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message($data['message_ar'])
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                        } else {
                            if ($data['type'] == 'default') {
                                $sms->to($user->phone)
                                    ->message('Hello friend ' . $user->name . ' We are pleased to inform you that you have been accepted into the (' . $workshop->getTranslation('title',
                                            'en') . ') program. We are waiting for you on (' . $slot['start_date'] . ') The workshop begins (' . $slot['start_time'] . ')')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message($data['message_en'])
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                        }
                        Booking::where('id', $record->id)->update(['status' => 2]);
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn(Booking $record) => $record->status === 2)
                    ->form([
                        Forms\Components\Radio::make('type')->label(__('Message Type'))->options([
                            'default' => 'Default',
                            'custom' => 'Custom',
                        ])
                            ->reactive()
                            ->required(),
                        Forms\Components\Textarea::make('message_ar')
                            ->required()
                            ->visible(function (callable $get) {
                                if ($get('type') == 'custom') {
                                    return true;
                                }
                            }),
                        Forms\Components\Textarea::make('message_en')
                            ->required()
                            ->visible(function (callable $get) {
                                if ($get('type') == 'custom') {
                                    return true;
                                }
                            }),
                    ]),

                Action::make('reject')->action('reject')
                    ->label(__('reject'))
                    ->action(function (Booking $record, array $data) {
                        $user = User::where('id', $record->user_id)->first();
                        $slot = Slot::where('id', '=', $record->slot_id)->first();
                        $workshop = Workshop::where('id', '=', $record->workshop_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'en') {
                            if ($data['rejection_reason'] == 'full') {
                                $sms->to($user->phone)
                                    ->message('Hello friend ' . $user->name . ' Thank you for registering in the (' . $workshop->getTranslation('title',
                                            'en') . ') program. We apologize for not accepting you among the participants due to the wide demand for registration and the completion of the specified number of the program. See you soon on our next shows.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('Welcome, ' . $user->name . '. Since you did not meet the admission requirements, we regret to inform you that you were not accepted into the (' . $workshop->getTranslation('title',
                                            'en') . ') program.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                        } else {
                            if ($data['rejection_reason'] == 'full') {
                                $sms->to($user->phone)
                                    ->message('أهلا بصديق المركز ' . $user->name . ' شكرً لتسجيلك في برنامج (' . $workshop->getTranslation('title',
                                            'ar') . '). نعتذر لك لعدم قبولك ضمن المشاركين فيها نظرا للإقبال الواسع في التسجيل و اكتمال العدد المحدد للبرنامج. نراك قريبًا في برامجنا القادمة.')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('أهلا بصديق المركز ' . $user->name . ' شكرً لتسجيلك في برنامج (' . $workshop->getTranslation('title',
                                            'ar') . '). نظرا لعدم استيفائك لشروط القبول يؤسِفنا إبلاغك بعدم قبولك في برنامج')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                        }

                        Booking::where('id', $record->id)->update([
                            'status' => 1, 'rejection_message' => $data['rejection_reason']
                        ]);
                    })
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->hidden(fn(Booking $record) => $record->status === 1)
                    ->form([
                        Select::make('rejection_reason')->required()
                            ->label(__('rejection_reason'))
                            ->options([
                                'full' => __('Fully Booked'),
                                'not_fit' => __('Not meeting the conditions')
                            ])
                    ]),
                Action::make('cancel')
                    ->label(__('cancel'))
                    ->action('cancel')
                    ->action(function (Booking $record, array $data) {
                        $workshop = Workshop::where('id', $record->workshop_id)->first();
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('تم الغاء حجزك في  ' . $workshop->getTranslation('title', 'ar'))
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Your reservation for ' . $workshop->getTranslation('title',
                                        'en') . ' has been canceled')
                                ->lang($user->preferred_language)
                                ->send();
                        }
                        Booking::where('id', $record->id)->update(['status' => 3]);
                    })
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->hidden(fn(Booking $record) => $record->status === 3),
                Action::make('waiting')
                    ->label(__('waiting'))
                    ->action('waiting')
                    ->action(function (Booking $record, array $data) {
                        $workshop = Workshop::where('id', $record->workshop_id)->first();
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('انت في قائمة الانتظار لل  ' . $workshop->getTranslation('title', 'ar'))
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('You are added to waiting list of ' . $workshop->getTranslation('title',
                                        'en'))
                                ->lang($user->preferred_language)
                                ->send();
                        }
                        Booking::where('id', $record->id)->update(['status' => 4]);
                    })
                    ->icon('heroicon-o-clock')
                    ->color('info')
                    ->hidden(fn(Booking $record) => $record->status === 4),
                Action::make('show_answers')
                    ->action(function (Booking $record, array $data) {

                    })
                    ->color('warning')
                    ->modalContent(fn($record) => view('filament.custom.answers', ['record' => $record]))
                    ->hidden(fn(Booking $record) => $record->answers === [])
            ])
            ->bulkActions([
                BulkAction::make('approve')
                    ->label(__('approve'))
                    ->action(function (Collection $records, array $data) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();
                            $slot = Slot::where('id', '=', $record->slot_id)->first();
                            $workshop = Workshop::where('id', '=', $record->workshop_id)->first();

                            $sms = new SmsMessage;
                            if ($user->preferred_language == 'ar') {
                                if ($data['type'] == 'default') {
                                    $sms->to($user->phone)
                                        ->message('أهلا بصديق المركز ' . $user->name . ' يسرنا إعلامك بقبولك في برنامج (' . $workshop->getTranslation('title',
                                                'ar') . '). نحن بانتظارك في (' . $slot['start_date'] . ') تبدأ الورشة (' . $slot['start_time'] . ')')
                                        ->lang('ar')
                                        ->send();
                                } else {
                                    $sms->to($user->phone)
                                        ->message($data['message_ar'])
                                        ->lang('ar')
                                        ->send();
                                }
                            } else {
                                if ($data['type'] == 'default') {
                                    $sms->to($user->phone)
                                        ->message('Hello friend ' . $user->name . ' We are pleased to inform you that you have been accepted into the (' . $workshop->getTranslation('title',
                                                'en') . ') program. We are waiting for you on (' . $slot['start_date'] . ') The workshop begins (' . $slot['start_time'] . ')')
                                        ->lang('en')
                                        ->send();
                                } else {
                                    $sms->to($user->phone)
                                        ->message($data['message_en'])
                                        ->lang('en')
                                        ->send();
                                }
                            }

                            Booking::where('id', $record->id)->update(['status' => 2]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\Radio::make('type')->label(__('Message Type'))->options([
                            'default' => 'Default',
                            'custom' => 'Custom',
                        ])
                            ->reactive()
                            ->required(),
                        Forms\Components\Textarea::make('message_ar')
                            ->required()
                            ->visible(function (callable $get) {
                                if ($get('type') == 'custom') {
                                    return true;
                                }
                            }),
                        Forms\Components\Textarea::make('message_en')
                            ->required()
                            ->visible(function (callable $get) {
                                if ($get('type') == 'custom') {
                                    return true;
                                }
                            }),
                    ]),
                BulkAction::make('reject')
                    ->label(__('reject'))
                    ->action(function (Collection $records, array $data) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();
                            $slot = Slot::where('id', '=', $record->slot_id)->first();
                            $workshop = Workshop::where('id', '=', $record->workshop_id)->first();

                            $sms = new SmsMessage;
                            if ($user->preferred_language == 'en') {
                                if ($data['rejection_reason'] == 'full') {
                                    $sms->to($user->phone)
                                        ->message('Hello friend ' . $user->name . ' Thank you for registering in the (' . $workshop->getTranslation('title',
                                                'en') . ') program. We apologize for not accepting you among the participants due to the wide demand for registration and the completion of the specified number of the program. See you soon on our next shows.')
                                        ->lang($user->preferred_language)
                                        ->send();
                                } else {
                                    $sms->to($user->phone)
                                        ->message('Welcome, ' . $user->name . '. Since you did not meet the admission requirements, we regret to inform you that you were not accepted into the (' . $workshop->getTranslation('title',
                                                'en') . ') program.')
                                        ->lang($user->preferred_language)
                                        ->send();
                                }
                            } else {
                                if ($data['rejection_reason'] == 'full') {
                                    $sms->to($user->phone)
                                        ->message('أهلا بصديق المركز ' . $user->name . ' شكرً لتسجيلك في برنامج (' . $workshop->getTranslation('title',
                                                'ar') . '). نعتذر لك لعدم قبولك ضمن المشاركين فيها نظرا للإقبال الواسع في التسجيل و اكتمال العدد المحدد للبرنامج. نراك قريبًا في برامجنا القادمة.')
                                        ->lang($user->preferred_language)
                                        ->send();
                                } else {
                                    $sms->to($user->phone)
                                        ->message('أهلا بصديق المركز ' . $user->name . ' شكرً لتسجيلك في برنامج (' . $workshop->getTranslation('title',
                                                'ar') . '). نظرا لعدم استيفائك لشروط القبول يؤسِفنا إبلاغك بعدم قبولك في برنامج')
                                        ->lang($user->preferred_language)
                                        ->send();
                                }
                            }
                            Booking::where('id', $record->id)->update(['status' => 1]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->form([
                        Select::make('rejection_reason')->required()
                            ->label(__('rejection_reason'))
                            ->options([
                                'full' => __('Fully Booked'),
                                'not_fit' => __('Not meeting the conditions')
                            ])
                    ]),
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('workshop_id')->options(Workshop::all()->pluck('title',
                    'id'))->searchable()
                    ->label(__('Workshop'))
                    ->reactive()
                    ->afterStateUpdated(fn(callable $set) => $set('slot_id', null))
                    ->required(),
                Forms\Components\Select::make('slot_id')
                    ->label(__('slot'))
                    ->options(function (callable $get) {
                        $workshop = Workshop::find($get('workshop_id'));
                        if (!$workshop) {
                            return null;
                        }
                        return $workshop->slots->pluck('name', 'id');
                    })
                    ->searchable()
                    ->label('Slot')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->getSearchResultsUsing(fn(string $search) => User::where('email', 'like',
                        "%{$search}%")->limit(10)->pluck('name', 'id'))
                    ->label('User')
                    ->required(),
                Forms\Components\TextInput::make('reasone')
                    ->label(__('reasone'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')->options([
                    0 => 'Waiting',
                    1 => 'Rejected',
                    2 => 'Approvied'
                ])->searchable()
                    ->label(__('status'))
                    ->required(),
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
            'index' => Pages\ListBookings::route('/'),
            'create' => Pages\CreateBooking::route('/create'),
            'edit' => Pages\EditBooking::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 0)->count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('workshops');
    }

    public function download()
    {
        ray('test');
    }

    protected function getDefaultTableSortColumn(): ?string
    {
        return 'created_at';
    }

    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
}
