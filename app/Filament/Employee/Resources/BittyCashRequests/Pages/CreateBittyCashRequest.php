<?php

namespace App\Filament\Employee\Resources\BittyCashRequests\Pages;

use App\Filament\Employee\Resources\BittyCashRequests\BittyCashRequestResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBittyCashRequest extends CreateRecord
{
    protected static string $resource = BittyCashRequestResource::class;
}
