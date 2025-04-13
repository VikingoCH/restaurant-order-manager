        <div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
            <x-header progress-indicator separator
                subtitle="{{ __('Once this account is deleted, all of its resources and data will be permanently deleted. Please enter admin password to confirm you would like to permanently delete the account.') }}"
                title="{{ __('Are you sure you want to delete this account?') }}">
            </x-header>
            <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" shadow>

                <div class="text-lg">
                    <p>{{ __('Account Details') }}</p>
                    <ul class="list-inside list-disc">
                        <li>{{ __('labels.name') }}: {{ $user->name }}</li>
                        <li>{{ __('labels.email') }}: {{ $user->email }}</li>
                    </ul>
                </div>
                <x-form wire:submit="deleteUser">
                    @csrf
                    <x-password hint="{{ __('Admin Password') }}" label="{{ __('labels.password') }}" right
                        wire:model="password" />
                    <x-slot:actions>
                        <x-button class="grow" label="{{ __('actions.cancel') }}"
                            link="{{ route('settings.users.list') }}" />
                        <x-button class="btn-error grow" label="{{ __('actions.confirm') }}" type="submit" />
                    </x-slot:actions>
                </x-form>

            </x-card>
        </div>
