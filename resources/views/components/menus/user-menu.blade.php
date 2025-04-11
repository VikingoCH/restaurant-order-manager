<x-dropdown>
    <x-slot:trigger>
        {{-- <x-avatar :placeholder="auth()->user()->initials()" :subtitle="auth()->user()->email" :title="auth()->user()->name" /> --}}
        <span class="cursor-pointer">
            <x-avatar :placeholder="auth()->user()->initials()" :title="auth()->user()->name" />
        </span>
    </x-slot:trigger>
    <x-menu-item :href="route('settings.profile')" icon="o-user" title="Profile" />
    <x-menu-separator />
    <div>
        <x-form action="{{ route('logout') }}" method="POST">
            @csrf
            <x-button class="btn-ghost btn-sm w-full" icon="o-power" type="submit">Log Out</x-button>
        </x-form>
    </div>
</x-dropdown>
