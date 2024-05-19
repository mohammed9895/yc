<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class CheckoutForm extends Form
{
    #[Validate('required|date_format:Y-m-d')]
    public ?string $date = null;

    public ?array $slots = [];

    #[Validate('required|date_format:H:i')]
    public ?string $time = null;

    #[Validate('required|string')]
    public ?string $title = null;


    #[Validate('required|string')]
    public ?string $reasone = null;

    #[Validate('required|integer')]
    public ?int $pax = null;
}
