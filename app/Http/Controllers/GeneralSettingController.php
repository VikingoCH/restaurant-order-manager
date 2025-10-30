<?php

namespace App\Http\Controllers;

use App\Models\AppSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class GeneralSettingController extends Controller
{
    public $appSetting = [
        'id'               => 0,
        'order_prefix'     => "",
        'quick_order_name' => "",
        'tax'              => 0,
        'rows_per_page'    => 0,
    ];


    public function index()
    {
        Gate::authorize('manage_settings');

        $appSetting = AppSetting::sole();

        if ($appSetting)
        {
            $this->appSetting = $appSetting;
        }

        return view('general-settings.index', [
            'appSetting' => $this->appSetting,
        ]);
    }

    public function save(Request $request, $id)
    {
        Gate::authorize('manage_settings');
        $validated = $this->validateForm($request);

        if ($id == 0)
        {
            AppSetting::create($validated);
        }
        else
        {
            AppSetting::where('id', $id)->update($validated);
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
}
