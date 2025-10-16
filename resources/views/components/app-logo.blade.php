<a {{ $attributes->class(['relative z-20 flex items-center text-lg font-medium cursor-pointer']) }}
    href="{{ route('home') }}" wire:navigate>
    <div class='mr-5 hidden items-center justify-center lg:flex' }}>
        <img class="h-20 w-20" src="{{ asset('storage/' . config('app.logo')) }}" />
    </div>
    {{ $slot }}
</a>
