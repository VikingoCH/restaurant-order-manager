<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.quick_order') }}" />
    <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
        title="{{ __('labels.payment') }}">
        <div class="grid grid-cols-2 gap-2">
            <div class="flex items-end justify-end py-3 font-bold">{{ $itemName }}</div>
            <x-input label="{{ __('labels.amount') }}" locale="de-CH" money prefix="CHF" wire:model.live='orderAmount' />

            <x-input icon="gmdi.percent-o" label="{{ __('Discount (%)') }}" wire:model.live='discount' />
            <x-input label="{{ __('Total Discount') }}" prefix="CHF" readonly
                value="{{ number_format(((int) $discount / 100) * $orderAmount, 2) }}" />

            <x-input icon="gmdi.percent-o" label="{{ __('labels.tax') }}" wire:model.live='tax' />
            <x-input label="{{ __('Total MWST') }}" prefix="CHF" readonly
                value="{{ number_format(($orderAmount - ((int) $discount / 100) * $orderAmount) * ((int) $tax / 100), 2) }}" />

            {{-- <div class="py-2 text-end font-bold">{{ __('labels.tip') }}</div> --}}
            <span></span>
            <x-input label="{{ __('labels.tip') }}" locale="de-CH" money prefix="CHF" wire:model.live='tip' />

            {{-- <div class="py-2 text-end font-bold">{{ __('labels.total') }}</div> --}}
            <span></span>
            <x-input label="{{ __('labels.total') }}" prefix="CHF" readonly
                value="{{ number_format($orderAmount - ((int) $discount / 100) * $orderAmount + (int) $tip + ($orderAmount - ((int) $discount / 100) * $orderAmount) * ((int) $tax / 100), 2) }}" />
        </div>

        <div class="mt-8 flex flex-col gap-4 border-t border-gray-300">

            <x-select :options="$paymentMethods" icon="o-credit-card" label="{{ __('Payment Method') }}"
                wire:model='paymentMethod' />

            <div class="grid grid-cols-3 gap-2">
                @if ($orderAmount != 0)
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
