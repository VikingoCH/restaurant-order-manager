<?php

namespace App\Livewire\Menu;

use App\Models\MenuFixedSide;
use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\MenuSelectableSide;
use App\Models\MenuSide;
use App\Models\Printer;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast, WithFileUploads;

    public $withSides = true;
    public $fixedSides = [];
    public $selectableSides = [];

    #[Validate('integer')]
    public $position;

    #[Validate('required|string|max:150')]
    public $name;

    #[Validate('decimal:0,2|min:1')]
    public $price;

    #[Validate('image|nullable|max:1024')]
    public $image_path;

    #[Validate('required|int')]
    public $menu_section_id;

    #[Validate('required|int')]
    public $printer_id;

    public function save(): void
    {
        $menuItem = MenuItem::create($this->validate());
        if ($this->image_path)
        {
            $url = $this->image_path->store('images', 'public');
            $menuItem->update(['image_path' => $url]);
        }
        if (count($this->fixedSides) > 0)
        {
            foreach ($this->fixedSides as $fixedSide)
            {
                MenuFixedSide::create(
                    [
                        'menu_side_id' => $fixedSide,
                        'menu_item_id' => $menuItem->id,
                    ]
                );
            }
        }
        if (count($this->selectableSides) > 0)
        {
            foreach ($this->selectableSides as $selectableSide)
            {
                MenuSelectableSide::create(
                    [
                        'menu_side_id' => $selectableSide,
                        'menu_item_id' => $menuItem->id,
                    ]
                );
            }
        }

        $this->success(__('Menu item created successfully'), redirectTo: route('menu.index'));
    }

    // public function menuSections()
    // {
    //     return MenuSection::all();
    // }

    public function render()
    {
        return view('livewire.menu.create', [
            'sections' => MenuSection::all(),
            'sides' => MenuSide::all(),
            'printers' => Printer::all(),
        ]);
    }
}
