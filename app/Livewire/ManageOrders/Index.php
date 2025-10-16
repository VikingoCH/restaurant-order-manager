<?php

namespace App\Livewire\ManageOrders;

use App\Models\Location;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Place;
use App\Models\Transaction;
use App\Traits\AppSettings;
use App\Traits\PrintReceipts;
use Livewire\Component;
use Livewire\WithPagination;
use Mary\Traits\Toast;

class Index extends Component
{
    use AppSettings, Toast, WithPagination, PrintReceipts;

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

        $items = Transaction::where('cash_closing_at', null)->get();

        $this->printCashClose($items);

        $this->success(__('Cash Close printed successfully'));
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
