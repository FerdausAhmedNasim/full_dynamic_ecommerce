<?php

namespace App\Providers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            $this->mapAdminRoutes();
            $this->mapSellerRoutes();

            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace('App\Http\Controllers\Public')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }

    protected function mapAdminRoutes()
    {
        $host = parse_url(config('app.url'))['host'];
        $admin_prefix = config('app.admin_prefix');
        $domain = $admin_prefix . '.' . $host;
        Route::middleware('web')
            ->domain($domain)
            ->name('admin.')
            ->namespace('App\Http\Controllers\Admin')
            ->group(base_path('routes/admin.php'));
    }

    protected function mapSellerRoutes()
    {
        $host = parse_url(config('app.url'))['host'];
        $seller_prefix = config('app.seller_prefix');
        $domain = $seller_prefix . '.' . $host;
        Route::middleware('web')
            ->domain($domain)
            ->name('seller.')
            ->namespace('App\Http\Controllers\Seller')
            ->group(base_path('routes/seller.php'));
    }
}
