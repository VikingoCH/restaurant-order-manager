<?php

namespace App\Livewire\Transactions;

use App\Models\Order;
use Livewire\Component;

class Index extends Component
{

    public $orders = [];
    public array $expanded = [];

    public function mount()
    {
        $this->orders = Order::with('transactions')->get();
    }

    public function headers(): array
    {
        return [
            // ['key' => 'id', 'label' => '#'],
            ['key' => 'number', 'label' => __('labels.number')],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'created_at', 'label' => __('labels.date')],
        ];
    }


    public function render()
    {
        return view('livewire.transactions.index', [
            'headers' => $this->headers(),
        ]);
    }
}
