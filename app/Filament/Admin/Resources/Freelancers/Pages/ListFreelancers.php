<?php

namespace App\Filament\Admin\Resources\Freelancers\Pages;

use Filament\Actions\CreateAction;
use App\Filament\Admin\Resources\Freelancers\FreelancersResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFreelancers extends ListRecords
{
    protected static string $resource = FreelancersResource::class;

    protected function getActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
