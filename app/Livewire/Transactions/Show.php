<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Traits\AppSettings;
use App\Traits\PrintReceipts;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    use AppSettings, PrintReceipts;
    public Transaction $transaction;


    public $showTransactionDetail = false;
    public $items;
    public $subtotal = 0;

    public function mount()
    {
        $this->items = TransactionItem::where('transaction_id', $this->transaction->id)->get();
        foreach ($this->items as $item)
        {
            $this->subtotal += number_format($item->quantity * $item->price, 2);
        }
    }
    public function headers()
    {
        return [
            ['key' => 'item', 'label' => __('labels.item')],
            ['key' => 'quantity', 'label' => __('labels.quantity')],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'amount', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF']],
        ];
    }

    public function print()
    {
        $this->authorize('manage_orders');
        $items = [];
        foreach ($this->items as $item)
        {
            $items[] = [
                'item' => $item->item,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'total' => number_format($item->quantity * $item->price, 2),
            ];
        }
        $totals = [
            'items_total' => $this->subtotal,
            'gross_total' => $this->transaction->total,
            'tax' => $this->tax(),
            'tax_amount' => $this->transaction->tax,
            'net_total' => number_format($this->transaction->total - $this->transaction->tax, 2),
            'discount' => $this->transaction->discount,
            'tip' => $this->transaction->tip,
            'total_paid' => number_format($this->transaction->total + $this->transaction->tip, 2),
        ];
        $this->printCashRegister($this->transaction->order_id, $items, $totals);
    }

    public function render()
    {
        return view('livewire.transactions.show', [
            'headers' => $this->headers(),
        ]);
    }
}
