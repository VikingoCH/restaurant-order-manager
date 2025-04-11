<x-layouts.app :title="__('Page')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <x-page.heading :pageSubtitle="' locale: ' . session('locale')" :pageTitle="__('Page Title')" />
        <div class="grid auto-rows-min gap-4 md:grid-cols-2">
            <x-card class="flex flex-col" separator shadow title="Button Styles">

                <p class="text-xl font-bold uppercase">Colors</p>
                <x-button label="Default" />
                <x-button class="btn-primary" label="Primary" />
                <x-button class="btn-secondary" label="Secondary " />
                <x-button class="btn-accent" label="Accent " />
                <x-button class="btn-info" label="Info " />
                <x-button class="btn-success" label="Succes" />
                <x-button class="btn-warning" label="Warning" />
                <x-button class="btn-error my-2" label="Error" />
                <p class="pt-10 text-xl font-bold uppercase">Sizes</p>
                <div class="flex flex-row gap-4">
                    <x-button class="btn-sm" label="Small" />
                    <x-button class="btn-md" label="MD" />
                    <x-button class="btn-xl" label="XL" />
                </div>
            </x-card>
            <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
                title="Form Inputs">
                <x-input hint="Your full name" icon="o-user" label="{{ __('labels.name') }}" placeholder="Your name"
                    wire:model="name" />

                <x-input icon-right="o-map-pin" label="Right icon" wire:model="address" />
                <div class="p-6">{{ 'locale: ' . session('locale') }}</div>

            </x-card>
        </div>
    </div>
</x-layouts.app>
