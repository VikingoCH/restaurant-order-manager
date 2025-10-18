<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeneralSettingController extends Controller
{
    public $appSetting = [
        'id'                    => 0,
        'order_prefix'          => "",
        'quick_order_name'      => "",
        'tax'                   => 0,
        'rows_per_page'         => 0,
    ];
    public $receiptInfo = [
        'name'  => "",
        'additional_name'  => "",
        'website' => "",
        'email'   => "",
        'phone'   => "",
        'address' => "",
    ];
    public $responseError = "";

    public function index()
    {
        Gate::authorize('manage_settings');

        $appSetting = AppSetting::sole();

        if ($appSetting)
        {
            $this->appSetting = $appSetting;
        }

        $response = Http::withToken(session('print_plugin_token'))->get(env('APP_PRINT_PLUGIN_URL') . 'store-info');
        if (!$response->json('success'))
        {
            Log::error('Print plug-in - Printers Error: ' . $response->status() . ' / ' . $response->json('errors'));
            $this->responseError = __('Printer Plug-in error: ') . $response->status() . ' / ' . $response->json('errors');
        }
        else
        {
            $this->receiptInfo =  $response->json('data');
        }

        return view('general-settings.index', [
            'appSetting' => $this->appSetting,
            'receiptInfo' => $this->receiptInfo,
            'responseError' => $this->responseError,
        ]);
    }

    public function save(Request $request, $id)
    {
        Gate::authorize('manage_settings');
        $validated = $this->validateForm($request);
        $requestValidated = $this->validateApi($request);

        if ($id == 0)
        {
            AppSetting::create($validated);
        }
        else
        {
            AppSetting::where('id', $id)->update($validated);
        }

        $response = Http::withToken(session('print_plugin_token'))->put(env('APP_PRINT_PLUGIN_URL') . 'store-info', $requestValidated);
        if (!$response->json('success'))
        {
            Log::error('Print plug-in - Save Store Info Error: ' . $response->status() . ' / ' . $response->json('errors'));
        }

        return redirect()->route('settings.general');
    }

    public function validateForm(Request $request)
    {
        return $request->validate([
            'order_prefix'      => 'required|string|max:255',
            'quick_order_name'  => 'required|string|max:255',
            'tax'               => 'required|decimal:0,2',
            'rows_per_page'     => 'required|integer',
        ]);
    }

    public function validateApi(Request $request)
    {
        return $request->validate([
            'name'              => ['required', 'string', 'max:50'],
            'additional_name'   => ['required', 'string', 'max:50'],
            'website'           => ['required', 'string', 'max:100'],
            'email'             => ['required', 'string', 'email'],
            'phone'             => ['required', 'string', 'max:20'],
            'address'           => ['required', 'string', 'max:250'],
        ]);
    }
}
