<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Gate;

class GeneralSettingController extends Controller
{

    public function index()
    {
        Gate::authorize('manage_settings');

        $appSetting = AppSetting::first();

        if ($appSetting)
        {
            return view('general-settings.edit', [
                'appSetting' => $appSetting,
            ]);
        }
        else
        {
            return view('general-settings.create');
        }
    }


    public function create(Request $request)
    {
        Gate::authorize('manage_settings');

        $this->validateForm($request);

        AppSetting::create([
            'order_prefix' => $request->order_prefix,
            'quick_order_name' => $request->quick_order_name,
            'tax' => $request->tax,
            'rows_per_page' => $request->rows_per_page,
            'printer_store_name_1' => $request->printer_store_name_1,
            'printer_store_name_2' => $request->printer_store_name_2,
            'printer_store_address' => $request->printer_store_address,
            'printer_store_email' => $request->printer_store_email,
            'printer_store_phone' => $request->printer_store_phone,
            'printer_store_website' => $request->printer_store_website,
        ]);
        return redirect()->route('settings.general');
    }

    public function update(Request $request, $id)
    {
        Gate::authorize('manage_settings');
        $this->validateForm($request);

        $appSetting = AppSetting::find($id);
        $appSetting->order_prefix = $request->order_prefix;
        $appSetting->quick_order_name = $request->quick_order_name;
        $appSetting->tax = $request->tax;
        $appSetting->rows_per_page = $request->rows_per_page;
        $appSetting->printer_store_name_1 = $request->printer_store_name_1;
        $appSetting->printer_store_name_2 = $request->printer_store_name_2;
        $appSetting->printer_store_address = $request->printer_store_address;
        $appSetting->printer_store_email = $request->printer_store_email;
        $appSetting->printer_store_phone = $request->printer_store_phone;
        $appSetting->printer_store_website = $request->printer_store_website;
        $appSetting->save();
        return redirect()->route('settings.general');
    }

    public function validateForm(Request $request)
    {
        $request->validate([
            'order_prefix' => 'required|string|max:255',
            'quick_order_name' => 'required|string|max:255',
            'tax' => 'required|decimal:0,2',
            'rows_per_page' => 'required|integer',
            'printer_store_name_1' => 'required|string|max:100',
            'printer_store_name_2' => 'nullable|string|max:100',
            'printer_store_address' => 'required|string|max:250',
            'printer_store_email' => 'required|email|max:100',
            'printer_store_phone' => 'required|string|max:20',
            'printer_store_website' => 'required|url|max:100',
        ]);
    }
}
