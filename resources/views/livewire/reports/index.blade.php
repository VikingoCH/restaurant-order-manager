<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.reports') }}" />
    <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
        title="{{ __('Account Reports') }}">
        <div class="flex flex-col justify-center gap-4 lg:flex-row">
            <x-button label="Day Report" />
            <x-button label="Month Report" />
            <x-button label="Year Report" />
            <x-button label="Other Report" />
        </div>
    </x-card>
    <div class="hidden justify-center gap-4 lg:flex lg:flex-col xl:flex-row">
        <x-card class="rounded-xl border border-neutral-200 xl:w-1/2 dark:border-neutral-700" separator shadow
            title="{{ __('Yearly Sales') }}">
            <x-slot:menu>
                <x-select :options="$years" class="bg-primary" icon="o-calendar" inline label="{{ __('labels.year') }}"
                    wire:model.live="yearId" />
            </x-slot:menu>
            <div class="size-full">
                <x-chart wire:model="yearSalesChart" />
            </div>
        </x-card>

        <x-card class="rounded-xl border border-neutral-200 xl:w-1/2 dark:border-neutral-700" separator shadow
            title="{{ __('Most Sold Products') }}">
            <div class="size-9/12">
                <x-chart wire:model="mostSoldChart" />
            </div>
        </x-card>
    </div>
</div>
