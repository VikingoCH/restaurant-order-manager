<?php

namespace App\Livewire\Orders;

use App\Models\MenuItem;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;

class MenuItems extends Component
{

    public $sectionId;
    public $orderId;

    public string $search = '';
    public string $orderNote = '';


    public function mount($sectionId, $orderId)
    {
        $this->sectionId = $sectionId;
        $this->orderId = $orderId;
    }

    public function menuitems()
    {
        return MenuItem::query()
            ->with(['menuFixedSides', 'menuSelectableSides'])
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->where('menu_section_id', $this->sectionId)
            ->orderBy('position', 'asc')->get();
    }

    public function add($id, $orderId)
    {
        $this->reset();
        $this->dispatch('add-item', menuItemId: $id);
    }

    public function render()
    {
        return view('livewire.orders.menu-items', [
            'menuItems' => $this->menuItems(),
        ]);
    }
}
