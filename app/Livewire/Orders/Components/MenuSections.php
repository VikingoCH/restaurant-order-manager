<?php

namespace App\Livewire\Orders\Components;

use App\Models\MenuSection;
use Livewire\Component;

class MenuSections extends Component
{
    public $orderId;

    public function render()
    {
        return view('livewire.orders.components.menu-sections', [
            'sections' => MenuSection::orderBy('position', 'asc')->get()
        ]);
    }
}
