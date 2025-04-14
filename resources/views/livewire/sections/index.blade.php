<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('Configure the sections of the menu') }}"
        title="{{ __('labels.menu_sections') }}">
        <x-slot:actions>
            <x-buttons.add link="{{ route('sections.create') }}" responsive />
        </x-slot:actions>
    </x-header>

    <div class="flex justify-center">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow>
            <div>
                <x-table :headers="$headers" :rows="$menuSections" changeRowOrder
                    empty-text="{{ __('Menu sections not found!') }}" show-empty-text>
                    @scope('cell_orderIcon', $menuSection)
                        <x-icon class="cursor-move text-gray-400" name="c-arrows-up-down" wire:sortable.handle />
                    @endscope
                    @scope('actions', $menuSection)
                        <div class="flex flex-nowrap gap-3">
                            <x-buttons.edit link="{{ route('sections.edit', $menuSection) }}" />
                            <x-buttons.trash wire:click="delete({{ $menuSection->id }})" />
                        @endscope
                </x-table>
            </div>
        </x-card>
    </div>
</div>
