<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('Configure your menu') }}"
        title="{{ __('labels.menu_items') }}">
        <x-slot:actions>
            @if (!$sections->isEmpty())
                <x-buttons.add link="{{ route('menu.create') }}" responsive />
            @endif
        </x-slot:actions>
    </x-header>
    <div class="flex justify-center">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow>
            @if ($sections->isEmpty())
                <x-alert class="alert-warning alert-soft"
                    description="{{ __('Create first at least one section to include items in the menu') }}"
                    icon="o-exclamation-triangle" title="{{ __('No menu sections found') }}">
                    <x-slot:actions>
                        <x-buttons.add link="{{ route('sections.index') }}" />
                    </x-slot:actions>
                </x-alert>
            @else
                <x-tabs selected="{{ 'tab-' . $activeTab }}">
                    @foreach ($sections as $section)
                        <x-tab label="{{ $section->name }}" name="{{ 'tab-' . $section->id }}">
                            <div>
                                <x-table :headers="$headers" :rows="$section->menuItems()->orderBy('position', 'asc')->get()" changeRowOrder
                                    empty-text="{{ __('This menu section is empty!') }}" show-empty-text>
                                    @scope('cell_orderIcon', $menuItem)
                                        <x-icon class="cursor-move text-gray-400" name="c-arrows-up-down"
                                            wire:sortable.handle />
                                    @endscope
                                    @scope('cell_image_path', $menuItem)
                                        @if ($menuItem->image_path != null)
                                            <x-avatar class="!w-10 !rounded-lg"
                                                image="{{ asset('storage/' . $menuItem->image_path) }}" />
                                        @else
                                            <x-avatar class="!w-10 !rounded-lg"
                                                image="{{ asset('storage/no-image-placeholder.svg') }}" />
                                        @endif
                                    @endscope
                                    @scope('actions', $menuItem)
                                        <div class="flex flex-nowrap gap-3">
                                            <x-buttons.edit link="{{ route('menu.edit', $menuItem) }}" />
                                            <x-buttons.trash wire:click="delete({{ $menuItem->id }})" />
                                        </div>
                                    @endscope
                                </x-table>
                            </div>
                        </x-tab>
                    @endforeach
                </x-tabs>

            @endif
        </x-card>
    </div>
</div>
