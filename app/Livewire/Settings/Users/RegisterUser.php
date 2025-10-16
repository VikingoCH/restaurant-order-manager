<?php

namespace App\Livewire\Settings\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Livewire\Component;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class RegisterUser extends Component
{

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public bool $isAdmin = false;
    public bool $showAlert = false;
    public string $alertMessage = "";

    public function mount(): void
    {
        $this->authorize('manage_users');
    }

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $this->authorize('manage_users');

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['is_admin'] = $this->isAdmin;

        $user = User::create($validated);

        $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'register', [
            'id' => $user->id,
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if (!isset($response->json()['success']))
        {
            $this->showAlert = true;
            $this->alertMessage = __('An error ocurred with printer-plugin. Created user cannot print / ' . $response->status());
            Log::error('Print plug-in - User register Error: ' . $response->status());
        }
        elseif (!$response->json()['success'])
        {
            $this->showAlert = true;
            $errors = "";
            foreach (Arr::flatten($response->json()['errors']) as $key => $error)
            {
                $errors .= $error . ' / ';
            }
            $this->alertMessage = __('An error ocurred with printer-plugin. Created user cannot print / ' . $errors);
            Log::error('Print plug-in - User register Error: ' . $response->status() . ' / ' . $errors);
        }
        else
        {

            $this->success(__('User created successfully'), redirectTo: route('settings.users.list'));
        }
    }
}
