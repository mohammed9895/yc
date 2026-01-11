<?php

namespace App\Filament\Admin\Resources\ThreeDs;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Actions\EditAction;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\DeleteBulkAction;
use App\Filament\Admin\Resources\ThreeDs\Pages\ListThreeDS;
use App\Filament\Admin\Resources\ThreeDs\Pages\CreateThreeD;
use App\Filament\Admin\Resources\ThreeDs\Pages\EditThreeD;
use App\Filament\Admin\Resources\ThreeDResource\Pages;
use App\Filament\Admin\Resources\ThreeDResource\RelationManagers;
use App\Models\ThreeD;
use App\Models\User;
use App\Notifications\OmantelSMSNotification;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class ThreeDResource extends Resource
{
    protected static ?string $model = ThreeD::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public static function getModelLabel(): string
    {
        return   __('3d booking');
    }

    public static function getPluralModelLabel(): string
    {
        return   __('3d booking');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label(__('User'))
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                Textarea::make('file_description')
                    ->label(__('File Description'))
                    ->required(),
                TimePicker::make('duration')->label(__('duration'))->required(),
                TextInput::make('weight')->label(__('weight'))->required(),
                TextInput::make('purpose')->label(__('purpose'))->required(),
                Select::make('status')
                    ->options([
                        0 => __('Waiting'),
                        1 => __('Rejected'),
                        2 => __('Approvied')
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label(__('User')),
                TextColumn::make('file_description')->label(__('File Description')),
                TextColumn::make('duration')->label(__('duration')),
                TextColumn::make('weight')->label(__('weight')),
                TextColumn::make('purpose')->label(__('purpose')),
                BadgeColumn::make('status')->label(__('status'))->formatStateUsing(fn ($state) => match ($state) {
                    0 => __('Waiting'),
                    1 => __('Rejected'),
                    2 => __('Approvied'),
                    3 => __('canceled')
                }),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                Action::make('approve')
                    ->label(__('approve'))
                    ->action('approve')
                    ->action(function (ThreeD $record) {
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('تم قبول حجزك لمختبر طباعة ثلاثية الأبعاد')
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Your reservation for a 3D printing lab has been accepted')
                                ->lang($user->preferred_language)
                                ->send();
                        }

                        ThreeD::where('id', $record->id)->update(['status' => 2]);
                    })
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->hidden(fn (ThreeD $record) => $record->status === 2)
                    ->requiresConfirmation(),
                Action::make('reject')
                    ->label(__('reject'))
                    ->action('reject')
                    ->action(function (ThreeD $record, array $data) {
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('تم رفض حجزك لمختبر طباعة ثلاثية الأبعاد')
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Your reservation for a 3D printing lab has been rejected')
                                ->lang($user->preferred_language)
                                ->send();
                        }
                        ThreeD::where('id', $record->id)->update(['status' => 1]);
                    })
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->hidden(fn (ThreeD $record) => $record->status === 1),

                Action::make('cancel')
                    ->label(__('cancel'))
                    ->action('cancel')
                    ->action(function (ThreeD $record, array $data) {
                        $user = User::where('id', $record->user_id)->first();

                        $sms = new SmsMessage;

                        if ($user->preferred_language == 'ar') {
                            $sms->to($user->phone)
                                ->message('تم الغاء حجزك لمختبر طباعة ثلاثية الأبعاد')
                                ->lang($user->preferred_language)
                                ->send();
                        } else {
                            $sms->to($user->phone)
                                ->message('Your reservation for a 3D printing lab has been canceled')
                                ->lang($user->preferred_language)
                                ->send();
                        }
                        ThreeD::where('id', $record->id)->update(['status' => 3]);
                    })
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->hidden(fn (ThreeD $record) => $record->status === 3),
            ])
            ->toolbarActions([
                BulkAction::make('approve')
                    ->label(__('approve'))
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();

                            $sms = new SmsMessage;

                            if ($user->preferred_language == 'ar') {
                                $sms->to($user->phone)
                                    ->message('تم قبول حجزك لمختبر طباعة ثلاثية الأبعاد')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('Your reservation for a 3D printing lab has been accepted')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }

                            ThreeD::where('id', $record->id)->update(['status' => 2]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation(),
                BulkAction::make('reject')
                    ->label(__('reject'))
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();

                            $sms = new SmsMessage;

                            if ($user->preferred_language == 'ar') {
                                $sms->to($user->phone)
                                    ->message('تم رفض حجزك لمختبر طباعة ثلاثية الأبعاد')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('Your reservation for a 3D printing lab has been rejected')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                            ThreeD::where('id', $record->id)->update(['status' => 1]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-x-circle')
                    ->color('warning')
                    ->requiresConfirmation(),
                BulkAction::make('cancel')
                    ->label(__('cancel'))
                    ->action(function (Collection $records) {
                        foreach ($records as $record) {
                            $user = User::where('id', $record->user_id)->first();

                            $sms = new SmsMessage;

                            if ($user->preferred_language == 'ar') {
                                $sms->to($user->phone)
                                    ->message('تم الغاء حجزك لمختبر طباعة ثلاثية الأبعاد')
                                    ->lang($user->preferred_language)
                                    ->send();
                            } else {
                                $sms->to($user->phone)
                                    ->message('Your reservation for a 3D printing lab has been canceled')
                                    ->lang($user->preferred_language)
                                    ->send();
                            }
                            ThreeD::where('id', $record->id)->update(['status' => 3]);
                        }
                    })
                    ->deselectRecordsAfterCompletion()
                    ->icon('heroicon-o-trash')
                    ->color('danger')
                    ->requiresConfirmation(),
                DeleteBulkAction::make(),
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
            'index' => ListThreeDS::route('/'),
            'create' => CreateThreeD::route('/create'),
            'edit' => EditThreeD::route('/{record}/edit'),
        ];
    }
}
