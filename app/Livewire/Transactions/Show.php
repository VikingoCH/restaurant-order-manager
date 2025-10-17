<?php

namespace App\Livewire\Transactions;

use App\Models\Order;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Traits\AppSettings;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;

class Show extends Component
{
    use Toast;

    use AppSettings;
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
            ['key' => 'item',     'label' => __('labels.item')],
            ['key' => 'quantity', 'label' => __('labels.quantity')],
            ['key' => 'price',    'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'amount',   'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF']],
        ];
    }

    public function print()
    {
        $this->authorize('manage_orders');
        $order = Order::find($this->transaction->order_id);
        $items = [];
        foreach ($this->items as $item)
        {
            $items[] = [
                'name'     => $item->item,
                'quantity' => $item->quantity,
                'price'    => $item->price,
            ];
        }

        //TODO: Define printer_id from general settings
        $request = [
            'printer-id'   => 1,
            'order_number' => $order->number,
            'tax'          => $this->tax(),
            'items'        => $items,
            'items_total'  => $this->subtotal,
            'gross_total'  => $this->transaction->total,
            'tax_amount'   => $this->transaction->tax,
            'net_total'    => number_format($this->transaction->total - $this->transaction->tax, 2),
            'discount'     => $this->transaction->discount,
            'tip'          => $this->transaction->tip,
            'total_paid'   => number_format($this->transaction->total + $this->transaction->tip, 2),
        ];

        $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'print-invoice', $request);
        if (!$response->json('success'))
        {
            Log::error('Print plug-in - Printers Error: ' . $response->status() . ' / ' . $response->json('errors'));
        }
        else
        {
            $this->success(__('Items printed successfully'));
        }
    }

    public function render()
    {
        return view('livewire.transactions.show', [
            'headers' => $this->headers(),
        ]);
    }
}
