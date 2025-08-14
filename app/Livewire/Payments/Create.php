<?php

namespace App\Livewire\Payments;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Traits\AppSettings;
use Livewire\Component;
use Mary\Traits\Toast;

class Create extends Component
{
    use Toast, AppSettings;

    public $orderId;

    public $orderItems = [];
    public $hasOpenItems = false;
    public array $paymentItems = [];
    public $orderItemsTotal = 0;

    public $itemsTotal = 0;
    public $discount = 0;
    public $discountAmount = 0;
    public $tax;
    public $taxAmount = 0;
    public $netTotal = 0;
    public $grossTotal = 0;
    public $tip = 0;
    public $paymentMethod;

    public $printing = false;


    public function mount()
    {
        $this->setOrderItems();
        $this->tax = $this->tax();
    }

    public function setOrderItems()
    {
        $orderItems = OrderItem::with(['menuItem'])->where('order_id', $this->orderId)->where('is_paid', false)->get();
        if ($orderItems)
        {
            foreach ($orderItems as $orderItem)
            {
                $this->orderItems[$orderItem->id] = [
                    'id' => $orderItem->id,
                    'item' => $orderItem->menuItem->name,
                    'quantity' => $orderItem->quantity - $orderItem->paid_quantity,
                    'price' => $orderItem->price,
                    'total' => number_format(($orderItem->quantity - $orderItem->paid_quantity) * $orderItem->price, 2),
                ];
                $this->orderItemsTotal += $this->orderItems[$orderItem->id]['total'];
            }
            if ($orderItems->where('printed', false)->count() != 0)
            {
                $this->hasOpenItems = true;
            }
        }
    }

