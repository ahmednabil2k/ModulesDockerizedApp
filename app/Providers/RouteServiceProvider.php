<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {

            $modules = activeModules();

            foreach ($modules as $module) {
                foreach ($this->centralDomains() as $domain) {

                    if (file_exists(base_path("Modules/$module/Routes/central/web.php"))) {

                        Route::middleware('web')
                            ->domain($domain)
                            ->namespace("Modules\\$module\\Http\\Controllers")
                            ->group(base_path("Modules/$module/Routes/central/web.php"));
                    }

                    if (file_exists(base_path("Modules/$module/Routes/central/api.php"))) {

                        Route::prefix('api')
                            ->domain($domain)
                            ->middleware('api')
                            ->namespace("Modules\\$module\\Http\\Controllers")
                            ->group(base_path("Modules/$module/Routes/central/api.php"));
                    }
                }
            }
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    /**
     * @return array
     */
    protected function centralDomains(): array
    {
        return config('tenancy.central_domains');
    }
}
