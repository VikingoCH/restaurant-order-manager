<?php

namespace App\Livewire\Transactions\Components;

use App\Models\Order;
use App\Traits\AppSettings;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class PayForm extends Component
{
    use AppSettings, Toast;

    public $openPayForm = false;
    public $order;

    #[Validate('required|string')]
    public $number;

    #[Validate('required|decimal:0,2')]
    public $total;

    #[Validate('decimal:0,2')]
    public $discount;

    #[Validate('decimal:0,2')]
    public $tip;

    #[Validate('decimal:0,2')]
    public $tax;

    public $paid = false;
    public $tax_percentage;
    public $discount_percentage = 0;

    #[On('payOrder')]
    public function payForm(Order $order)
    {
        $this->openPayForm = true;
        $this->order = $order;
        $this->tax_percentage = $this->tax();
    }

    public function save()
    {
        $this->openPayForm = false;
        $this->success(__('Payment processed successfully'));
    }

    public function render()
    {
        return view('livewire.transactions.components.pay-form');
    }
}
