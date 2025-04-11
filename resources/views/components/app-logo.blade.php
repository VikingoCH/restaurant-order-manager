<a {{ $attributes->class(['relative z-20 flex items-center text-lg font-medium']) }} href="{{ route('home') }}"
    wire:navigate>
    <div class='mr-5 flex items-center justify-center' }}>
        <img src="{{ asset('storage/' . env('APP_LOGO')) }}" />
    </div>
    {{ $slot }}
    {{-- {{ config('app.name', 'Laravel') }} --}}
</a>
