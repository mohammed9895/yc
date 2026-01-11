<?php

namespace App\Filament\Admin\Resources\Companies\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Companies\CompanyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCompany extends EditRecord
{
    protected static string $resource = CompanyResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
