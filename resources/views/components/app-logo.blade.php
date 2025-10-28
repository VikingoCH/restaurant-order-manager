<a {{ $attributes->class(['relative z-20 flex items-center text-lg font-medium cursor-pointer']) }}
    href="{{ route('home') }}" wire:navigate>
    <div {{ $attributes->merge(['class' => 'flex flex-row w-full justify-center']) }}>
        <img alt="Logo" class="h-40 w-40" src="{{ asset('storage/' . config('app.logo')) }}">
    </div>
</a>
