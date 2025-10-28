<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.printers') }}" />
    {{-- <x-table :headers='$headers' :rows='$printers' show-empty-text /> --}}
    @if ($responseError)
        <x-alert :title="__(
            'An error occurred while trying to connect to the Print Plug-in. Please check the Print Plug-in settings and ensure it is running.',
        )" class="alert-warning mx-auto w-full lg:w-3/4" icon="o-exclamation-triangle" />
    @else
        <!-- Printers list and Edit Printer form -->
        {{-- <livewire:settings.printers.printers-list :$printers :key="'printers-list-' . count($printers)" /> --}}
        {{-- <div class="flex flex-col-reverse justify-center gap-4 lg:flex-row"> --}}
        <div class="flex flex-col justify-center gap-4">
            <div class="m-auto flex w-full flex-row gap-2 lg:w-3/4">
                <x-card class="m-auto h-full w-full rounded-xl border-neutral-200 dark:border-neutral-700" separator
                    shadow title="{{ __('Available printers') }}">
                    <x-slot:menu>
                        <x-buttons.add responsive wire:click="create" />
                    </x-slot:menu>

                    <x-table :headers='$headers' :rows='$printers' show-empty-text>
                        @scope('actions', $printer)
                            <div class="flex flex-nowrap gap-3">
                                <x-buttons.edit wire:click="edit({{ $printer['id'] }})" />
                                <x-buttons.trash wire:click="destroy({{ $printer['id'] }})" />
                            </div>
                        @endscope
                    </x-table>
                </x-card>
                {{-- <x-card class="m-auto w-full rounded-xl border-neutral-200 lg:w-1/4 dark:border-neutral-700">
                    <x-form wire:submit='save'>
                        @csrf
                        <x-input label="{{ __('labels.name') }}" wire:model="name" />
                        <x-input label="{{ __('labels.model') }}" wire:model="printer_model" />
                        <x-input label="{{ __('labels.ip') }}" wire:model="ip_address" />
                        <x-input label="{{ __('labels.port') }}" wire:model="connection_port" />
                        <x-slot:actions>
                            <x-buttons.save spinner="save" type="submit" />
                            <x-buttons.cancel wire:click="$toggle('showForm')" />
                        </x-slot:actions>
                    </x-form>
                </x-card> --}}
            </div>

            <!-- Edit Printer form -->
            {{-- @if ($showForm) --}}
            {{-- @endif --}}
            {{-- </div>
        <div class="flex flex-col justify-center gap-4" wire:ignore> --}}
            <div wire:ignore>
                <livewire:settings.printers.store-info :key="'store-info'" />

            </div>
            <div wire:ignore>
                <livewire:settings.printers.default-printer :key="'default-printer-' . count($printers)" />

            </div>

            <!-- Default Printer -->
        </div>

        <x-drawer class="w-11/12 lg:w-1/3" close-on-escape right separator title="{{ __('labels.printer') }}"
            wire:model="showForm" with-close-button>

            <x-form wire:submit='save'>
                @csrf
                <x-input label="{{ __('labels.name') }}" wire:model="name" />
                <x-input label="{{ __('labels.model') }}" wire:model="printer_model" />
                <x-input label="{{ __('labels.ip') }}" wire:model="ip_address" />
                <x-input label="{{ __('labels.port') }}" wire:model="connection_port" />
                <x-slot:actions>
                    <x-buttons.save spinner="save" type="submit" />
                    <x-buttons.cancel wire:click="$toggle('showForm')" />
                </x-slot:actions>
            </x-form>
        </x-drawer>
    @endif
</div>
