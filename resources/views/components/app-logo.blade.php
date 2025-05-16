<a {{ $attributes->class(['relative z-20 flex items-center text-lg font-medium']) }} href="{{ route('home') }}"
    wire:navigate>
    <div class='mr-5 flex items-center justify-center' }}>
        <img src="{{ asset('storage/' . config('app.logo')) }}" />
    </div>
    {{ $slot }}
</a>
