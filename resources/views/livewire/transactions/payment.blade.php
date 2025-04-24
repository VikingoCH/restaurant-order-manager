<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.payment') }}">
        <x-slot:middle>
            <div class="flex flex-row gap-2 text-xl font-bold lg:text-2xl">
                <span>{{ $order->number . ': ' }}</span>
                <span>{{ 'CHF ' . number_format($order->total, 2) }}</span>

            </div>

        </x-slot:middle>
    </x-header>
    @if ($hasOpenItems)
        <x-alert class="alert-warning"
            description="{{ __('If continue with payment all open items will be closed automatically or check Order page') }}"
            icon="o-exclamation-triangle" title="{{ __('This order have open items!!') }}">
            <x-slot:actions>
                <x-button class="btn-sm btn-secondary" label="{{ __('Check open items') }}"
                    link="{{ route('order.edit', [$orderId]) }}" />
            </x-slot:actions>
        </x-alert>
    @endif
    <div class="flex flex-col justify-center gap-4 lg:flex-row">
        <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('labels.open_items') }}">
            <x-slot:menu>
                <x-buttons.pay label="{{ __('Pay all') }}" />
            </x-slot:menu>
            <x-table :headers="$headers" :rows="$orderItems" @row-click="$wire.addPaymentItem($event.detail.id)"
                empty-text="{{ __('All ordered items are payed!') }}" show-empty-text>
                {{-- @scope('cell_items', $orderItem)
                    <p>{{ $orderItem->menuItem->name }}</p>
                    <span class="text-xs text-gray-400">{{ $orderItem->sides }}</span>
                    <span class="text-xs text-gray-400">
                        {{ $orderItem->remarks ? ' | ' . $orderItem->remarks : '' }}
                    </span>
                @endscope

                @scope('cell_total', $orderItem)
                    {{ 'CHF ' . number_format($orderItem->quantity * $orderItem->price, 2) }}
                @endscope --}}
            </x-table>
        </x-card>
        <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('labels.payment') }}">
            <x-table :headers="$headers" :rows="$paymentItems" empty-text="{{ __('Select an item to add') }}"
                show-empty-text />
            <hr class="my-8 border border-gray-300" />
            <x-form>
                <div class="grid grid-cols-2 gap-2">
                    <div class="py-2 text-end font-bold">{{ __('labels.subTotal') }}</div>
                    <x-input prefix="CHF" readonly value="{{ number_format($itemsTotal, 2) }}" />

                    <x-input icon="gmdi.percent-o" label="{{ __('Discount (%)') }}" />
                    <x-input label="{{ __('Total Discount') }}" prefix="CHF" readonly value="120 CHF" />

                    <x-input icon="gmdi.percent-o" label="{{ __('VAT (%)') }}" />
                    <x-input label="{{ __('Total VAT') }}" prefix="CHF" readonly value="10 CHF" />

                    <div class="py-2 text-end font-bold">{{ __('labels.tip') }}</div>
                    <x-input prefix="CHF" />

                    <div class="py-2 text-end font-bold">{{ __('labels.total') }}</div>
                    <x-input prefix="CHF" readonly value="400" />

                    <x-select :options="$paymentMethods" icon="o-credit-card" label="{{ __('Payment Method') }}" />
                    <div class="flex flex-row justify-center align-middle">
                        <x-buttons.pay />
                        <x-buttons.cancel />
                    </div>

                </div>
            </x-form>
        </x-card>
    </div>
</div>
