<?php

namespace App\Filament\Employee\Resources\Incomes\Pages;

use App\Filament\Employee\Resources\Incomes\IncomeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateIncome extends CreateRecord
{
    protected static string $resource = IncomeResource::class;
}
