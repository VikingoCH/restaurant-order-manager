<?php

namespace App\Livewire\Menu;

use App\Models\MenuFixedSide;
use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\MenuSelectableSide;
use App\Models\MenuSide;
use App\Models\Printer;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\WithFileUploads;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast, WithFileUploads;

    public MenuItem $menuItem;
    public $withSides = false;

    public $fixedSides = [];
    public $selectableSides = [];

    #[Validate('integer')]
    public $position;

    #[Validate('required|string|max:150')]
    public $name;

    #[Validate('decimal:0,2|min:1')]
    public $price;

    #[Validate('image|nullable|max:1024')]
    public $newImagePath;

    #[Validate('required|int')]
    public $menu_section_id;

    #[Validate('required|int')]
    public $printer_id;

    public $image_path;

    public function mount(): void
    {
        $this->fill($this->menuItem);
        $this->fixedSides = MenuFixedSide::where('menu_item_id', $this->menuItem->id)->get('menu_side_id')
            ->pluck('menu_side_id')->toArray();

        $this->selectableSides = MenuSelectableSide::where('menu_item_id', $this->menuItem->id)->get('menu_side_id')->pluck('menu_side_id')->toArray();
        if (count($this->fixedSides) != 0 || count($this->selectableSides) != 0)
        {
            $this->withSides = true;
        }
    }

    // protected function rules()
    // {
    //     return [
    //         'name' => 'required|string|max:150',
    //         'price' => 'required|decimal:0,2|min:1',
    //         'position' => 'integer',
    //         'newImagePath' => 'image|nullable|max:1024',
    //         'menu_section_id' => 'required|int',
    //     ];
    // }

    public function save(): void
    {
        $validated = $this->validate();
        $this->menuItem->update(
            [
                'name' => $validated['name'],
                'price' => $validated['price'],
                'position' => $validated['position'],
                'menu_section_id' => $validated['menu_section_id'],
                'printer_id' => $validated['printer_id'],
            ]
        );

        // Update the image if a new one is uploaded
        if ($this->newImagePath)
        {
            if ($this->menuItem->image_path)
            {
                // Delete the old image if it exists
                Storage::disk('public')->delete($this->menuItem->image_path);
            }

            $url = $this->newImagePath->store('images', 'public');
            $this->menuItem->update(['image_path' => $url]);
        }

        // Update menu side dishes
        //TODO: Side dishes update to be improved. No to delete and save each time
        $fixSides = MenuFixedSide::where('menu_item_id', $this->menuItem->id)->get();
        $selectSides = MenuSelectableSide::where('menu_item_id', $this->menuItem->id)->get();
        // dd('fixDB', Arr::flatten($fixSides), 'fixPage', $this->fixedSides, 'SelecDB', $selectSides, 'SelecPage', $this->selectableSides);
        // Check for existing side dishes in DB and remove them
        // if ($fixSides->count() > 0)
        // {
        //     foreach ($fixSides as $side)
        //     {
        //         $side->delete();
        //     }
        // }
        // if ($selectSides->count() > 0)
        // {
        //     foreach ($selectSides as $side)
        //     {
        //         $side->delete();
        //     }
        // }

        if (count($this->fixedSides) > 0)
        {
            foreach ($this->fixedSides as $fixedSide)
            {
                MenuFixedSide::updateOrInsert(
                    [
                        'menu_side_id' => $fixedSide,
                        'menu_item_id' => $this->menuItem->id,
                    ]
                );
            }
        }
        if (count($this->selectableSides) > 0)
        {
            foreach ($this->selectableSides as $selectableSide)
            {
                MenuSelectableSide::updateOrInsert(
                    [
                        'menu_side_id' => $selectableSide,
                        'menu_item_id' => $this->menuItem->id,
                    ]
                );
            }
        }

        $this->success(__('Menu item updated successfully'), redirectTo: route('menu.index'));
    }

    public function render()
    {
        return view('livewire.menu.edit', [
            'sections' => MenuSection::all(),
            'sides' => MenuSide::all(),
            'printers' => Printer::all(),
        ]);
    }
}
