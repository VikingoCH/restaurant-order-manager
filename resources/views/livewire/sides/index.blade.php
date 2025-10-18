<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('Configure the side dishes of the menu') }}"
        title="{{ __('labels.menu_sides') }}">
        <x-slot:actions>
            <x-buttons.add responsive wire:click="create" />
        </x-slot:actions>
    </x-header>

    <div class="flex flex-col-reverse justify-center gap-4 lg:flex-row">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow>
            <div>
                <x-table :headers="$headers" :rows="$menuSides" changeRowOrder
                    empty-text="{{ __('Side dishes not found!') }}" show-empty-text>
                    @scope('cell_orderIcon', $menuSide)
                        <x-icon class="cursor-move text-gray-400" name="c-arrows-up-down" wire:sortable.handle />
                    @endscope
                    @scope('actions', $menuSide)
                        <div class="flex flex-nowrap gap-3">
                            <x-buttons.edit wire:click="edit({{ $menuSide->id }})" />
                            <x-buttons.trash wire:click="destroy({{ $menuSide->id }})" />
                        @endscope
                </x-table>
            </div>
        </x-card>

        @if ($showForm)
            <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700" separator
                shadow>
                <x-form wire:submit="save">
                    @csrf
                    <x-input label="{{ __('labels.name') }}" wire:model.blur="name" />
                    <x-slot:actions separator>
                        <x-buttons.save spinner="save" type="submit" />
                        <x-buttons.cancel wire:click="$toggle('showForm')" />
                    </x-slot:actions>
                </x-form>
            </x-card>
        @endif

    </div>
</div>
