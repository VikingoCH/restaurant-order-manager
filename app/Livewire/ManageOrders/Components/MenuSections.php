<?php

namespace App\Livewire\ManageOrders\Components;

use App\Models\MenuSection;
use Livewire\Component;
use Mary\Traits\Toast;

class MenuSections extends Component
{
    use Toast;
    public $orderId;

    public function openSection($sectionId)
    {
        $this->success('Open Section' . $sectionId);
    }

    public function render()
    {
        return view('livewire.manage-orders.components.menu-sections', [
            'sections' => MenuSection::orderBy('position', 'asc')->get()
        ]);
    }
}
