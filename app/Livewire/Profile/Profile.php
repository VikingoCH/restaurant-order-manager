<?php

namespace App\Livewire\Profile;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;

class Profile extends Component
{
    public string $name = '';
    public string $email = '';
    public bool $showAlert = false;
    public string $alertMessage = "";
    public $token;

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
        $this->token = session('print_plugin_token');
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

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

        $user->fill($validated);

        if ($user->isDirty('email'))
        {
            $user->email_verified_at = null;
        }

        $user->save();

        //Printer Plugin User profile update
        $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'user/' . $user->id, [
            'name' => $validated['name'],
            'email' => $validated['email'],
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

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail())
        {
            $this->redirectIntended(default: route('home', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
