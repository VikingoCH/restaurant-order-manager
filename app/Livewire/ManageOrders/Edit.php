<?php

namespace App\Livewire\ManageOrders;

use App\Models\MenuSection;
use App\Models\Order;
use App\Models\OrderItem;
use App\Traits\AppSettings;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;

class Edit extends Component
{
    use Toast, AppSettings;

    public $orderId;
    public array $selectedRows;

    public function headers(): array
    {
        return [
            ['key' => 'id', 'label' => 'id', 'class' => 'w-1'],
            ['key' => 'items', 'label' => __('labels.items')],
            ['key' => 'quantity', 'label' => __('labels.quantity'), 'class' => 'text-center'],
            ['key' => 'price', 'label' => __('labels.price'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
            ['key' => 'total', 'label' => __('labels.total'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'text-center'],
        ];
    }

    public function order()
    {
        return Order::with('place')->find($this->orderId);
    }

    public function print()
    {
        $this->authorize('manage_orders');

        $orderItems = OrderItem::with(['menuItem'])->where('order_id', $this->orderId)->get();
        $openItems = $orderItems->where('printed', false);
        if (!$openItems->isEmpty())
        {
            foreach ($openItems as $openItem)
            {
                $openItem->update([
                    'printed' => true,
                ]);
            }
        }
        $order = Order::find($this->orderId);
        $items = [];
        foreach ($orderItems as $item)
        {
            $items[] = [
                'name'     => $item->menuItem->name,
                'quantity' => $item->quantity,
                'price'    => $item->price,
            ];
        }

        $request = [
            'printer-id'   => $this->defaultPrinter(),
            'order_number' => $order->number,
            'tax'          => $this->tax(),
            'order_total'  => $order->total,
            'items'        => $items,

        ];

        $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'print-check', $request);
        if (!$response->json('success'))
        {
            Log::error('Print plug-in - Printers Error: ' . $response->status() . ' / ' . $response->json('errors'));
        }
        else
        {
            $this->success(__('Items printed successfully'));
            return redirect(request()->header('Referer'));
        }
    }


    public function render()
    {
        return view('livewire.manage-orders.edit', [
            'sections' => MenuSection::orderBy('position', 'asc')->get(),
            'order' => $this->order(),
        ]);
    }
}
