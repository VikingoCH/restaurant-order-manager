    <x-settings.layout :heading="__('labels.delete_account')" :subheading="__('Delete your account and all of its resources')">

        <x-modal
            subtitle="{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}"
            title="{{ __('Are you sure you want to delete your account?') }}" wire:model="delModal">
            <x-form no-separator wire:submit="deleteUser">
                @csrf
                <x-password label="'{{ __('labels.password') }}'" right wire:model="password" />
                <x-slot:actions>
                    <x-button @click="$wire.delModal = false" class="grow" label="{{ __('actions.cancel') }}" />
                    <x-button class="btn-error grow" label="{{ __('actions.confirm') }}" type="submit" />
                </x-slot:actions>
            </x-form>
        </x-modal>

        <x-button @click="$wire.delModal = true" class="btn-error w-full" label="{{ __('labels.delete_account') }}" />
    </x-settings.layout>
