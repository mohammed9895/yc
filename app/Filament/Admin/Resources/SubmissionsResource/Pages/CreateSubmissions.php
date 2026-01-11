<?php

namespace App\Filament\Admin\Resources\SubmissionsResource\Pages;

use App\Filament\Admin\Resources\Submissions\SubmissionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateSubmissions extends CreateRecord
{
    protected static string $resource = SubmissionResource::class;
}
