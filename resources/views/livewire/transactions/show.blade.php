<span>
    @if ($showTransactionDetail)
        <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('labels.transanction_detail') }}">
            <x-table :headers="$headers" :rows="$transactionItems" striped>
                @scope('cell_total', $transactionItem)
                    {{ 'CHF ' . number_format($transactionItem->price * $transactionItem->quantity, 2) }}
                @endscope
            </x-table>
            <hr class="my-8 border border-gray-300" />

            <div class="grid grid-cols-2 gap-2">
                <div class="py-2 text-end font-bold">{{ __('labels.sub_total') }}</div>
                <x-input prefix="CHF" readonly value="{{ number_format($transacSubtotal, 2) }}" />

                <div class="py-2 text-end font-bold">{{ __('labels.discount') }}</div>
                <x-input prefix="CHF" readonly value="{{ number_format($transaction->discount, 2) }}" />

                <div class="py-2 text-end font-bold">{{ __('labels.tax') }}</div>
                <x-input prefix="CHF" readonly value="{{ number_format($transaction->tax, 2) }}" />

                <div class="py-2 text-end font-bold">{{ __('labels.tip') }}</div>
                <x-input prefix="CHF" readonly value="{{ number_format($transaction->tip, 2) }}" />

                <div class="py-2 text-end font-bold">{{ __('labels.total') }}</div>
                <x-input prefix="CHF" readonly value="{{ number_format($transaction->total, 2) }}" />
            </div>
            <div class="mt-4 flex flex-col gap-4 border-t border-gray-300">
                <x-button class="btn-secondary mt-2" icon="gmdi.arrow-back" label="{{ __('labels.close') }}"
                    wire:click='close' />
            </div>
        </x-card>
    @endif
</span>
