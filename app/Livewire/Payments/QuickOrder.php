<?php

namespace App\Livewire\Payments;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Traits\AppSettings;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class QuickOrder extends Component
{
    use Toast, AppSettings;

    public $itemName;

    #[Validate('required|numeric|min:1')]
    public $orderAmount = 0;

    #[Validate('required|numeric|min:0|max:100')]
    public $discount = 0;

    #[Validate('required|numeric|min:0')]
    public $tax;

    #[Validate('required|numeric|min:0')]
    public $tip = 0;

    #[Validate('required|exists:payment_methods,id')]
    public $paymentMethod;

    public $printing = false;


    public function mount()
    {
        $this->itemName = $this->quickOrderName();
        $this->tax = $this->tax();
    }

    public function pay()
    {
        //Create the order
        $prefix = $this->orderPrefix();
        $order = Order::create([
            'number' => $prefix,
            'total' => $this->orderAmount,
            'is_open' => false,
            'table' => 'none',
            'place_id' => 1,
        ]);
        $order->number = $prefix . "-" . date("Ymd") . "-" . $order->id;
        $order->save();

        //Create the transaction
        $transaction = Transaction::create([
            'number' => $order->number . '-' . date('Gis'),
            'total' => $this->orderAmount - ((float) $this->discount / 100) * $this->orderAmount + (float) $this->tip + ($this->orderAmount - ((float) $this->discount / 100) * $this->orderAmount) * ((float) $this->tax / 100),
            'discount' => ((float) $this->discount / 100) * $this->orderAmount,
            'tip' => $this->tip,
            'tax' => ($this->orderAmount - ((float) $this->discount / 100) * $this->orderAmount) * ((float) $this->tax / 100),
            'paid' => true,
            'order_id' => $order->id,
            'payment_method_id' => $this->paymentMethod,
        ]);

        //Create the transaction item
        TransactionItem::create([
            'item' => $this->itemName,
            'quantity' => 1,
            'price' => $this->orderAmount,
            'transaction_id' => $transaction->id,
        ]);
        $this->success('Transaction created successfully');
        return redirect()->route('transactions.index');
    }

    //TODO: To include logic for printer.
    public function updatedPrinting()
    {
        sleep(3);
        $this->printing = false;
        $this->success('Printed!');
    }


    public function setPaymentMethods()
    {
        $paymentMethods = PaymentMethod::all();
        $this->paymentMethod = $paymentMethods->first()->id;
        return $paymentMethods;
    }

    public function cancel()
    {
        $this->reset('orderAmount', 'discount', 'tip');
        $this->tax = $this->tax();
    }



    public function render()
    {
        return view('livewire.payments.quick-order', [
            'paymentMethods' => $this->setPaymentMethods(),
        ]);
    }
}
