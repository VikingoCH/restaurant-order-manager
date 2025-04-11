@props(['title', 'description'])

<div class="flex w-full flex-col text-center">
    <x-header separator subtitle="{{ __($description) }}" title="{{ __($title) }}" />
</div>
