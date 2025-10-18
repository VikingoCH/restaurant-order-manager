<section class="w-full">
    <x-page.heading :pageSubtitle="__('Manage your profile')" :pageTitle="__('User Profile')" />
    <div class="bg-base-100 flex items-start rounded-xl p-10 max-md:flex-col">
        <div class="mr-10 h-full w-full py-6 md:w-[220px] md:border-r">
            <x-menu activate-by-route>
                <x-menu-item link="{{ route('profile.index') }}">{{ __('Profile') }}</x-menu-item>
                <x-menu-item link="{{ route('profile.password') }}">{{ __('Change Password') }}</x-menu-item>
                <x-menu-item link="{{ route('profile.delete') }}">{{ __('Delete Account') }}</x-menu-item>
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
