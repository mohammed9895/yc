<?php

namespace App;

use Filament\Support\Contracts\HasLabel;

enum WorkFromHomeStatus: int implements HasLabel
{
    case Waiting = 0;
    case AcceptedByDirectManger = 1;
    case AcceptedByCEO = 2;
    case RejectedByDirectManger = 3;
    case RejectedByCEO = 4;

    public function getLabel(): ?string
    {

        return match ($this) {
            self::Waiting => 'Waiting',
            self::AcceptedByDirectManger => 'Accepted By Direct Manger',
            self::AcceptedByCEO => 'Accepted By CEO',
            self::RejectedByDirectManger => 'Rejected By Direct Manger',
            self::RejectedByCEO => 'Rejected By CEO',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Waiting => 'warning',
            self::AcceptedByDirectManger, self::AcceptedByCEO => 'success',
            self::RejectedByDirectManger, self::RejectedByCEO => 'danger',
        };
    }
}
