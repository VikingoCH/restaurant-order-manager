<?php

namespace App\Livewire\Sides;

use App\Models\MenuSide;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    #[Validate('required|string|max:150')]
    public $name;


    public function save(): void
    {
        $validated = $this->validate();
        MenuSide::create($validated);
        $this->success(__('Side dish created successfully'), redirectTo: route('sides.index'));
    }

    public function render()
    {
        return view('livewire.sides.create');
    }
}
