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
        $a = str_pad('Picanha Grande com Arroz', 25, ' ');
        $b = str_pad('Coca cola', 25, ' ');
        $c = str_pad(2, 3, ' ', STR_PAD_LEFT);
        $d = str_pad(23, 3, ' ', STR_PAD_LEFT);
        $e = str_pad("10.00", 7, ' ', STR_PAD_LEFT);
        $f = str_pad("50.00", 7, ' ', STR_PAD_LEFT);
        $g = str_pad("150.00", 9, ' ', STR_PAD_LEFT);
        $h = str_pad("670.00", 9, ' ', STR_PAD_LEFT);

        // dd($a . $c . $e . $g, $b . $d . $f . $h, strlen($a . $c . $e . $g), strlen($b . $d . $f . $h), strlen('Picanha Grande com Arroz'));

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
