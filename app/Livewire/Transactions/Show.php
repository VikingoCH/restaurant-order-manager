<?php

namespace App\Livewire\Transactions;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
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
            ['key' => 'amount', 'label' => __('labels.amount'), 'format' => ['currency', '2.\'', 'CHF']],
        ];
    }

    // #[On('showTransaction')]
    // public function transactionItems()
    // {
    // $this->transacSubtotal = 0;
    // $this->transactionItems = TransactionItem::where('transaction_id', $this->transaction->id)->get();
    // foreach ($this->transactionItems as $item)
    // {
    //     $this->transacSubtotal += number_format($item->quantity * $item->price, 2);
    // }

    // $this->transacSubtotal = TransactionItem::where('id', $transactionId)->sum('quantity*price');
    // $this->transaction = Transaction::where('id', $transactionId)->first();
    // dd($this->transaction);
    // $this->showTransactionDetail = true;
    // }

    // public function close()
    // {
    //     $this->reset();
    // }

    public function render()
    {
        return view('livewire.transactions.show', [
            'headers' => $this->headers(),
        ]);
    }
}
