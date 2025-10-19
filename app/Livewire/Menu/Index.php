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


    public function menuSections()
    {
        $sections = MenuSection::with('menuItems')->orderBy('position', 'asc')->get();
        if (!$sections->isEmpty())
        {
            $this->activeTab = $sections->first()->id;
        }
        return $sections;
    }

    public function headers(): array
    {
        return [
            ['key' => 'orderIcon', 'label' => '', 'class' => 'w-1'],
            ['key' => 'position', 'label' => '#', 'class' => 'w-1 hidden lg:table-cell'],
            ['key' => 'image_path', 'label' => __('labels.image'), 'class' => 'w-3'],
            ['key' => 'name', 'label' => __('labels.title')],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF']],
        ];
    }

    public function delete(MenuItem $menuItem): void
    {

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
            'headers' => $this->headers(),
        ]);
    }
}
