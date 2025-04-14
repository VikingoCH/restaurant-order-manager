<?php

namespace App\Livewire\Sections;

use App\Models\MenuSection;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Validate;

class Edit extends Component
{
    use Toast;

    public MenuSection $menuSection;

    #[Validate('required|string|max:150')]
    public $name;

    #[Validate('integer')]
    public $position;

    public function mount(): void
    {
        $this->fill($this->menuSection);
    }

    public function save()
    {
        $validated = $this->validate();
        $this->menuSection->update($validated);
        $this->success(__('Menu Section updated successfully'), redirectTo: route('sections.index'));
    }

    public function render()
    {
        return view('livewire.sections.edit');
    }
}
