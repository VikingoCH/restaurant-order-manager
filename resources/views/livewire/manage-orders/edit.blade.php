<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ $order->number }}"
        title="{{ __('labels.table') . ' - ' . $order->place->location->name . ' / ' . $order->place->number }}">
        <x-slot name="actions">
            <x-buttons.pay link="{{ route('payments.create', [$order->id]) }}" />
        </x-slot>
    </x-header>
    <!-- Menu Items section -->
    <livewire:manage-orders.components.menu-sections :$orderId />

    <div class="flex flex-col gap-4 lg:flex-row">

        <!-- Order Items section -->
        {{-- <div class="flex w-full flex-col gap-4 lg:basis-3/4"> --}}
        <div class="flex w-full flex-col gap-4">
            <!-- Open Order Items -->
            <livewire:manage-orders.components.open-order-items :$orderId />

            <!-- Closed Order Items -->
            <livewire:manage-orders.components.closed-order-items :$orderId />
        </div>
        {{-- @if ($showMenuItems) --}}
        <livewire:manage-orders.components.menu-items :$orderId />
        {{-- @endif --}}

    </div>
</div>
