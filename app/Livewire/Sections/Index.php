<?php

namespace App\Livewire\Sections;

use App\Models\MenuSection;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{

    use Toast;

    #[Validate('required|string|max:150')]
    public $name;

    #[Validate('integer')]
    public $position;

    public $id;

    public $showForm = false;


    public function headers(): array
    {
        return [
            ['key' => 'orderIcon', 'label' => '', 'class' => 'w-1'],
            ['key' => 'position', 'label' => '#', 'class' => 'w-1 hidden lg:table-cell'],
            ['key' => 'name', 'label' => __('labels.title')],
        ];
    }

    public function edit(MenuSection $menuSection)
    {
        $this->reset();
        $this->fill($menuSection);
        $this->showForm = true;
    }

    public function create()
    {
        $this->reset();
        $this->showForm = true;
    }

    public function save()
    {
        if ($this->id)
        {
            $menuSection = MenuSection::find($this->id);
            $menuSection->update($this->validate());
            $this->reset();
        }
        else
        {
            MenuSection::create($this->validate());
            $this->reset();
        }
        $this->success(__('Menu Section saved successfully'));
    }

    public function destroy(MenuSection $menuSection): void
    {
        $menuSection->delete();

        $this->success(__('Menu section deleted successfully'));
    }

    public function changeRowOrder($items)
    {
        foreach ($items as $item)
        {
            MenuSection::find($item['value'])->update(['position' => $item['order']]);
        }
        $this->success(__('Menu Sections reordered successfully'));
    }

    public function render()
    {
        return view('livewire.sections.index', [
            'menuSections' => MenuSection::orderBy('position', 'asc')->get(),
            'headers' => $this->headers(),
        ]);
    }
}
