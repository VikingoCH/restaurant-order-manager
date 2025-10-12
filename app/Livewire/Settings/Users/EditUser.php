<?php

namespace App\Livewire\Settings\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class EditUser extends Component
{

    public string $userId;
    public string $name;
    public string $email;
    public bool $isAdmin;

    public function mount($id): void
    {
        $this->authorize('manage_users');

        $user = User::find($id);
        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->isAdmin = $user->is_admin;
    }

    public function updateUser()
    {
        $this->authorize('manage_users');

        $user = User::find($this->userId);

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
        ]);

        $validated['is_admin'] = $this->isAdmin;

        $user->fill($validated);

        if ($user->isDirty('email'))
        {
            $user->email_verified_at = null;
        }

        $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'update-user', [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        if (!isset($response->json()['success']) && $response->status() >= 400)
        {
            $this->warning($response->status());
        }
        elseif (!$response->json()['success'])
        {
            $this->warning('print-plugin: ' . $response->json()['message']);
        }

        $user->save();


        $this->redirect(route('settings.users.list'));
    }
}
