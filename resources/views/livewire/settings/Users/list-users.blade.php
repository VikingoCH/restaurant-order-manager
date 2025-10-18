<div class="flex h-full w-full flex-1 flex-col gap-2 rounded-xl">
    <x-header progress-indicator separator subtitle="{{ __('List of registered users') }}"
        title="{{ __('labels.users') }}" />

    <div class="flex justify-center gap-4">
        <x-card class="w-full rounded-xl border border-neutral-200 lg:w-3/4 dark:border-neutral-700" separator shadow
            title="{{ __('Available users') }}">
            <x-slot:menu>
                <x-buttons.add link="{{ route('settings.users.add') }}" />
            </x-slot:menu>
            <div>{{ $token ?? 'NO TOKEN FOUND' }}</div>
            <x-table :headers="$headers" :rows="$users">

                @scope('cell_is_admin', $user)
                    {{ $user->is_admin ? __('labels.admin') : __('labels.user') }}
                @endscope

                @scope('actions', $user)
                    <div class="flex items-center space-x-2">
                        <x-buttons.edit link="{{ route('settings.users.edit', ['id' => $user->id]) }}" />
                        <x-buttons.trash link="{{ route('settings.users.delete', ['id' => $user->id]) }}" />
                    </div>
                @endscope
            </x-table>
        </x-card>
    </div>
</div>
