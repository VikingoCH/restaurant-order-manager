<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('Configure the sections of the menu') }}"
        title="{{ __('labels.transanctions') }}">
    </x-header>

    <div class="flex flex-col-reverse justify-center gap-4 lg:flex-row">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/2 dark:border-neutral-700" separator shadow
            title="{{ __('labels.transanctions') }}">
            <x-table :headers="$headers" :rows="$orders" empty-text="{{ __('Transactions not found!') }}" expandable
                show-empty-text wire:model="expanded" with-pagination>
                @scope('expansion', $order)
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
                @endscope
            </x-table>
        </x-card>
        <livewire:transactions.show />
    </div>
</div>
