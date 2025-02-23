<?php

namespace App\Filament\Employee\Widgets;

use App\LeaveStatus;
use App\Models\Employee;
use App\WorkFromHomeStatus;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class WorkFromHome extends BaseWidget
{
    use HasWidgetShield;
    protected function getStats(): array
    {

        $employee  = Employee::where('user_id', auth()->id())->first();

        $totalLeaveDays = \App\Models\WorkFromHomeRequest::where('employee_id', $employee->id)
            ->whereIn('status', [WorkFromHomeStatus::AcceptedByCEO, WorkFromHomeStatus::AcceptedByDirectManger])
            ->get()
            ->sum(function ($leave) {
                return Carbon::parse($leave->from)->diffInDays(Carbon::parse($leave->to)) + 1;
            });

        $leaveBalance = $employee->work_from_home_days - $totalLeaveDays;


        return [
            Stat::make('Days per Year', $employee->work_from_home_days . ' Days'),
            Stat::make('Work from Home Days Remaining', $leaveBalance . ' Days'),
            Stat::make('Work from Home Days you took', $totalLeaveDays . ' Days'),        ];
    }
}
