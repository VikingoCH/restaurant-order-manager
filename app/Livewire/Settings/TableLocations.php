<?php

namespace App\Livewire\Settings;

use App\Models\Location;
use App\Models\Place;
use Illuminate\Support\Arr;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class TableLocations extends Component
{
    use Toast;

    #[Validate('required|string|max:50')]
    public $name = '';

    #[Validate('integer')]
    public $position = 1;

    #[Validate('required|integer')]
    public $number = '';

    public $id;
    public $placeId; //not needed(??)

    public $editForm = false;
    public $newForm = false;

    public function headers()
    {
        return [
            ['key' => 'sortable', 'label' => '', 'class' => 'w-1'],
            ['key' => 'position', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => __('labels.location')],
            ['key' => 'tables', 'label' => __('labels.tables')],
        ];
    }


    public function edit(Location $location)
    {
        $this->reset();
        $this->fill($location);
        $this->number = $location->places->count();
        $this->editForm = true;
    }

    public function update()
    {
        //Update Locations Table
        $location = Location::find($this->id);
        $location->update($this->validate());

        //Current number of places
        $tables = $location->places->count();

        //If number of places is incremented
        if ($tables < $this->number)
        {
            for ($i =  $tables + 1; $i <= $this->number; $i++)
            {
                Place::create([
                    'number' => $i,
                    'available' => true,
                    'location_id' => $location->id
                ]);
            }
        }
        //If number of places is reduced
        elseif ($tables > $this->number)
        {
            $places = Place::where('location_id', $this->id)->get();
            $placeIds = [];
            for ($i = $this->number + 1; $i <= $tables; $i++)
            {
                $place = Arr::flatten($places->where('number', $i));
                $placeIds[] = $place[0]->id;
            }
            Place::destroy($placeIds);
        }

        $this->reset();
        $this->success(__('Payment Method updated successfully'));
    }

    public function create()
    {
        $this->reset();
        $this->newForm = true;
    }

    public function store()
    {
        $this->validate();
        $location = Location::create([
            'name' => $this->name,
        ]);
        for ($i = 1; $i <= $this->number; $i++)
        {
            Place::create([
                'number' => $i,
                'available' => true,
                'location_id' => $location->id
            ]);
        }
        $this->reset();
        $this->success(__('Payment Method created successfully'));
    }

    public function destroy(Location $location)
    {
        $location->delete();
        $this->success(__('Payment Method deleted successfully'));
    }

    public function changeRowOrder($items)
    {
        // dd($items);
        foreach ($items as $item)
        {
            Location::find($item['value'])->update(['position' => $item['order']]);
        }
        $this->success(__('Items reordered successfully'));
    }



    public function render()
    {
        // $locations = Location::with(['places'])->get();
        // dd($locations[0]->places->count());

        return view('livewire.settings.table-locations', [
            'headers' => $this->headers(),
            'locations' => Location::with(['places'])->orderBy('position', 'asc')->get(),
        ]);
    }
}
