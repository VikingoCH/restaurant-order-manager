<x-layouts.app :title="__('App')">
    {{-- {{ dd($appSetting) }} --}}
    <form action="{{ route('settings.general.create') }}" method="POST">
        @csrf
        <x-header separator subtitle="{{ __('Settings used in general by the App') }}"
            title="{{ __('General Settings - Create') }}">
            <x-slot:actions>
                <x-button class="btn-primary" icon="o-plus" label="{{ __('labels.save') }}" type="submit" />
            </x-slot:actions>
        </x-header>
        @include('general-settings.form')
    </form>
</x-layouts.app>
