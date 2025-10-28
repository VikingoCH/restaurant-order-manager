<?php

namespace App\Livewire\Settings\Printers;

use App\Models\AppSetting;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On;
use Mary\Traits\Toast;

class DefaultPrinter extends Component
{
    use Toast;

    public $printers = [];

    #[Validate('required|integer')]
    public $defaultPrinter = 0;

    public function mount()
    {
        $this->defaultPrinter = AppSetting::sole()->default_printer;
        $this->getPrinters();
    }

    #[On('printerUpdated')]
    public function getPrinters()
    {
        try
        {
            $response = Http::withToken(session('print_plugin_token'))->get(env('APP_PRINT_PLUGIN_URL') . 'printers');
            if (!$response->json('success'))
            {
                Log::error('Print plug-in - Printers Error: ' . $response->status() . ' / ' . $response->json('errors'));
                $this->printers =  [];
                return;
            }
        }
        catch (\Exception $e)
        {
            Log::error('Print plug-in - Printers Exception: ' . $e->getMessage());
            $this->printers =  [];
            return;
        }
        log::alert('Print plug-in: ' . $response->body());
        $this->printers =  $response->json('data');
    }

    public function save()
    {
        $appSetting = AppSetting::sole();
        $data = $this->validate();
        $appSetting->default_printer = $data['defaultPrinter'];
        $appSetting->save();

        $this->defaultPrinter = $data['defaultPrinter'];
        $this->success(__('Deafult printer updated successfully'));
    }

    public function render()
    {
        return view('livewire.settings.printers.default-printer');
    }
}
