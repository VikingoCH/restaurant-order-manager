<?php

namespace App\Livewire\ManageOrders\Components;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Mary\Traits\Toast;

class MenuItems extends Component
{
    use Toast;

    public $sectionId;
    public $orderId;

    public string $search = '';

    // Add form variables
    public $openAddForm = false;
    public $fixedSides;
    public $selectableSides;
    public $orderNotes = '';
    public $editMenuItem;

    public function menuitems()
    {
        return MenuItem::query()
            ->with(['menuFixedSides', 'menuSelectableSides'])
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->where('menu_section_id', $this->sectionId)
            ->orderBy('position', 'asc')->get();
    }

    public function addForm(MenuItem $menuItem)
    {
        $this->authorize('manage_orders');

        $this->editMenuItem = $menuItem;
        if ($this->editMenuItem->menuFixedSides->count())
        {
            $this->fixedSides = $this->editMenuItem->menuFixedSides->pluck('id')->toArray();
        }
        if ($this->editMenuItem->menuSelectableSides->count())
        {
            $this->selectableSides = $this->editMenuItem->menuSelectableSides()->orderBy('position', 'asc')->first()->id;
        }

        $this->openAddForm = true;
    }

    public function add(MenuItem $menuItem)
    {
        $this->authorize('manage_orders');

        $orderItems = OrderItem::where('order_id', $this->orderId)->where('printed', false)->where('menu_item_id', $menuItem->id)->get();

        $sides = '';
        $fixedSides = '';
        $selectableSides = '';
        if ($this->fixedSides != null)
        {
            foreach ($this->fixedSides as $fixSide)
            {
                $sides .= $menuItem->menuFixedSides->where('id', $fixSide)->implode('name', ' | ') . ' | ';
                $fixedSides = $menuItem->menuFixedSides->where('id', $fixSide)->implode('id', ',');
            }
        }
        elseif ($menuItem->menuFixedSides()->count())
        {
            $sides .= $menuItem->menuFixedSides->implode('name', ' | ');
            $fixedSides = $menuItem->menuFixedSides->implode('id', ',');
        }
        if ($this->selectableSides != null)
        {
            $sides .= $menuItem->menuSelectableSides->where('id', $this->selectableSides)->implode('name', ' | ');
            $selectableSides = $menuItem->menuSelectableSides->where('id', $this->selectableSides)->implode('id', ',');
        }
        elseif ($menuItem->menuSelectableSides()->count())
        {
            $sides .= ' | ' . $menuItem->menuSelectableSides()->orderBy('position', 'asc')->first()->name;
            $selectableSides = $menuItem->menuSelectableSides()->orderBy('position', 'asc')->first()->id;
        }

        // dd($sides, $fixedSides, $selectableSides);
        $itemExist = false;
        if ($orderItems)
        {
            foreach ($orderItems as $item)
            {
                if ($item->sides == $sides && $item->remarks == $this->orderNotes)
                {
                    $itemExist = true;
                    $item->update([
                        'quantity' => $item->quantity + 1
                    ]);
                    break;
                }
            }
        }

        if (!$itemExist)
        {
            OrderItem::create([
                'quantity' => 1,
                'price' => $menuItem->price,
                'printed' => false,
                'sides' => $sides,
                'remarks' => $this->orderNotes,
                'selectable_sides' => $selectableSides,
                'fixed_sides' => $fixedSides,
                'order_id' => $this->orderId,
                'menu_item_id' => $menuItem->id,
            ]);
        }

        //Update total price of the order
        $order = Order::find($this->orderId);
        $order->update([
            'total' => $order->total + $menuItem->price
        ]);


        $this->reset('search', 'openAddForm', 'fixedSides', 'selectableSides', 'orderNotes', 'editMenuItem');
        $this->dispatch('refreshOrderItems');
        $this->success(__('Order item added successfully'));
    }

    public function render()
    {
        return view('livewire.manage-orders.components.menu-items', [
            'menuItems' => $this->menuItems(),
        ]);
    }
}
