<?php

namespace App\Livewire\Settings\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class EditUser extends Component
{

    public string $userId;
    public string $name;
    public string $email;
    public bool $isAdmin;
    public bool $showAlert = false;
    public string $alertMessage = "";

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
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)]
        ]);

        $validated['is_admin'] = $this->isAdmin;

        $user->fill($validated);

        if ($user->isDirty('email'))
        {
            $user->email_verified_at = null;
        }

        $user->save();

        $response = Http::withToken(session('print_plugin_token'))->put(env('APP_PRINT_PLUGIN_URL') . 'user/' . $user->id, [
            'name' => $user->name,
            'email' => $user->email,
        ]);

        if (!isset($response->json()['success']))
        {
            $this->showAlert = true;
            $this->alertMessage = __('Print plug-in - User edit Error:  ' . $response->status());
            Log::error('Print plug-in - User edit Error: ' . $response->status());
        }
        elseif (!$response->json()['success'])
        {
            $this->showAlert = true;
            $errors = "";
            foreach (Arr::flatten($response->json()['errors']) as $key => $error)
            {
                $errors .= $error . ' / ';
            }
            Log::error('Print plug-in - User edit Error: ' . $response->status() . ' / ' . $errors);
        }



        $this->redirect(route('settings.users.list'));
    }
}
