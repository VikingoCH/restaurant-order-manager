<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ $order->number }}"
        title="{{ __('labels.table') . ' - ' . $order->place->location->name . ' / ' . $order->place->number }}" />
    <div class="flex flex-col gap-4 lg:flex-row">
        <!-- Menu Items section -->
        <livewire:orders.components.menu-sections :$orderId />

        <!-- Order Items section -->
        <div class="flex w-full flex-col gap-4 lg:basis-3/4">

            <!-- Open Order Items -->
            <livewire:orders.components.open-order-items :$orderId />

            <!-- Closed Order Items -->
            <livewire:orders.components.closed-order-items :$orderId />
        </div>
        {{-- <livewire:orders.menu-item-edit :$orderId @item-added="$refresh" /> --}}
    </div>
</div>
