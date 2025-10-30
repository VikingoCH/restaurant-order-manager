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
                <x-buttons.all wire:click='addAllPaymentItems' />
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

            <div class="grid grid-cols-3 gap-2">
                <span class="col-span-2 col-start-2">
                    <x-input label="{{ __('labels.sub_total') }}" prefix="CHF" readonly
                        value="{{ number_format($itemsTotal, 2) }}" />
                </span>

                <x-input icon="gmdi.percent-o" label="{{ __('Discount (%)') }}" wire:model.live='discount' />
                <span class="col-span-2 col-start-2">
                    <x-input label="{{ __('Total Discount') }}" prefix="CHF" wire:model.live='discountAmount' />
                </span>

                {{-- <div class="py-2 text-end font-bold">{{ __('labels.tip') }}</div> --}}
                <span class="col-span-2 col-start-2">
                    <x-input label="{{ __('labels.total_gross') }}" prefix="CHF" readonly
                        value="{{ number_format($grossTotal, 2) }}" />
                </span>

                {{-- <div class="py-2 text-end font-bold">{{ __('labels.total') }}</div> --}}
                <x-input label="{{ __('labels.tip') }}" prefix="CHF" wire:model.live='tip' />
                <span class="bg-(--color-primary) col-span-2 col-start-2 pb-2 pl-2 pr-2">
                    <x-input label="{{ __('labels.total_paid') }}" prefix="CHF" readonly
                        value="{{ number_format($paymentTotal, 2) }}" />
                </span>
            </div>
            <div class="mt-8 grid grid-cols-2 gap-2 border-t border-gray-300">

                <x-input class="bg-gray-50 text-gray-400" label="{{ __('labels.tax_value', ['value' => $tax]) }}"
                    prefix="CHF" readonly value="{{ number_format($taxAmount, 2) }}" />

                <x-input class="bg-gray-50 text-gray-400" label="{{ __('labels.total_net') }}" prefix="CHF" readonly
                    value="{{ number_format($netTotal, 2) }}" />
            </div>
            <div class="mt-8 flex flex-col gap-4 border-t border-gray-300">

                <x-select :options="$paymentMethods" icon="o-credit-card" label="{{ __('Payment Method') }}"
                    wire:model='paymentMethod' />

                <div class="grid grid-cols-3 gap-2">
                    @if (count($paymentItems) != 0)
                        <x-button class="btn-primary mt-auto" icon="gmdi.payments-o" label="{{ __('labels.pay') }}"
                            wire:click='pay' />
                        @if (!session('print_disabled'))
                            <x-button class="btn-secondary mt-auto" icon="o-printer"
                                label="{{ __('labels.print-pay') }}" wire:click="printAndPay" />
                        @else
                            <x-button class="btn-secondary mt-auto" disabled icon="o-printer"
                                label="{{ __('labels.print-pay') }}" />
                        @endif
                    @else
                        <x-button class="btn-primary mt-auto" disabled icon="gmdi.payments-o"
                            label="{{ __('labels.pay') }}" />
                        <x-button class="btn-secondary mt-auto" disabled icon="o-printer"
                            label="{{ __('labels.print-pay') }}" />
                    @endif
                    <x-buttons.cancel class="mt-auto" wire:click='cancel' />
                </div>
            </div>
        </x-card>
    </div>
</div>
