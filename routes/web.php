<?php

use App\Http\Controllers\GeneralSettingController;
use App\Livewire\Profile\Profile as ProfileProfile;
use App\Livewire\Profile\DeleteUserForm;
use App\Livewire\Profile\Password;
use App\Livewire\Profile\Profile;
use App\Livewire\Settings\PaymentMethods;
use App\Livewire\Settings\Printers;
use App\Livewire\Settings\TableLocations;
use App\Livewire\Settings\Users\DeleteUser;
use App\Livewire\Settings\Users\ListUsers;
use App\Livewire\Settings\Users\EditUser;
use App\Livewire\Settings\Users\RegisterUser;
use Illuminate\Support\Facades\Route;
use App\Livewire\Menu;
use App\Livewire\Sections;
use App\Livewire\Sides;


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

    Route::name('menu.')->prefix('menu')->group(function ()
    {
        Route::get('/', Menu\Index::class)->name('index');
        Route::get('/create', Menu\Create::class)->name('create');
        Route::get('/{menuItem}/edit', Menu\Edit::class)->name('edit');
    });

    Route::name('sections.')->prefix('sections')->group(function ()
    {
        Route::get('/', Sections\Index::class)->name('index');
        Route::get('/create', Sections\Create::class)->name('create');
        Route::get('/{menuSection}/edit', Sections\Edit::class)->name('edit');
    });

    Route::name('sides.')->prefix('sides')->group(function ()
    {
        Route::get('/', Sides\Index::class)->name('index');
        Route::get('/create', Sides\Create::class)->name('create');
        Route::get('/{menuSide}/edit', Sides\Edit::class)->name('edit');
    });

    Route::name('profile.')->prefix('profile')->group(function ()
    {
        Route::get('/', Profile::class)->name('index');
        Route::get('password', Password::class)->name('password');
        Route::get('delete', DeleteUserForm::class)->name('delete');
    });
    Route::name('settings.')->prefix('settings')->group(
        function ()
        {
            Route::get('/payment-methods', PaymentMethods::class)->name('payment.methods');
            Route::get('/table-locations', TableLocations::class)->name('table.locations');
            Route::get('/printers', Printers::class)->name('printers');

            Route::get('/general', [GeneralSettingController::class, 'index'])->name('general');
            Route::post('/general/create', [GeneralSettingController::class, 'create'])->name('general.create');
            Route::put('/general/{id}/update', [GeneralSettingController::class, 'update'])->name('general.update');

            Route::name('users.')->prefix('users')->group(
                function ()
                {
                    Route::get('/list', ListUsers::class)->name('list');
                    Route::get('/edit/{id}', EditUser::class)->name('edit');
                    Route::get('/add', RegisterUser::class)->name('add');
                    Route::get('/delete/{id}', DeleteUser::class)->name('delete');
                }
            );
        }
    );
});

require __DIR__ . '/auth.php';
