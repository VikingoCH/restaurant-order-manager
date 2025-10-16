<?php

namespace App\Livewire\Profile;

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DeleteUserForm extends Component
{
    public string $password = '';
    public bool $delModal = false;

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        //Delete Print Plugin user
        $response = Http::withToken(session('print_plugin_token'))->delete(env('APP_PRINT_PLUGIN_URL') . 'user/' . Auth::id());

        if (!isset($response->json()['success']))
        {
            Log::error('Print plug-in - User delete Error: ' . $response->status());
        }
        elseif (!$response->json()['success'])
        {
            Log::error('Print plug-in - User delete Error: ' . $response->status() . ' / ' . $response->json()['errors']);
        }

        //Delete App user
        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}
