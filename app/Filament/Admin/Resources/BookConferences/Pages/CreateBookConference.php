<?php

namespace App\Filament\Admin\Resources\BookConferences\Pages;

use App\Filament\Admin\Resources\BookConferences\BookConferenceResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBookConference extends CreateRecord
{
    protected static string $resource = BookConferenceResource::class;
}
