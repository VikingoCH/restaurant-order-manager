<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.quick_order') }}" />
    <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
        title="{{ __('labels.payment') }}">
        <div class="grid grid-cols-3 gap-2">
            <div class="flex items-end justify-end py-3 font-bold">{{ $itemName }}</div>
            <span class="col-span-2 col-start-2">
                <x-input label="{{ __('labels.amount') }}" money prefix="CHF" wire:model.live='orderAmount' />
            </span>

            <x-input icon="gmdi.percent-o" label="{{ __('Discount (%)') }}" wire:model.live='discount' />
            <span class="col-span-2 col-start-2">
                <x-input label="{{ __('Total Discount') }}" prefix="CHF" wire:model.live='discountAmount' />
            </span>

            <span class="col-span-2 col-start-2">
                <x-input label="{{ __('labels.total_gross') }}" prefix="CHF" readonly
                    value="{{ number_format($grossTotal, 2) }}" />
            </span>

            <x-input label="{{ __('labels.tip') }}" prefix="CHF" wire:model.live='tip' />
            <span class="bg-(--color-primary) col-span-2 col-start-2 pb-2 pl-2 pr-2">
                <x-input label="{{ __('labels.total_paid') }}" prefix="CHF" readonly
                    value="{{ number_format($paymentTotal, 2) }}" />
            </span>
        </div>

        <div class="mt-8 grid grid-cols-2 gap-2 border-t border-gray-300">

            <x-input class="bg-gray-50 text-gray-400" label="{{ __('labels.tax_value', ['value' => $tax]) }}"
                prefix="CHF" readonly value="{{ number_format($taxAmount, 2) }}" />

            <x-input class="bg-gray-50 text-gray-400" label="{{ __('Net Total') }}" prefix="CHF" readonly
                value="{{ number_format($netTotal, 2) }}" />
        </div>
        <div class="mt-8 flex flex-col gap-4 border-t border-gray-300">

            <x-select :options="$paymentMethods" icon="o-credit-card" label="{{ __('Payment Method') }}"
                wire:model='paymentMethod' />

            <div class="grid grid-cols-3 gap-2">
                @if ($orderAmount >= 1)
                    <x-button class="btn-primary mt-auto" icon="gmdi.payments-o" label="{{ __('labels.pay') }}"
                        wire:click='pay' />
                    <x-button class="btn-secondary mt-auto" icon="o-printer" label="{{ __('labels.print') }}"
                        wire:click="$toggle('printing')" />
                @else
                    <x-button class="btn-primary mt-auto" disabled icon="gmdi.payments-o"
                        label="{{ __('labels.pay') }}" />
                    <x-button class="btn-secondary mt-auto" disabled icon="o-printer"
                        label="{{ __('labels.print') }}" />
                @endif
                <x-buttons.cancel class="mt-auto" wire:click='cancel' />
            </div>
        </div>
    </x-card>
</div>
