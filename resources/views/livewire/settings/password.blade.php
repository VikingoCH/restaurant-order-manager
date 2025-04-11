    <x-settings.layout :heading="__('labels.update_password')" :subheading="__('Ensure your account is using a long, random password to stay secure')">
        <x-form wire:submit="updatePassword">
            <x-password label="{{ __('labels.current_password') }}" right wire:model="current_password" />
            <x-password label="{{ __('labels.new_password') }}" right wire:model="password" />
            <x-password label="{{ __('labels.confirm_password') }}" right wire:model="password_confirmation" />
            <x-button class="btn-secondary w-full" type="submit">{{ __('actions.save') }}</x-button>

        </x-form>
    </x-settings.layout>
