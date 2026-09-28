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
        Gate::define('manage-users', fn (User $user): bool => $user->role?->name === Role::ADMINISTRATOR);
        Gate::define('manage-employees', fn (User $user): bool => in_array(
            $user->role?->name,
            [Role::ADMINISTRATOR, Role::HUMAN_RESOURCES],
            true,
        ));

        RateLimiter::for('login', function (Request $request): Limit {
            $email = $request->input('email');
            $email = is_string($email) ? Str::lower($email) : '';

            return Limit::perMinute(5)->by(Str::transliterate($email.'|'.$request->ip()));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
