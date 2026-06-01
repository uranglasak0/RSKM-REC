<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\RateLimited;
use Illuminate\Support\Facades\Route;
use RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/dashboard'; // Ubah sesuai kebutuhan
    public const HOMEADMIN = '/panel/dashboardadmin'; // Ubah sesuai kebutuhan

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
{
    $this->configureRateLimiting();
    $this->routes(function () {
        // 1. API pakai middleware 'api'
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('routes/api.php'));

        // 2. WEB WAJIB pakai middleware 'web' 
        // (Ini yang bikin Cookies/Session kamu AWET)
        Route::middleware('web')
            ->group(base_path('routes/web.php'));
    });
}

    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function ($request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}