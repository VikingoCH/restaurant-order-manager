<x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" shadow>
    <div class="flex flex-row justify-center gap-2">
        {{-- <x-slot:brand>
        <div>{{ __('Add menu Items') }}</div>
    </x-slot:brand> --}}
        {{-- <x-slot:actions> --}}
        @if (count($sections) != 0)
            @foreach ($sections as $section)
                <x-button class="btn-outline" label="{{ $section->name }}"
                    wire:click="$dispatch('show-menu-items',  {sectionId: {{ $section->id }}})" />
            @endforeach
        @else
            <div class="flex flex-col">
                <h3 class="text-error py-2 text-center font-semibold">
                    {{ __('To add items in an order, you must create the menu first!!') }}
                </h3>
                <x-buttons.add link="{{ route('menu.index') }}" />
            </div>
        @endif
        {{-- </x-slot:actions> --}}
    </div>
</x-card>

{{-- <x-card class="flex basis-1/4 flex-col rounded-xl border border-neutral-200 lg:w-1/4 dark:border-neutral-700"
    title="{{ __('Add menu Items') }}">
    @if (count($sections) != 0)
        <x-accordion>
            @foreach ($sections as $section)
                <x-collapse class="mb-2" name="{{ $section->id }}" separator>
                    <x-slot:heading>
                        {{ $section->name }}
                    </x-slot:heading>
                    <x-slot:content>
                        <livewire:manage-orders.components.menu-items :$orderId :key="$section->id" :sectionId="$section->id" />
                    </x-slot:content>
                </x-collapse>
            @endforeach
        </x-accordion>
    @else
        <div class="flex flex-col">
            <h3 class="text-error py-2 text-center font-semibold">
                {{ __('To add items in an order, you must create the menu first!!') }}
            </h3>
            <x-buttons.add link="{{ route('menu.index') }}" />
        </div>
    @endif
</x-card> --}}
