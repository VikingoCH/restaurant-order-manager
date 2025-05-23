<?php

namespace App\Livewire\ManageOrders\Components;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Printer;
use Illuminate\Support\Arr;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;
use phpDocumentor\Reflection\Types\Boolean;

class OpenOrderItems extends Component
{
    use Toast;

    // public $isPrinted = false;
    public $orderId;
    public array $selectedRows;

    // Edit form variables
    public $openEditForm = false;
    public $fixedSides;
    public $selectableSides;
    public $orderNotes = '';
    public $orderItem;
    public $menuItem;

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

    public function increment(OrderItem $orderItem)
    {
        $this->authorize('manage_orders');

        $orderItem->update([
            'quantity' => $orderItem->quantity + 1,
        ]);
        //Update total price of the order
        $order = Order::find($this->orderId);
        $order->update([
            'total' => $order->total + $orderItem->price
        ]);

        $this->success(__('Order item updated successfully'));
    }

    public function decrement(OrderItem $orderItem)
    {
        $this->authorize('manage_orders');

        if ($orderItem->quantity >= 1)
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

        $this->success(__('Order item updated successfully'));
    }

    public function print($printerId)
    {
        $this->authorize('manage_orders');

        $openItems = OrderItem::with(['menuItem'])->where('printed', false)->where('order_id', $this->orderId)->get();
        if (count($this->selectedRows) != 0)
        {
            $openItems = $openItems->only(Arr::flatten($this->selectedRows));
        }

        foreach ($openItems as $openItem)
        {
            $openItem->update([
                'printed' => true,
            ]);
        }

        //TODO: To include logic for printer.
        $this->dispatch('OrderItemsPrinted');

        $this->success(__('Items printed successfully'));
    }

    public function editForm(OrderItem $orderItem)
    {
        $this->orderItem = $orderItem;
        $this->menuItem = MenuItem::with(['menuFixedSides', 'menuSelectableSides'])->find($orderItem->menu_item_id);
        if ($this->menuItem->menuFixedSides->count())
        {
            $this->fixedSides = explode(",", $orderItem->fixed_sides);
        }
        if ($this->menuItem->menuSelectableSides->count())
        {
            $this->selectableSides = $orderItem->selectable_sides;
        }
        $this->orderNotes = $orderItem->remarks;
        $this->openEditForm = true;
    }

    public function update()
    {
        // $menuItem = MenuItem::with(['menuFixedSides', 'menuSelectableSides'])->find($this->menuItemId);
        // $orderItem = OrderItem::where('order_id', $this->orderId)->where('printed', false)->where('menu_item_id', $this->menuItemId)->get();
        $sides = '';
        if ($this->fixedSides != null)
        {
            foreach ($this->fixedSides as $fixSide)
            {
                $sides .= $this->menuItem->menuFixedSides->where('id', $fixSide)->implode('name', ' | ') . ' | ';
            }
        }

        if ($this->selectableSides != null)
        {
            $sides .= $this->menuItem->menuSelectableSides->where('id', $this->selectableSides)->implode('name', ' | ');
        }

        $this->orderItem->update([
            'sides' => $sides,
            'remarks' => $this->orderNotes,
        ]);

        // $this->openEditForm = false;
        $this->reset(
            'openEditForm',
            'fixedSides',
            'selectableSides',
            'orderNotes',
            'orderItem',
            'menuItem'
        );

        $this->success(__('Order item updated successfully'));
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


    #[On('refreshOrderItems')]
    public function render()
    {
        return view('livewire.manage-orders.components.open-order-items', [
            'orderItems' => OrderItem::with(['menuItem'])->where('printed', false)->where('order_id', $this->orderId)->get(),
            // 'withActions' => !$this->isPrinted,
            'headers' => $this->headers(),
            // 'title' => $this->isPrinted ? __("labels.open_orders") : __("labels.unprocessed"),
            'printers' => Printer::get(),
        ]);
    }
}
