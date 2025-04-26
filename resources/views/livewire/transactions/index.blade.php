<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('Configure the sections of the menu') }}"
        title="{{ __('labels.transanctions') }}">
    </x-header>

    <div class="flex flex-col-reverse justify-center gap-4 lg:flex-row">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow>
            <x-table :headers="$headers" :rows="$orders" empty-text="{{ __('Transactions not found!') }}" expandable
                show-empty-text wire:model="expanded">
                @scope('expansion', $order)
                    @foreach ($order->transactions as $transaction)
                        <div class="flex flex-row gap-4 border-y border-gray-300 p-2">
                            <x-icon class="m-4 text-green-600" name="gmdi.check-box-o" />
                            <span class="border-r border-gray-400 p-4">{{ $transaction->number }}</span>
                            <span class="p-4">{{ 'CHF ' . number_format($transaction->total, 2) }}</span>
                        </div>
                    @endforeach
                @endscope
            </x-table>
        </x-card>
    </div>
</div>
