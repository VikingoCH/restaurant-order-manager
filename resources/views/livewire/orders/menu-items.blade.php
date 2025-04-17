<div>

    <x-input icon="o-magnifying-glass" placeholder="Search ..." wire:model.live.debounce="search" />

    @foreach ($menuItems as $menuItem)
        <x-list-item :item="$menuItem" avatar="image_path" class="w-full">
            <x-slot:avatar>
                <a class="cursor-pointer" link="#" wire:click.prevent='add({{ $menuItem->id }},{{ $orderId }})'>
                    <x-avatar class="!w-10 !rounded-lg" image="{{ asset('storage/' . $menuItem->image_path) }}" />
                </a>
            </x-slot:avatar>
            <x-slot:value>
                <a class="cursor-pointer" link="#"
                    wire:click.prevent='add({{ $menuItem->id }},{{ $orderId }})'>
                    {{ $menuItem->name }}
                </a>
            </x-slot:value>
            <x-slot:sub-value>
                <a class="cursor-pointer" link="#"
                    wire:click.prevent='add({{ $menuItem->id }},{{ $orderId }})'>
                    {{ ' [CHF ' . $menuItem->price . ' ]' }}
                </a>
            </x-slot:sub-value>
            <x-slot:actions>
                <x-buttons.edit wire:click="$dispatch('edit-form', { menuItemId: {{ $menuItem->id }} })" />
            </x-slot:actions>
        </x-list-item>
    @endforeach

</div>
