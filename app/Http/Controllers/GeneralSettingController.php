<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Mary\Traits\Toast;

class GeneralSettingController extends Controller
{
    use Toast;

    public function index()
    {
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
        $request->validate([
            'order_prefix' => 'required|string|max:255',
            'tax' => 'required|decimal:0,2',
            'rows_per_page' => 'required|integer',
        ]);
        AppSetting::create([
            'order_prefix' => $request->order_prefix,
            'tax' => $request->tax,
            'rows_per_page' => $request->rows_per_page,
        ]);
        return redirect()->route('settings.general');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'order_prefix' => 'required|string|max:255',
            'tax' => 'required|decimal:0,2',
            'rows_per_page' => 'required|integer',
        ]);
        // dd($request->rows_per_page);

        $appSetting = AppSetting::find($id);
        $appSetting->order_prefix = $request->order_prefix;
        $appSetting->tax = $request->tax;
        $appSetting->rows_per_page = $request->rows_per_page;
        $appSetting->save();
        return redirect()->route('settings.general');
    }
}
