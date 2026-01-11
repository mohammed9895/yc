<?php

namespace App\Filament\Employee\Resources\Incomes\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Employee\Resources\Incomes\IncomeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditIncome extends EditRecord
{
    protected static string $resource = IncomeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
