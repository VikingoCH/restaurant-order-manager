<x-button {{ $attributes }} {{ $attributes->merge(['class' => 'btn-sm text-error']) }} icon="o-trash" spinner
    tooltip="{{ __('labels.delete') }}" wire:confirm="{{ __('Are you sure?') }}" />
