<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator title="{{ __('New Menu Item') }}" />
    <div class="flex justify-center">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow>
            <x-form wire:submit="save">
                <div class="flex flex-col gap-4 lg:flex-row lg:gap-8">
                    <div class="flex w-full flex-row gap-8 lg:basis-1/4 lg:flex-col">
                        @if ($image_path)
                            <img class="h-40 w-40 rounded-lg" src="{{ $image_path->temporaryUrl() }}" />
                        @else
                            <img class="h-40 w-40 rounded-lg" src="{{ asset('storage/no-image-placeholder.png') }}" />
                        @endif
                        <x-file accept="image/png, image/jpeg" hint="{{ 'Image types: jpg, jpeg, png' }}"
                            label="{{ __('labels.image') }}" wire:model="image_path" />
                    </div>
                    <div class="flex flex-col gap-4 lg:w-full">
                        <x-select :options="$sections" label="{{ __('labels.sections') }}" placeholder="---"
                            wire:model.blur="menu_section_id" />
                        <x-input label="{{ __('labels.name') }}" wire:model.blur="name" />
                        <x-input label="{{ __('labels.price') }}" locale="de-CH" money prefix="CHF"
                            wire:model.blur="price" />
                        <x-input label="{{ __('labels.position') }}" wire:model.blur="position" />
                        <x-select :options="$printers" label="{{ __('labels.printer') }}" placeholder="---"
                            wire:model.blur="printer_id" />
                        <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700"
                            title="{{ __('Side dishes') }}">
                            <x-slot:menu>
                                <x-toggle label="{{ $withSides ? __('With Side Dishes') : __('Without Side Dishes') }}"
                                    right wire:click="$toggle('withSides')" wire:model='withSides' />
                            </x-slot:menu>
                            @if ($withSides)
                                <div class="grid w-full grid-cols-3 items-center lg:w-1/2">
                                    <span class="fieldset-legend mb-0.5">{{ __('labels.name') }}</span>
                                    <span class="fieldset-legend mb-0.5">{{ __('labels.always') }}</span>
                                    <span class="fieldset-legend mb-0.5">{{ __('labels.one_of') }}</span>
                                    @foreach ($sides as $side)
                                        <span>{{ $side->name }}</span>
                                        @if (in_array($side->id, $selectableSides))
                                            <x-checkbox disabled uncheck value='{{ $side->id }}'
                                                wire:model.live='fixedSides' />
                                        @else
                                            <x-checkbox value='{{ $side->id }}' wire:model.live='fixedSides' />
                                        @endif
                                        @if (in_array($side->id, $fixedSides))
                                            <x-checkbox disabled uncheck value='{{ $side->id }}'
                                                wire:model.live='selectableSides' />
                                        @else
                                            <x-checkbox value='{{ $side->id }}'
                                                wire:model.live='selectableSides' />
                                        @endif
                                    @endforeach
                                </div>

                            @endif
                        </x-card>
                    </div>
                </div>
                <x-slot:actions separator>
                    <x-buttons.save spinner="save" type="submit" />
                    <x-buttons.cancel link="{{ route('menu.index') }}" />
                </x-slot:actions>

            </x-form>
        </x-card>
    </div>

</div>
