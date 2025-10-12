<?php

namespace App\Livewire\Settings\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Mary\Traits\Toast;

class DeleteUser extends Component
{
    use Toast;
    // public string $userId;
    // public string $name;
    // public string $email;
    // public bool $isAdmin;
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
            $response = Http::withToken(session('print_plugin_token'))->delete(env('APP_PRINT_PLUGIN_URL') . 'delete-user', [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ]);


            if (!isset($response->json()['success']) && $response->status() >= 400)
            {
                $this->warning($response->status());
            }
            elseif (!$response->json()['success'])
            {
                $this->warning('print-plugin: ' . $response->json()['message']);
            }

            User::destroy($this->user->id);

            $this->success(__('User deleted successfully'), redirectTo: route('settings.users.list'));
        }
    }
}
