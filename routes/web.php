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
use App\Livewire\ManageOrders;
use App\Livewire\Orders;
use App\Livewire\Transactions;
use App\Livewire\Payments;
use App\Livewire\Reports;
use App\Http\Controllers\PdfReports\ByDateController;
use App\Http\Controllers\PdfReports\ByMonthController;
use App\Http\Controllers\PdfReports\ByYearController;

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
    Route::get('/', ManageOrders\Index::class)->name('home');
    Route::get('/manage-order/{orderId}/edit', ManageOrders\Edit::class)->name('manage-order.edit');

    Route::get('/orders', Orders\Index::class)->name('orders.index');
    Route::get('/orders/{order}/show', Orders\Show::class)->name('orders.show');

    Route::get('/transactions', Transactions\Index::class)->name('transactions.index');
    Route::get('/transactions/{transaction}/show', Transactions\Show::class)->name('transactions.show');

    Route::get('/payments/{orderId}/create', Payments\Create::class)->name('payments.create');
    Route::get('/payments/quick-order', Payments\QuickOrder::class)->name('payments.quick-order');

    Route::name('reports.')->prefix('reports')->group(function ()
    {
        Route::get('/', Reports\Index::class)->name('index');
        Route::get('/cash-close', Reports\CashClose::class)->name('cash-close');
    });

    Route::name('printPdf.')->prefix('print-pdf')->group(function ()
    {
        Route::get('/by-date/{date}', [ByDateController::class, 'printPDF'])->name('by-date');
        Route::get('/by-month/{date}', [ByMonthController::class, 'printPDF'])->name('by-month');
        Route::get('/by-year/{date}', [ByYearController::class, 'printPDF'])->name('by-year');
        // Route::get('/by-month/{date}', \App\Http\Controllers\PdfReports\ByMonthController::class)->name('by-month');
        // Route::get('/by-year/{year}', \App\Http\Controllers\PdfReports\ByYearController::class)->name('by-year');
    });


    // Route::redirect('settings', 'settings/profile');

    Route::name('menu.')->prefix('menu')->group(function ()
    {
        Route::get('/', Menu\Index::class)->name('index');
        Route::get('/create', Menu\Create::class)->name('create');
        Route::get('/{menuItem}/edit', Menu\Edit::class)->name('edit');
    });

    Route::get('/sections', Sections\Index::class)->name('sections.index');

    Route::get('/sides', Sides\Index::class)->name('sides.index');

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
