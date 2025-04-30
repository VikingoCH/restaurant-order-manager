@props(['enabled' => true])
@if ($enabled)
    <x-button {{ $attributes }} {{ $attributes->merge(['class' => 'btn-square btn-sm btn-secondary']) }} spinner />
@else
    <x-button {{ $attributes }}
        {{ $attributes->merge(['class' => 'btn-square btn-sm btn-secondary cursor-not-allowed']) }} disabled />
@endif
