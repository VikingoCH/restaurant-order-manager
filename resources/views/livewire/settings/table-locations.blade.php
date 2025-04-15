<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.table_locations') }}">
    </x-header>
    <div class="flex flex-col-reverse justify-center gap-4 lg:flex-row">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow
            title="{{ __('Available Tables') }}">
            <x-slot:menu>
                <x-buttons.add class="btn-sm" wire:click="create" />
            </x-slot:menu>

            <x-table :headers='$headers' :rows='$locations' changeRowOrder empty-text="{{ __('Nothing to show!') }}"
                show-empty-text>
                @scope('cell_sortable', $menuItem)
                    <x-icon class="cursor-move text-gray-400" name="c-arrows-up-down" wire:sortable.handle />
                @endscope
                @scope('cell_tables', $location)
                    {{ $location->places->count() }}
                @endscope
                @scope('actions', $location)
                    <div class="flex flex-nowrap gap-3">
                        <x-buttons.edit wire:click='edit({{ $location->id }})' />
                        <x-buttons.trash wire:click="destroy({{ $location->id }})" />
                    </div>
                @endscope
            </x-table>
        </x-card>

        <!-- New Payment Method form -->
        @if ($newForm)
            <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700" shadow
                title="{{ __('New Payment Method') }}">
                <x-form wire:submit='store'>
                    <x-input label="{{ __('labels.name') }}" wire:model="name" />
                    <x-input label="{{ __('labels.position') }}" wire:model="position" />
                    <x-input label="{{ __('labels.tables') }}" wire:model="number" />
                    <x-slot:actions>
                        <x-buttons.save spinner="store" type="submit" />
                        <x-buttons.cancel wire:click="$toggle('newForm')" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        @endif

        <!-- Edit Payment Method form -->
        @if ($editForm)
            <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700" shadow
                title="{{ __('Edit Payment Method') }}">
                <x-form wire:submit='update'>
                    <x-input label="Name" wire:model="name" />
                    <x-input label="{{ __('labels.position') }}" wire:model="position" />
                    <x-input label="{{ __('labels.tables') }}" wire:model="number" />
                    <x-slot:actions>
                        <x-buttons.save spinner="store" type="submit" />
                        <x-buttons.cancel wire:click="$toggle('editForm')" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        @endif
    </div>
</div>
