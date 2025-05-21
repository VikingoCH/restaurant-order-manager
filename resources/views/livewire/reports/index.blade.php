<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.reports') }}" />
    <x-card class="w-1/2 rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
        title="{{ __('Yearly Sales') }}">
        <x-slot:menu>
            <x-select :options="$years" icon="o-calendar" inline label="{{ __('labels.year') }}"
                wire:model.live="yearId" />
        </x-slot:menu>
        <div class="w-full">
            <x-chart wire:model="yearSalesChart" />
        </div>
    </x-card>
</div>
