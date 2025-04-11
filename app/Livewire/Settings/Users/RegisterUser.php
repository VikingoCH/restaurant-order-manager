<?php

namespace App\Livewire\Settings\Users;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Component;

class RegisterUser extends Component
{
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

        event(new Registered(($user = User::create($validated))));

        // Auth::login($user);

        // $this->redirect(route('home', absolute: false), navigate: true);

        // $this->success(__('User Created Successfully'));
        $this->redirect(route('settings.users.list'));
    }
}
