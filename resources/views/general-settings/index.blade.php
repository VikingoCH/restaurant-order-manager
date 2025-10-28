<x-layouts.app :title="__('App')">
    <form action="{{ route('settings.general.save', $appSetting['id']) }}" method="POST">
        @csrf
        {{-- @method('PUT') --}}
        <x-header separator subtitle="{{ __('Settings used in general by the App') }}"
            title="{{ __('General Settings') }}">
            {{-- @if ($responseError == '') --}}
            <x-slot:actions>
                <x-buttons.save responsive type="submit" />
            </x-slot:actions>
            {{-- @endif --}}
        </x-header>

        <div class="flex w-full justify-center lg:w-3/4">
            <div class="flex flex-col gap-4">
                @include('general-settings.form')
            </div>
        </div>
    </form>
</x-layouts.app>
