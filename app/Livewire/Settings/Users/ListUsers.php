<?php

namespace App\Livewire\Settings\Users;

use Livewire\Component;
use App\Models\User;


class ListUsers extends Component
{
    public $users;
    public $headers;

    public function mount(): void
    {
        $this->authorize('manage_users');
        $this->users = User::all();
        $this->headers = [
            // ['key' => 'id', 'label' => '#'],
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'email', 'label' => __('Email')],
            ['key' => 'is_admin', 'label' => __('Role')],
            // ['key' => 'actions', 'label' => 'Actions']
        ];
    }

    // public function render()
    // {
    //     return view('livewire.users');
    // }
}
