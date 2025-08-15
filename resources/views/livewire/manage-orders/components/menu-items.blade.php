<x-drawer class="w-11/12 lg:w-1/3" close-on-escape right separator title="{{ $sectionName ?? '' }}"
    wire:model="openMenuItems" with-close-button>
    <x-input icon="o-magnifying-glass" placeholder="Search ..." wire:model.live.debounce="search" />
    @foreach ($menuItems as $menuItem)
        <x-list-item :item="$menuItem" avatar="image_path" class="w-full" no-hover>
            <x-slot:avatar>
                <a class="cursor-pointer" link="#" wire:click.prevent='add({{ $menuItem->id }})'>
                    @if ($menuItem->image_path != null)
                        <x-avatar class="!w-10 !rounded-lg" image="{{ asset('storage/' . $menuItem->image_path) }}" />
                    @else
                        <x-avatar class="!w-10 !rounded-lg" image="{{ asset('storage/no-image-placeholder.svg') }}" />
                    @endif
                </a>
            </x-slot:avatar>
            <x-slot:value>
                <a class="cursor-pointer" link="#" wire:click.prevent='add({{ $menuItem->id }})'>
                    {{ $menuItem->name . ' [CHF ' . $menuItem->price . ' ]' }}
                </a>
            </x-slot:value>
            <x-slot:sub-value>
                @if ($menuItem->menuFixedSides->count() || $menuItem->menuSelectableSides->count())
                    <x-button class="btn-ghost btn-sm" icon="o-plus" wire:click='showOptions({{ $menuItem->id }})' />
                @endif
                @if (@isset($itemOptions) && $itemOptions == $menuItem->id)
                    {{-- <div class="{{ $menuItemsClass }}"> --}}
                    <div>
                        <x-input label="{{ __('labels.remarks') }}" wire:model.live='orderNotes' />
                        @if ($menuItem->menuFixedSides->count() || $menuItem->menuSelectableSides->count())
                            <h3 class="fieldset-legend mb-0.5">{{ __('labels.sides') }}</h3>

                            <div class="grid grid-cols-2 items-center">
                                <div>
                                    @foreach ($menuItem->menuFixedSides as $side)
                                        {{-- @if (in_array($side->id, $fixedSides)) --}}
                                        <x-checkbox label='{{ $side->name }}' value='{{ $side->id }}'
                                            wire:model.live='fixedSides' />
                                        {{-- @endif --}}
                                    @endforeach
                                </div>
                                <div>
                                    <x-radio :options="$menuItem->menuSelectableSides" wire:model="selectableSides" />
                                </div>
                            </div>
                        @endif
                    </div>
                @endif
            </x-slot:sub-value>
        </x-list-item>
    @endforeach
</x-drawer>
