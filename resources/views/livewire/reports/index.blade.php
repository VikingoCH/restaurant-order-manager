<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('labels.reports') }}" />

    <div class="flex flex-row gap-4">
        <!-- Open report by date -->
        <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('By Date') }}">
            <div class="flex flex-col justify-center gap-4 lg:flex-row">
                {{-- <x-buttons.report-summary /> --}}
                <x-datepicker :config="$byDateCalendar" class="bg-info" icon="o-calendar" inline label="{{ __('labels.date') }}"
                    wire:model.live="reportByDate" />
                {{-- <x-buttons.go link="{{ route('reports.by-date', $urlDate) }}" /> --}}
                <x-buttons.pdf external link="{{ route('printPdf.by-date', $urlDate) }}" />
            </div>
        </x-card>

        <!-- Open report by Month -->
        <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('By Month') }}">
            <div class="flex flex-col justify-center gap-4 lg:flex-row">
                <x-datepicker :config="$byMonthCalendar" class="bg-info" icon="o-calendar" inline label="{{ __('labels.date') }}"
                    wire:model.live="reportByMonth" />
                <x-buttons.pdf external link="{{ route('printPdf.by-month', $reportByMonth) }}" />
                {{-- <x-buttons.report-details /> --}}
            </div>
        </x-card>
        <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
            title="{{ __('By Year') }}">
            <div class="flex flex-col justify-center gap-4 lg:flex-row">
                <x-select :options="$years" class="bg-info" icon="o-calendar" inline label="{{ __('labels.year') }}"
                    wire:model.live="reportYear" />
                <x-buttons.pdf external link="{{ route('printPdf.by-year', $urlYear) }}" />
            </div>
        </x-card>

    </div>
    <div class="hidden justify-center gap-4 lg:flex lg:flex-col xl:flex-row">
        <x-card class="rounded-xl border border-neutral-200 xl:w-1/2 dark:border-neutral-700" separator shadow
            title="{{ __('Yearly Sales') }}">
            <x-slot:menu>
                <x-select :options="$years" class="bg-primary" icon="o-calendar" inline label="{{ __('labels.year') }}"
                    wire:model.live="chartYear" />
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
