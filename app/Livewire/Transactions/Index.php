<?php

namespace App\Livewire\Transactions;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    // public $orders = [];
    public array $expanded = [];

    // public function mount()
    // {
    //     // // $this->orders = Order::with('transactions')->orderBy('created_at', 'desc')->paginate(10);
    //     $getOrders = Order::with('transactions')->orderBy('created_at', 'desc')->get();
    //     // $this->orders = $getOrders->paginate(10);
    //     // $this->orders = Order::with('transactions')->paginate(20);
    // }

    public function headers(): array
    {
        return [
            ['key' => 'number', 'label' => __('labels.order_number'), 'class' => 'w-3'],
            ['key' => 'table', 'label' => __('labels.table'), 'class' => 'w-3'],
            ['key' => 'total', 'label' => __('labels.amount'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'w-48'],
            ['key' => 'created_at', 'label' => __('labels.date'), 'format' => ['date', 'Y/m/d (H:i)']],
        ];
    }


    public function render()
    {
        return view('livewire.transactions.index', [
            'orders' => Order::with('transactions')->where('is_open', false)->orderBy('created_at', 'desc')->paginate(20),
            'headers' => $this->headers(),
        ]);
    }
}
