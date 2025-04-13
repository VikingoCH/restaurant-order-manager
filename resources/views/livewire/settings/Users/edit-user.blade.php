<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('Update user name and email address') }}"
        title="{{ __('labels.edit') }}">
    </x-header>
    <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" shadow>
        <x-form wire:submit="updateUser">
            @csrf
            <x-input autofocus icon="o-user" label="{{ __('labels.name') }}" placeholder="name" required
                wire:model="name" />
            <x-input icon="o-at-symbol" label="{{ __('labels.email') }}" placeholder="email" required type="email"
                wire:model="email" />
            <x-checkbox label="Admin rights" wire:model="isAdmin" />
            <x-slot:actions>
                <x-button class="grow" label="{{ __('actions.cancel') }}" link="{{ route('settings.users.list') }}" />
                <x-button class="btn-secondary grow" type="submit">{{ __('actions.save') }}</x-button>
            </x-slot:actions>
        </x-form>

    </x-card>
</div>
