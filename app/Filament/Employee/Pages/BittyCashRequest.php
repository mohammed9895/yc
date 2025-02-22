<?php

namespace App\Filament\Employee\Pages;

use App\BittyCashStatus;
use App\LeaveStatus;
use App\Models\Employee;
use App\Models\Expense;
use App\Models\Leave;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;

class BittyCashRequest extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static string $view = 'filament.employee.pages.bitty-cash-request';


    public array $data = [];

    public function mount()
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form->schema([
            \Filament\Forms\Components\Section::make('')
                ->schema([
                    TextInput::make('amount')->required()->suffix('OMR'),
                    DatePicker::make('expense_date')->required()->native(false),
                    RichEditor::make('reason')->label('Reason')->required()->columnSpanFull(),
                    FileUpload::make('proof')->multiple()->label('Proof')->required()->columnSpanFull(),
                ])->columns(2)
        ])
            ->statePath('data');
    }

    public function submit()
    {

        $employee  = Employee::where('user_id', auth()->id())->first();

        $this->data['employee_id'] = $employee->id;

        \App\Models\BittyCashRequest::create($this->data);

        $this->reset();

        return Notification::make('success')
            ->title('Success')
            ->body('Grate, your reimbursement request submitted successfully')
            ->success()
            ->send();

    }

    public function table(Table $table): Table
    {
        $employee  = Employee::where('user_id', auth()->id())->first();

        return $table
            ->query(\App\Models\BittyCashRequest::where('employee_id', $employee->id))
            ->columns([
                TextColumn::make('amount')->money('OMR'),
                TextColumn::make('expense_date')->date(),
                TextColumn::make('status')->badge(),
            ]);
    }

}
