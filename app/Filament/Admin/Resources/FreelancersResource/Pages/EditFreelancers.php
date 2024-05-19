<?php

namespace App\Filament\Admin\Resources\FreelancersResource\Pages;

use App\Filament\Admin\Resources\FreelancersResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFreelancers extends EditRecord
{
    protected static string $resource = FreelancersResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
