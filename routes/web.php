<?php

use App\Livewire\Settings\DeleteUserForm;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\Users\DeleteUser;
use App\Livewire\Settings\Users\ListUsers;
use App\Livewire\Settings\Users\EditUser;
use App\Livewire\Settings\Users\RegisterUser;
use Illuminate\Support\Facades\Route;

// Route::view('/', 'home')
//     ->middleware(['auth', 'verified'])
//     ->name('home');

Route::get('/lang/{locale}', function ($locale)
{
    session()->put('locale', $locale);
    return redirect()->back();
})->name('lang');

Route::middleware(['auth'])->group(function ()
{
    Route::view('/', 'home')->name('home');

    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/delete', DeleteUserForm::class)->name('settings.delete');
    Route::group(
        [
            'prefix' => 'settings/users',
            'as' => 'settings.users.'
        ],
        function ()
        {
            Route::get('list', ListUsers::class)->name('list');
            Route::get('edit/{id}', EditUser::class)->name('edit');
            Route::get('register', RegisterUser::class)->name('register');
            Route::get('delete/{id}', DeleteUser::class)->name('delete');
        }
    );
});

require __DIR__ . '/auth.php';
