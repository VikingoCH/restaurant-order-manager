<div class="flex flex-row gap-4">
    <div class="flex basis-1/4 flex-col">
        <h3 class="text-lg font-bold">{{ __('Order Prefix') }}</h3>
        <p class="text-gray-500">
            {{ __('Used as prefix of the auto generated order-number when an order is ceated') }}</p>
    </div>
    <x-card class="grow rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        <x-input name="order_prefix" value="{{ isset($appSetting) ? $appSetting->order_prefix : '' }}" />
        @error('order_prefix')
            <span class="text-error mt-4 text-sm">{{ $errors->first('order_prefix') }}</span>
        @enderror
    </x-card>
</div>
<div class="mt-4 flex flex-row gap-4">
    <div class="flex basis-1/4 flex-col">
        <h3 class="text-lg font-bold">{{ __('Tax') }}</h3>
        <p class="text-gray-500">
            {{ __('Tax percentage to be used to calculate order total amount. Define it as zero if Tax must not be considered.') }}
        </p>
    </div>
    <x-card class="grow rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        <x-input name="tax" value="{{ isset($appSetting) ? $appSetting->tax : 0 }}" />
        @error('tax')
            <span class="text-error mt-4 text-sm">{{ $errors->first('tax') }}</span>
        @enderror
    </x-card>
</div>
<div class="mt-4 flex flex-row gap-4">
    <div class="flex basis-1/4 flex-col">
        <h3 class="text-lg font-bold">{{ __('Rows per Page') }}</h3>
        <p class="text-gray-500">
            {{ __('Define the number of rows to be shown on Tables in the application.') }}</p>
    </div>
    <x-card class="grow rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        <x-input name="rows_per_page" value="{{ isset($appSetting) ? $appSetting->rows_per_page : 0 }}" />
        @error('rows_per_page')
            <span class="text-error mt-4 text-sm">{{ $errors->first('rows_per_page') }}</span>
        @enderror
    </x-card>
</div>
