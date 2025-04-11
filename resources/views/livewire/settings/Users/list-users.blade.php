    <x-settings.layout :heading="__('labels.users')" :subheading="__('List of registered users')">
        <div class="flex items-center justify-end">
            <x-button class="btn-primary"
                link="{{ route('settings.users.register') }}">{{ __('actions.new_user') }}</x-button>
        </div>
        <x-table :headers="$headers" :rows="$users">

            @scope('cell_is_admin', $user)
                {{ $user->is_admin ? __('labels.admin') : __('labels.user') }}
            @endscope

            @scope('actions', $user)
                <div class="flex items-center space-x-2">
                    <x-button class="btn-xs btn-ghost text-secondary" icon="o-pencil"
                        link="{{ route('settings.users.edit', ['id' => $user->id]) }}" spinner
                        tooltip="{{ __('actions.edit') }}" />
                    <x-button class="btn-xs btn-ghost text-error" icon="o-trash"
                        link="{{ route('settings.users.delete', ['id' => $user->id]) }}" spinner
                        tooltip="{{ __('actions.delete') }}" />
                </div>
            @endscope
        </x-table>
    </x-settings.layout>
