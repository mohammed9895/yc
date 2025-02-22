<?php

namespace App\Filament\Employee\Widgets;

use App\LeaveStatus;
use App\Models\Employee;
use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class Leave extends BaseWidget
{
    protected static ?int $sort = 1000;
    protected function getStats(): array
    {

        $employee  = Employee::where('user_id', auth()->id())->first();

        $totalLeaveDays = \App\Models\Leave::where('employee_id', $employee->id)
            ->whereIn('status', [LeaveStatus::AcceptedByCEO, LeaveStatus::AcceptedByDirectManger])
            ->get()
            ->sum(function ($leave) {
                return Carbon::parse($leave->from)->diffInDays(Carbon::parse($leave->to)) + 1;
            });

        $leaveBalance = $employee->number_of_yearly_leave - $totalLeaveDays;


        return [
            Stat::make('Days per Year', $employee->number_of_yearly_leave . ' Days'),
            Stat::make('Leave Days Remaining', $leaveBalance . ' Days'),
            Stat::make('Leave Days', $totalLeaveDays . ' Days'),        ];
    }
}
