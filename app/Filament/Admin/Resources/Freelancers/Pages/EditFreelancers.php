<?php

namespace App\Filament\Admin\Resources\Freelancers\Pages;

use Filament\Actions\DeleteAction;
use App\Filament\Admin\Resources\Freelancers\FreelancersResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreelancers extends EditRecord
{
    protected static string $resource = FreelancersResource::class;

    protected function getActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
