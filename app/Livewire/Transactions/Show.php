<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    public $showTransactionDetail = false;
    public $transactionItems = [];
    public $transaction = [];
    public $transacSubtotal = 0;

    public function headers()
    {
        return [
            ['key' => 'item', 'label' => __('labels.item')],
            ['key' => 'quantity', 'label' => __('labels.quantity'), 'class' => 'w-3 text-center'],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF']],
        ];
    }

    #[On('showTransaction')]
    public function showTransaction($transactionId)
    {
        $this->transacSubtotal = 0;
        $this->transactionItems = TransactionItem::where('transaction_id', $transactionId)->get();
        foreach ($this->transactionItems as $item)
        {
            $this->transacSubtotal += number_format($item->quantity * $item->price, 2);
        }

        // $this->transacSubtotal = TransactionItem::where('id', $transactionId)->sum('quantity*price');
        $this->transaction = Transaction::where('id', $transactionId)->first();
        // dd($this->transaction);
        $this->showTransactionDetail = true;
    }

    public function close()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.transactions.show', [
            'headers' => $this->headers(),
        ]);
    }
}
