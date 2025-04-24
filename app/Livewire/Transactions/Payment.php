<?php

namespace App\Livewire\Transactions;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use Livewire\Component;
use Mary\Traits\Toast;

class Payment extends Component
{
    use Toast;

    public $orderId;
    public array $selectedRows;

    public $orderItems;
    public $hasOpenItems = false;
    public array $paymentItems = [];

    public $itemsTotal = 0;


    public function mount()
    {
        $orderItems = OrderItem::with(['menuItem'])->where('order_id', $this->orderId)->where('is_payed', false)->get();
        foreach ($orderItems as $orderItem)
        {
            $this->orderItems[$orderItem->id] = [
                'id' => $orderItem->id,
                'item' => $orderItem->menuItem->name,
                'quantity' => $orderItem->quantity,
                'price' => $orderItem->price,
                'total' => number_format($orderItem->quantity * $orderItem->price, 2),
            ];
        }
        if ($orderItems->where('printed', false)->count() != 0)
        {
            return $this->hasOpenItems = true;
        }
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'item', 'label' => __('labels.items')],
            ['key' => 'quantity', 'label' => __('labels.quantity'), 'class' => 'text-center'],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
        ];
    }

    // public function orderItems()
    // {
    //     $orderItems = OrderItem::with(['menuItem'])->where('order_id', $this->orderId)->get();
    //     foreach ($orderItems as $orderItem)
    //     {
    //         $this->orderItems[$orderItem->id] = [
    //             'item' => $orderItem->menuItem->name,
    //             'quantity' => $orderItem->quantity,
    //             'price' => $orderItem->price,
    //             'total' => number_format($orderItem->quantity * $orderItem->price, 2),
    //         ];
    //     }
    // }

    // public function hasOpenItems()
    // {
    //     if ($this->orderItems->where('printed', false)->count() != 0)
    //     {
    //         return $this->hasOpenItems = true;
    //     }
    //     return $this->hasOpenItems = false;
    // }

    public function addPaymentItem($orderItemId)
    {
        // $orderItem = $this->orderItems[$orderItemId];
        // $menuItem = MenuItem::where('id', $orderItem->menu_item_id);
        if (array_key_exists($orderItemId, $this->paymentItems))
        {
            $this->paymentItems[$orderItemId]['quantity'] += 1;
            $this->paymentItems[$orderItemId]['total'] += $this->orderItems[$orderItemId]['price'];

            $this->orderItems[$orderItemId]['quantity'] -= 1;
            $this->orderItems[$orderItemId]['total'] = number_format($this->orderItems[$orderItemId]['quantity'] * $this->orderItems[$orderItemId]['price'], 2);
        }
        else
        {
            // dd($orderItem);
            $this->paymentItems[$orderItemId] = [
                'id' => $orderItemId,
                'item' => $this->orderItems[$orderItemId]['item'],
                'quantity' => 1,
                'price' => $this->orderItems[$orderItemId]['price'],
                'total' => $this->orderItems[$orderItemId]['price'],
            ];

            $this->orderItems[$orderItemId]['quantity'] -= 1;
            $this->orderItems[$orderItemId]['total'] = number_format($this->orderItems[$orderItemId]['quantity'] * $this->orderItems[$orderItemId]['price'], 2);
        }

        $this->itemsTotal += $this->paymentItems[$orderItemId]['total'];

        if ($this->orderItems[$orderItemId]['quantity'] == 0)
        {
            unset($this->orderItems[$orderItemId]);
        }
        // var_dump($this->paymentItems);
        $this->success('Item Added', $orderItemId);
    }

    public function render()
    {
        return view('livewire.transactions.payment', [
            'order' => Order::find($this->orderId),
            'paymentMethods' => PaymentMethod::all(),
            // 'orderItems' => $this->orderItems(),
            // 'hasOpenItems' => $this->hasOpenItems(),
            'headers' => $this->headers(),
        ]);
    }
}
