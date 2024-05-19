<?php

namespace App\Filament\Cp\Pages;

use App\Exports\WorkshopsExport;
use App\Models\Province;
use App\Models\State;
use BezhanSalleh\FilamentShield\Traits\HasPageShield;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Maatwebsite\Excel\Facades\Excel;

class Report extends Page implements HasForms, HasTable
{
    use InteractsWithForms, InteractsWithTable, HasPageShield;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.report';

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function mount(): void
    {
        $this->form->fill();
    }

    public function print()
    {
        $data = $this->form->getState();
        return Excel::download(new WorkshopsExport($data['state_id'], $data['start_date'], $data['end_date']),
            'report.xlsx');
    }

    protected function getFormSchema(): array
    {
        return [
            \Filament\Forms\Components\Select::make('province_id')
                ->label(__('province'))
                ->required()
                ->options(Province::all()->pluck('name', 'id'))
                ->searchable()
                ->reactive()
                ->afterStateUpdated(fn(callable $set) => $set('state_id', null))->columnSpan(1),
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
                ->searchable()
                ->multiple()
                ->columnSpan(1),
            DatePicker::make('start_date'),
            DatePicker::make('end_date'),
        ];
    }
}
