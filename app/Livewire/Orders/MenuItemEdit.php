<?php

namespace App\Livewire\Orders;

use App\Models\MenuItem;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\On;
use Livewire\Component;
use Mary\Traits\Toast;

class MenuItemEdit extends Component
{
    use Toast;

    public $openForm = false;
    public $onlyUpdate = false;
    public $orderId;
    public $menuItemId;

    public $fixedSides;
    public $selectableSides;
    public $editItem;
    public string $orderNotes = '';

    // public function mount($id)
    // {
    //     $this->menuItemId = $id;
    // }

    #[On('edit-form')]
    public function openEditForm($menuItemId, $onlyUpdate = false)
    {
        $this->onlyUpdate = $onlyUpdate;
        $this->editItem = MenuItem::with(['menuFixedSides', 'menuSelectableSides'])->find($menuItemId);
        // dd($this->editItem);
        if ($this->editItem->menuFixedSides->count())
        {
            $this->fixedSides = $this->editItem->menuFixedSides->pluck('id')->toArray();
        }
        if ($this->editItem->menuSelectableSides->count())
        {
            $this->selectableSides = $this->editItem->menuSelectableSides()->orderBy('position', 'asc')->first()->id;
        }
        $orderItem = OrderItem::where('menu_item_id', $menuItemId)->get();
        $this->orderNotes = $orderItem[0]->remarks;
        // dd($this->selectableSides);
        // $this->selectableSides = $this->editItem->menuSelectableSides->pluck('id')->toArray();
        $this->openForm = true;
    }

    #[On('add-item')]
    public function addItem($menuItemId)
    {
        $this->menuItemId = $menuItemId;
        if ($this->onlyUpdate)
        {
            $this->update();
        }
        else
        {
            $this->add();
        }
        $this->dispatch("item-added");
    }

    public function add()
    {
        $menuItem = MenuItem::with(['menuFixedSides', 'menuSelectableSides'])->find($this->menuItemId);
        $orderItem = OrderItem::where('order_id', $this->orderId)->where('printed', false)->where('menu_item_id', $this->menuItemId)->get();
        $sides = '';
        if ($this->fixedSides != null)
        {
            foreach ($this->fixedSides as $fixSide)
            {
                $sides .= $menuItem->menuFixedSides->where('id', $fixSide)->implode('name', ' | ') . ' | ';
            }
        }
        elseif ($menuItem->menuFixedSides()->count())
        {
            $sides = $menuItem->menuFixedSides->implode('name', ' | ');
        }

        if ($this->selectableSides != null)
        {
            $sides .= $menuItem->menuSelectableSides->where('id', $this->selectableSides)->implode('name', ' | ');
        }
        elseif ($menuItem->menuSelectableSides()->count())
        {
            $sides .= ' | ' . $menuItem->menuSelectableSides()->orderBy('position', 'asc')->first()->name;
        }

        // dd($sides);

        $itemExist = false;
        if ($orderItem)
        {
            foreach ($orderItem as $item)
            {
                if ($item->sides == $sides && $item->remarks == $this->orderNotes)
                {
                    $itemExist = true;
                    $item->update([
                        'quantity' => $item->quantity + 1
                    ]);
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
                'order_id' => $this->orderId,
                'menu_item_id' => $menuItem->id,
            ]);
        }

        //Update total price of the order
        $order = Order::find($this->orderId);
        $order->update([
            'total' => $order->total + $menuItem->price
        ]);

        $this->reset('fixedSides', 'selectableSides', 'editItem', 'orderNotes', 'openForm');
        $this->success(__('Menu item added successfully'));
    }

    public function update()
    {
        $menuItem = MenuItem::with(['menuFixedSides', 'menuSelectableSides'])->find($this->menuItemId);
        // $orderItem = OrderItem::where('order_id', $this->orderId)->where('printed', false)->where('menu_item_id', $this->menuItemId)->get();
        $sides = '';
        if ($this->fixedSides != null)
        {
            foreach ($this->fixedSides as $fixSide)
            {
                $sides .= $menuItem->menuFixedSides->where('id', $fixSide)->implode('name', ' | ') . ' | ';
            }
        }

        if ($this->selectableSides != null)
        {
            $sides .= $menuItem->menuSelectableSides->where('id', $this->selectableSides)->implode('name', ' | ');
        }
        OrderItem::where('order_id', $this->orderId)->where('printed', false)->where('menu_item_id', $this->menuItemId)->update([
            'sides' => $sides,
            'remarks' => $this->orderNotes,
        ]);

        $this->reset('fixedSides', 'selectableSides', 'editItem', 'orderNotes', 'openForm');
        $this->success(__('Menu item updated successfully'));
    }


    public function render()
    {
        return view('livewire.orders.menu-item-edit');
    }
}
