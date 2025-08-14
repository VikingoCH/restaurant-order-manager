<?php

namespace App\Livewire\ManageOrders;

use App\Models\MenuSection;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Component;
use Mary\Traits\Toast;
use App\Traits\PrintReceipts;

class Edit extends Component
{
    use Toast, PrintReceipts;

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

    public function print()
    {
        $this->authorize('manage_orders');
        $invoiceItems = OrderItem::with(['menuItem'])->where('order_id', $this->orderId)->get();
        $openItems = $invoiceItems->where('printed', false);
        if (!$openItems->isEmpty())
        {
            foreach ($openItems as $openItem)
            {
                $openItem->update([
                    'printed' => true,
                ]);
            }
        }
        $this->printInvoice($this->orderId, $invoiceItems);
        $this->success(__('Items printed successfully'));
    }


    public function render()
    {
        return view('livewire.manage-orders.edit', [
            'sections' => MenuSection::orderBy('position', 'asc')->get(),
            'order' => $this->order(),
        ]);
    }
}
