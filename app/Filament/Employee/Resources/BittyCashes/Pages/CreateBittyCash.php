<?php

namespace App\Filament\Employee\Resources\BittyCashes\Pages;

use App\Filament\Employee\Resources\BittyCashes\BittyCashResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBittyCash extends CreateRecord
{
    protected static string $resource = BittyCashResource::class;
}
