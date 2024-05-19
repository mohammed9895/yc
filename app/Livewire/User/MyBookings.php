<?php

namespace App\Livewire\User;

use App\Models\Attendees;
use App\Models\Booking;
use App\Models\Evaluate;
use App\Models\Slot;
use App\Models\User;
use App\Models\Workshop;
use App\Notifications\SmsMessage;
use Carbon\Carbon;
use Filament\Notifications\Notification;
use Filament\Support\Contracts\TranslatableContentDriver;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use setasign\Fpdi\Tfpdf\Fpdi;


class MyBookings extends Component
{

}
