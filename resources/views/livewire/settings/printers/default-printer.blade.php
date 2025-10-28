<!-- Default Printer -->
<x-form wire:submit='save'>
    <x-card class="m-auto w-full rounded-xl border-neutral-200 lg:w-3/4 dark:border-neutral-700" shadow
        subtitle="{{ __('Define the printer used for invoice and cash close receipts.') }}"
        title="{{ __('Default Printer') }}">

        <x-slot:menu>
            <x-buttons.save spinner="save" type="submit" />
        </x-slot:menu>

        <x-choices :options="$printers" icon="o-printer" single wire:model="defaultPrinter" />
    </x-card>
</x-form>
