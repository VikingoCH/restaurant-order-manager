<div>
    <!-- Edit menu item  -->
    <x-drawer class="w-11/12 lg:w-1/3" close-on-escape right separator title="{{ $editItem->name ?? '' }}"
        wire:model="openForm" with-close-button>
        {{-- {{ var_dump(count($editItem)) }} --}}
        @if ($editItem != null)
            <x-form wire:submit='addItem({{ $editItem->id }})'>
                <x-textarea label="{{ __('labels.remarks') }}" rows="3" wire:model.live='orderNotes' />
                @if ($editItem->menuFixedSides->count() || $editItem->menuSelectableSides->count())
                    <h3 class="fieldset-legend mb-0.5">{{ __('labels.sides') }}</h3>

                    <div class="grid grid-cols-2 items-center">
                        <div>
                            @foreach ($editItem->menuFixedSides as $side)
                                {{-- @if (in_array($side->id, $fixedSides)) --}}
                                <x-checkbox label='{{ $side->name }}' value='{{ $side->id }}'
                                    wire:model.live='fixedSides' />
                                {{-- @endif --}}
                            @endforeach
                        </div>
                        <div>
                            <x-radio :options="$editItem->menuSelectableSides" wire:model="selectableSides" />
                        </div>
                    </div>
                @endif

                <x-slot:actions>
                    <x-button label="{{ __('labels.cancel') }}" wire:click="$toggle('openForm')" />
                    {{-- @if ($editItem != null) --}}
                    <x-button class="btn-primary" icon="o-check" label="{{ __('labels.add') }}" type='submit' />
                    {{-- wire:click='add({{ $editItem->id }})' /> --}}
                    {{-- @endif --}}
                </x-slot:actions>
            </x-form>
        @endif
    </x-drawer>
</div>
