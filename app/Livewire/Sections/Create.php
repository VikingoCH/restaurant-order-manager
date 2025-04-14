<?php

namespace App\Livewire\Sections;

use App\Models\MenuSection;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast;

    #[Validate('required|string|max:150')]
    public $name;

    #[Validate('required|string|max:50|unique:menu_sections,slug')]
    public $slug;

    #[Validate('integer')]
    public $position;

    public function save(): void
    {
        $validated = $this->validate();
        MenuSection::create($validated);
        $this->success(__('Menu Section created successfully'), redirectTo: route('sections.index'));
    }

    public function render()
    {
        return view('livewire.sections.create');
    }
}
