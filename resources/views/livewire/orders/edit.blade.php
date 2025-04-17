<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('Order Details') }}" />
    <div class="flex flex-col gap-4 lg:flex-row">
        <!-- Menu section -->
        <x-card class="flex basis-1/4 flex-col rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700"
            title="{{ __('Add menu Items') }}">
            @if (count($sections) != 0)
                @foreach ($sections as $section)
                    <x-collapse class="mb-2" separator>
                        <x-slot:heading>
                            {{ $section->name }}
                        </x-slot:heading>
                        <x-slot:content>
                            <livewire:orders.menu-items :key="$section->id" :orderId="$orderId" :sectionId="$section->id" />
                        </x-slot:content>
                    </x-collapse>
                @endforeach
            @else
                <div class="flex flex-col">
                    <h3 class="text-error py-2 text-center font-semibold">
                        {{ __('To add items in an order, you must create the menu first!!') }}
                    </h3>
                    <x-buttons.add link="{{ route('menu.index') }}" />
                </div>
            @endif
        </x-card>

        <!-- Order Items section -->
        <div class="flex w-full flex-col gap-4 lg:basis-3/4">

            <!-- Unprocessed Order Items -->
            <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
                title="{{ __('labels.unprocessed') }}">
                <x-table :headers="$headers" :rows="$openItems" empty-text="{{ __('No items to show!') }}" no-hover
                    selectable show-empty-text wire:model='selectedRows'>
                    @scope('cell_items', $orderItem)
                        <p>{{ $orderItem->menuItem->name }}</p>
                        <span class="text-xs text-gray-400">{{ $orderItem->sides }}</span>
                        <span class="text-xs text-gray-400">
                            {{ $orderItem->remarks ? ' | ' . $orderItem->remarks : '' }}
                        </span>
                    @endscope

                    @scope('cell_quantity', $orderItem)
                        <div class="flex flex-row justify-center">
                            <x-button class="btn-square" icon="o-plus" wire:click='increment({{ $orderItem->id }})' />
                            <span class="rounded-sm border border-gray-200 px-4 py-2">{{ $orderItem->quantity }}</span>
                            <x-button class="btn-square" icon="o-minus" wire:click='decrement({{ $orderItem->id }})' />
                        </div>
                    @endscope

                    @scope('cell_total', $orderItem)
                        {{ 'CHF ' . number_format($orderItem->quantity * $orderItem->price, 2) }}
                    @endscope

                    @scope('actions', $orderItem)
                        <div class="flex flex-nowrap gap-3">
                            <x-buttons.edit
                                wire:click="$dispatch('edit-form', { menuItemId: {{ $orderItem->menu_item_id }} ,onlyUpdate:{{ true }} })" />
                            <x-buttons.trash wire:click="destroy({{ $orderItem->id }})" />
                        </div>
                    @endscope
                </x-table>
            </x-card>

            <!-- Processed Order Items -->
            <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700"
                title="{{ __('labels.processed') }}">
                <x-table :headers="$headers" :rows="$closedItems" empty-text="{{ __('No items to show!') }}" selectable
                    show-empty-text wire:model='selectedRows'>
                    @scope('cell_items', $orderItem)
                        <p>{{ $orderItem->menuItem->name }}</p>
                        <span class="text-xs text-gray-400">{{ $orderItem->sides }}</span>
                        <span class="text-xs text-gray-400">
                            {{ $orderItem->remarks ? ' | ' . $orderItem->remarks : '' }}
                        </span>
                    @endscope
                    @scope('cell_total', $orderItem)
                        {{ 'CHF ' . number_format($orderItem->quantity * $orderItem->price, 2) }}
                    @endscope
                    @scope('actions', $orderItem)
                        {{-- <div class="flex flex-nowrap gap-3"> --}}
                        <x-buttons.trash wire:click="destroy({{ $orderItem->id }})" />
                    @endscope
                </x-table>
            </x-card>
        </div>
        <livewire:orders.menu-item-edit :orderId="$orderId" @item-added="$refresh" />
    </div>
</div>
