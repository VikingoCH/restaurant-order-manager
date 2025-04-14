<?php

namespace App\Livewire\Menu;

use App\Models\MenuItem;
use App\Models\MenuSection;
use Livewire\Attributes\Url;
use Livewire\Component;
use Mary\Traits\Toast;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Title;

class Index extends Component
{
    use Toast;

    public $activeTab;

    #[Url]
    public string $search = '';

    // public function mount()
    // {
    //     $this->activeTab = MenuSection::first()->id ?? null;
    // }

    // Reset table pagination only if these properties has changed
    // public function updated($property)
    // {
    //     if (in_array($property, ['search']))
    //     {
    //         $this->resetPage();
    //     }
    // }

    // public function menuSections(): mixed
    // {
    //     return MenuSection::orderBy('position', 'asc')->get();
    // }

    public function menuSections()
    {
        $sections = MenuSection::with('menuItems')->orderBy('position', 'asc')->get();
        $this->activeTab = $sections->first()->id;
        return $sections;
    }

    // public function menuItems(): mixed
    // {
    //     $item = [];
    //     $sections = MenuSection::with('menuItems')->orderBy('position', 'asc')->get();
    //     // dd($sections->find(1)->menuItems()->orderBy('position', 'asc')->get());
    //     if ($sections->count() != 0)
    //     {
    //         foreach ($sections as $section)
    //         {
    //             $response = MenuItem::query()
    //                 ->with(['menuFixedSides', 'menuSelectableSides'])
    //                 ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
    //                 ->where('menu_section_id', $section->id)
    //                 ->orderBy('position', 'asc')->get();
    //             $item[$section->name] = $response ?? [];
    //         }
    //     }
    //     return $item;
    // }

    public function headers(): array
    {
        return [
            ['key' => 'orderIcon', 'label' => '', 'class' => 'w-1'],
            ['key' => 'position', 'label' => '#', 'class' => 'w-1 hidden lg:table-cell'],
            ['key' => 'image_path', 'label' => __('labels.image'), 'class' => 'w-3'],
            ['key' => 'name', 'label' => __('labels.title')],
            // ['key' => 'sides', 'label' => __('labels.sides')],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF']],
        ];
    }

    public function delete(MenuItem $menuItem): void
    {
        // TODO: To implement sof deletes recovery and destroy methods
        // $fixSides = MenuFixedSide::where('menu_item_id', $menuItem->id)->get();
        // $selectSides = MenuFixedSide::where('menu_item_id', $menuItem->id)->get();
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

        // if ($menuItem->image_path)
        // {
        //     // Delete the old image if it exists
        //     Storage::disk('public')->delete($menuItem->image_path);
        // }

        $menuItem->delete();

        $this->success(__('Menu item deleted successfully'));
    }

    public function changeRowOrder($items)
    {
        foreach ($items as $item)
        {
            MenuItem::find($item['value'])->update(['position' => $item['order']]);
        }
        $this->success(__('Menu Items reordered successfully'));
    }

    #[Title('Menu')]
    public function render()
    {
        return view('livewire.menu.index', [
            'sections' => $this->menuSections(),
            // 'menuItems' => $this->menuItems(),
            'headers' => $this->headers(),
        ]);
    }
}
