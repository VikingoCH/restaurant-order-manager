<?php

namespace App\Livewire\Settings\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;

class DeleteUser extends Component
{
    use Toast;

    public $user;
    public string $password = '';

    public function mount($id): void
    {
        $this->authorize('manage_users');

        $this->user = User::find($id);
    }

    public function deleteUser(): void
    {
        $this->authorize('manage_users');

        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        if (Auth::check())
        {
            $response = Http::withToken(session('print_plugin_token'))->delete(env('APP_PRINT_PLUGIN_URL') . 'user/' . $this->user->id);

            if (!isset($response->json()['success']))
            {
                Log::error('Print plug-in - User delete Error: ' . $response->status());
            }
            elseif (!$response->json()['success'])
            {
                Log::error('Print plug-in - User delete Error: ' . $response->status() . ' / ' . $response->json()['errors']);
            }

            User::destroy($this->user->id);

            $this->success(__('User deleted successfully'), redirectTo: route('settings.users.list'));
        }
    }
}
