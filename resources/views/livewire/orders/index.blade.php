<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.orders') }}" />

    <div class="flex flex-col justify-center gap-4 lg:flex-row-reverse">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700" separator shadow
            subtitle="{{ __('To open a new order') }}" title="{{ __('Select a Table') }}">
            <div class="flex flex-col flex-wrap gap-1">
                @foreach ($locations as $location)
                    {{-- {{ dd($location->places) }} --}}
                    <x-collapse separator>
                        <x-slot:heading>
                            {{ $location->name }}
                        </x-slot:heading>
                        <x-slot:content>
                            <div class="flex flex-row flex-wrap gap-1">
                                @foreach ($location->places as $table)
                                    <x-buttons.number enabled="{{ $table->available }}" label="{{ $table->number }}"
                                        wire:click="create({{ $table->id }})" />
                                @endforeach
                            </div>
                        </x-slot:content>
                    </x-collapse>
                @endforeach
            </div>
        </x-card>
        <div class="flex w-full flex-col gap-4 lg:w-3/4">
            <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
                title="{{ __('Open Orders') }}">
                <x-table :headers="$headers" :rows="$openOrders" empty-text="{{ __('No orders yet!') }}"
                    link="/order/{id}/edit" show-empty-text>
                    @scope('actions', $openOrder)
                        <div class="flex flex-nowrap gap-3">
                            <x-buttons.pay />
                            <x-buttons.trash wire:click="destroy({{ $openOrder->id }})" />
                        </div>
                    @endscope
                </x-table>
            </x-card>
            <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
                title="{{ __('Closed Orders') }}">
                <x-table :headers="$headers" :rows="$openOrders" empty-text="{{ __('No closed orders today!') }}"
                    show-empty-text />
            </x-card>
        </div>
    </div>

</div>
