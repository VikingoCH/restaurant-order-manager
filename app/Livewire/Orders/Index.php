<?php

namespace App\Livewire\Orders;

use App\Models\Location;
use App\Models\Order;
use App\Models\Place;
use App\Traits\AppSettings;
use Livewire\Component;
use Mary\Traits\Toast;

class Index extends Component
{
    use AppSettings, Toast;

    public function headers(): array
    {
        return [
            ['key' => 'number', 'label' => __('labels.order_number')],
            ['key' => 'table', 'label' => __('labels.table'), 'class' => 'w-3'],
            // ['key' => 'place_id', 'label' => __('labels.table'), 'class' => 'w-3'],
            ['key' => 'total', 'label' => __('labels.amount'), 'format' => ['currency', '2.\'', 'CHF ']],
            ['key' => 'created_at', 'label' => __('labels.open_at'), 'format' => ['date', 'Y/m/d']],
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
        $order->number = $prefix . "-" . date("m-Y") . "-" . $order->id;
        $order->save();

        $place->available = false;
        $place->save();
        $this->success(__('Order created successfully'), redirectTo: route('order.edit', $order->id));
        $this->success(__('Order created successfully'));
    }

    public function destroy(Order $order): void
    {
        Place::where('id', $order->place_id)->update(['available' => true]);
        $order->delete();

        $this->success(__('Order deleted successfully'));
    }

    public function render(): mixed
    {
        return view('livewire.orders.index', [
            'openOrders' => Order::with('place')->where('is_open', true)->orderBy('created_at', 'desc')->paginate(20),
            'headers' => $this->headers(),
            'locations' => Location::with('places')->get(),
        ]);
    }
}
