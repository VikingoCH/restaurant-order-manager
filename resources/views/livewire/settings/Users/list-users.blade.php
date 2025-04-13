<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('List of registered users') }}"
        title="{{ __('labels.users') }}">
        {{-- <x-slot:actions>
            <x-button class="btn-primary" link="{{ route('settings.users.add') }}">{{ __('actions.new_user') }}</x-button>
        </x-slot:actions> --}}
    </x-header>
    <x-card class="rounded-xl border border-neutral-200 dark:border-neutral-700" separator shadow
        title="{{ __('Available users') }}">
        <x-slot:menu>
            <x-button class="btn-primary btn-sm" icon="o-plus" link="{{ route('settings.users.add') }}"
                tooltip="{{ __('labels.add') }}" />
        </x-slot:menu>
        <x-table :headers="$headers" :rows="$users">

            @scope('cell_is_admin', $user)
                {{ $user->is_admin ? __('labels.admin') : __('labels.user') }}
            @endscope

            @scope('actions', $user)
                <div class="flex items-center space-x-2">
                    <x-button class="btn-sm text-primary" icon="o-pencil"
                        link="{{ route('settings.users.edit', ['id' => $user->id]) }}" spinner
                        tooltip="{{ __('actions.edit') }}" />
                    <x-button class="btn-sm text-error" icon="o-trash"
                        link="{{ route('settings.users.delete', ['id' => $user->id]) }}" spinner
                        tooltip="{{ __('actions.delete') }}" />
                </div>
            @endscope
        </x-table>
    </x-card>
</div>
