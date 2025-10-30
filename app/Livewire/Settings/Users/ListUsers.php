<?php

namespace App\Livewire\Settings\Users;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class ListUsers extends Component
{
    public $users;
    public $headers;
    public $token;

    public function mount(): void
    {
        $this->authorize('manage_users');
        $users = User::all();
        $this->users = $users->except(Auth::id());

        $this->headers = [
            ['key' => 'name', 'label' => __('Name')],
            ['key' => 'email', 'label' => __('Email')],
            ['key' => 'is_admin', 'label' => __('Role')],
        ];
    }
}
