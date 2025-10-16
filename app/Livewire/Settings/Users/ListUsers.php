<?php

namespace App\Livewire\Settings\Users;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;

class ListUsers extends Component
{
    public $users;
    public $headers;
    public $token;

    public function mount(): void
    {
        $this->authorize('manage_users');
        $this->users = User::all();

        //TODO: Show token from session - to be removed
        $this->token = session('print_plugin_token');

        $this->headers = [
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'email', 'label' => __('Email')],
            ['key' => 'is_admin', 'label' => __('Role')],
        ];
    }
}
