<?php

namespace App\Livewire\Payments;

use App\Models\PaymentMethod;
use App\Traits\AppSettings;
use Livewire\Component;
use Mary\Traits\Toast;

class QuickOrder extends Component
{
    use Toast, AppSettings;

    public $orderAmount = 0;
    public $itemName;
    public $discount = 0;
    public $tax;
    public $tip = 0;
    public $paymentMethod;

    public function mount()
    {
        $this->itemName = $this->quickOrderName();
        $this->tax = $this->tax();
    }

    public function setPaymentMethods()
    {
        $paymentMethods = PaymentMethod::all();
        $this->paymentMethod = $paymentMethods->first()->id;
        return $paymentMethods;
    }



    public function render()
    {
        return view('livewire.payments.quick-order', [
            'paymentMethods' => $this->setPaymentMethods(),
        ]);
    }
}
