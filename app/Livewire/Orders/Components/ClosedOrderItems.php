<?php

namespace App\Livewire\Orders\Components;

use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class ClosedOrderItems extends Component
{
    use Toast;

    public $orderId;

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

    public function destroy(OrderItem $orderItem)
    {
        $this->authorize('manage_orders');

        //remove item price from total price
        $order = Order::find($this->orderId);
        $itemTotal = $orderItem->quantity * $orderItem->price;
        $order->update([
            'total' => $order->total - $itemTotal
        ]);

        $orderItem->delete();

        $this->success(__('Menu item deleted successfully'));
    }

    #[On('OrderItemsPrinted')]
    public function render()
    {
        return view('livewire.orders.components.closed-order-items', [
            'orderItems' => OrderItem::with(['menuItem'])->where('printed', true)->where('order_id', $this->orderId)->get(),
            'headers' => $this->headers(),
        ]);
    }
}
