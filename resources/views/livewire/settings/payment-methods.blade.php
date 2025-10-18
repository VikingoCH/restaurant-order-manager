<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.payment_methods') }}">
        <x-slot:actions>
            <x-buttons.add responsive wire:click="create" />
        </x-slot:actions>
    </x-header>
    <div class="flex flex-col-reverse justify-center gap-4 lg:flex-row">
        {{-- <div class="flex "> --}}
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow
            title="{{ __('Available payment methods') }}">

            <x-table :headers='$headers' :rows='$payMethods' empty-text="{{ __('Nothing to show!') }}" show-empty-text>
                @scope('actions', $payMethod)
                    <div class="flex flex-nowrap gap-3">
                        <x-buttons.edit wire:click='edit({{ $payMethod->id }})' />
                        <x-buttons.trash wire:click="destroy({{ $payMethod->id }})" />
                    </div>
                @endscope
            </x-table>

        </x-card>

        <!-- Create / Edit form -->
        @if ($showForm)
            <x-card class="w-full rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700" shadow
                title="{{ __('Payment Method') }}">

                <x-form wire:submit='save'>
                    @csrf
                    <x-input label="{{ __('labels.name') }}" wire:model="name" />
                    <x-slot:actions>
                        <x-buttons.save spinner="save" type="submit" />
                        <x-buttons.cancel wire:click="$toggle('showForm')" />
                    </x-slot:actions>
                </x-form>

            </x-card>
        @endif
    </div>
</div>
