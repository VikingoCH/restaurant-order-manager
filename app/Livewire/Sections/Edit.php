<?php

namespace App\Livewire\Sections;

use App\Models\MenuSection;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rule;

class Edit extends Component
{
    use Toast;

    public MenuSection $menuSection;

    #[Validate]
    public $name;

    #[Validate]
    public $slug;

    #[Validate]
    public $position;

    public function mount(): void
    {
        $this->fill($this->menuSection);
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'slug' => [Rule::unique('menu_sections')->ignore($this->menuSection->id), 'required', 'string', 'max:50'],
            'position' => 'integer',
        ];
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
