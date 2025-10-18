<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.payments') }}" />
    <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
        subtitle="{{ $showing }}" title="{{ number_format($total, 2) . ' CHF' }}">
        <x-slot:menu>
            <x-select :options="$dateRanges" class="bg-primary" wire:model.live="dateRange" />
            <x-datepicker :config="$datePlugin" class="bg-primary" icon="o-calendar" inline
                label="{{ __('labels.date_by_month') }}" wire:model.live="monthYear" />
        </x-slot:menu>

        <x-table :headers="$headers" :rows="$transactions" empty-text="{{ __('Transactions not found!') }}"
            link="{{ route('transactions.show', ['transaction' => '[id]']) }}" show-empty-text with-pagination>
        </x-table>
    </x-card>
</div>
