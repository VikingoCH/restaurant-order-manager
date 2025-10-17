<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.printers') }}">
        <x-slot:actions>
            <x-buttons.add responsive wire:click="create" />
        </x-slot:actions>
    </x-header>
    <div class="flex flex-col-reverse justify-center gap-4 lg:flex-row">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow
            title="{{ __('Available printers') }}">

            <x-table :empty-text='$responseError' :headers='$headers' :rows='$printers' show-empty-text>
                @scope('actions', $printer)
                    <div class="flex flex-nowrap gap-3">
                        <x-buttons.edit wire:click="edit({{ $printer['id'] }})" />
                        <x-buttons.trash wire:click="destroy({{ $printer['id'] }})" />
                    </div>
                @endscope
            </x-table>

        </x-card>

        <!-- Edit Printer form -->
        @if ($showForm)
            <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700" shadow
                title="{{ __('labels.printer') }}">

                <x-form wire:submit='save'>
                    @csrf
                    <x-input label="{{ __('labels.name') }}" wire:model="name" />
                    <x-input label="{{ __('labels.model') }}" wire:model="printer_model" />
                    {{-- <x-input label="{{ __('labels.location') }}" wire:model="location" /> --}}
                    <x-input label="{{ __('labels.ip') }}" wire:model="ip_address" />
                    <x-input label="{{ __('labels.port') }}" wire:model="connection_port" />
                    <x-slot:actions>
                        <x-buttons.save spinner="save" type="submit" />
                        <x-buttons.cancel wire:click="$toggle('showForm')" />
                    </x-slot:actions>
                </x-form>

            </x-card>
        @endif
    </div>
</div>
