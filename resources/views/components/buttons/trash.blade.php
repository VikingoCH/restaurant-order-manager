<x-button {{ $attributes }} {{ $attributes->merge(['class' => 'btn-sm btn-error']) }} icon="o-trash" spinner
    tooltip="{{ __('labels.delete') }}" wire:confirm="{{ __('Are you sure?') }}" />
