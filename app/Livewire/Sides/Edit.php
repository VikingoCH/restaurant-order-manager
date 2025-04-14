<?php

namespace App\Livewire\Sides;

use App\Models\MenuSide;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public MenuSide $menuSide;

    #[Validate('required|string|max:150')]
    public $name;


    public function mount(): void
    {
        $this->fill($this->menuSide);
    }

    public function save()
    {

        $validated = $this->validate();
        $this->menuSide->update($validated);
        $this->success(__('Side dish updated successfully'), redirectTo: route('sides.index'));
    }


    public function render()
    {

        return view('livewire.sides.edit');
    }
}
