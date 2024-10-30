<?php

namespace App\Livewire\Frontend\Tmakon;

use App\Models\TmakonCategory;
use App\Models\TmakonUser;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Freelancers extends Component
{
    public $tmakonCtegories;

    public $selectedCategory;

    public function mount()
    {
        $this->tmakonCtegories = TmakonCategory::all();
    }

    public function setCategory($id)
    {
        $this->selectedCategory = $id;
    }

    #[Computed]
    public function tmakonUsers()
    {
        return TmakonUser::where('tmakon_category_id', 1)->get();
    }

    public function render()
    {
        return view('livewire.frontend.tmakon.freelancers');
    }
}
