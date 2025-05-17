<x-button {{ $attributes }} {{ $attributes->merge(['class' => 'btn-sm btn-error']) }} icon="o-trash"
    label="{{ __('labels.delete') }}" responsive spinner wire:confirm="{{ __('Are you sure?') }}" />
