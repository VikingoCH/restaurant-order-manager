<div class="{{ $menuItemsClass }}">

    <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
        title="{{ $sectionName }}">
        <x-slot:menu>
            <x-button class="btn-ghost btn-sm" icon="o-x-mark" wire:click="closeMenuItems" />
        </x-slot:menu>
        <x-input icon="o-magnifying-glass" placeholder="Search ..." wire:model.live.debounce="search" />

        @foreach ($menuItems as $menuItem)
            <x-list-item :item="$menuItem" avatar="image_path" class="w-full">
                {{-- <x-list-item :item="$menuItem" class="w-full"> --}}
                <x-slot:avatar>
                    <a class="cursor-pointer" link="#" wire:click.prevent='add({{ $menuItem->id }})'>
                        @if ($menuItem->image_path != null)
                            <x-avatar class="!w-10 !rounded-lg"
                                image="{{ asset('storage/' . $menuItem->image_path) }}" />
                        @else
                            <x-avatar class="!w-10 !rounded-lg"
                                image="{{ asset('storage/no-image-placeholder.svg') }}" />
                        @endif
                    </a>
                </x-slot:avatar>
                <x-slot:value>
                    <a class="cursor-pointer" link="#" wire:click.prevent='add({{ $menuItem->id }})'>
                        {{ $menuItem->name }}
                    </a>
                </x-slot:value>
                <x-slot:sub-value>
                    <a class="cursor-pointer" link="#" wire:click.prevent='add({{ $menuItem->id }})'>
                        {{ ' [CHF ' . $menuItem->price . ' ]' }}
                    </a>
                </x-slot:sub-value>
                <x-slot:actions>
                    <x-buttons.edit-icon wire:click='addForm({{ $menuItem->id }})' />
                </x-slot:actions>
            </x-list-item>
        @endforeach
    </x-card>
    <!-- Edit menu item before add  -->

    <x-drawer class="w-11/12 lg:w-1/3" close-on-escape right separator title="{{ $editMenuItem->name ?? '' }}"
        wire:model="openAddForm" with-close-button>
        {{-- {{ var_dump(count($editItem)) }} --}}
        @if ($editMenuItem != null)
            <x-form wire:submit='add({{ $editMenuItem->id }})'>
                <x-textarea label="{{ __('labels.remarks') }}" rows="3" wire:model.live='orderNotes' />
                @if ($editMenuItem->menuFixedSides->count() || $editMenuItem->menuSelectableSides->count())
                    <h3 class="fieldset-legend mb-0.5">{{ __('labels.sides') }}</h3>

                    <div class="grid grid-cols-2 items-center">
                        <div>
                            @foreach ($editMenuItem->menuFixedSides as $side)
                                {{-- @if (in_array($side->id, $fixedSides)) --}}
                                <x-checkbox label='{{ $side->name }}' value='{{ $side->id }}'
                                    wire:model.live='fixedSides' />
                                {{-- @endif --}}
                            @endforeach
                        </div>
                        <div>
                            <x-radio :options="$editMenuItem->menuSelectableSides" wire:model="selectableSides" />
                        </div>
                    </div>
                @endif

                <x-slot:actions>
                    <x-button label="{{ __('labels.cancel') }}" wire:click="$toggle('openAddForm')" />
                    {{-- @if ($menuItem != null) --}}
                    <x-button class="btn-primary" icon="o-check" label="{{ __('labels.add') }}" type='submit' />
                    {{-- wire:click='add({{ $menuItem->id }})' /> --}}
                    {{-- @endif --}}
                </x-slot:actions>
            </x-form>
        @endif
    </x-drawer>
</div>
