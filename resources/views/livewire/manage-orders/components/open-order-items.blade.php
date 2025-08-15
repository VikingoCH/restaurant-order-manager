<x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
    title="{{ __('labels.open_items') }}">
    {{-- <div class="flex justify-end gap-2"> --}}
    <x-slot:actions separator>
        <div class="grid grid-cols-2 gap-2 lg:flex lg:flex-row">
            @foreach ($printers as $printer)
                <x-button class="btn-primary btn-sm" icon="{{ $printer->icon ?? 'o-printer' }}"
                    label="{{ $printer->name }}" wire:click="print({{ $printer->id }})" />
            @endforeach
            <x-button class="btn-secondary btn-sm" icon="gmdi.restaurant-menu-r" label="{{ __('Print All') }}"
                wire:click="print('all')" />
            <x-button class="btn-accent btn-sm" icon="gmdi.print-disabled-o" label="{{ __('No Print') }}"
                wire:click="print('none')" />
        </div>

    </x-slot:actions>
    <x-table :headers="$headers" :rows="$orderItems" empty-text="{{ __('No items to show!') }}" no-hover selectable
        show-empty-text wire:model='selectedRows'>
        @scope('cell_items', $orderItem)
            <p>{{ $orderItem->menuItem->name }}</p>
            <span class="text-xs text-gray-400">{{ $orderItem->sides ?? '' }}</span>
            <span class="text-xs text-gray-400">
                {{ $orderItem->remarks ? ' | ' . $orderItem->remarks : '' }}
            </span>
        @endscope
        @scope('cell_quantity', $orderItem)
            <div class="flex flex-row justify-center">
                @if ($orderItem->quantity != 1)
                    <x-button class="btn-square btn-sm lg:btn-md" icon="o-minus"
                        wire:click='decrement({{ $orderItem->id }})' />
                @else
                    <x-button class="btn-square btn-sm lg:btn-md" disabled icon="o-minus" />
                @endif
                <span class="px-4 py-2">{{ $orderItem->quantity }}</span>
                <x-button class="btn-square btn-sm lg:btn-md" icon="o-plus"
                    wire:click='increment({{ $orderItem->id }})' />
            </div>
        @endscope

        @scope('cell_total', $orderItem)
            {{ 'CHF ' . number_format($orderItem->quantity * $orderItem->price, 2) }}
        @endscope

        @scope('actions', $orderItem)
            <div class="flex flex-nowrap gap-3">
                <x-buttons.edit wire:click="editForm({{ $orderItem->id }})" />
                <x-buttons.trash wire:click="destroy({{ $orderItem->id }})" />
            </div>
        @endscope
    </x-table>

    <!-- Edit menu item  -->
    <x-drawer class="w-11/12 lg:w-1/3" close-on-escape right separator title="{{ $menuItem->name ?? '' }}"
        wire:model="openEditForm" with-close-button>
        @if ($orderItem != null)
            <x-form wire:submit='update'>

                <x-textarea label="{{ __('labels.remarks') }}" rows="3" wire:model.live='orderNotes' />

                @if ($menuItem->menuFixedSides->count() || $menuItem->menuSelectableSides->count())
                    <h3 class="fieldset-legend mb-0.5">{{ __('labels.sides') }}</h3>
                @endif
                <div class="grid grid-cols-2 items-center">
                    @if ($menuItem->menuFixedSides->count() || $menuItem->menuSelectableSides->count())
                        <div>
                            @foreach ($menuItem->menuFixedSides as $side)
                                {{-- @if (in_array($side->id, $fixedSides)) --}}
                                <x-checkbox label='{{ $side->name }}' value='{{ $side->id }}'
                                    wire:model.live='fixedSides' />
                                {{-- @endif --}}
                            @endforeach
                        </div>
                    @endif
                    @if ($menuItem->menuSelectableSides->count())
                        <div>
                            <x-radio :options="$menuItem->menuSelectableSides" wire:model="selectableSides" />
                        </div>
                    @endif
                </div>

                <x-slot:actions>
                    <x-button label="{{ __('labels.cancel') }}" wire:click="$toggle('openEditForm')" />
                    <x-button class="btn-primary" icon="o-check" label="{{ __('labels.save') }}" type='submit' />
                </x-slot:actions>
            </x-form>
        @endif
    </x-drawer>
</x-card>
