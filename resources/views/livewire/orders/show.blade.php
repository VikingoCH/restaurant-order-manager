<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    {{-- {{ dd($order) }} --}}
    <x-header progress-indicator separator subtitle="{{ $order->number }}" title="{{ __('labels.order_details') }}">
        <x-slot name="actions">
            <x-buttons.back link="{{ route('orders.index') }}" />
        </x-slot>
    </x-header>
    <div class="flex flex-col justify-center gap-4 lg:flex-row">
        <!-- Order Details table -->
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/2 dark:border-neutral-700" separator shadow
            title="{{ __('Order Items') }}">
            <x-table :headers="$orderHeaders" :rows="$orderItems">
                @if ($order->table != 'none')
                    @scope('cell_amount', $orderItem)
                        {{ 'CHF ' . number_format($orderItem->quantity * $orderItem->price, 2) }}
                    @endscope
                @endif
            </x-table>
            <!-- Order Total Amount -->
            <div class="mt-4 flex flex-row gap-2 border-t border-gray-300">
                <div class="basis-2/3 py-2 text-end font-bold">{{ __('labels.sub_total') }}</div>
                <div class="basis-1/3 px-12 py-2 text-end font-bold">
                    {{ 'CHF ' . number_format($order->total, 2) }}
                </div>
            </div>
            <!-- Order Discount -->
            <div class="mt-4 flex flex-row gap-2">
                <div class="basis-2/3 py-2 text-end font-bold">{{ __('labels.discount') }}</div>
                <div class="basis-1/3 px-12 py-2 text-end font-bold">
                    {{ 'CHF ' . number_format($totals->discount_sum, 2) }}
                </div>
            </div>

            <!-- Order Tip -->
            <div class="mt-4 flex flex-row gap-2">
                <div class="basis-2/3 py-2 text-end font-bold">{{ __('labels.tip') }}</div>
                <div class="basis-1/3 px-12 py-2 text-end font-bold">
                    {{ 'CHF ' . number_format($totals->tip_sum, 2) }}
                </div>
            </div>
            <!-- Total Paid -->
            <div class="mt-4 flex flex-row gap-2">
                <div class="basis-2/3 py-2 text-end font-bold">{{ __('labels.total') }}</div>
                <div class="basis-1/3 px-12 py-2 text-end font-bold">
                    {{ 'CHF ' . number_format($totals->total_sum, 2) }}
                </div>
            </div>
        </x-card>

        <!-- Payments table -->
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/2 dark:border-neutral-700" separator shadow
            title="{{ __('Payments') }}">
            <x-table :headers="$transactionsHeader" :rows="$transactions" expandable wire:model="expanded">
                @scope('expansion', $transaction, $transactionItemsHeader)
                    <x-table :headers="$transactionItemsHeader" :rows="$transaction->transactionItems" />
                @endscope
            </x-table>

        </x-card>
    </div>
</div>
