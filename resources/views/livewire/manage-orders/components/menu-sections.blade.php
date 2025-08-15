<x-card class="w-full rounded-xl border border-neutral-200 dark:border-neutral-700" shadow>
    <div class="flex flex-col justify-center gap-2 lg:flex-row">
        @if (count($sections) != 0)
            @foreach ($sections as $section)
                <x-button class="btn-outline btn-xs lg:btn-md" label="{{ $section->name }}"
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
    </div>
</x-card>
