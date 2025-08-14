<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    {{-- {{ dd($order) }} --}}
    <x-header progress-indicator separator subtitle="{{ $transaction->number }}"
        title="{{ __('labels.transaction_detail') }}">
        <x-slot name="actions">
            <x-buttons.back link="{{ route('transactions.index') }}" />
        </x-slot>
    </x-header>
    <div class="flex flex-col gap-4 lg:flex-row">
        <!-- Order Details table -->
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" shadow>
            <x-table :headers="$headers" :rows="$items">
                @scope('cell_amount', $item)
                    {{ 'CHF ' . number_format($item->quantity * $item->price, 2) }}
                @endscope
            </x-table>
        </x-card>
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700" shadow>
            <!-- Order Total Amount -->
            <div class="flex flex-row gap-2">
                <div class="w-1/2 py-2 text-end font-bold">{{ __('labels.sub_total') }}</div>
                <div class="w-full py-2 text-end font-bold">
                    {{ 'CHF ' . number_format($subtotal, 2) }}
                </div>
            </div>
            <!-- Order Discount -->
            <div class="flex flex-row gap-2">
                <div class="w-1/2 py-2 text-end font-bold">{{ __('labels.discount') }}</div>
                <div class="w-full py-2 text-end font-bold">
                    {{ 'CHF ' . number_format($transaction->discount, 2) }}
                </div>
            </div>

            <!-- Order Tip -->
            <div class="flex flex-row gap-2">
                <div class="w-1/2 py-2 text-end font-bold">{{ __('labels.tip') }}</div>
                <div class="w-full py-2 text-end font-bold">
                    {{ 'CHF ' . number_format($transaction->tip, 2) }}
                </div>
            </div>
            <!-- Total Paid -->
            <div class="mt-4 flex flex-row gap-2 border-b border-t border-gray-500">
                <div class="w-1/2 py-2 text-end font-bold">{{ __('labels.total') }}</div>
                <div class="w-full py-2 text-end font-bold">
                    {{ 'CHF ' . number_format($transaction->total, 2) }}
                </div>
            </div>

            <!-- Order Tax -->
            <div class="mt-8 flex flex-row gap-2 border-b border-t border-gray-300">
                <div class="w-1/2 py-2 text-end text-xs font-bold text-gray-400">{{ __('labels.tax') }}</div>
                <div class="w-full py-2 text-end text-xs font-bold text-gray-400">
                    {{ 'CHF ' . number_format($transaction->tax, 2) }}
                </div>
            </div>
        </x-card>
    </div>
</div>
