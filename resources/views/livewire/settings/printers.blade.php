<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.printers') }}">
    </x-header>
    <div class="flex flex-row gap-4">
        <x-card class="grow rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('Available printers') }}">
            <x-slot:menu>
                <x-button class="btn-sm btn-primary" icon="o-plus" tooltip="{{ __('labels.add') }}" wire:click="create" />
            </x-slot:menu>

            <x-table :headers='$headers' :rows='$printers' empty-text="{{ __('Nothing to show!') }}" show-empty-text>
                @scope('actions', $printer)
                    <div class="flex flex-nowrap gap-3">
                        <x-button class="btn-sm text-primary" icon="o-pencil" spinner tooltip="{{ __('labels.edit') }}"
                            wire:click='edit({{ $printer->id }})' />
                        <x-button class="btn-sm text-error" icon="o-trash" spinner tooltip="{{ __('labels.delete') }}"
                            wire:click="destroy({{ $printer->id }})" wire:confirm="{{ __('Are you sure?') }}" />
                    </div>
                @endscope
            </x-table>
        </x-card>

        <!-- New Printer form -->
        @if ($newForm)
            <x-card class="grow rounded-xl border border-neutral-200 dark:border-neutral-700" shadow
                title="{{ __('New Printer') }}">
                <x-form wire:submit='store'>
                    <x-input label="{{ __('labels.name') }}" wire:model="name" />
                    <x-input label="{{ __('labels.identifier') }}" wire:model="identifier" />
                    <x-input label="{{ __('labels.location') }}" wire:model="location" />
                    <x-input label="{{ __('labels.ip') }}" wire:model="ip_address" />
                    <x-input label="{{ __('labels.conection') }}" wire:model="conection_type" />
                    <x-slot:actions>
                        <x-button label="{{ __('labels.cancel') }}" wire:click="$toggle('newForm')" />
                        <x-button class="btn-primary" label="{{ __('labels.add') }}" spinner="store" type="submit" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        @endif

        <!-- Edit Printer form -->
        @if ($editForm)
            <x-card class="grow rounded-xl border border-neutral-200 dark:border-neutral-700" shadow
                title="{{ __('Edit Printer') }}">
                <x-form wire:submit='update'>
                    <x-input label="{{ __('labels.name') }}" wire:model="name" />
                    <x-input label="{{ __('labels.identifier') }}" wire:model="identifier" />
                    <x-input label="{{ __('labels.location') }}" wire:model="location" />
                    <x-input label="{{ __('labels.ip') }}" wire:model="ip_address" />
                    <x-input label="{{ __('labels.conection') }}" wire:model="conection_type" />
                    <x-slot:actions>
                        <x-button label="{{ __('labels.cancel') }}" wire:click="$toggle('editForm')" />
                        <x-button class="btn-primary" label="{{ __('labels.save') }}" spinner="store" type="submit" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        @endif
    </div>
</div>
