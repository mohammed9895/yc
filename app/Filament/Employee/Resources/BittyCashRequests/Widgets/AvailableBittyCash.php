<?php

namespace App\Filament\Employee\Resources\BittyCashRequests\Widgets;

use App\BittyCashStatus;
use App\Filament\Employee\Resources\BittyCashRequests\Pages\ListBittyCashRequests;
use App\Models\BittyCash;
use App\Models\BittyCashRequest;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AvailableBittyCash extends BaseWidget
{

    protected ?string $pollingInterval = '5s';

    protected function getTablePage(): string
    {
        return ListBittyCashRequests::class;
    }

    protected function getStats(): array
    {
        // get available bitty cash from BittyCash model and decries the amount of Bitty cash requests that are approved


        $bittyCash = BittyCash::where('status', 1)->sum('amount');
        // bitty cash request which are approved
        $bittyCashRequest = BittyCashRequest::where('status', BittyCashStatus::Dismissed)->sum('amount');
        $bittyCashRequestAttached = BittyCashRequest::where('status', BittyCashStatus::Attached)->sum('amount');

        // available bitty cash
        $availableBittyCash = $bittyCash - $bittyCashRequest;

        return [
            Stat::make('Available Bitty Cash', $availableBittyCash . ' OMR'),
            Stat::make('Total Dismissed Bitty Cash', $bittyCashRequest . ' OMR'),
            Stat::make('Total Attached Bitty Cash', $bittyCashRequestAttached),
        ];
    }
}
