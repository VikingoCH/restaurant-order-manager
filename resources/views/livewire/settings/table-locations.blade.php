<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.table_locations') }}">
    </x-header>
    <div class="flex flex-row gap-4">
        <x-card class="grow rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('Available Tables') }}">
            <x-slot:menu>
                <x-button class="btn-sm btn-primary" icon="o-plus" tooltip="{{ __('labels.add') }}" wire:click="create" />
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
                        <x-button class="btn-sm text-primary" icon="o-pencil" spinner tooltip="{{ __('labels.edit') }}"
                            wire:click='edit({{ $location->id }})' />
                        <x-button class="btn-sm text-error" icon="o-trash" spinner tooltip="{{ __('labels.delete') }}"
                            wire:click="destroy({{ $location->id }})" wire:confirm="{{ __('Are you sure?') }}" />
                    </div>
                @endscope
            </x-table>
        </x-card>

        <!-- New Payment Method form -->
        @if ($newForm)
            <x-card class="grow rounded-xl border border-neutral-200 dark:border-neutral-700" shadow
                title="{{ __('New Payment Method') }}">
                <x-form wire:submit='store'>
                    <x-input label="{{ __('labels.name') }}" wire:model="name" />
                    <x-input label="{{ __('labels.position') }}" wire:model="position" />
                    <x-input label="{{ __('labels.tables') }}" wire:model="number" />
                    <x-slot:actions>
                        <x-button label="{{ __('labels.cancel') }}" wire:click="$toggle('newForm')" />
                        <x-button class="btn-primary" label="{{ __('labels.add') }}" spinner="store" type="submit" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        @endif

        <!-- Edit Payment Method form -->
        @if ($editForm)
            <x-card class="grow rounded-xl border border-neutral-200 dark:border-neutral-700" shadow
                title="{{ __('Edit Payment Method') }}">
                <x-form wire:submit='update'>
                    <x-input label="Name" wire:model="name" />
                    <x-input label="{{ __('labels.position') }}" wire:model="position" />
                    <x-input label="{{ __('labels.tables') }}" wire:model="number" />
                    <x-slot:actions>
                        <x-button label="{{ __('labels.cancel') }}" wire:click="$toggle('editForm')" />
                        <x-button class="btn-primary" label="{{ __('labels.save') }}" spinner="store" type="submit" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        @endif
    </div>
</div>