    public function setPaymentMethods()
    {
        $paymentMethods = PaymentMethod::all();
        $this->paymentMethod = $paymentMethods->first()->id;
        return $paymentMethods;
    }

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => '#'],
            ['key' => 'item', 'label' => __('labels.items')],
            ['key' => 'quantity', 'label' => __('labels.quantity'), 'class' => 'text-center'],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
        ];
    }

    public function addPaymentItem($orderItemId)
    {
        //If item is already in the payment list
        if (array_key_exists($orderItemId, $this->paymentItems))
        {
            //Add payment item
            $this->paymentItems[$orderItemId]['quantity'] += 1;
            $this->paymentItems[$orderItemId]['total'] += $this->orderItems[$orderItemId]['price'];

            // Update order item
            $this->orderItems[$orderItemId]['quantity'] -= 1;
            $this->orderItems[$orderItemId]['total'] = number_format($this->orderItems[$orderItemId]['quantity'] * $this->orderItems[$orderItemId]['price'], 2);
        }
        else //If item is not in the payment list yet
        {

            // Create payment item
            $this->paymentItems[$orderItemId] = [
                'id' => $orderItemId,
                'item' => $this->orderItems[$orderItemId]['item'],
                'quantity' => 1,
                'price' => $this->orderItems[$orderItemId]['price'],
                'total' => $this->orderItems[$orderItemId]['price'],
            ];

            // Update order item
            $this->orderItems[$orderItemId]['quantity'] -= 1;
            $this->orderItems[$orderItemId]['total'] = number_format($this->orderItems[$orderItemId]['quantity'] * $this->orderItems[$orderItemId]['price'], 2);
        }

        // Recalculate totals
        $this->itemsTotal += $this->paymentItems[$orderItemId]['price'];
        $this->orderItemsTotal -= $this->paymentItems[$orderItemId]['price'];

        $totalWithDiscount = $this->itemsTotal - $this->discountAmount;
        $this->taxAmount = $totalWithDiscount - ($totalWithDiscount / (1 + $this->tax / 100));
        $this->netTotal = $totalWithDiscount - $this->taxAmount;
        $this->grossTotal = $totalWithDiscount + $this->tip;


        // If all order items added to payment list then remove it from ordered list
        if ($this->orderItems[$orderItemId]['quantity'] == 0)
        {
            unset($this->orderItems[$orderItemId]);
        }
    }

    public function addAllPaymentItems()
    {
        $this->paymentItems = $this->orderItems;

        //calculate subtotal
        foreach ($this->paymentItems as $paymentItem)
        {
            $this->itemsTotal += $paymentItem['total'];
        }
        $this->orderItems = [];
        $this->orderItemsTotal = 0;

        $totalWithDiscount = $this->itemsTotal - $this->discountAmount;
        $this->taxAmount = $totalWithDiscount - ($totalWithDiscount / (1 + $this->tax / 100));
        $this->netTotal = $totalWithDiscount - $this->taxAmount;
        $this->grossTotal = $totalWithDiscount + $this->tip;
    }

    public function removePaymentItem($orderItemId)
    {

        //If item exist in the ordered items list
        if (array_key_exists($orderItemId, $this->orderItems))
        {
            //Update order item
            $this->orderItems[$orderItemId]['quantity'] += 1;
            $this->orderItems[$orderItemId]['total'] = number_format($this->orderItems[$orderItemId]['quantity'] * $this->orderItems[$orderItemId]['price'], 2);
        }
        else //If item is not in the ordered list create ordered item
        {
            $this->orderItems[$orderItemId] = [
                'id' => $orderItemId,
                'item' => $this->paymentItems[$orderItemId]['item'],
                'quantity' => 1,
                'price' => $this->paymentItems[$orderItemId]['price'],
                'total' => $this->paymentItems[$orderItemId]['price'],
            ];
        }

        //Remove payment item
        $this->paymentItems[$orderItemId]['quantity'] -= 1;
        $this->paymentItems[$orderItemId]['total'] = number_format($this->paymentItems[$orderItemId]['quantity'] * $this->paymentItems[$orderItemId]['price'], 2);

        // Recalculate totals
        $this->itemsTotal -= $this->paymentItems[$orderItemId]['price'];
        $this->orderItemsTotal += $this->paymentItems[$orderItemId]['price'];

        $totalWithDiscount = $this->itemsTotal - $this->discountAmount;
        $this->taxAmount = $totalWithDiscount - ($totalWithDiscount / (1 + $this->tax / 100));
        $this->netTotal = $totalWithDiscount - $this->taxAmount;
        $this->grossTotal = $totalWithDiscount + $this->tip;

        // If all order items removed from payment list then add it from ordered list
        if ($this->paymentItems[$orderItemId]['quantity'] == 0)
        {
            unset($this->paymentItems[$orderItemId]);
        }
    }

    public function pay()
    {
        // dd($this->grossTotal, $this->discountAmount, $this->tip, $this->taxAmount);
        $order = Order::find($this->orderId);

        //Transaction Number
        date_default_timezone_set('Europe/Zurich');
        $orderNumber = Order::where('id', $this->orderId)->get('number');
        $transacNumber = $orderNumber[0]->number . '-' . date('Gis');

        // Transaction register
        $transaction = Transaction::create([
            'number' => $transacNumber,
            'total' => $this->grossTotal,
            'discount' => $this->discountAmount,
            'tip' => $this->tip,
            'tax' => $this->taxAmount,
            'paid' => true,
            'order_id' => $order->id,
            'payment_method_id' => $this->paymentMethod,
        ]);

        //transaction Items register
        $orderItems = OrderItem::where('order_id', $this->orderId)->where('is_paid', false)->get();
        foreach ($this->paymentItems as $orderItemId => $paymentItem)
        {
            TransactionItem::create([
                'item' => $paymentItem['item'],
                'quantity' => $paymentItem['quantity'],
                'price' => $paymentItem['price'],
                'transaction_id' => $transaction->id,
            ]);

            // Update the order item
            $orderItem = $orderItems->find($orderItemId);
            $paidQty = $orderItem->paid_quantity + $paymentItem['quantity'];
            $orderItem->update(['paid_quantity' => $paidQty]);
            if (!$orderItem->printed)
            {
                $orderItem->update(['printed' => true]);
            }
            if ($orderItem->quantity == $paidQty)
            {
                $orderItem->update(['is_paid' => true]);
            }
        }

        //Verify if all items are paid if so then close the order
        if (OrderItem::where('order_id', $this->orderId)->where('is_paid', false)->count() == 0)
        {
            $order->update(['is_open' => false]);
            $order->place->update(['available' => true]);
            $this->success('No more orders');
        }

        $this->reset('paymentItems', 'itemsTotal', 'discount', 'tip');
        $this->success('Payment processed sucessfully');
        return redirect('/');
    }

    //TODO: Add print receipt and print order.
    public function updatedPrinting()
    {
        sleep(3);
        $this->printing = false;
    }

    public function updatedDiscount()
    {
        $this->discountAmount = ((float) $this->discount / 100) * $this->itemsTotal;
        $totalWithDiscount = $this->itemsTotal - $this->discountAmount;
        $this->taxAmount = $totalWithDiscount - ($totalWithDiscount / (1 + $this->tax / 100));
        $this->netTotal = $totalWithDiscount - $this->taxAmount;
        $this->grossTotal = $totalWithDiscount + $this->tip;
    }

    public function updatedTip()
    {
        $totalWithDiscount = $this->itemsTotal - $this->discountAmount;
        $this->grossTotal = $totalWithDiscount + $this->tip;
    }



    public function cancel()
    {
        $this->reset('orderItems', 'orderItemsTotal', 'paymentItems', 'itemsTotal', 'discount', 'discountAmount', 'tip', 'taxAmount', 'netTotal', 'grossTotal');
        $this->setOrderItems();
        $this->tax = $this->tax();
    }

    public function render()
    {
        return view('livewire.payments.create', [
            'order' => Order::find($this->orderId),
            'paymentMethods' => $this->setPaymentMethods(),
            'headers' => $this->headers(),
        ]);
    }
}
