<x-dropdown label="Language">
    <x-slot:trigger>
        @if (session()->has('locale'))
            <x-dynamic-component :component="'flag-language-' . session('locale')" class="h-6 w-6" />
        @else
            <x-dynamic-component :component="'flag-language-' . app()->getLocale()" class="h-6 w-6" />
        @endif
    </x-slot:trigger>
    @foreach (config('lang.supported_locales') as $locale => $data)
        <x-menu-item :href="route('lang', $locale)">
            {{-- blade-formatter-disable-next-line --}}
        <x-dynamic-component :component="'flag-language-' . $data['flag']" class="h-6 w-6" />
        </x-menu-item>
    @endforeach
</x-dropdown>
