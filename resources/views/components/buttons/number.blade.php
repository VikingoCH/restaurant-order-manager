@props(['enabled' => true])
@if ($enabled)
    <x-button {{ $attributes }} {{ $attributes->merge(['class' => 'btn-square btn-sm btn-primary']) }} spinner />
@else
    <x-button {{ $attributes }}
        {{ $attributes->merge(['class' => 'btn-square btn-sm btn-primary cursor-not-allowed']) }} disabled />
@endif
