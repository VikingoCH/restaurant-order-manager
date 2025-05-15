<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.orders') }}" />
    <div class="flex w-full flex-col justify-center gap-4">
        <!-- Closed Orders table -->
        <x-card class="w- rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            subtitle="{{ $showing }}" title="{{ __('Close Orders') }}">
            <x-slot:menu>
                <x-select :options="$dateRanges" class="bg-primary" wire:model.live="dateRange" />
                <x-datepicker :config="$datePlugin" class="bg-primary" icon="o-calendar" inline
                    label="{{ __('labels.date_by_month') }}" wire:model.live="monthYear" />
            </x-slot:menu>
            <x-table :headers="$headers" :rows="$closeOrders" empty-text="{{ __('No orders to show!') }}"
                link="/orders/{id}/show" show-empty-text with-pagination>
                @scope('cell_is_open', $order)
                    <x-icon class="text-green-600" name="gmdi.credit-card-o" />
                @endscope
                @scope('cell_total_order', $order, $totals)
                    {{ 'CHF ' . number_format($totals->find($order->id)->total_sum ?? 0, 2) }}
                @endscope
            </x-table>
        </x-card>

        <!-- Open Orders table -->
        <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('Open Orders') }}">
            <x-table :headers="$headers" :rows="$openOrders" empty-text="{{ __('No orders to show!') }}"
                link="/manage-order/{id}/edit" show-empty-text>
                @scope('cell_is_open', $order)
                    <x-icon class="text-red-600" name="gmdi.credit-card-off-o" />
                @endscope
                @scope('cell_total_order', $order, $totals)
                    {{ 'CHF ' . number_format($totals->find($order->id)->total_sum ?? 0, 2) }}
                @endscope
                @scope('actions', $order)
                    <x-buttons.pay link="{{ route('payments.create', [$order->id]) }}" />
                @endscope
            </x-table>
        </x-card>
    </div>
</div>
