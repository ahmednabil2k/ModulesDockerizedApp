<?php

namespace App\Providers;

// use Illuminate\Base\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Passport;
use Stancl\Tenancy\Middleware\InitializeTenancyBySubdomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    public function register()
    {
        Passport::ignoreMigrations();
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Passport::tokensExpireIn(now()->addYear());

        Route::group([
            'as' => 'passport.',
            'middleware' => [
                InitializeTenancyBySubdomain::class,
                PreventAccessFromCentralDomains::class,
            ],
            'prefix' => config('passport.path', 'oauth'),
            'namespace' => 'Laravel\Passport\Http\Controllers',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . "/../../vendor/laravel/passport/src/../routes/web.php");
        });
    }
}
