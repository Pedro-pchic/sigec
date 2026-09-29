<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

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
        Gate::define('manage-users', fn (User $user): bool => $user->role?->name === Role::ADMINISTRATOR
        );

        Gate::define('manage-employees', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::HUMAN_RESOURCES],
            true,
        ));

        Gate::define('manage-catalog', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::WAREHOUSE],
            true,
        ));

        Gate::define('manage-purchases', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::PURCHASING],
            true,
        ));

        Gate::define('manage-commercial', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::SALES],
            true,
        ));

        Gate::define('view-purchases', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::PURCHASING, Role::WAREHOUSE],
            true,
        ));

        Gate::define('receive-purchases', fn (User $user): bool => $user->can('view-purchases'));

        Gate::define('manage-finances', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::FINANCE],
            true,
        ));

        Gate::define('view-invoices', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::SALES, Role::FINANCE],
            true,
        ));

        Gate::define('issue-invoices', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::SALES],
            true,
        ));

        RateLimiter::for('login', function (Request $request): Limit {
            $email = $request->input('email');
            $email = is_string($email) ? Str::lower($email) : '';

            return Limit::perMinute(5)
                ->by(Str::transliterate($email.'|'.$request->ip()));
        });
    }
}
