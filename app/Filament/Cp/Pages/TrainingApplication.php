<?php

namespace App\Filament\Cp\Pages;

use App\Models\EducationType;
use App\Models\EmployeeType;
use App\Models\Province;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;

class TrainingApplication extends Page implements HasForms, HasTable
{
    use InteractsWithForms,  InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.training-application';

    public $registred = 0;

    public $open = false;

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string
    {
        return   __('Training Application');
    }

    public static function getNavigationLabel(): string
    {
        return   __('Training Application');
    }

    public function mount(): void
    {
        $this->registred = \App\Models\TrainingApplication::where('user_id', auth()->id())->count();
        $this->form->fill();
    }

    protected function getFormSchema(): array
    {
        return [
            Select::make('province_id')->label(__('province'))->options(Province::all()->pluck('name', 'id'))->searchable()->required(),
            Select::make('education_type_id')->label(__('filament::users.degree'))->options(EducationType::all()->pluck('name', 'id'))->searchable()->required(),
            Select::make('employee_type_id')->label(__('filament::users.work'))->options(EmployeeType::all()->pluck('name', 'id'))->searchable()->required(),
            FileUpload::make('cv')->label(__('CV'))->required()->acceptedFileTypes(['application/pdf']),
        ];
    }

    public function register()
    {
        $orginal = $this->form->getState();
        $orginal['user_id'] = auth()->id();
        $booking = \App\Models\TrainingApplication::create($orginal);
        return Notification::make()
            ->title(__('Registered Successfully'))
            ->success()
            ->send();
    }

}
