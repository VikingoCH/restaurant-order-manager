<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ $order->number }}"
        title="{{ __('labels.table') . ' - ' . $order->place->location->name . ' / ' . $order->place->number }}">
        <x-slot name="actions">
            <x-buttons.pay link="{{ route('payments.create', [$order->id]) }}" />
        </x-slot>
    </x-header>
    <div class="flex flex-col gap-4 lg:flex-row">
        <!-- Menu Items section -->
        <livewire:manage-orders.components.menu-sections :$orderId />

        <!-- Order Items section -->
        <div class="flex w-full flex-col gap-4 lg:basis-3/4">

            <!-- Open Order Items -->
            <livewire:manage-orders.components.open-order-items :$orderId />

            <!-- Closed Order Items -->
            <livewire:manage-orders.components.closed-order-items :$orderId />
        </div>
    </div>
</div>
