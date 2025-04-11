    <x-settings.layout :heading="__('labels.profile')" :subheading="__('Update your name and email address')">
        <x-form wire:submit="updateUser">
            @csrf
            <x-input autofocus icon="o-user" label="{{ __('labels.name') }}" placeholder="name" required
                wire:model="name" />
            <x-input icon="o-at-symbol" label="{{ __('labels.email') }}" placeholder="email" required type="email"
                wire:model="email" />
            <x-checkbox label="Admin rights" wire:model="isAdmin" />

            <x-button class="btn-secondary w-full" type="submit">{{ __('actions.save') }}</x-button>
        </x-form>

    </x-settings.layout>
