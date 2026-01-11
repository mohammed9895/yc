<?php

namespace App\Filament\Admin\Resources\Companies\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Companies\CompanyResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCompanies extends ListRecords
{
    protected static string $resource = CompanyResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
