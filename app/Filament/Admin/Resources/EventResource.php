<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\EventResource\Pages;
use App\Filament\Admin\Resources\EventResource\RelationManagers;
use App\Mail\HallConfirmationMail;
use App\Models\Event;
use App\Models\Hall;
use App\Models\User;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use Spatie\CalendarLinks\Link;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getModelLabel(): string
    {
        return __('events');
    }

    public static function getPluralModelLabel(): string
    {
        return __('events');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->label(__('id'))->searchable(),
                Tables\Columns\TextColumn::make('user.name')->sortable()->label(__('user'))->searchable(),
                Tables\Columns\TextColumn::make('hall.name')->sortable()->label(__('hall'))->searchable(),
                Tables\Columns\TextColumn::make('title')->label(__('title'))->searchable(),
                Tables\Columns\TextColumn::make('reasone')->label(__('reasone'))->searchable(),
                Tables\Columns\TextColumn::make('pax')->label(__('pax')),
                Tables\Columns\TextColumn::make('start')->sortable()->label(__('start'))->searchable(),
                Tables\Columns\TextColumn::make('end')->sortable()->label(__('end'))->searchable(),
                Tables\Columns\TextColumn::make('status')->sortable()->badge()->formatStateUsing(fn ($state) => match ($state) {
                    0 => __('Waiting'),
                    1 => __('Approvied'),
                    2 => __('Rejected'),
                    3 => __('canceled'),
                })->label(__('status')),
                Tables\Columns\TextColumn::make('created_at')->label(__('created_at'))
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')->label(__('updated_at'))
                    ->dateTime(),
            ])
            ->filters([
                SelectFilter::make('status')->label(__('status'))
                    ->multiple()
                    ->options([
                        0 => __('Waiting'),
                        1 => __('Approvied'),
                        2 => __('Rejected'),
                        3 => __('canceled'),
                    ]),
                SelectFilter::make('hall_id')->label(__('hall'))
                    ->multiple()
                    ->options(Hall::all()
                        ->where('status', 1)
                        ->pluck('name', 'id')),
                Filter::make('start_date')
                    ->form([
                        DatePicker::make('start_date')->label(__('start')),
                    ])
                    ->label(__('filament::yc.date'))
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['start_date'],
                                fn(Builder $query, $date): Builder => $query->whereDate('start', '=', $date),
                            );
                    }),
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
                Action::make('approve')->action('approve')
                    ->action(function (Event $record) {
                        if ($record->status == 1) {
                            Notification::make()
                                ->title('This event already approved!')
                                ->danger()
                                ->send();
                            return;
                        }
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;
                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message("تم قبولك طلب حجزك للقاعة " . $record->hall->name . ' من ' . $record->start . ' الى ' . $record->end)
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message("Your " . $record->hall->name . " reservation request has been accepted from " . $record->start . ' till ' . $record->end)
                                ->lang($user->preferred_language)
                                ->send();
                        }

                        $from = Carbon::parse($record->start);
                        $to = Carbon::parse($record->end);

//                        $link = Link::create($record->title, $from, $to)
//                            ->description($record->reasone)
//                            ->address('Youth Center ' . $record->hall->name);

//                        Mail::to($user->email)->send(new HallConfirmationMail($record->hall->name, $user, $record->start, $record->end, $link->ics()));
                        Event::where('id', $record->id)->update(['status' => 1]);
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation(),

                Action::make('reject')->action('reject')
                    ->action(function (Event $record, array $data) {
                        if ($record->status == 2) {
                            Notification::make()
                                ->title('This event already rejected!')
                                ->danger()
                                ->send();
                            return;
                        }
                        $user = User::where('id', $record->user_id)->first();
                        if (Config::get('app.locale') == 'ar') {
                            $messageSms = "تم رفض طلب حجزك ل " . $record->hall->name;
                        } else {
                            $messageSms = "Your " . $record->hall->name . " reservation request has been rejected";
                        }

                        $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                        $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                        Event::where('id', $record->id)->update(['status' => 2]);
                    })
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation(),

            ])
            ->bulkActions([
                ExportBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
                BulkAction::make('approve')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            // if ($record->status == 1) {
                            //     Notification::make()
                            //         ->title('This event already approved!' . $record->id)
                            //         ->danger()
                            //         ->send();
                            //     return;
                            // }
                            $user = User::where('id', $record->user_id)->first();
                            if (Config::get('app.locale') == 'ar') {
                                $messageSms = "تم قبولك طلب حجزك للقاعة " . $record->hall->name . ' من ' . $record->start . ' الى ' . $record->end;
                            } else {
                                $messageSms = "Your " . $record->hall->name . " reservation request has been accepted from " . $record->start . ' till ' . $record->end;
                            }

                            $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                            $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                            Event::where('id', $record->id)->update(['status' => 1]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation(),
                BulkAction::make('reject')
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            // if ($record->status == 2) {
                            //     Notification::make()
                            //         ->title('This event already approved! ID is ' . $record->id)
                            //         ->danger()
                            //         ->send();
                            //     return;
                            // }
                            $user = User::where('id', $record->user_id)->first();
                            if (Config::get('app.locale') == 'ar') {
                                $messageSms = "تم رفض طلب حجزك ل " . $record->hall->name;
                            } else {
                                $messageSms = "Your " . $record->hall->name . " reservation request has been rejected";
                            }

                            $lang = Config::get('app.locale') == 'ar' ? '64' : '0';
                            $response = Http::post('https://www.ismartsms.net/iBulkSMS/HttpWS/SMSDynamicAPI.aspx?UserId=' . env('User_ID_OTP', 'youthsmsweb') . '&Password=' . env('OTP_Password', 'L!ulid80') . '&MobileNo=' . $user['phone'] . '&Message=' . $messageSms . '&PushDateTime=10/12/2022 02:03:00&Lang=' . $lang . '&FLashSMS=N');

                            Event::where('id', $record->id)->update(['status' => 2]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation(),
            ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label(__('Title'))
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('reasone')
                    ->label(__('reasone'))
                    ->required()
                    ->maxLength(255),
                Select::make('hall_id')
                    ->label(__('hall'))
                    ->options(Hall::all()
                        ->where('status', 1)
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\DateTimePicker::make('start')
                    ->label(__('start'))
                    ->withoutSeconds()
                    ->minutesStep(30)
                    ->required(),
                Forms\Components\DateTimePicker::make('end')
                    ->label(__('end'))
                    ->withoutSeconds()
                    ->minutesStep(30)
                    ->required(),
                Select::make('hall_id')
                    ->label(__('User'))
                    ->options(User::all()
                        ->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('pax')->required()->numeric()->label(__('pax'))
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 0)->count();
    }

    public static function getNavigationGroup(): ?string
    {
        return __('halls');
    }
}
