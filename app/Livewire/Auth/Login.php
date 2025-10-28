<?php

namespace App\Livewire\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Mary\Traits\Toast;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    use Toast;

    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    public function login(): void
    {
        $this->validate();

        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember))
        {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        RateLimiter::clear($this->throttleKey());

        // Print Plugin
        try
        {
            $response = Http::post(env('APP_PRINT_PLUGIN_URL') . 'login', [
                'email' => $this->email,
                'password' => $this->password,
                'is_admin' => Auth::user()->is_admin,
            ]);
        }
        catch (\Exception $e)
        {
            Session::put('print_disabled', true);
            Log::error('Print plug-in - User login Exception: ' . $e->getMessage());
            $this->toastError(__('messages.print_plugin_unreachable'));
            Session::regenerate();
            $this->redirectIntended(default: route('home', absolute: false), navigate: true);
            return;
        }

        if (!isset($response->json()['success']) || !$response->json()['success'])
        {
            Session::put('print_disabled', true);
            Log::error('Print plug-in - User login Error: ' . $response->status());
        }
        else
        {
            Session::put('print_plugin_token', $response->json()['data']['token']);
            Session::put('print_disabled', false);
        }

        Session::regenerate();

        $this->redirectIntended(default: route('home', absolute: false), navigate: true);
    }

    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5))
        {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
