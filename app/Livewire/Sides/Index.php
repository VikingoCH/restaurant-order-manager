<?php

namespace App\Livewire\Sides;

use App\Models\MenuSide;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use Toast;

    #[Validate('required|string|max:150')]
    public $name;

    public $id;

    public $showForm = false;

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

    public function edit(MenuSide $menuSides)
    {
        $this->reset();
        $this->fill($menuSides);
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
            $menuSides = MenuSide::find($this->id);
            $menuSides->update($this->validate());
            $this->reset();
        }
        else
        {
            MenuSide::create($this->validate());
            $this->reset();
        }
        $this->success(__('Menu Side Dishs saved successfully'));
    }

    public function destroy(MenuSide $menuSide): void
    {
        $menuSide->delete();

        $this->success(__('Menu side dish deleted successfully'));
    }

    public function render()
    {

        return view('livewire.sides.index', [
            'menuSides' => MenuSide::all(),
            'headers' => $this->headers(),
        ]);
    }
}
