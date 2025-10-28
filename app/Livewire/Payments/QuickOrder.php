<?php

namespace App\Livewire\Payments;

use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Traits\AppSettings;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;

class QuickOrder extends Component
{
    use Toast, AppSettings;

    public $itemName;

    public $taxAmount = 0;
    public $netTotal = 0;
    public $grossTotal = 0;
    public $paymentTotal = 0;
    public $tax;
    public $orderNumber;

    #[Validate('required|numeric|min:1')]
    public $orderAmount = 0;

    #[Validate('required|numeric|min:0|max:100')]
    public $discount = 0;

    #[Validate('required|numeric|min:0')]
    public $discountAmount = 0;

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
        $this->validate();

        //Create the order
        $prefix = $this->orderPrefix();
        $order = Order::create([
            'number' => $prefix,
            'total' => $this->grossTotal,
            'is_open' => false,
            'table' => 'none',
            'place_id' => 1,
        ]);
        $order->number = $prefix . "-" . date("Ymd") . "-" . $order->id;
        $order->save();
        $this->orderNumber = $order->number;

        //Create the transaction
        $transaction = Transaction::create([
            'number' => $order->number . '-' . date('Gis'),
            'total' => $this->grossTotal,
            'discount' => $this->discountAmount,
            'tip' => $this->tip,
            'tax' => $this->taxAmount,
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

    public function printAndPay()
    {
        $this->authorize('manage_orders');
        $this->pay();

        $items[] = [
            'name'     => $this->itemName,
            'quantity' => 1,
            'price'    => $this->orderAmount,
        ];

        $request = [
            'printer-id'   => $this->defaultPrinter(),
            'order_number' => $this->orderNumber,
            'tax'          => $this->tax(),
            'items'        => $items,
            'items_total'  => $this->orderAmount,
            'gross_total'  => $this->grossTotal,
            'tax_amount'   => $this->taxAmount,
            'net_total'    => $this->netTotal,
            'discount'     => $this->discountAmount,
            'tip'          => $this->tip,
            'total_paid'   => $this->paymentTotal,
        ];

        $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'print-invoice', $request);
        if (!$response->json('success'))
        {
            Log::error('Print plug-in - Print invoice Error: ' . $response->status() . ' / ' . $response->json('errors'));
        }
    }

    public function setPaymentMethods()
    {
        $paymentMethods = PaymentMethod::all();
        $this->paymentMethod = $paymentMethods->first()->id;
        return $paymentMethods;
    }

    public function cancel()
    {
        $this->reset('orderAmount', 'discount', 'tip', 'discountAmount', 'taxAmount', 'netTotal', 'grossTotal', 'paymentTotal');
        $this->calculateTotals();
        $this->tax = $this->tax();
    }

    public function updatedOrderAmount()
    {
        $this->validate();
        $this->discountAmount = ($this->discount / 100) * $this->orderAmount;
        $this->calculateTotals();
    }

    public function updatedDiscount()
    {
        $this->validate();
        $this->discountAmount = ($this->discount / 100) * $this->orderAmount;
        $this->calculateTotals();
    }

    public function updatedDiscountAmount()
    {
        $this->validate();
        $this->discount = ($this->discountAmount / $this->orderAmount) * 100;
        $this->calculateTotals();
    }

    public function updatedTip()
    {
        $this->validate();
        $this->calculateTotals();
    }

    public function render()
    {
        return view('livewire.payments.quick-order', [
            'paymentMethods' => $this->setPaymentMethods(),
        ]);
    }


    private function calculateTotals()
    {
        $this->grossTotal = $this->orderAmount - $this->discountAmount;
        $this->taxAmount = $this->grossTotal - ($this->grossTotal / (1 + $this->tax / 100));
        $this->netTotal = $this->grossTotal - $this->taxAmount;
        $this->paymentTotal = $this->grossTotal + $this->tip;
    }
}
