<?php

namespace App\Filament\Cp\Pages;

use App\Models\Event;
use App\Models\User;
use App\Notifications\SmsMessage;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Pages\Page;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MyHallBooking extends Page implements HasTable
{
//    use HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.my-hall-booking';

    public static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public function getTitle(): string
    {
        return   __('my-hall-booking');
    }

    public static function getNavigationLabel(): string
    {
        return   __('my-hall-booking');
    }

    use InteractsWithTable;

    protected function getTableQuery(): Builder
    {
        return Event::query()->where('user_id', '=', Auth::id());
    }
    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('title')->label(__('Title')),
            TextColumn::make('hall.name')->weight('bold')->label(__('hall')),
            BadgeColumn::make('status')->label(__('status'))
                ->badge()
                ->formatStateUsing(fn ($state) => match ($state) {
                    0 => __('Waiting'),
                    2 => __('Rejected'),
                    1 => __('Approvied'),
                    3 => __('canceled'),
                })
                ->colors([
                    'warning' => static fn ($state): bool => $state === 0,
                    'success' => static fn ($state): bool => $state === 1,
                    'danger' => static fn ($state): bool => $state === 2,
                    'danger' => static fn ($state): bool => $state === 3,
                ]),
            TextColumn::make('start')->label(__('start_date'))
                ->dateTime('M d, Y h:i'),
            TextColumn::make('end')->label(__('end_date'))
                ->dateTime('M d, Y h:i'),
        ];
    }

    protected function getTableFilters(): array
    {
        return [];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('cancel')
                ->label(__('cancel'))
                ->action('cancel')
                ->action(function (Event $record, array $data) {
                    $user = User::where('id', $record->user_id)->first();

                    $sms = new SmsMessage;

                    if ($user->preferred_language == 'ar') {
                        $sms->to($user->phone)
                            ->message('تم الغاء حجزك '.$record->hall->getTranslation('name', 'ar').'')
                            ->lang($user->preferred_language)
                            ->send();
                    } else {
                        $sms->to($user->phone)
                            ->message('Your reservation for a '.$record->hall->getTranslation('name', 'en').' has been canceled')
                            ->lang($user->preferred_language)
                            ->send();
                    }
                    Event::where('id', $record->id)->update(['status' => 3]);
                })
                ->icon('heroicon-o-trash')
                ->color('danger')
                ->hidden(fn (Event $record) => $record->status === 3),
        ];
    }

    protected function getTableBulkActions(): array
    {
        return [];
    }

}
