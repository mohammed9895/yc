<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum BittyCashStatus: int implements HasLabel
{
    case Attached = 0;
    case Dismissed = 1;

    public function getLabel(): ?string
    {

        return match ($this) {
            self::Attached => 'Attached',
            self::Dismissed => 'Dismissed',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Attached => 'warning',
            self::Dismissed => 'success',
        };
    }
}
