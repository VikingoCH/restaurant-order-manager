<?php

namespace App\Livewire\Settings\Printers;

use Livewire\Attributes\Validate;
use Livewire\Component;
use Mary\Traits\Toast;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StoreInfo extends Component
{
    use Toast;

    public $storeInfo;

    #[Validate('required|string|max:50')]
    public $name = "";
    // public $storeName = "";
    #[Validate('required|string|max:50')]
    public $additional_name = "";
    // public $storeAdditionalName = "";
    #[Validate('required|string|max:100')]
    public $website = "";
    // public $storeWebsite = "";
    #[Validate('required|string|email')]
    public $email = "";
    // public $storeEmail = "";
    #[Validate('required|string|max:20')]
    public $phone = "";
    // public $storePhone = "";
    #[Validate('required|string|max:250')]
    public $address = "";
    // public $storeAddress = "";
    // #[Validate('required|integer')]
    // public $defaultPrinter = 0;

    public function mount()
    {
        $this->fill($this->getStoreInfo());
        // $this->storeName = $this->storeInfo['name'] ?? "";
        // $this->storeAdditionalName = $this->storeInfo['additional_name'] ?? "";
        // $this->storeAddress = $this->storeInfo['address'] ?? "";
        // $this->storePhone = $this->storeInfo['phone'] ?? "";
        // $this->storeEmail = $this->storeInfo['email'] ?? "";
        // $this->storeWebsite = $this->storeInfo['website'] ?? "";
    }

    public function getStoreInfo()
    {
        try
        {
            $response = Http::withToken(session('print_plugin_token'))->get(env('APP_PRINT_PLUGIN_URL') . 'store-info');
            if (!$response->json('success'))
            {
                Log::error('Print plug-in - Store Info Error: ' . $response->status() . ' / ' . $response->json('errors'));
                // $this->responseError = true;
                return [];
            }
        }
        catch (\Exception $e)
        {
            Log::error('Print plug-in - Printers Exception: ' . $e->getMessage());
            // $this->responseError = true;
            return [];
        }
        return $response->json('data');
    }

    public function save()
    {
        $this->authorize('manage_settings');
        $data = $this->validate();
        // dd($data);
        $response = Http::withToken(session('print_plugin_token'))->put(env('APP_PRINT_PLUGIN_URL') . 'store-info', $data);
        if ($response->json('success'))
        {
            $this->success(__('Store info updated successfully'));
            $this->fill($response->json('data'));
        }
        else
        {
            Log::error('Print plug-in - Save Store Info Error: ' . $response->status() . ' / ' . $response->json('errors'));
            $this->warning(__('Print plug-in - Save Store Info Error: ') . $response->status() . ' / ' . $response->json('errors'));
        }
    }

    public function render()
    {
        return view('livewire.settings.printers.store-info');
    }
}
