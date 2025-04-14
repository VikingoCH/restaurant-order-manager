<?php

namespace App\Livewire\Settings;

use App\Models\Printer;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class Printers extends Component
{
    use Toast;

    #[Validate('required|string|max:150')]
    public $name = '';

    #[Validate('required|string|max:150')]
    public $identifier = '';

    #[Validate('required|string|max:150')]
    public $location = '';

    #[Validate('ip')]
    public $ip_address = '';

    #[Validate('string|max:50')]
    public $conection_type = 'network';

    public $id;

    public $editForm = false;
    public $newForm = false;

    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => __('labels.name')],
            ['key' => 'identifier', 'label' => __('labels.identifier')],
            ['key' => 'location', 'label' => __('labels.location')],
            ['key' => 'ip_address', 'label' => __('labels.ip')],
            ['key' => 'conection_type', 'label' => __('labels.conection')],
        ];
    }


    public function edit(Printer $printer)
    {
        $this->authorize('manage_settings');

        $this->reset();
        $this->fill($printer);
        $this->editForm = true;
    }

    public function update()
    {
        $this->authorize('manage_settings');

        $printer = Printer::find($this->id);
        $printer->update($this->validate());
        $this->reset();
        $this->success(__('Printer updated successfully'));
    }

    public function create()
    {
        $this->authorize('manage_settings');

        $this->reset();
        $this->newForm = true;
    }

    public function store()
    {
        $this->authorize('manage_settings');

        Printer::create($this->validate());
        $this->reset();
        $this->success(__('Printer created successfully'));
    }

    public function destroy(Printer $printer)
    {
        $this->authorize('manage_settings');

        $printer->delete();
        $this->success(__('Printer deleted successfully'));
    }

    public function render()
    {
        $this->authorize('manage_settings');

        return view('livewire.settings.printers', [
            'headers' => $this->headers(),
            'printers' => Printer::all(),
        ]);
    }
}
