<?php

namespace App\Filament\Cp\Pages;

use App\Models\ThreeD;
use App\Models\User;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;

class ThreeDHallBooking extends Page implements HasForms, HasTable
{
    use InteractsWithForms,  InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.three-d-hall-booking';

    public static function getNavigationGroup(): ?string
    {
        return   __('halls');
    }

    public function getTitle(): string
    {
        return   __('Book 3D Lab');
    }

    public static function getNavigationLabel(): string
    {
        return   __('Book 3D Lab');
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Textarea::make('file_description')
                ->label(__('File Description'))
                ->required(),
            TimePicker::make('duration')->label(__('duration'))->required(),
            TextInput::make('weight')->label(__('weight'))->required(),
            TextInput::make('purpose')->label(__('purpose'))->required(),
            Checkbox::make('protocols')->label(__('Accept Priniting Protocols'))->inline()->dehydrated(false)->required(),
        ];
    }

    protected function getTableQuery(): Builder
    {
        return ThreeD::query()->where('user_id', auth()->id());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.name')->label(__('User')),
            TextColumn::make('file_description')->label(__('File Description')),
            TextColumn::make('duration')->label(__('duration')),
            TextColumn::make('weight')->label(__('weight')),
            TextColumn::make('purpose')->label(__('purpose')),
            BadgeColumn::make('status')->label(__('status'))->badge()->formatStateUsing(fn ($state) => match ($state) {
                0 => __('Waiting'),
                1 => __('Rejected'),
                2 => __('Approvied'),
                3 => __('canceled')
            }),
        ];
    }

    protected function getTableActions(): array
    {
        return [
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
        ];
    }

    public function book()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();
        $booking = ThreeD::create($orginal);
        return Notification::make()
            ->title(__('Booked Successfuly'))
            ->success()
            ->send();
    }
}
