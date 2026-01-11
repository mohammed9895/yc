<?php

namespace App\Filament\Employee\Resources\WorkFromHomeRequests\Pages;

use App\Filament\Employee\Resources\WorkFromHomeRequests\WorkFromHomeRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateWorkFromHomeRequest extends CreateRecord
{
    protected static string $resource = WorkFromHomeRequestResource::class;
}
