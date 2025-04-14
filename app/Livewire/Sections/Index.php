<?php

namespace App\Livewire\Sections;

use App\Models\MenuSection;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{

    use Toast;

    public function headers(): array
    {
        return [
            ['key' => 'orderIcon', 'label' => '', 'class' => 'w-1'],
            ['key' => 'position', 'label' => '#', 'class' => 'w-1 hidden lg:table-cell'],
            ['key' => 'name', 'label' => __('labels.title')],
        ];
    }

    public function menuSections(): mixed
    {
        return MenuSection::orderBy('position', 'asc')->get();
    }

    public function delete(MenuSection $menuSection): void
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
            'menuSections' => $this->menuSections(),
            'headers' => $this->headers(),
        ]);
    }
}
