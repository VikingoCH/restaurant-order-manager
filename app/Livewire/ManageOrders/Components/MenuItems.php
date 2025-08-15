<?php

namespace App\Livewire\ManageOrders\Components;

use App\Models\MenuItem;
use App\Models\MenuSection;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Mary\Traits\Toast;
use Livewire\Attributes\On;

class MenuItems extends Component
{
    use Toast;

    public $orderId;
    public string $search = '';
    public $fixedSides;
    public $selectableSides;
    public $orderNotes = '';
    public $itemOptions;
    public $openMenuItems = false;
    public $sectionId;
    public $sectionName = '';

    #[On('show-menu-items')]
    public function showMenuItems($sectionId)
    {
        $this->authorize('manage_orders');

        $this->sectionId = $sectionId;
        $this->sectionName = MenuSection::find($sectionId)->name;
        $this->openMenuItems = true;
    }

    public function closeMenuItems()
    {
        $this->reset('search', 'sectionName');
    }

    public function menuitems()
    {
        return MenuItem::query()
            ->with(['menuFixedSides', 'menuSelectableSides'])
            ->when($this->search, fn(Builder $q) => $q->where('name', 'like', "%$this->search%"))
            ->where('menu_section_id', $this->sectionId)
            ->orderBy('position', 'asc')->get();
    }

    public function showOptions(MenuItem $menuItem)
    {
        $this->authorize('manage_orders');

        $this->itemOptions = $menuItem->id;
        if ($menuItem->menuFixedSides->count())
        {
            $this->fixedSides = $menuItem->menuFixedSides->pluck('id')->toArray();
        }

        if ($menuItem->menuSelectableSides->count())
        {
            $this->selectableSides = $menuItem->menuSelectableSides()->orderBy('position', 'asc')->first()->id;
        }
    }

    public function add(MenuItem $menuItem)
    {
        $this->authorize('manage_orders');


        $sides = '';
        $fixedSides = '';
        $selectableSides = '';
        if ($this->fixedSides != null)
        {
            foreach ($this->fixedSides as $fixSide)
            {
                $sides .= $menuItem->menuFixedSides->where('id', $fixSide)->implode('name', ' | ') . ' | ';
            }
            $fixedSides = implode(',', $this->fixedSides);
        }
        elseif ($menuItem->menuFixedSides()->count())
        {
            $sides .= $menuItem->menuFixedSides->implode('name', ' | ');
            $fixedSides = $menuItem->menuFixedSides->implode('id', ',');
        }
        if ($this->selectableSides != null)
        {
            $sides .= $menuItem->menuSelectableSides->where('id', $this->selectableSides)->implode('name', ' | ');
            $selectableSides = $this->selectableSides;
        }
        elseif ($menuItem->menuSelectableSides()->count())
        {
            $sides .= ' | ' . $menuItem->menuSelectableSides()->orderBy('position', 'asc')->first()->name;
            $selectableSides = $menuItem->menuSelectableSides()->orderBy('position', 'asc')->first()->id;
        }

        $itemExist = false;
        // Get Order items already in the Open items list that match selected item
        $orderItems = OrderItem::where('order_id', $this->orderId)->where('printed', false)->where('menu_item_id', $menuItem->id)->get();

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


        $this->reset('search', 'fixedSides', 'selectableSides', 'orderNotes', 'itemOptions');
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
