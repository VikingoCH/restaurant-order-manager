<?php

namespace App\Livewire\ManageOrders;

use App\Models\MenuSection;
use App\Models\Order;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\On;

class Edit extends Component
{
    use Toast;

    public $orderId;
    // public $showMenuItems = false;
    public array $selectedRows;

    // #[On('show-menu-items')]
    // public function showMenuItems($sectionId)
    // {
    //     $this->showMenuItems = true;
    //     $this->dispatch('list-menu-items', $sectionId);
    // }


    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => 'id', 'class' => 'w-1'],
            ['key' => 'items', 'label' => __('labels.items')],
            ['key' => 'quantity', 'label' => __('labels.quantity'), 'class' => 'text-center'],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
        ];
    }

    // #[On('refreshOrder')]
    public function order()
    {
        return Order::with('place')->find($this->orderId);
    }


    public function render()
    {
        return view('livewire.manage-orders.edit', [
            'sections' => MenuSection::orderBy('position', 'asc')->get(),
            'order' => $this->order(),
        ]);
    }
}
