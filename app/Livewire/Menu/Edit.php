<?php

namespace App\Livewire\Menu;

use App\Models\MenuFixedSide;
use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\MenuSelectableSide;
use App\Models\MenuSide;
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


    public $fixedSides = [];
    public $selectableSides = [];

    #[Validate]
    public $name;

    // [Validate('required|string|max:50|unique:menu_items,slug')]
    #[Validate]
    public $slug;

    #[Validate]
    public $price;

    #[Validate]
    public $position;

    #[Validate]
    public $newImagePath;


    public $image_path;

    #[Validate]
    public $menu_section_id;


    public function mount(): void
    {
        $this->fill($this->menuItem);
        $this->fixedSides = MenuFixedSide::where('menu_item_id', $this->menuItem->id)->get('menu_side_id')
            ->pluck('menu_side_id')->toArray();

        $this->selectableSides = MenuSelectableSide::where('menu_item_id', $this->menuItem->id)->get('menu_side_id')->pluck('menu_side_id')->toArray();
    }

    protected function rules()
    {
        return [
            'name' => 'required|string|max:150',
            'slug' => [Rule::unique('menu_items')->ignore($this->menuItem->id), 'required', 'string', 'max:50'],
            'price' => 'required|decimal:0,2|min:1',
            'position' => 'integer',
            'newImagePath' => 'image|nullable|max:1024',
            'menu_section_id' => 'required|int',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $this->menuItem->update(
            [
                'name' => $validated['name'],
                'slug' => $validated['slug'],
                'price' => $validated['price'],
                'position' => $validated['position'],
                'menu_section_id' => $validated['menu_section_id'],
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
        $fixSides = MenuFixedSide::where('menu_item_id', $this->menuItem->id)->get();
        $selectSides = MenuSelectableSide::where('menu_item_id', $this->menuItem->id)->get();
        if ($fixSides->count() > 0)
        {
            foreach ($fixSides as $side)
            {
                $side->delete();
            }
        }
        if ($selectSides->count() > 0)
        {
            foreach ($selectSides as $side)
            {
                $side->delete();
            }
        }

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
        ]);
    }
}
