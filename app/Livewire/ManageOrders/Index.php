<?php

namespace App\Livewire\ManageOrders;

use App\Models\Location;
use App\Models\Order;
use App\Models\Place;
use App\Models\Transaction;
use App\Traits\AppSettings;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;

class Index extends Component
{
    use AppSettings, Toast, WithPagination;

    public function headers(): array
    {
        return [
            ['key' => 'number', 'label' => __('labels.order_number'), 'class' => 'w-3'],
            ['key' => 'table', 'label' => __('labels.table'), 'class' => 'w-3'],
            ['key' => 'total', 'label' => __('labels.amount'), 'format' => ['currency', '2.\'', 'CHF '], 'class' => 'w-48'],
            ['key' => 'created_at', 'label' => __('labels.date'), 'format' => ['date', 'Y/m/d (H:i)']],
        ];
    }

    public function create(Place $place): void
    {
        $prefix = $this->orderPrefix();
        $location = Location::where('id', $place->location_id)->get();

        $order = Order::create([
            'number' => $prefix,
            'total' => 0.00,
            'is_open' => true,
            'table' => $location[0]->name . "-" . $place->number,
            'place_id' => $place->id
        ]);
        $order->number = $prefix . "-" . date("Ymd") . "-" . $order->id;
        $order->save();

        $place->available = false;
        $place->save();
        $this->success(__('Order created successfully'), redirectTo: route('manage-order.edit', $order->id));
        $this->success(__('Order created successfully'));
    }

    public function destroy(Order $order): void
    {
        Place::where('id', $order->place_id)->update(['available' => true]);
        $order->delete();

        $this->success(__('Order deleted successfully'));
    }

    public function print()
    {
        $this->authorize('manage_orders');

        $transactions = Transaction::where('cash_closing_at', null)->get();
        if (!$transactions->isEmpty())
        {
            $items = [];
            foreach ($transactions as $item)
            {
                $items[] = [
                    'number' => $item->number,
                    'total'  => $item->total,
                ];
            }

            $request = [
                'printer-id'   => $this->defaultPrinter(),
                'items'        => $items,

            ];
            $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'print-cash-close', $request);
            if (!$response->json('success'))
            {
                Log::error('Print plug-in - Print Cash Close Error: ' . $response->status() . ' / ' . $response->json('errors'));
                $this->error(__('Cash Close print error'));
            }
            else
            {
                foreach ($transactions as $transaction)
                {
                    $transaction->update([
                        'cash_closing_at' => now(),
                    ]);
                }
                $this->success(__('Cash Close printed successfully'));
            }
        }
        else
        {
            $this->warning(__('No Cash Close pending'));
        }
    }

    public function render(): mixed
    {
        return view('livewire.manage-orders.index', [
            'openOrders' => Order::with('place')->where('is_open', true)->orderBy('created_at', 'desc')->paginate(20),
            'headers' => $this->headers(),
            'locations' => Location::where('physical', true)->with('places')->get(),
        ]);
    }
}
