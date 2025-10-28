<!-- Receipt Store Info -->
<x-form wire:submit='save'>
    <x-card class="m-auto w-full rounded-xl border-neutral-200 lg:w-3/4 dark:border-neutral-700" shadow
        subtitle="{{ __('Define the data to be shown in the header / footer of the receipt.') }}"
        title="{{ __('Receipt Restaurant Info') }}">

        <x-slot:menu>
            <x-buttons.save spinner="save" type="submit" />
        </x-slot:menu>

        <x-input :label="__('Store Name')" wire:model="name" />
        <x-input :label="__('Additional Store Name')" wire:model="additional_name" />
        <x-input :label="__('Store Address')" wire:model="address" />
        <x-input :label="__('Store Phone')" wire:model="phone" />
        <x-input :label="__('Store Email')" wire:model="email" />
        <x-input :label="__('Store Website')" wire:model="website" />
    </x-card>
</x-form>
