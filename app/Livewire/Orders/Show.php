<?php

namespace App\Livewire\Orders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Traits\AppSettings;
use Livewire\Component;

class Show extends Component
{
    use AppSettings;

    public Order $order;
    public array $expanded = [];

    public function orderHeaders(): array
    {
        return [
            ['key' => 'menuItem.name', 'label' => __('labels.items')],
            ['key' => 'quantity', 'label' => __('labels.quantity'), 'class' => 'text-center'],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'amount', 'label' => __('labels.amount'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
        ];
    }

    public function transactionsHeader()
    {
        return [
            ['key' => 'number', 'label' => __('labels.number')],
            ['key' => 'tip', 'label' => __('labels.tip'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'discount', 'label' => __('labels.discount'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'tax', 'label' => __('labels.tax'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
        ];
    }

    public function transactionItemsHeader()
    {
        return [
            ['key' => 'item', 'label' => __('labels.items')],
            ['key' => 'quantity', 'label' => __('labels.quantity'), 'class' => 'text-center'],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
        ];
    }

    public function totals()
    {
        return Transaction::query()
            ->where('order_id', $this->order->id)
            ->selectRaw('SUM(total) as total_sum, SUM(discount) as discount_sum, SUM(tip) as tip_sum, SUM(tax) as tax_sum ')
            ->first();
    }


    public function orderItems()
    {
        if ($this->order->table == 'none')
        {
            return collect([
                [
                    'menuItem' => [
                        'name' => $this->quickOrderName(),
                    ],
                    'quantity' => 1,
                    'price' => $this->order->total,
                    'amount' => $this->order->total,
                ]
            ]);
        }
        else
        {
            return  OrderItem::with('menuItem')->where('order_id', $this->order->id)->get();
        }
    }

    public function render()
    {
        return view('livewire.orders.show', [
            'orderItems' => $this->orderItems(),
            'totals' => $this->totals(),
            'transactions' => Transaction::with('transactionItems')->where('order_id', $this->order->id)->get(),
            'orderHeaders' => $this->orderHeaders(),
            'transactionsHeader' => $this->transactionsHeader(),
            'transactionItemsHeader' => $this->transactionItemsHeader(),
        ]);
    }
}
