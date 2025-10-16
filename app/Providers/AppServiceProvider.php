<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Model::automaticallyEagerLoadRelationships();
        Model::shouldBeStrict(!$this->app->environment('production'));
        DB::prohibitDestructiveCommands($this->app->environment('production'));
        Gate::define('manage_users', fn(User $user) => $user->is_admin);
        Gate::define('manage_settings', fn(User $user) => $user->is_admin);
        Gate::define('manage_admin', fn(User $user) => $user->is_admin);
        Gate::define('manage_orders', fn() => Auth::check());
    }
}
