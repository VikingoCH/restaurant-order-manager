<x-dropdown>
    <x-slot:trigger>
        <span class="cursor-pointer">
            {{-- <x-avatar :placeholder="auth()->user()->initials()" :title="auth()->user()->name" > --}}
            <x-avatar :placeholder="auth()->user()->initials()">
            </x-avatar>
        </span>
    </x-slot:trigger>
    <x-menu-item :href="route('profile.index')" icon="o-user" title="Profile" />
    <x-menu-separator />
    <div>
        <x-form action="{{ route('logout') }}" method="POST">
            @csrf
            <x-button class="btn-ghost btn-sm w-full" icon="o-power" type="submit">Log Out</x-button>
        </x-form>
    </div>
</x-dropdown>
