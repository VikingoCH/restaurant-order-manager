<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('Enter the details below to create an account') }}"
        title="{{ __('Create an account') }}" />

    <div class="flex justify-center gap-4">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" shadow>
            <x-form wire:submit="register">
                <x-input icon="o-user" label="{{ __('labels.name') }}" placeholder="{{ __('Full name') }}" required
                    wire:model="name" wire:model="name" />

                <x-input icon="o-at-symbol" label="{{ __('labels.email') }}" placeholder="email@example.com" required
                    type="email" wire:model="email" />

                <x-password label="{{ __('labels.password') }}" placeholder="{{ __('labels.password') }}" required right
                    wire:model="password" />

                <x-password label="{{ __('labels.confirm_password') }}"
                    placeholder="{{ __('labels.confirm_password') }}" required right
                    wire:model="password_confirmation" />

                <x-checkbox label="Admin rights" wire:model="isAdmin" />

                <x-slot:actions>
                    <x-buttons.cancel link="{{ route('settings.users.list') }}" />
                    <x-buttons.save type="submit" />
                </x-slot:actions>
            </x-form>
        </x-card>
    </div>
</div>
