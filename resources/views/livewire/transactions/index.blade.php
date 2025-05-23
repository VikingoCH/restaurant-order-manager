<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    {{-- {{ dd($totals->find(1)->total_sum) }} --}}
    <x-header progress-indicator separator title="{{ __('labels.payments') }}" />
    {{-- <div class="flex flex-col-reverse justify-center gap-4 lg:flex-row"> --}}
    <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
        subtitle="{{ $showing }}" title="{{ number_format($total, 2) . ' CHF' }}">
        <x-slot:menu>
            <x-select :options="$dateRanges" class="bg-primary" wire:model.live="dateRange" />
            <x-datepicker :config="$datePlugin" class="bg-primary" icon="o-calendar" inline
                label="{{ __('labels.date_by_month') }}" wire:model.live="monthYear" />
        </x-slot:menu>

        {{-- <x-table :headers="$headers" :rows="$orders" empty-text="{{ __('Transactions not found!') }}" expandable
                show-empty-text wire:model="expanded" with-pagination> --}}
        <x-table :headers="$headers" :rows="$transactions" empty-text="{{ __('Transactions not found!') }}"
            link="{{ route('transactions.show', ['transaction' => '[id]']) }}" show-empty-text with-pagination>
            {{-- @scope('cell_total_order', $order, $totals)
                    {{ 'CHF ' . number_format($totals->find($order->id)->total_sum, 2) }}
                @endscope --}}
            {{-- @scope('expansion', $order)
                    @foreach ($order->transactions as $transaction)
                        <div class="flex flex-row gap-4 border-y border-gray-300 p-2">
                            <a href="#"
                                wire:click="$dispatch('showTransaction',
                                {'transactionId':{{ $transaction->id }}})">
                                <x-icon class="m-4 text-green-600" name="gmdi.check-box-o" />
                                <span class="border-r border-gray-400 p-4">{{ $transaction->number }}</span>
                                <span class="p-4">{{ 'CHF ' . number_format($transaction->total, 2) }}</span>
                            </a>
                        </div>
                    @endforeach
                @endscope --}}
        </x-table>
    </x-card>
    {{-- <livewire:transactions.show /> --}}
    {{-- </div> --}}
</div>
