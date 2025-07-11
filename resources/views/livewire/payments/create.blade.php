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
                    link="{{ route('manage-order.edit', [$orderId]) }}" />
            </x-slot:actions>
        </x-alert>
    @endif
    <div class="flex flex-col justify-center gap-4 lg:flex-row">

        <!-- Ordered Items Section -->
        <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('labels.open_items') }}">
            <x-slot:menu>
                <x-buttons.pay label="{{ __('Pay all') }}" wire:click='addAllPaymentItems' />
            </x-slot:menu>
            <x-table :headers="$headers" :rows="$orderItems" @row-click="$wire.addPaymentItem($event.detail.id)"
                empty-text="{{ __('All ordered items are paid!') }}" show-empty-text />
            <div class="mt-4 flex flex-row gap-2 border-t border-gray-300">
                <div class="basis-2/3 py-2 text-end font-bold">{{ __('labels.total') }}</div>
                <div class="basis-1/3 px-12 py-2 text-end font-bold">{{ 'CHF ' . number_format($orderItemsTotal, 2) }}
                </div>
            </div>
        </x-card>

        <!-- Payment section -->
        <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('labels.payment') }}">
            <x-table :headers="$headers" :rows="$paymentItems" empty-text="{{ __('Select an item to add') }}"
                show-empty-text>
                @scope('actions', $paymentItem)
                    <x-buttons.trash wire:click="removePaymentItem({{ $paymentItem['id'] }})" />
                @endscope
            </x-table>

            <hr class="my-8 border border-gray-300" />

            <div class="grid grid-cols-2 gap-2">
                {{-- <div class="py-2 text-end font-bold">{{ __('labels.sub_total') }}</div> --}}
                <span></span>
                <x-input label="{{ __('labels.sub_total') }}" prefix="CHF" readonly
                    value="{{ number_format($itemsTotal, 2) }}" />

                <x-input icon="gmdi.percent-o" label="{{ __('Discount (%)') }}" wire:model.live='discount' />
                <x-input label="{{ __('Total Discount') }}" prefix="CHF" readonly
                    value="{{ number_format(((int) $discount / 100) * $itemsTotal, 2) }}" />

                <x-input icon="gmdi.percent-o" label="{{ __('labels.tax') }}" wire:model.live='tax' />
                <x-input label="{{ __('Total MWST') }}" prefix="CHF" readonly
                    value="{{ number_format(($itemsTotal - ((int) $discount / 100) * $itemsTotal) * ((int) $tax / 100), 2) }}" />

                {{-- <div class="py-2 text-end font-bold">{{ __('labels.tip') }}</div> --}}
                <span></span>
                <x-input label="{{ __('labels.tip') }}" prefix="CHF" wire:model.live='tip' />

                {{-- <div class="py-2 text-end font-bold">{{ __('labels.total') }}</div> --}}
                <span></span>
                <x-input label="{{ __('labels.total') }}" prefix="CHF" readonly
                    value="{{ number_format($itemsTotal - ((int) $discount / 100) * $itemsTotal + (int) $tip + ($itemsTotal - ((int) $discount / 100) * $itemsTotal) * ((int) $tax / 100), 2) }}" />
            </div>

            <div class="mt-8 flex flex-col gap-4 border-t border-gray-300">

                <x-select :options="$paymentMethods" icon="o-credit-card" label="{{ __('Payment Method') }}"
                    wire:model='paymentMethod' />

                <div class="grid grid-cols-3 gap-2">
                    @if (count($paymentItems) != 0)
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

    <!-- Temporal printing modal - to be replaced by final printer method -->
    <x-modal separator title="Printing payment" wire:model="printing">
        <div class="flex justify-between">
            Printing ...
            <x-loading class="loading-bars" />
        </div>
    </x-modal>
</div>
