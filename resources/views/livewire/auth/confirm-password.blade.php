<div class="flex flex-col gap-6">
    <x-auth-header :description="__('This is a secure area of the application. Please confirm your password before continuing.')" :title="__('labels.confirm_password')" />

    <!-- Session Status -->
    <x-auth-session-status :status="session('status')" class="text-center" />

    <x-form class="flex flex-col gap-6" wire:submit="confirmPassword">
        <!-- Password -->
        <x-password label="{{ __('labels.password') }}" placeholder="{{ __('labels.password') }}" required right
            wire:model="password" />

        <x-button class="btn-accent w-full" type="submit">{{ __('actions.confirm') }}</x-button>
    </x-form>
</div>
