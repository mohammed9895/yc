<?php

namespace App\Filament\Admin\Widgets\User;

use App\Models\Booking;
use App\Models\Hall;
use App\Models\Workshop;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class WorkshopsCard extends BaseWidget
{
    protected function getCards(): array
    {
        return [
            Card::make(__('workshops'), Workshop::where('status', 1)->count())
                ->extraAttributes(['wire:click' => 'redirectToWorkshops', 'class' => 'cursor-pointer']),
           Card::make(__('halls'), Hall::where('status', 1)->count())
                ->extraAttributes(['wire:click' => 'redirectToHalls', 'class' => 'cursor-pointer']),
            Card::make(__('workshop_bookings'), Booking::where('user_id', auth()->user()->id)
                        ->count())
                        ->extraAttributes(['wire:click' => 'redirectToBookings', 'class' => 'cursor-pointer']),
        ];
    }

    public function redirectToWorkshops()
    {
        return redirect()->to('/cp/available-workshops');
    }

    public function redirectToHalls()
    {
        return redirect()->to('/cp/book-hall');
    }
    public function redirectToBookings()
    {
        return redirect()->to('/cp/workshop-bookings');
    }
}
