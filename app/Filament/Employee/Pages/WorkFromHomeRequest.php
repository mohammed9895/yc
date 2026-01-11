<?php

namespace App\Filament\Employee\Pages;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use App\Filament\Employee\Widgets\WorkFromHome;
use App\LeaveStatus;
use App\Models\Employee;
use App\Models\Leave;
use App\WorkFromHomeStatus;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class WorkFromHomeRequest extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-home-modern';

    protected string $view = 'filament.employee.pages.work-from-home-request';

    public array $data = [];

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('')
                ->schema([
                    DatePicker::make('from')->minDate(now())->live(onBlur: true)->reactive()->native(false)->required(),
                    DatePicker::make('to')->live()->minDate(fn (Get $get) => $get('from'))->native(false)->required(),
                    RichEditor::make('reason')->required(),
                ])
        ])
            ->statePath('data');
    }

    public function submit()
    {
        $employee  = Employee::where('user_id', auth()->id())->first();

        $totalLeaveDays = \App\Models\WorkFromHomeRequest::where('employee_id', $employee->id)
            ->whereIn('status', [WorkFromHomeStatus::AcceptedByCEO, WorkFromHomeStatus::AcceptedByDirectManger])
            ->get()
            ->sum(function ($leave) {
                return Carbon::parse($leave->from)->diffInDays(Carbon::parse($leave->to)) + 1;
            });

        $leaveBalance = $employee->work_from_home_days - $totalLeaveDays;

        $requestedDays = Carbon::parse($this->data['from'])->diffInDays(Carbon::parse($this->data['to'])) + 1;

        $this->data['employee_id'] = $employee->id;

        if ($requestedDays > $leaveBalance) {
            return Notification::make('error')
                ->title('Error')
                ->body('Sorry, But you don\'t have enough work from home days')
                ->danger()
                ->send();
        }

        $waitingLeave = \App\Models\WorkFromHomeRequest::where('employee_id', $employee->id)->where('status', WorkFromHomeStatus::Waiting)->count();

        if ($waitingLeave > 0) {
            return Notification::make('error')
                ->title('Error')
                ->body('Sorry, But you have pending work from home request')
                ->danger()
                ->send();
        }

        \App\Models\WorkFromHomeRequest::create($this->data);

        $this->reset();

        return Notification::make('success')
            ->title('Success')
            ->body('Grate, your work from home request submitted successfully')
            ->success()
            ->send();

    }

    public function table(Table $table): Table
    {
        $employee  = Employee::where('user_id', auth()->id())->first();

        return $table
            ->query(\App\Models\WorkFromHomeRequest::where('employee_id', $employee->id))
            ->columns([
                TextColumn::make('from')->date(),
                TextColumn::make('to')->date(),
                TextColumn::make('status')->badge(),
            ]);
    }

    protected function getHeaderWidgets(): array
    {
        return [
            WorkFromHome::class
        ];
    }
}
