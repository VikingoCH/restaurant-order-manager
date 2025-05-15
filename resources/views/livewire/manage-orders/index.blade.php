<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.manage') }}">
        <x-slot:actions>
            <x-button class="btn-primary" icon="gmdi.fastfood-o" label="{{ __('labels.quick_order') }}"
                link="{{ route('payments.quick-order') }}" />
        </x-slot:actions>
    </x-header>

    <div class="flex flex-col justify-center gap-4 lg:flex-row-reverse">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700" separator shadow
            subtitle="{{ __('To open a new order') }}" title="{{ __('Select a Table') }}">
            @if ($locations->isEmpty())
                <x-alert class="alert-info"
                    description="{{ __('Create first at least one table to be able to add new orders') }}"
                    icon="o-exclamation-triangle" title="{{ __('No tables found') }}">
                    <x-slot:actions>
                        <x-buttons.add link="{{ route('settings.table.locations') }}" />
                    </x-slot:actions>
                </x-alert>
            @endif
            <div class="flex flex-col flex-wrap gap-1">
                @foreach ($locations as $location)
                    {{-- {{ dd($location->places) }} --}}
                    @if (!$location->places->isEmpty())
                        <x-collapse separator>
                            <x-slot:heading>
                                {{ $location->name }}
                            </x-slot:heading>
                            <x-slot:content>
                                <div class="flex flex-row flex-wrap gap-1">
                                    @foreach ($location->places as $table)
                                        <x-buttons.number enabled="{{ $table->available }}"
                                            label="{{ $table->number }}" wire:click="create({{ $table->id }})" />
                                    @endforeach
                                </div>
                            </x-slot:content>
                        </x-collapse>
                    @endif
                @endforeach
            </div>
        </x-card>
        <div class="flex w-full flex-col gap-4 lg:w-3/4">
            <x-card class="w- rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
                title="{{ __('Open Orders') }}">
                <x-table :headers="$headers" :rows="$openOrders" empty-text="{{ __('No orders yet!') }}"
                    link="/manage-order/{id}/edit" show-empty-text with-pagination>
                    @scope('actions', $openOrder)
                        <div class="flex flex-nowrap gap-3">
                            <x-buttons.pay link="{{ route('payments.create', [$openOrder->id]) }}" />
                            <x-buttons.trash wire:click="destroy({{ $openOrder->id }})" />
                        </div>
                    @endscope
                </x-table>
            </x-card>
            {{-- <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
                title="{{ __('Closed Orders') }}">
                <x-table :headers="$headers" :rows="$closedOrders" empty-text="{{ __('No closed orders today!') }}"
                    show-empty-text with-pagination />
            </x-card> --}}
        </div>
    </div>

</div>
