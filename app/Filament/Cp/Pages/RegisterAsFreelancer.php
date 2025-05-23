<?php

namespace App\Filament\Cp\Pages;

use App\Models\Field;
use App\Models\Freelancers;
use App\Notifications\SmsMessage;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Database\Eloquent\Builder;

class RegisterAsFreelancer extends Page implements HasForms, HasTable
{
    use InteractsWithForms,  InteractsWithTable;

    public array $data = [];

    public static function getNavigationGroup(): ?string
    {
        return   __('companies');
    }

    public function getTitle(): string
    {
        return   __('Register as Freelancer');
    }

    public static function getNavigationLabel(): string
    {
        return   __('Register as Freelancer');
    }

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.register-as-freelancer';

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
            FileUpload::make('civil_copy')
                ->label(__('Civil Copy'))
                ->required(),
            Select::make('field_id')
                ->label(__('Field'))
                ->options(Field::where('type', 'freelancer')
                    ->pluck('name', 'id'))
                ->searchable()
                ->reactive()
                ->required(),
            TextInput::make('others')->label('Others')->visible(function (callable $get) {
                if ($get('field_id') == 24) {
                    return true;
                }
            }),
            FileUpload::make('cr_copy')
                ->label(__('cr_copy')),
            FileUpload::make('profile_file')
                ->label(__('Work Files'))
                ->multiple(),
            TextInput::make('profile_link')
                ->label(__('Profile Link')),
        ])->statePath('data');
    }

    protected function getTableQuery(): Builder
    {
        return Freelancers::query()->where('user_id', auth()->id());
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('user.name')->label(__('User')),
            TextColumn::make('field.name')->label(__('Field')),
            TextColumn::make('others')->label(__('Others'))->visible(14 || 24),
            TextColumn::make('profile_link')->label(__('Profile Link')),
            TextColumn::make('created_at')
                ->dateTime(),
            TextColumn::make('updated_at')
                ->dateTime(),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('delete')
                ->label(__('delete'))
                ->action('delete')
                ->action(function (Freelancers $record, array $data) {
                    $record->delete();
                })
                ->icon('heroicon-o-trash')
                ->color('danger')
        ];
    }

    public function register()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();
        if ($orginal['field_id'] == 24) {
            $orginal['others'] = $orginal['others'];
        }

        $booking = Freelancers::create($orginal);

//        auth()->user()->assignRole('company');
        if ($booking) {
            $sms = new SmsMessage;
            if (auth()->user()->preferred_language == 'ar') {
                $sms->to(auth()->user()->phone)
                    ->message('شكراً لك، تم تسجيلك كمستقل في مركز الشباب')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            } else {
                $sms->to(auth()->user()->phone)
                    ->message('Thank you, You have been registered as a freelancer successfuly')
                    ->lang(auth()->user()->preferred_language)
                    ->send();
            }
            return Notification::make()
                ->title(__('Registered Successfuly'))
                ->success()
                ->send();
        }
    }
}
