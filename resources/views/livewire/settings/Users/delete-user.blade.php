    <x-settings.layout :heading="__('Are you sure you want to delete this account?')" :subheading="__(
        'Once this account is deleted, all of its resources and data will be permanently deleted. Please enter admin password to confirm you would like to permanently delete the account.',
    )">
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
                <x-button class="grow" label="{{ __('actions.cancel') }}" link="{{ route('settings.users.list') }}" />
                <x-button class="btn-error grow" label="{{ __('actions.confirm') }}" type="submit" />
            </x-slot:actions>
        </x-form>

    </x-settings.layout>
