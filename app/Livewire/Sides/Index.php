<?php

namespace App\Livewire\Sides;

use App\Models\MenuSide;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => 'id', 'class' => 'w-1 hidden lg:table-cell'],
            ['key' => 'name', 'label' => __('labels.title')],
        ];
    }

    public function menuSides(): mixed
    {
        return MenuSide::all();
    }

    public function delete(MenuSide $menuSide): void
    {
        $menuSide->delete();

        $this->success(__('Menu side deleted successfully'));
    }

    public function render()
    {

        return view('livewire.sides.index', [
            'menuSides' => $this->menuSides(),
            'headers' => $this->headers(),
        ]);
    }
}
