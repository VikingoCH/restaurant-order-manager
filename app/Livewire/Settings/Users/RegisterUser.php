<?php

namespace App\Livewire\Settings\Users;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Mary\Traits\Toast;

class RegisterUser extends Component
{
    use Toast;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public bool $isAdmin = false;

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

        User::create($validated);

        $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'register', [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
        ]);

        if (!isset($response->json()['success']) && $response->status() >= 400)
        {
            $this->warning($response->status());
        }
        elseif (!$response->json()['success'])
        {
            $this->warning('print-plugin: ' . $response->json()['message']);
        }

        $this->success(__('User created successfully'), redirectTo: route('settings.users.list'));
    }
}
