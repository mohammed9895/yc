<?php

namespace App\Livewire\Auth;

use Livewire\Attributes\Layout;
use Livewire\Component;

class VerifyPhone extends Component
{

    #[Layout('layouts.auth')]
    public function render()
    {
        return view('livewire.auth.verify-phone');
    }
}
