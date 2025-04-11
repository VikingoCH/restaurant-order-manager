<div class="flex flex-col gap-6">
    <x-auth-header :description="__('Enter your email to receive a password reset link')" :title="__('Forgot password')" />

    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" class="text-center" />

    <x-form wire:submit="sendPasswordResetLink">
        <!-- Email Address -->
        <x-input icon="o-at-symbol" label="{{ __('labels.email') }}" placeholder="email@example.com" required type="email"
            wire:model="email" />
        <x-button class="btn-accent w-full" label="{{ __('Email password reset link') }}" type="submit" />
    </x-form>

    <div class="space-x-1 text-center text-sm text-zinc-400">
        {{ __('Or, return to') }}
        <x-button class="btn-ghost text-warning" label="{{ __('actions.log_in') }}" link="{{ route('login') }}" />
    </div>
</div>
