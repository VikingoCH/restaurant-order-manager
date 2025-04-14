<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('Configure the side dishes of the menu') }}"
        title="{{ __('labels.menu_sides') }}">
        <x-slot:actions>
            <x-buttons.add link="{{ route('sides.create') }}" responsive />
        </x-slot:actions>
    </x-header>
    <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow>
        <div>
            <x-table :headers="$headers" :rows="$menuSides" empty-text="{{ __('Side dishes not found!') }}" show-empty-text>
                @scope('actions', $menuSide)
                    <div class="flex flex-nowrap gap-3">
                        <x-buttons.edit link="{{ route('sides.edit', $menuSide) }}" />
                        <x-buttons.trash wire:click="delete({{ $menuSide->id }})" />
                    @endscope
            </x-table>
        </div>
    </x-card>
</div>
