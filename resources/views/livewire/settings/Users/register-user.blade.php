<x-settings.layout :heading="__('Create an account')" :subheading="__('Enter the details below to create an account')">
    <x-form wire:submit="register">

        <x-input icon="o-user" label="{{ __('labels.name') }}" placeholder="{{ __('Full name') }}" required
            wire:model="name" wire:model="name" />

        <x-input icon="o-at-symbol" label="{{ __('labels.email') }}" placeholder="email@example.com" required type="email"
            wire:model="email" />

        <x-password label="{{ __('labels.password') }}" placeholder="{{ __('labels.password') }}" required right
            wire:model="password" />

        <x-password label="{{ __('labels.confirm_password') }}" placeholder="{{ __('labels.confirm_password') }}"
            required right wire:model="password_confirmation" />

        <x-checkbox label="Admin rights" wire:model="isAdmin" />

        <x-button class="btn-secondary w-full" label="{{ __('actions.create_account') }}" type="submit" />
    </x-form>
</x-settings.layout>
