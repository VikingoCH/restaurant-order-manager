<!-- Order Prefix -->
<div class="flex flex-row gap-4">
    <div class="flex w-3/5 flex-col">
        <h3 class="text-lg font-bold">{{ __('Order Prefix') }}</h3>
        <p class="text-gray-500">
            {{ __('Used as prefix of the auto generated order-number when an order is ceated') }}</p>
    </div>
    <x-card class="w-full rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        {{-- <x-input name="order_prefix" value="{{ isset($appSetting) ? $appSetting['order_prefix'] : '' }}" /> --}}
        <x-input name="order_prefix" value="{{ $appSetting['order_prefix'] }}" />
        @error('order_prefix')
            <span class="text-error mt-4 text-sm">{{ $errors->first('order_prefix') }}</span>
        @enderror
    </x-card>
</div>

<!-- Quick Order Name -->
<div class="flex flex-row gap-4">
    <div class="flex w-3/5 flex-col">
        <h3 class="text-lg font-bold">{{ __('Quick Order Name') }}</h3>
        <p class="text-gray-500">
            {{ __('Used as order item name when a quick order is ceated') }}</p>
    </div>
    <x-card class="w-full rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        <x-input name="quick_order_name" value="{{ $appSetting['quick_order_name'] }}" />
        @error('quick_order_name')
            <span class="text-error mt-4 text-sm">{{ $errors->first('quick_order_name') }}</span>
        @enderror
    </x-card>
</div>

<!-- Tax -->
<div class="mt-4 flex flex-row gap-4">
    <div class="flex w-3/5 flex-col">
        <h3 class="text-lg font-bold">{{ __('Tax') }}</h3>
        <p class="text-gray-500">
            {{ __('Tax percentage to be used to calculate order total amount. Define it as zero if Tax must not be considered.') }}
        </p>
    </div>
    <x-card class="w-full rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        <x-input name="tax" value="{{ $appSetting['tax'] }}" />
        @error('tax')
            <span class="text-error mt-4 text-sm">{{ $errors->first('tax') }}</span>
        @enderror
    </x-card>
</div>

<!-- Rows per page -->
<div class="mt-4 flex flex-row gap-4">
    <div class="flex w-3/5 flex-col">
        <h3 class="text-lg font-bold">{{ __('Rows per Page') }}</h3>
        <p class="text-gray-500">
            {{ __('Define the number of rows to be shown on Tables in the application.') }}</p>
    </div>
    <x-card class="w-full rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        <x-input name="rows_per_page" value="{{ $appSetting['rows_per_page'] }}" />
        @error('rows_per_page')
            <span class="text-error mt-4 text-sm">{{ $errors->first('rows_per_page') }}</span>
        @enderror
    </x-card>
</div>

<!-- Default Printer -->
<div class="mt-4 flex flex-row gap-4">
    <div class="flex w-3/5 flex-col">
        <h3 class="text-lg font-bold">{{ __('Default Printer') }}</h3>
        <p class="text-gray-500">
            {{ __('Define the printer used for invoice and cash close receipts.') }}</p>
    </div>
    <x-card class="w-full rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        <x-select :options="$printers" icon="o-printer" single wire:model="{{ $appSetting['default_printer'] }}" />
        {{-- <x-input name="rows_per_page" value="{{ $appSetting['rows_per_page'] }}" /> --}}
        @error('default_printer')
            <span class="text-error mt-4 text-sm">{{ $errors->first('default_printer') }}</span>
        @enderror
    </x-card>
</div>

<!-- Receipt header -->
<div class="mt-4 flex flex-row gap-4">
    <div class="flex w-3/5 flex-col">
        <h3 class="text-lg font-bold">{{ __('Receipt Header') }}</h3>
        <p class="text-gray-500">
            {{ __('Define the header of receipt when printing.') }}</p>
        <p class="text-red-500">{{ $responseError }}</p>
    </div>
    <x-card class="w-full rounded-xl border-neutral-200 dark:border-neutral-700" shadow>
        <x-input :label="__('Store Name')" name="name" value="{{ $receiptInfo['name'] }}" />
        @error('name')
            <span class="text-error mt-4 text-sm">{{ $errors->first('name') }}</span>
        @enderror
        <x-input :label="__('Additional Store Name')" name="additional_name" value="{{ $receiptInfo['additional_name'] }}" />
        @error('additional_name')
            <span class="text-error mt-4 text-sm">{{ $errors->first('additional_name') }}</span>
        @enderror
        <x-input :label="__('Store Address')" name="address" value="{{ $receiptInfo['address'] }}" />
        @error('address')
            <span class="text-error mt-4 text-sm">{{ $errors->first('address') }}</span>
        @enderror
        <x-input :label="__('Store Phone')" name="phone" value="{{ $receiptInfo['phone'] }}" />
        @error('phone')
            <span class="text-error mt-4 text-sm">{{ $errors->first('phone') }}</span>
        @enderror
        <x-input :label="__('Store Email')" name="email" value="{{ $receiptInfo['email'] }}" />
        @error('email')
            <span class="text-error mt-4 text-sm">{{ $errors->first('email') }}</span>
        @enderror
        <x-input :label="__('Store Website')" name="website" value="{{ $receiptInfo['website'] }}" />
        @error('website')
            <span class="text-error mt-4 text-sm">{{ $errors->first('website') }}</span>
        @enderror
    </x-card>
</div>
