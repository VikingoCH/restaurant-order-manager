<?php

namespace App\Livewire\Orders;

use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\MenuSide;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Printer;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast;

    public $orderId;
    public array $selectedRows;


    public function headers(): array
    {
        return [
            ['key' => 'items', 'label' => __('labels.items')],
            ['key' => 'quantity', 'label' => __('labels.quantity'), 'class' => 'text-center'],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
        ];
    }


    public function increment(OrderItem $orderItem)
    {
        $orderItem->update([
            'quantity' => $orderItem->quantity + 1,
        ]);
        //Update total price of the order
        $order = Order::find($this->orderId);
        $order->update([
            'total' => $order->total + $orderItem->price
        ]);
    }

    public function decrement(OrderItem $orderItem)
    {
        if ($orderItem->quantity - 1 == 0)
        {
            //TODO: Update total price of the order
            //TODO: delete order  Item
        }
        else
        {
            $orderItem->update([
                'quantity' => $orderItem->quantity - 1,
            ]);
            //Update total price of the order
            $order = Order::find($this->orderId);
            $order->update([
                'total' => $order->total - $orderItem->price
            ]);
        }
    }


    public function destroy()
    {
        $this->success(__('Menu item deleted successfully'));
    }
    public function render()
    {
        return view('livewire.orders.edit', [
            'sections' => MenuSection::orderBy('position', 'asc')->get(),
            'openItems' => OrderItem::with(['menuItem'])->where('printed', false)->where('order_id', $this->orderId)->get(),
            'closedItems' => OrderItem::with(['menuItem'])->where('printed', true)->where('order_id', $this->orderId)->get(),
            'headers' => $this->headers(),
            'printers' => Printer::all(),
        ]);
    }
}
