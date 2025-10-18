<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Password extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try
        {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', PasswordRule::defaults(), 'confirmed'],
            ]);
        }
        catch (ValidationException $e)
        {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        //Printer Plugin User password update
        $response = Http::withToken(session('print_plugin_token'))->post(env('APP_PRINT_PLUGIN_URL') . 'update-password', [
            'email' => Auth::user()->email,
            'password' => $validated['password'],
        ]);

        if (!isset($response->json()['success']) || !$response->json()['success'])
        {
            Log::error('Print plug-in - User password reset Error: ' . $response->status());
        }

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}
