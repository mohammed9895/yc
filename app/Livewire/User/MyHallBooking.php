<?php

namespace App\Livewire\User;

use App\Models\User;
use App\Models\Event;
use Filament\Support\Contracts\TranslatableContentDriver;
use Livewire\Component;
use App\Notifications\SmsMessage;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Illuminate\Contracts\Database\Eloquent\Builder;

class MyHallBooking extends Component implements HasTable
{

}
