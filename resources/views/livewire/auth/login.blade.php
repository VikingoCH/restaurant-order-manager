<div class="flex flex-col gap-6">
    <x-auth-header :description="__('Enter your email and password below to log in')" :title="__('Log in to your account')" />

    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" class="text-center" />
    <x-form wire:submit="login">
        <x-input icon="o-at-symbol" label="{{ __('labels.email') }}" placeholder="email@example.com" required type="email"
            wire:model="email" />
        <div class="relative">

            <x-password label="{{ __('labels.password') }}" placeholder="{{ __('labels.password') }}" required right
                wire:model="password" />
            @if (Route::has('password.request'))
                <x-button class="btn-ghost text-success absolute right-0 top-0 text-sm"
                    label="{{ __('Forgot your password?') }}" link="{{ route('password.request') }}" />
            @endif
        </div>
        <x-checkbox label="{{ __('Remember me') }}" wire:model="remember" />
        <x-button class="btn-accent w-full" label="{{ __('actions.log_in') }}" type="submit" />
    </x-form>

    @if (Route::has('register'))
        <div class="space-x-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __('Don\'t have an account?') }}
            <x-button class="btn-ghost text-warning" label="{{ __('actions.sign_up') }}"
                link="{{ route('register') }}" />
        </div>
    @endif
</div>
