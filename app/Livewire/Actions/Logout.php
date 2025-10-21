<?php

namespace App\Livewire\Actions;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Mary\Traits\Toast;

class Logout
{
    use Toast;

    public function __invoke()
    {
        if (session('print_plugin_token'))
        {
            $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'logout');

            if (isset($response->json()['success']) && $response->json()['success'])
            {
                Session::forget('print_plugin_token');
            }
        }

        Auth::guard('web')->logout();

        Session::invalidate();
        Session::regenerateToken();

        return redirect('/');
    }
}
