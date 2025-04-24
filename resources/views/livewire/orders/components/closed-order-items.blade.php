<x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
    title="{{ __('labels.closed_items') }}">
    <x-table :headers="$headers" :rows="$orderItems" empty-text="{{ __('No items to show!') }}" no-hover>
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
            <div class="flex flex-nowrap gap-3">
                <x-buttons.trash wire:click="destroy({{ $orderItem->id }})" />
            </div>
        @endscope
    </x-table>
</x-card>
