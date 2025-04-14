<x-layouts.app :title="__('App')">
    {{-- {{ dd($appSetting) }} --}}

    <form action="{{ route('settings.general.update', $appSetting->id) }}" method="POST">
        @csrf
        @method('PUT')
        <x-header separator subtitle="{{ __('Settings used in general by the App') }}"
            title="{{ __('General Settings') }}">
            <x-slot:actions>
                <x-buttons.save type="submit" />
            </x-slot:actions>
        </x-header>
        @include('general-settings.form')
    </form>
</x-layouts.app>
