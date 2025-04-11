<section class="w-full">
    <x-page.heading :pageSubtitle="__('Manage your profile and account settings')" :pageTitle="__('User Settings')" />
    <div class="bg-base-100 flex items-start rounded-xl p-10 max-md:flex-col">
        <div class="mr-10 h-full w-full py-6 md:w-[220px] md:border-r">
            <x-menu activate-by-route>
                <x-menu-item link="{{ route('settings.profile') }}">{{ __('Profile') }}</x-menu-item>
                <x-menu-item link="{{ route('settings.password') }}">{{ __('Change Password') }}</x-menu-item>
                <x-menu-item link="{{ route('settings.delete') }}">{{ __('Delete Account') }}</x-menu-item>
                {{-- <x-menu-item link="{{ route('settings.register') }}">{{ __('New User') }}</x-menu-item> --}}
                @can('manage_users')
                    <x-menu-item link="{{ route('settings.users.list') }}">{{ __('Manage Users') }}</x-menu-item>
                @endcan
            </x-menu>

        </div>
        <x-separator class="md:hidden" />

        <div class="flex-1 self-stretch max-md:pt-6">
            <x-header subtitle="{{ $subheading ?? '' }}" title="{{ $heading ?? '' }}" />
            <div class="mt-5 w-full max-w-lg">
                {{ $slot }}
            </div>
        </div>
    </div>
</section>
