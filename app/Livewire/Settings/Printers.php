<?php

namespace App\Livewire\Settings;

use App\Models\Printer;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;

class Printers extends Component
{
    use Toast;

    #[Validate('required|string|max:150')]
    public $name = '';

    #[Validate('required|string|max:150')]
    public $printer_model = '';


    #[Validate('ip')]
    public $ip_address = '';

    #[Validate('required|integer')]
    public $connection_port = 0;

    public $id;
    public $responseError = "";

    public $showForm = false;

    public function headers()
    {
        return [
            ['key' => 'id', 'label' => '#', 'class' => 'w-1'],
            ['key' => 'name', 'label' => __('labels.name')],
            ['key' => 'printer_model', 'label' => __('labels.model')],
            ['key' => 'ip_address', 'label' => __('labels.ip')],
            ['key' => 'connection_port', 'label' => __('labels.port')],
        ];
    }

    public function printers()
    {
        $response = Http::withToken(session('print_plugin_token'))->get(env('APP_PRINT_PLUGIN_URL') . 'printers');
        if (!$response->json('success'))
        {
            Log::error('Print plug-in - Printers Error: ' . $response->status() . ' / ' . $response->json('errors'));
            $this->responseError = __('Printer Plug-in error: ') . $response->status() . ' / ' . $response->json('errors');
            return [];
        }
        return $response->json('data');
    }


    public function edit($id)
    {
        $this->authorize('manage_settings');

        $response = Http::withToken(session('print_plugin_token'))->get(env('APP_PRINT_PLUGIN_URL') . 'printer/' . $id);
        if (!$response->json('success'))
        {
            Log::error('Print plug-in - List Printers Error: ' . $response->status() . ' / ' . $response->json('errors'));
            $this->warning(__('Printer Plug-in error: ') . $response->status() . ' / ' . $response->json('errors'));
            return;
        }
        $printer = $response->json('data');

        $this->reset();
        $this->fill($printer);
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
        $data = $this->validate();
        if ($this->id)
        {
            $response = Http::withToken(session('print_plugin_token'))->put(env('APP_PRINT_PLUGIN_URL') . 'printer/' . $this->id, [
                'name'            => $data['name'],
                'printer_model'   => $data['printer_model'],
                'ip_address'      => $data['ip_address'],
                'connection_port' => $data['connection_port']
            ]);

            $this->reset();
        }
        else
        {
            $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'printer', [
                'name'            => $data['name'],
                'printer_model'   => $data['printer_model'],
                'ip_address'      => $data['ip_address'],
                'connection_port' => $data['connection_port']
            ]);

            $this->reset();
        }

        if ($response->json('success'))
        {
            $this->success(__('Printer saved successfully'));
        }
        else
        {
            Log::error('Print plug-in - Save Printer Error: ' . $response->status() . ' / ' . $response->json('errors'));
            $this->warning(__('Printer Plug-in error: ') . $response->status() . ' / ' . $response->json('errors'));
        }
    }

    public function destroy($id)
    {
        $this->authorize('manage_settings');

        $response = Http::withToken(session('print_plugin_token'))->delete(env('APP_PRINT_PLUGIN_URL') . 'printer/' . $id);

        if ($response->json('success'))
        {
            $this->success(__('Printer deleted successfully'));
        }
        else
        {
            Log::error('Print plug-in - Destroy Printer Error: ' . $response->status() . ' / ' . $response->json('errors'));
            $this->warning(__('Printer Plug-in error: ') . $response->status() . ' / ' . $response->json('errors'));
        }
    }

    public function render()
    {
        $this->authorize('manage_settings');

        return view('livewire.settings.printers', [
            'headers' => $this->headers(),
            'printers' => $this->printers(),
        ]);
    }
}
