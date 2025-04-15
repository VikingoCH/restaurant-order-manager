<x-layouts.app :title="__('App')">
    {{-- {{ dd($appSetting) }} --}}

    <form action="{{ route('settings.general.update', $appSetting->id) }}" method="POST">
        @csrf
        @method('PUT')
        <x-header separator subtitle="{{ __('Settings used in general by the App') }}"
            title="{{ __('General Settings') }}">
            <x-slot:actions>
                <x-buttons.save responsive type="submit" />
            </x-slot:actions>
        </x-header>
        <div class="flex w-full justify-center lg:w-3/4">
            <div class="flex flex-col gap-4">
                @include('general-settings.form')
            </div>
        </div>
    </form>
</x-layouts.app>
