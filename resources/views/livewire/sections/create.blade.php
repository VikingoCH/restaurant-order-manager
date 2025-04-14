<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('New Section') }}" />
    <x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow>
        <x-form wire:submit="save">
            <div class="flex flex-col gap-4 lg:flex-row lg:gap-8">
                <div class="flex flex-col gap-4 lg:w-full">
                    <x-input label="{{ __('labels.name') }}" wire:model.blur="name" />
                    <x-input label="{{ __('labels.position') }}" wire:model.blur="position" />
                </div>
            </div>
            <x-slot:actions separator>
                <x-buttons.save spinner="save" type="submit" />
                <x-buttons.cancel link="{{ route('sections.index') }}" />
            </x-slot:actions>
        </x-form>
    </x-card>
</div>
