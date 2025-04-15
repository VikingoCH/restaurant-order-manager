<?php

namespace App\Livewire\Settings;

use App\Models\PaymentMethod;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;

class PaymentMethods extends Component
{

    use Toast;

    #[Validate('required|string|max:50')]
    public $name = '';
    public $id;

    public $showForm = false;

    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => __('labels.name')],
        ];
    }

    public function edit(PaymentMethod $payMethod)
    {
        $this->authorize('manage_settings');

        $this->reset();
        $this->fill($payMethod);
        $this->showForm = true;
    }

    public function create()
    {
        $this->authorize('manage_settings');

        $this->reset();
        $this->showForm = true;
    }

    public function save()
    {
        $this->authorize('manage_settings');
        if ($this->id)
        {
            $payMethod = PaymentMethod::find($this->id);
            $payMethod->update($this->validate());
            $this->reset();
        }
        else
        {
            PaymentMethod::create($this->validate());
            $this->reset();
        }
        $this->success(__('Payment Method saved successfully'));
    }


    public function destroy(PaymentMethod $payMethod)
    {
        $this->authorize('manage_settings');

        $payMethod->delete();
        $this->success(__('Payment Method deleted successfully'));
    }


    public function render()
    {
        $this->authorize('manage_settings');

        return view('livewire.settings.payment-methods', [
            'headers' => $this->headers(),
            'payMethods' => PaymentMethod::all(),
        ]);
    }
}
