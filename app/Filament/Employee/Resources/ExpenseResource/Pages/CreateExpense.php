<?php

namespace App\Filament\Employee\Resources\ExpenseResource\Pages;

use App\Filament\Employee\Resources\ExpenseResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateExpense extends CreateRecord
{
    protected static string $resource = ExpenseResource::class;
}
